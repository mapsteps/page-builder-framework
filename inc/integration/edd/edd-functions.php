<?php
/**
 * EDD Functions
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */

/* Menu Item */

/**
 * Cart Menu Item
 */
function wpbf_edd_menu_item() {

	// vars
	$icon			= get_theme_mod( 'edd_menu_item_icon', 'cart' );
	$css_classes	= apply_filters( 'wpbf_edd_menu_item_classes', 'menu-item wpbf-edd-menu-item' );
	$title			= apply_filters( 'wpbf_edd_menu_item_title', __( 'Shopping Cart', 'page-builder-framework' ) );
	$cart_count		= edd_get_cart_quantity();
	$cart_url		= edd_get_checkout_uri();

	// construct menu item
	$menu_item = '';

	$menu_item .= '<li class="'. esc_attr( $css_classes ) .'">';

		$menu_item .= '<a href="' . esc_url( $cart_url ) . '" title="'. esc_attr( $title ) .'">';

			$menu_item .= apply_filters( 'wpbf_edd_before_menu_item', '' );

			$menu_item .= '<i class="wpbff wpbff-'. esc_attr( $icon ) .'"></i>';
			if( get_theme_mod( 'edd_menu_item_count' ) !== 'hide' ) $menu_item .= '<span class="wpbf-edd-menu-item-count">' . wp_kses_data( $cart_count ) . '</span>';

			$menu_item .= apply_filters( 'wpbf_edd_after_menu_item', '' );

		$menu_item .= '</a>';

		$menu_item .= apply_filters( 'wpbf_edd_menu_item_dropdown', '' );

	$menu_item .= '</li>';

	return $menu_item;

}

/**
 * Add Cart Menu Item to Main Navigation
 */
function wpbf_edd_menu_icon( $items, $args ) {

	// stop right here if menu item is hidden
	if( get_theme_mod( 'edd_menu_item_desktop' ) == 'hide' ) return $items;

	// hide if we're on non-EDD pages
	// if( get_theme_mod( 'edd_menu_item_hide_if_not_edd' ) && !is_woocommerce() ) return $items;

	// stop here if we're on a off canvas menu
	if( wpbf_is_off_canvas_menu() ) return $items;

	if ( $args->theme_location === 'main_menu' ) {

		$items .= wpbf_edd_menu_item();
	}

	return $items;

}
add_filter( 'wp_nav_menu_items', 'wpbf_edd_menu_icon', 10, 2 );

/**
 * Add Cart Menu Item to Mobile Menu Toggle
 */
function wpbf_edd_menu_icon_mobile() {

	// hide if mobile EDD menu item is disabled
	if( get_theme_mod( 'edd_menu_item_mobile' ) == 'hide' ) return;

	// hide if we're on non-EDD pages
	// if( get_theme_mod( 'edd_menu_item_hide_if_not_edd' ) && !is_woocommerce() ) return;

	$menu_item = '<ul class="wpbf-mobile-nav-item">';
	$menu_item .= wpbf_edd_menu_item();
	$menu_item .= '</ul>';

	echo $menu_item; // WPCS: XSS ok.

}
add_action( 'wpbf_before_mobile_toggle', 'wpbf_edd_menu_icon_mobile' );

/**
 * EDD Ajax
 */
function wpbf_edd_ajax() {

    wp_enqueue_script( 'wpbf-edd-ajax', get_template_directory_uri() . '/assets/edd/js/edd-ajax.js', array(  'jquery' ), '', true );

	wp_localize_script(
		'wpbf-edd-ajax',
		'wpbf_edd_fragments',
		array(  
			'ajaxurl'	=> function_exists( 'edd_get_ajax_url' ) ? edd_get_ajax_url() : admin_url( 'admin-ajax.php' ),
			'nonce'		=> wp_create_nonce( 'edd_ajax_nonce' )
		)
	);

}
add_action( 'wp_enqueue_scripts', 'wpbf_edd_ajax' );

function wpbf_edd_fragments() {

	check_ajax_referer( 'edd_ajax_nonce', 'security' );

	$menu_item = wpbf_edd_menu_item();
	echo $menu_item;
	die();

}
add_action( 'wp_ajax_wpbf_edd_fragments', 'wpbf_edd_fragments' );
add_action( 'wp_ajax_nopriv_wpbf_edd_fragments', 'wpbf_edd_fragments' );