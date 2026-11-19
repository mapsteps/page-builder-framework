<?php
/**
 * Snapshot helper (dev only, never shipped). snapshot.py and customizer-check.mjs copy this file to
 * wp-content/mu-plugins/zz-test-snapshot.php for the run and delete it afterwards.
 *
 * Never writes to the database. Acts only on requests with one of these parameters:
 * - zz_nolock=1 (Customizer check): opening the editor or the Customizer leaves no post locks or dismissed drafts behind.
 * - zz_snap=<variant> (page snapshots): same, plus PHP warnings are logged, nonces stay the same within a run, and
 *   zz_snap=live keeps the saved settings while any other variant swaps in the settings from output/variants.json;
 *   zz_nopremium=1 switches the Premium Add-On off for that request.
 *
 * @package Page Builder Framework
 */

// phpcs:disable -- Dev tool.

// Preview check (customizer-check.mjs): every request of the run (Customizer, preview, partials) uses Premium
// breakpoints that differ from the defaults, so the check shows the preview takes them from PHP.
if ( ! empty( $_COOKIE['zz_breakpoints'] ) ) {
	add_filter(
		'option_wpbf_settings',
		function ( $settings ) {
			return array_merge(
				(array) $settings,
				array(
					'wpbf_breakpoint_desktop' => '1100px',
					'wpbf_breakpoint_medium'  => '700px',
					'wpbf_breakpoint_mobile'  => '400px',
				)
			);
		}
	);
}

// Preview check: the front-end CSS of the areas written with wpbf_css() for the posted setting values (saved values
// plus these), and the posted preview CSS, both minified like the front end. Reads only, never saves.
if ( isset( $_GET['zz_css'] ) ) {
	$zz_input = json_decode( (string) file_get_contents( 'php://input' ), true );
	$zz_input = is_array( $zz_input ) ? $zz_input : array();

	add_action(
		'template_redirect',
		function () use ( $zz_input ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( 'not allowed', 403 );
			}

			// Clean the values like the Customizer does before the preview sees them (and before a save would store
			// them): ranges, colors, JSON. A Customizer object is only built here to reach the settings' checks.
			require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
			$zz_manager = new WP_Customize_Manager();
			do_action( 'customize_register', $zz_manager );

			$zz_values = array();
			foreach ( isset( $zz_input['values'] ) ? (array) $zz_input['values'] : array() as $zz_id => $zz_value ) {
				$zz_setting = $zz_manager->get_setting( $zz_id );
				$zz_clean   = $zz_setting ? $zz_setting->sanitize( $zz_value ) : $zz_value;
				if ( null !== $zz_clean && ! is_wp_error( $zz_clean ) ) {
					$zz_values[ $zz_id ] = $zz_clean;
				}
			}

			// Sub-settings (a typography field's id[font-family] / id[variant] selects) are saved into their option,
			// after it (registered later), as WordPress saves and previews them.
			foreach ( $zz_values as $zz_id => $zz_value ) {
				if ( preg_match( '/^([^\[]+)\[([^\]]+)\]$/', $zz_id, $zz_sub ) ) {
					unset( $zz_values[ $zz_id ] );
					$zz_base = array_key_exists( $zz_sub[1], $zz_values ) ? $zz_values[ $zz_sub[1] ] : get_theme_mod( $zz_sub[1] );
					$zz_base = is_array( $zz_base ) ? $zz_base : array();

					$zz_base[ $zz_sub[2] ]     = $zz_value;
					$zz_values[ $zz_sub[1] ] = $zz_base;
				}
			}

			add_filter(
				'option_theme_mods_' . get_option( 'stylesheet' ),
				function ( $live ) use ( $zz_values ) {
					return array_merge( (array) $live, $zz_values );
				}
			);

			ob_start();
			wpbf_css_area( isset( $zz_input['area'] ) ? $zz_input['area'] : 'general' );
			$front = ob_get_clean();

			// Hex colors compare without letter case: the preview gets colors lowercased by the Customizer
			// (a saved #FFFFFF previews as #ffffff, the same color).
			$zz_normal = function ( $css ) {
				return preg_replace_callback(
					'/#[0-9a-fA-F]{3,8}\b/',
					function ( $hex ) {
						return strtolower( $hex[0] );
					},
					wpbf_minify_css( $css )
				);
			};

			wp_send_json(
				array(
					'front'   => $zz_normal( $front ),
					'preview' => $zz_normal( isset( $zz_input['preview'] ) ? (string) $zz_input['preview'] : '' ),
				)
			);
		},
		0
	);

	return;
}

