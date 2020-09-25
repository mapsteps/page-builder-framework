<?php
/**
 * LifterLMS functions.
 *
 * @package Page Builder Framework
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Remove LifterLMS default sidebars.
 */
function wpbf_lifterlms_remove_archive_sidebar() {

	remove_action( 'lifterlms_sidebar', 'lifterlms_get_sidebar' );

}
add_action( 'wp', 'wpbf_lifterlms_remove_archive_sidebar' );

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
 * Remove default theme sidebars from LifterLMS archives & membership pages.
 *
 * This is the preferred/opinionated default state.
 *
 * @param string $layout The sidebar layout
 *
 * @return string $layout The updated sidebar layout
 */
function wpbf_lifterlms_default_archive_sidebars( $layout ) {

	// Stop here if we're not on a LifterLMS archive or membership page.
	if ( ! wpbf_is_lifterlms_archive() && ! is_membership() ) {
		return $layout;
	}

	return 'none';

}
add_filter( 'wpbf_sidebar_layout', 'wpbf_lifterlms_default_archive_sidebars' );

/**
 * Remove sidebar from course pages if users are not logged in.
 *
 * This is the preferred/opinionated default state.
 *
 * @param string $layout The sidebar layout
 *
 * @return string $layout The updated sidebar layout
 */
function wpbf_lifterlms_remove_course_sidebar_if_not_logged_in( $layout ) {

	if ( is_course() && ! is_user_logged_in() ) {
		$layout = 'none';
	}

	return $layout;

}
add_filter( 'wpbf_sidebar_layout', 'wpbf_lifterlms_remove_course_sidebar_if_not_logged_in' );

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
 * Remove post links from lessons, quizzes & memberships.
 *
 */
function wpbf_lifterlms_remove_post_navigation() {

	if ( ! wpbf_is_lifterlms_single() ) {
		return;
	}

	remove_action( 'wpbf_post_links', 'wpbf_do_post_links' );

}
add_action( 'wp', 'wpbf_lifterlms_remove_post_navigation' );

/**
 * Remove header & footer from certificate pages.
 *
 */
function wpbf_lifterlms_remove_header_footer() {

	if ( ! is_singular( 'llms_certificate' ) ) {
		return;
	}

	remove_action( 'wpbf_header', 'wpbf_do_header' );
	remove_action( 'wpbf_footer', 'wpbf_do_footer' );

}
add_action( 'wp', 'wpbf_lifterlms_remove_header_footer' );

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

function wpbf_lifterlms_remove_title_from_dashboard( $title ) {

	if ( is_llms_account_page() ) {
		$title = false;
	}

	return $title;

}
add_filter( 'wpbf_title', 'wpbf_lifterlms_remove_title_from_dashboard' );
