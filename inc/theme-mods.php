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
 * Filter 404 Page Title
 */
function wpbf_custom_404_title( $title ) {

	$custom_title = get_theme_mod( '404_headline' );

	if( $custom_title ) {
		$title = $custom_title;
	}

	return $title;

}
add_filter( 'wpbf_404_headline', 'wpbf_custom_404_title' );

/**
 * Filter 404 Page Text
 */
function wpbf_custom_404_text( $text ) {

	$custom_text = get_theme_mod( '404_text' );

	if( $custom_text ) {
		$text = $custom_text;
	}

	return $text;

}
add_filter( 'wpbf_404_text', 'wpbf_custom_404_text' );

/**
 * Hide Search Form from 404 Page
 */
function wpbf_remove_404_search_form() {

    if( is_404() && get_theme_mod( '404_search_form' ) == 'hide' ) {

        add_filter( 'get_search_form', '__return_false' );

    }

}
add_action( 'wp', 'wpbf_remove_404_search_form' );

/**
 * Search Menu Item
 * 
 * Construct Search Menu Item to be displayed inside the main menu and navigation header.
 */
function wpbf_search_menu_item( $is_navigation = true, $is_mobile = false ) {

	$class = $is_mobile ? 'wpbf-mobile-nav-item' : 'wpbf-nav-item';

	// if we have a shop, we're going to call the product search form
	if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'woocommerce_search_menu_item' ) ) {
		$search_form = get_product_search_form( $echo = false );
	} else {
		$search_form = get_search_form( $echo = false );
	}

	$search_form = apply_filters( 'wpbf_search_menu_item_form', $search_form );

	// initialize $search_item
	$search_item = '';

	// we have a slightly different markup for the search menu item if it's being displayed outside the main menu
	$search_item .= $is_navigation ? '<li class="menu-item wpbf-menu-item-search" aria-haspopup="true" aria-expanded="false"><a href="javascript:void(0)" role="button">' : '<button class="'. $class .' wpbf-menu-item-search" aria-haspopup="true" aria-expanded="false">';
	$search_item .= '<span class="screen-reader-text">'. __( 'Search Toggle', 'page-builder-framework' ) .'</span>';
	$search_item .= '<div class="wpbf-menu-search">';
	$search_item .= $search_form;
	$search_item .= '</div>';
	$search_item .= '<i class="wpbff wpbff-search" aria-hidden="true"></i>';
	$search_item .= $is_navigation ? '</a></li>' : '</button>';

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

/**
 * Custom Breadcrumbs Separator
 */
function wpbf_breadcrumbs_custom_separator( $separator ) {

	$custom_separator = get_theme_mod( 'breadcrumbs_separator' );

	if( $custom_separator ) {
		$separator = $custom_separator;
	}

	return $separator;

}
add_filter( 'wpbf_breadcrumbs_separator', 'wpbf_breadcrumbs_custom_separator' );

/**
 * Next Post Link
 */
function wpbf_next_post_link( $next ) {

	if( get_theme_mod( 'single_post_nav' ) !== 'default' ) return $next;

	$next = '%title &rarr;';

	return $next;

}
add_filter( 'wpbf_next_post_link', 'wpbf_next_post_link' );

/**
 * Previous Post Link
 */
function wpbf_previous_post_link( $prev ) {

	if( get_theme_mod( 'single_post_nav' ) !== 'default' ) return $prev;

	$prev = '&larr; %title';

	return $prev;

}
add_filter( 'wpbf_previous_post_link', 'wpbf_previous_post_link' );

/**
 * Categories Title
 */
function wpbf_categories_title( $title ) {

	$cat_title = get_theme_mod( 'blog_categories_title' );

	if( $cat_title && $cat_title !== 'Filed under:' ) {

		$title = $cat_title;

	}

	return $title;

}
add_filter( 'wpbf_categories_title', 'wpbf_categories_title' );

/**
 * Read More Text
 */
function wpbf_read_more_text( $text ) {

	$read_more_text = get_theme_mod( 'blog_read_more_text' );

	if( $read_more_text && $read_more_text !== 'Read more' ) {

		$text = $read_more_text;

	}

	return $text;

}
add_filter( 'wpbf_read_more_text', 'wpbf_read_more_text' );

/**
 * Aritlce Meta Separator
 */
 function wpbf_article_meta_separator( $separator ) {

	$blog_meta_separator = get_theme_mod( 'blog_meta_separator' );

	if( $blog_meta_separator ) {
		$separator = ' ' . $blog_meta_separator. ' ';
	}

	return $separator;

}
add_filter( 'wpbf_article_meta_separator', 'wpbf_article_meta_separator' );