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
 * @return string $id The updated sidebar id
 */
function wpbf_lifterlms_sidebar_function( $sidebar_id ) {

	$sidebar_id = 'sidebar-1';

	return $sidebar_id;

}
add_filter( 'llms_get_theme_default_sidebar', 'wpbf_lifterlms_sidebar_function' );

/**
 * Remove sidebars from LifterLMS archives.
 *
 * This is the preferred default state. Users can change this in the customizer.
 *
 * @param string $layout The sidebar layout
 *
 * @return string $layout The updated sidebar layout
 */
function wpbf_lifterlms_default_archive_sidebars( $layout ) {

	// Stop here if we're not on a page.
	if ( ! is_post_type_archive( 'course' ) && ! is_post_type_archive( 'llms_membership' ) ) {
		return $layout;
	}

	return 'none';

}
add_filter( 'wpbf_sidebar_layout', 'wpbf_lifterlms_default_archive_sidebars' );

/**
 * Replace sidebar widgets with the ones in LifterLMS' lesson sidebar when viewing a quiz.
 *
 * We must do this as they don't provide a more convenient way to manipulate sidebars on quizzes.
 * Simply replacing the sidebar won't work so we follow their process of replacing the widgets.
 *
 * @param array $widgets The widgets array
 *
 * @return array $widgets The updated widgets array
 */
function wpbf_lifterlms_replace_quiz_sidebar_widgets( $widgets ) {

	$sidebar_id = 'sidebar-1';

	if ( is_singular( 'llms_quiz' ) && array_key_exists( 'llms_lesson_widgets_side', $widgets ) ) {
		$widgets[$sidebar_id] = $widgets['llms_lesson_widgets_side'];
	}

	return $widgets;

}
add_filter( 'sidebars_widgets', 'wpbf_lifterlms_replace_quiz_sidebar_widgets' );

/**
 * Remove post links from lessons.
 *
 * Those are supposed to be handled by LifterLMS.
 */
function wpbf_lifterlms_remove_post_navigation() {

	if ( ! is_singular( 'lesson' ) && ! is_singular( 'llms_quiz' ) ) {
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
 * @return array $dirs Updated array of paths
 */
function wpbf_lifterlms_theme_override_dirs( $dirs ) {
	
	array_unshift( $dirs, WPBF_THEME_DIR . '/inc/integration/lifterlms/templates' );

	return $dirs;
	
}
add_filter( 'lifterlms_theme_override_directories', 'wpbf_lifterlms_theme_override_dirs', 10, 1 );
