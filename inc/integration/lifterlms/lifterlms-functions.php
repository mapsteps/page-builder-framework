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

/**
 * Remove LifterLMS default sidebars.
 */
function wpbf_lifterlms_remove_archive_sidebar() {

	remove_action( 'lifterlms_sidebar', 'lifterlms_get_sidebar' );

}
add_action( 'wp', 'wpbf_lifterlms_remove_archive_sidebar' );

/**
 * Add an arbitrary plugin directory to the list.
 *
 * @param array $dirs Array of paths to directories to load LifterLMS templates from
 *
 * @return array Updated array of paths
 */
function wpbf_lifterlms_theme_override_dirs( $dirs ) {
	
	array_unshift( $dirs, WPBF_THEME_DIR . '/inc/integration/lifterlms/templates' );

	return $dirs;
	
}
add_filter( 'lifterlms_theme_override_directories', 'wpbf_lifterlms_theme_override_dirs', 10, 1 );
