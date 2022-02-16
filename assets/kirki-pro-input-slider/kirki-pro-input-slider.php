<?php
/**
 * Plugin Name: Kirki PRO Input Slider
 * Plugin URI:  https://kirki.org
 * Description: Input slider control for Kirki Customizer Framework.
 * Version:     0.1.0
 * Author:      David Vongries
 * Author URI:  https://davidvongries.com/
 * License:     GPL-3.0
 * License URI: https://oss.ninja/gpl-3.0?organization=Kirki%20Framework&project=control%20input%20slider
 * Text Domain: kirki-pro-input-slider
 * Domain Path: /languages
 *
 * @package kirki-pro-input-slider
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kirki_pro_load_input_slider_control' ) ) {

	/**
	 * Load input slider control.
	 */
	function kirki_pro_load_input_slider_control() {

		// Stop, if Kirki is not installed.
		if ( ! defined( 'KIRKI_VERSION' ) ) {
			return;
		}

		define( 'KIRKI_PRO_INPUT_SLIDER_VERSION', '0.1.0' );
		define( 'KIRKI_PRO_INPUT_SLIDER_PLUGIN_FILE', __FILE__ );

		require_once __DIR__ . '/vendor/autoload.php';

		new \Kirki\Pro\InputSlider\Init();

	}
	add_action( 'plugins_loaded', 'kirki_pro_load_input_slider_control' );

}
