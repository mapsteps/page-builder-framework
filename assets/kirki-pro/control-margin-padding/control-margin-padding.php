<?php
/**
 * Plugin Name: Kirki PRO - Margin & Padding Control
 * Plugin URI:  https://kirki.org
 * Description: Margin & padding control for Kirki Customizer Framework.
 * Version:     0.1.0
 * Author:      David Vongries
 * Author URI:  https://davidvongries.com/
 * License:     GPL-3.0
 * License URI: https://oss.ninja/gpl-3.0?organization=Kirki%20Framework&project=control%20margin%20padding
 * Text Domain: control-margin-padding
 * Domain Path: /languages
 *
 * @package kirki-pro/control-margin-padding
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

		/**
		 * To enable tests, add this line to your wp-config.php file (or anywhere alse):
		 * define( 'KIRKI_TEST', true );
		 *
		 * Please note that the example.php file is not included in the wordpress.org distribution
		 * and will only be included in dev versions of the plugin in the github repository.
		 */
		if ( defined( 'KIRKI_TEST' ) && true === KIRKI_TEST && file_exists( dirname( __FILE__ ) . '/example.php' ) ) {
			include_once dirname( __FILE__ ) . '/example.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
		}

	}
	add_action( 'plugins_loaded', 'kirki_pro_load_margin_padding_control' );

}
