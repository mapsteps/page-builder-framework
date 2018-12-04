<?php
/**
 * Theme Mods
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Excerpt Length
 */
function wpbf_excerpt_length( $excerpt_length ) {

	$wpbf_excerpt_length = get_theme_mod( 'excerpt_lenght' );

	if( !$wpbf_excerpt_length || $wpbf_excerpt_length == 0 ) return $excerpt_length;

	$excerpt_length = $wpbf_excerpt_length;

	return $excerpt_length;

}
add_filter( 'excerpt_length', 'wpbf_excerpt_length', 999 );

/**
 * Search Menu Item
 * 
 * Construct Search Menu Item to be displayed inside the main menu and navigation header.
 */
function wpbf_search_menu_item( $is_navigation = true, $is_mobile = false ) {

	// vars
	$class = $is_mobile ? 'wpbf-mobile-nav-item' : 'wpbf-nav-item';

	$search_item = '';

	// we have a slightly different markup for the search menu item if it's being displayed inside the main menu
	$search_item .= $is_navigation ? '<li class="menu-item wpbf-menu-item-search"><a href="#">' : '<div class="'. $class .' wpbf-menu-item-search">';
	$search_item .= '<div class="wpbf-menu-search">';

	// if we have a shop, we're going to call the product search form
	if ( class_exists( 'WooCommerce' ) ) {
		$search_item .= get_product_search_form( $echo = false );
	} else {
		$search_item .= get_search_form( $echo = false );
	}

	$search_item .= '</div>';
	$search_item .=  '<i class="wpbff wpbff-search" aria-hidden="true"></i>';
	$search_item .= '</a>';
	$search_item .= $is_navigation ? '</a></li>' : '</div>';

	return $search_item;

}

/**
 * Search Menu Item
 * 
 * Adding the Search Menu Item to the main navigation
 */
function wpbf_search_menu_icon( $items, $args ) {

	// stop here, if we have an off-canvas menu
	if( wpbf_is_off_canvas_menu() ) return $items;

	// only add the Search Menu Item to the main navigation and if it's enabled
	if( $args->theme_location == 'main_menu' && get_theme_mod( 'menu_search_icon' ) ) {

		$items .= wpbf_search_menu_item();

	}

	return $items;

}
add_filter( 'wp_nav_menu_items','wpbf_search_menu_icon', 20, 2 );

/**
 * Search Menu Item
 * 
 * Adding the Search Menu Item to the mobile navigation header
 */
function wpbf_search_menu_icon_mobile() {

	// stop here if Search Menu Item is turned off for mobiles
	if( !get_theme_mod( 'mobile_menu_search_icon' ) ) return;

	$menu_item = wpbf_search_menu_item( $is_navigation = false, $is_mobile = true );

	echo $menu_item; // WPCS: XSS ok.

}
add_action( 'wpbf_before_mobile_toggle', 'wpbf_search_menu_icon_mobile', 20 );