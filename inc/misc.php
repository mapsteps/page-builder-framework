<?php
/**
 * Misc
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Navigation Fallback
function wpbf_menu_fallback() {
	if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) { ?>
			<a style="float: right" target="_blank" href="<?php echo esc_url( admin_url( '/nav-menus.php' ) ); ?>"><?php _e( 'Add Menu', 'page-builder-framework' ); // WPCS: XSS ok. ?></a>
	<?php }
}

// add description to main menu
function wpbf_menu_description( $item_output, $item, $depth, $args ) {

	if( 'main_menu' == $args->theme_location && strlen( $item->description ) > 1 ) {
		$item_output .= '<div class="wpbf-menu-description">' . $item->description . '</div>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'wpbf_menu_description', 10, 4 );

// allow HTML inside menu descriptions
remove_filter( 'nav_menu_description', 'strip_tags' );

add_filter( 'wp_setup_nav_menu_item', 'wpbf_menu_description_html' );
function wpbf_menu_description_html( $menuItem ) {

	if ( isset( $menuItem->post_type ) && 'nav_menu_item' == $menuItem->post_type ) {
		$menuItem->description = apply_filters( 'nav_menu_description', $menuItem->post_content );
	}
	
	return $menuItem;
}

// Load Google Fonts asynchronously
$file_path = wp_normalize_path( WPBF_THEME_DIR . '/assets/kirki-webfont-link.php' );
if ( file_exists( $file_path ) && ! class_exists( 'Kirki_Modules_Webfonts_Link' ) ) {
	include_once $file_path;
}

function wpbf_theme_change_fonts_load_method( $method ) {

	$wpbf_settings = get_option( 'wpbf_settings' );

	if( !isset( $wpbf_settings['wpbf_clean_head'] ) ) {

		return 'link';

	} else {

		$wpbf_performance = $wpbf_settings['wpbf_clean_head'];

		if ( !in_array( 'google_fonts_async', $wpbf_performance ) ) {

			return 'link';

		}

	}

	return $method;
}

add_filter( 'kirki_googlefonts_load_method', 'wpbf_theme_change_fonts_load_method' );