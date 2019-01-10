<?php
/**
 * Body Classes
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Body Classes
 */
function wpbf_body_classes( $classes ) {

	// Add wpbf Body Class
	$classes[] = 'wpbf';

	// Add wpbf-{post-name} Body Class on Singular
	if( is_singular() ) {
		global $post;
		$classes[] = 'wpbf-' . $post->post_name;
	}

	// Sidebar Classes
	if( is_page() && !is_page_template( 'page-sidebar.php' ) ) {
		$classes[] = 'wpbf-no-sidebar';
	} else {
		$classes[] = wpbf_sidebar_layout() == 'none' ? 'wpbf-no-sidebar' : 'wpbf-sidebar-' . wpbf_sidebar_layout();
	}

	// Sub Menu Alignment Body Class
	$sub_menu_alignment = get_theme_mod( 'sub_menu_alignment' );

	if( $sub_menu_alignment == 'right' ) {
		$classes[] = 'wpbf-sub-menu-align-right';
	} elseif( $sub_menu_alignment == 'center' ) {
		$classes[] = 'wpbf-sub-menu-align-center';
	} else {
		$classes[] = 'wpbf-sub-menu-align-left';
	}

	// Full Width Body Class
	$inner_content = wpbf_inner_content( $echo = false );

	if( !$inner_content ) {
		$classes[] = 'wpbf-full-width';
	}

	return $classes;

}
add_filter( 'body_class', 'wpbf_body_classes' );

/**
 * Post Classes
 */
function wpbf_post_classes( $classes ) {

	// Add wpbf-post Class to all Posts
	$classes[] = 'wpbf-post';

	return $classes;

}
add_filter( 'post_class', 'wpbf_post_classes' );