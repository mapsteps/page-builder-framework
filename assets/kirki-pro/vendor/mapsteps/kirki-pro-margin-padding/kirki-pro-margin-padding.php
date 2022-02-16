<?php
/**
 * Plugin Name: Kirki PRO Margin & Padding
 * Plugin URI:  https://kirki.org
 * Description: Margin & padding control for Kirki Customizer Framework.
 * Version:     0.1.0
 * Author:      David Vongries
 * Author URI:  https://davidvongries.com/
 * License:     GPL-3.0
 * License URI: https://oss.ninja/gpl-3.0?organization=Kirki%20Framework&project=control%20margin%20padding
 * Text Domain: kirki-pro-margin-padding
 * Domain Path: /languages
 *
 * @package kirki-pro-margin-padding
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kirki_pro_load_margin_padding_control' ) ) {

	/**
	 * Load margin & padding control.
	 */
	function kirki_pro_load_margin_padding_control() {

		// Stop, if Kirki is not installed.
		if ( ! defined( 'KIRKI_VERSION' ) ) {
			return;
		}

		define( 'KIRKI_PRO_MARGIN_PADDING_VERSION', '0.1.0' );
		define( 'KIRKI_PRO_MARGIN_PADDING_PLUGIN_FILE', __FILE__ );

		require_once __DIR__ . '/vendor/autoload.php';

		new \Kirki\Pro\MarginPadding\Init();

	}
	add_action( 'plugins_loaded', 'kirki_pro_load_margin_padding_control' );

}
