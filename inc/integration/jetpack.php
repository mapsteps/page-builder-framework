<?php
/**
 * Jetpack Integration
 *
 * Displays posts on archives, category, search and index pages.
 *
 * @package Page Builder Framework
 * @subpackage Integration/Jetpack
 */

// exit if accessed directly
// if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Jetpack theme support
 */
function wpbf_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'wpbf_infinite_scroll_render',
		'footer'    => false,
	) );
}
add_action( 'after_setup_theme', 'wpbf_jetpack_setup' );

/**
 * Infinite Scroll render function
 */
function wpbf_infinite_scroll_render() {

	$blog_layout = wpbf_blog_layout();
	$blog_layout = $blog_layout['blog_layout'];

	get_template_part( 'inc/template-parts/blog-layouts/' . $blog_layout );

}


/**
 * Disable Infinite Scroll on WooCommerce
 */
function wpbf_woo_disable_infinite_scroll() {
	if ( is_woocommerce() ) {
		remove_theme_support( 'infinite-scroll' );
	}
}
add_action( 'pre_get_posts', 'wpbf_woo_disable_infinite_scroll' );