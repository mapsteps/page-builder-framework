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

	add_filter(
		'option_theme_mods_' . get_option( 'stylesheet' ),
		function ( $live ) use ( $zz_mods ) {
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
