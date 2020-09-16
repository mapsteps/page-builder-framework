<?php
/**
 * LifterLMS functions.
 *
 * @package Page Builder Framework
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Display LifterLMS course and lesson sidebars.
 *
 * @param string $id The default sidebar id
 *
 * @return string The updated sidebar id
 */
function wpbf_lifterlms_sidebar_function( $sidebar_id ) {

	$sidebar_id = 'sidebar-1';

	return $sidebar_id;

}
add_filter( 'llms_get_theme_default_sidebar', 'wpbf_lifterlms_sidebar_function' );

/**
 * Remove post links from lessons.
 *
 * Those are supposed to be handled by LifterLMS.
 */
function wpbf_lifterlms_remove_post_navigation() {

	if ( ! is_singular( 'lesson' ) ) {
		return;
	}

	remove_action( 'wpbf_post_links', 'wpbf_do_post_links' );

}
add_action( 'wp', 'wpbf_lifterlms_remove_post_navigation' );
