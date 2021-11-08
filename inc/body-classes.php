<?php
/**
 * Body classes.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Body classes.
 *
 * @param array $classes The body classes.
 *
 * @return array The updated body classes.
 */
function wpbf_body_classes( $classes ) {

	// Add wpbf body class.
	$classes[] = 'wpbf';

	if ( get_theme_mod( 'page_boxed' ) ) {
		$classes[] = 'wpbf-boxed-layout';
	}


	// Add wpbf-{post-name} body class on singular.
	if ( is_singular() ) {
		global $post;
		$classes[] = 'wpbf-' . $post->post_name;
	}

	// Sidebar classes.
	$sidebar_layout = wpbf_sidebar_layout();

	$classes[] = 'none' === $sidebar_layout ? 'wpbf-no-sidebar' : 'wpbf-sidebar-' . $sidebar_layout;

	// Full width body class.
	$inner_content = wpbf_inner_content( $echo = false );

	if ( ! $inner_content ) {
		$classes[] = 'wpbf-full-width';
	}

	// WooCommerce list layout.
	if ( 'list' === get_theme_mod( 'woocommerce_loop_layout' ) ) {
		$classes[] = 'wpbf-woo-list-view';
	}

	return $classes;

}
add_filter( 'body_class', 'wpbf_body_classes' );

/**
 * Post classes.
 *
 * @param array $classes The post classes.
 *
 * @return array The updated post classes.
 */
function wpbf_post_classes( $classes ) {

	// Add wpbf-post class to all posts.
	$classes[] = 'wpbf-post';

	return $classes;

}
add_filter( 'post_class', 'wpbf_post_classes' );