if ( ! isset( $_GET['zz_snap'] ) && ! isset( $_GET['zz_nolock'] ) ) {
	return;
}

// Opening an editor or the Customizer must not leave anything behind (post locks, dismissed Customizer drafts).
foreach ( array( 'add_post_metadata', 'update_post_metadata' ) as $zz_hook ) {
	add_filter(
		$zz_hook,
		function ( $check, $object_id, $meta_key ) {
			return in_array( $meta_key, array( '_edit_lock', '_edit_last', '_customize_restore_dismissed' ), true ) ? true : $check;
		},
		10,
		3
	);
}

// The Customizer CSS cache (and its file, its refresh schedule) is read but never written by these runs.
add_filter( 'wpbf_customizer_css_store', '__return_false' );

// The Dashboard's Quick Draft widget creates an empty draft post when there is none.
add_action(
	'wp_dashboard_setup',
	function () {
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	},
	999
);

if ( ! isset( $_GET['zz_snap'] ) ) {
	return;
}

// Log every PHP warning/notice of snapshot requests (compared before/after), never show them.
error_reporting( E_ALL );
ini_set( 'display_errors', '0' );
ini_set( 'log_errors', '1' );

$zz_variant = preg_replace( '/[^a-z0-9]/', '', $_GET['zz_snap'] );

// Print the Customizer CSS into the page (the site may use a CSS file), so the snapshot shows it.
add_filter(
	'wpbf_css_output',
	function () {
		return 'inline';
	},
	PHP_INT_MAX
);

if ( ! empty( $_GET['zz_nopremium'] ) ) {
	add_filter(
		'option_active_plugins',
		function ( $plugins ) {
			return array_values( array_diff( (array) $plugins, array( 'wpbf-premium/wpbf-premium.php' ) ) );
		}
	);
}

if ( 'live' !== $zz_variant ) {
	$zz_all  = json_decode( file_get_contents( WP_CONTENT_DIR . '/themes/page-builder-framework/bin/snapshot/output/variants.json' ), true );
	$zz_mods = isset( $zz_all[ $zz_variant ] ) ? $zz_all[ $zz_variant ] : array();

	// Hand-made variants (general1, ...) change only their own settings on top of the saved ones.
	$zz_hand = 0 === strpos( $zz_variant, 'general' );

	if ( isset( $zz_mods['__wpbf_settings'] ) ) {
		$zz_settings = $zz_mods['__wpbf_settings'];
		unset( $zz_mods['__wpbf_settings'] );
		add_filter(
			'option_wpbf_settings',
			function ( $settings ) use ( $zz_settings ) {
				return array_merge( (array) $settings, $zz_settings );
			}
		);
	}

	add_filter(
		'option_theme_mods_' . get_option( 'stylesheet' ),
		function ( $live ) use ( $zz_mods, $zz_hand ) {
			if ( $zz_hand ) {
				return array_merge( (array) $live, $zz_mods );
			}
			$keep = array();
			foreach ( array( 'nav_menu_locations', 'custom_logo', 'custom_css_post_id', 'sidebars_widgets' ) as $key ) {
				if ( isset( $live[ $key ] ) ) {
					$keep[ $key ] = $live[ $key ];
				}
			}
			return array_merge( $keep, $zz_mods );
		}
	);
}

// Stable nonces within a run (only valid for snapshot requests).
add_filter(
	'nonce_life',
	function () {
		return 365 * DAY_IN_SECONDS;
	}
);
