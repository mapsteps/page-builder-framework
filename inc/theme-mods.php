<?php
/**
 * Theme Mods
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Excerpt Lenght
function wpbf_excerpt_length( $length ) {

	$wpbf_excerpt_length = get_theme_mod( 'excerpt_lenght' );

	if( !$wpbf_excerpt_length || $wpbf_excerpt_length == 0 ) return $length;

	$length = $wpbf_excerpt_length;

	return $length;
}
add_filter( 'excerpt_length', 'wpbf_excerpt_length', 999 );

// Search
add_filter( 'wp_nav_menu_items','wpbf_menu_search', 20, 2 );
function wpbf_menu_search( $items, $args ) {

	if( $args->theme_location == 'main_menu' && get_theme_mod( 'menu_search_icon' ) ) {

		if ( in_array( get_theme_mod( 'menu_position', 'menu-right' ), array( 'menu-right', 'menu-left', 'menu-stacked', 'menu-stacked-advanced', 'menu-centered' ) ) ) {

			$items .= '<li class="menu-item wpbf-menu-item-search">';
			$items .= '<a href="#">';
			$items .= '<div class="wpbf-menu-search">';
			$items .= get_search_form( $echo = false );
			$items .= '</div>';
			$items .= '<i class="wpbff wpbff-search" aria-hidden="true"></i>';
			$items .= '</a>';
			$items .= '</li>';

		}

	}

	return $items;

}