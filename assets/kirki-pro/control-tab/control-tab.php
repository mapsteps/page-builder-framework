<?php
/**
 * Plugin Name: Kirki PRO - Tab Control
 * Plugin URI:  https://kirki.org
 * Description: Tab control for Kirki Customizer Framework.
 * Version:     0.1.0
 * Author:      David Vongries
 * Author URI:  https://davidvongries.com/
 * License:     GPL-3.0
 * License URI: https://oss.ninja/gpl-3.0?organization=Kirki%20Framework&project=control%20tab
 * Text Domain: control-tab
 * Domain Path: /languages
 *
 * @package kirki-pro/control-tab
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kirki_pro_load_tab_control' ) ) {

	/**
	 * Load tab control inside "plugins_loaded" hook.
	 * This is necessary to check if Kirki plugin is installed.
	 */
	function kirki_pro_load_tab_control() {

		// Stop, if Kirki is not installed.
		if ( ! defined( 'KIRKI_VERSION' ) ) {
			return;
		}

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin_data = get_plugin_data( __FILE__ );

		define( 'KIRKI_PRO_TAB_VERSION', $plugin_data['Version'] );
		define( 'KIRKI_PRO_TAB_PLUGIN_FILE', __FILE__ );

		require_once __DIR__ . '/vendor/autoload.php';

		new \Kirki\Pro\Tab\Init();

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

	add_action( 'plugins_loaded', 'kirki_pro_load_tab_control' );

}
