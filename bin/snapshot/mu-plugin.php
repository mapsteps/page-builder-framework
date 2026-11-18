<?php
/**
 * Snapshot helper (dev only, never shipped). snapshot.py copies this file to
 * wp-content/mu-plugins/zz-test-snapshot.php for the run and deletes it afterwards.
 *
 * Only acts on requests with ?zz_snap=<variant>. Never writes to the database:
 * - zz_snap=live keeps the saved settings, any other variant swaps in the settings from variants.json.
 * - zz_nopremium=1 switches the Premium Add-On off for that request.
 *
 * @package Page Builder Framework
 */

// phpcs:disable -- Dev tool.

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

// Stable nonces within a run.
add_filter(
	'nonce_life',
	function () {
		return 365 * DAY_IN_SECONDS;
	}
);
