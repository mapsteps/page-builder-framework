<?php
/**
 * Plugin Name: Kirki PRO Responsive
 * Plugin URI:  https://kirki.org
 * Description: Responsive control for Kirki Customizer Framework.
 * Version:     0.1.0
 * Author:      David Vongries
 * Author URI:  https://davidvongries.com/
 * License:     GPL-3.0
 * License URI: https://oss.ninja/gpl-3.0?organization=Kirki%20Framework&project=control%20input%20slider
 * Text Domain: kirki-pro-responsive
 * Domain Path: /languages
 *
 * @package kirki-pro-responsive
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kirki_pro_load_responsive_control' ) ) {

	/**
	 * Load responsive control.
	 */
	function kirki_pro_load_responsive_control() {

		// Stop, if Kirki is not installed.
		if ( ! defined( 'KIRKI_VERSION' ) ) {
			return;
		}

		define( 'KIRKI_PRO_RESPONSIVE_VERSION', '0.1.0' );
		define( 'KIRKI_PRO_RESPONSIVE_PLUGIN_FILE', __FILE__ );

		require_once __DIR__ . '/vendor/autoload.php';

		new \Kirki\Pro\Responsive\Init();

	}
	add_action( 'plugins_loaded', 'kirki_pro_load_responsive_control' );

}
