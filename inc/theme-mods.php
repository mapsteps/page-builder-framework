<?php
/**
 * Theme Mods
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Excerpt Lenght
if ( get_theme_mod( 'excerpt_lenght' ) && get_theme_mod( 'excerpt_lenght' ) != 0 ) {

	add_filter( 'excerpt_length', 'wpbf_excerpt_length', 999 );
	function wpbf_excerpt_length( $length ) {

		return esc_attr( get_theme_mod( 'excerpt_lenght' ) );

	}

}

// Search
add_filter( 'wp_nav_menu_items','wpbf_menu_search', 10, 2 );
function wpbf_menu_search( $items, $args ) {

	if( $args->theme_location == 'main_menu' ) {

		if ( get_theme_mod( 'menu_search_icon' ) ) { 

			$menu_position = get_theme_mod( 'menu_position' );
			$menu_position =  $menu_position ? get_theme_mod( 'menu_position' ) : 'menu-right';
			$array = array( 'menu-right', 'menu-left', 'menu-stacked', 'menu-stacked-advanced', 'menu-centered' );

			if ( in_array( $menu_position, $array ) ) {

				$items .= '<li class="menu-item wpbf-menu-item-search">';
				$items .= '<a href="#">';
				$items .= '<div class="wpbf-menu-search">';
				$items .= get_search_form( $echo = false );
				$items .= '</div>';
				$items .= '<i class="fas fa-search" aria-hidden="true"></i>';
				$items .= '</a>';
				$items .= '</li>';

				return $items;

			}

		}

	}

	return $items;

}