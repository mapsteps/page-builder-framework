<?php
/**
 * Plugin Name: Kirki PRO - Headlines & Divider Control
 * Plugin URI:  https://kirki.org
 * Description: Headlines & divider control for Kirki Customizer Framework.
 * Version:     0.1.0
 * Author:      David Vongries
 * Author URI:  https://davidvongries.com/
 * License:     GPL-3.0
 * License URI: https://oss.ninja/gpl-3.0?organization=Kirki%20Framework&project=control%20headline%20divider
 * Text Domain: kirki-pro-headline-divider
 * Domain Path: /languages
 *
 * @package kirki-pro-headline-divider
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kirki_pro_load_headline_divider_control' ) ) {

	/**
	 * Load headline divider control.
	 */
	function kirki_pro_load_headline_divider_control() {

		// Stop, if Kirki is not installed.
		if ( ! defined( 'KIRKI_VERSION' ) ) {
			return;
		}

		define( 'KIRKI_PRO_HEADLINE_DIVIDER_VERSION', '0.1.0' );
		define( 'KIRKI_PRO_HEADLINE_DIVIDER_PLUGIN_FILE', __FILE__ );

		require_once __DIR__ . '/vendor/autoload.php';

		new \Kirki\Pro\HeadlineDivider\Init();

	}
	add_action( 'plugins_loaded', 'kirki_pro_load_headline_divider_control' );

}
