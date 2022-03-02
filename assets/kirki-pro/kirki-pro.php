<?php
/**
 * Plugin Name: Kirki PRO
 * Plugin URI:  https://kirki.org
 * Description: PRO extension fields for Kirki Customizer Framework.
 * Version:     0.1.0
 * Author:      David Vongries
 * Author URI:  https://davidvongries.com/
 * License:     GPL-3.0
 * License URI: https://oss.ninja/gpl-3.0?organization=Kirki%20Framework&project=Kirki%20PRO
 * Text Domain: kirki-pro
 * Domain Path: /languages
 *
 * @package kirki-pro
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kirki_pro_init_controls' ) ) {

	/**
	 * Init Kirki PRO controls.
	 */
	function kirki_pro_init_controls() {

		require_once __DIR__ . '/vendor/autoload.php';

		$packages = [
			'mapsteps/kirki-pro-headline-divider',
			'mapsteps/kirki-pro-input-slider',
			'mapsteps/kirki-pro-margin-padding',
			'mapsteps/kirki-pro-responsive',
			'mapsteps/kirki-pro-tabs',
		];

		foreach ( $packages as $package ) {
			$init_class_name = str_ireplace( 'mapsteps/kirki-pro-', '', $package );
			$init_class_name = str_ireplace( '-', ' ', $init_class_name );
			$init_class_name = ucwords( $init_class_name );
			$init_class_name = str_ireplace( ' ', '', $init_class_name );
			$init_class_name = '\\Kirki\\Pro\\' . $init_class_name . '\\Init';

			if ( class_exists( $init_class_name ) ) {
				new $init_class_name();
			}
		}

	}
}

if ( ! function_exists( 'kirki_pro_load_controls' ) ) {

	/**
	 * Load Kirki PRO controls.
	 */
	function kirki_pro_load_controls() {

		// Stop, if Kirki is not installed.
		if ( ! defined( 'KIRKI_VERSION' ) ) {
			return;
		}

		// Stop, if Kirki PRO is already installed.
		if ( defined( 'KIRKI_PRO_VERSION' ) ) {
			return;
		}

		define( 'KIRKI_PRO_VERSION', '0.1.0' );
		define( 'KIRKI_PRO_PLUGIN_FILE', __FILE__ );

		kirki_pro_init_controls();

	}

	add_action( 'plugins_loaded', 'kirki_pro_load_controls' );

}
