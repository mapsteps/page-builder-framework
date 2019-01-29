<?php
/**
 * Misc
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Navigation Fallback
 * 
 * is displayed if no menu is selected and user is logged in + able to edit theme options
 */
function wpbf_menu_fallback() {

	if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {

		echo '<a style="float: right" target="_blank" href="'. esc_url( admin_url( '/nav-menus.php' ) ) .'">'. __( 'Add Menu', 'page-builder-framework' ) .'</a>'; // WPCS: XSS ok.

	}

}

/**
 * Add description to main menu items
 */
function wpbf_menu_description( $item_output, $item, $depth, $args ) {

	if( 'main_menu' == $args->theme_location && strlen( $item->description ) > 1 ) {

		$item_output .= '<div class="wpbf-menu-description">' . $item->description . '</div>';

	}

	return $item_output;

}
add_filter( 'walker_nav_menu_start_el', 'wpbf_menu_description', 10, 4 );

/**
 * Allow HTML inside menu descriptions
 */
remove_filter( 'nav_menu_description', 'strip_tags' );

function wpbf_menu_description_html( $menuItem ) {

	if ( isset( $menuItem->post_type ) && 'nav_menu_item' == $menuItem->post_type ) {

		$menuItem->description = apply_filters( 'nav_menu_description', $menuItem->post_content );

	}
	
	return $menuItem;

}
add_filter( 'wp_setup_nav_menu_item', 'wpbf_menu_description_html' );

/**
 * Load Google Fonts asynchronously
 */
if ( !class_exists( 'Kirki_Modules_Webfonts_Link' ) ) {

	require_once WPBF_THEME_DIR . '/assets/kirki-webfont-link.php';

}

function wpbf_change_fonts_load_method( $method ) {

	$wpbf_settings = get_option( 'wpbf_settings' );

	if( !isset( $wpbf_settings['wpbf_clean_head'] ) ) {

		$method = 'link';

	} else {

		if ( !in_array( 'google_fonts_async', $wpbf_settings['wpbf_clean_head'] ) ) {

			$method = 'link';

		}

	}

	return $method;

}
add_filter( 'kirki_googlefonts_load_method', 'wpbf_change_fonts_load_method' );

/**
 * Featured Plugin
 */
class WPBF_Featured_Plugin {

	public static function init() {
		add_filter( 'install_plugins_table_api_args_featured', [__CLASS__, 'featured_plugins_tab'] );
	}

	public static function featured_plugins_tab( $args ) {
		add_filter( 'plugins_api_result', [__CLASS__, 'inject_plugin'], 10, 3 );

		return $args;
	}

	public static function inject_plugin( $res, $action, $args ) {

		//remove filter to avoid infinite loop.
		remove_filter( 'plugins_api_result', [__CLASS__, 'inject_plugin'], 10, 3 );

		$api = plugins_api( 'plugin_information', array(
			'slug'   => 'ultimate-dashboard',
			'is_ssl' => is_ssl(),
			'fields' => array(
				'banners'			=> true,
				'reviews'			=> true,
				'downloaded'		=> true,
				'active_installs'	=> true,
				'icons'				=> true,
				'short_description'	=> true,
			)
		) );

		if ( !is_wp_error( $api ) ) {
			array_unshift( $res->plugins, $api );
		}

		return $res;
	}

	public static function instance() {
		add_action( 'after_setup_theme', [__CLASS__, 'init'] );
	}

}
WPBF_Featured_Plugin::instance();