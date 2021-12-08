<?php
/**
 * LifterLMS integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * LifterLMS theme support.
 */
function wpbf_lifterlms_theme_support(){

	add_theme_support( 'lifterlms-sidebars' );

}
add_action( 'after_setup_theme', 'wpbf_lifterlms_theme_support' );

/**
 * Enqueue scripts & styles.
 */
function wpbf_lifterlms_scripts() {

	wp_enqueue_style( 'wpbf-lifterlms', get_template_directory_uri() . '/css/min/lifterlms-min.css', '', WPBF_VERSION );

}
add_action( 'wp_enqueue_scripts', 'wpbf_lifterlms_scripts', 10 );

// LifterLMS helpers.
require_once WPBF_THEME_DIR . '/inc/integration/lifterlms/lifterlms-helpers.php';

// LifterLMS customizer settings.
// require_once WPBF_THEME_DIR . '/inc/integration/lifterlms/lifterlms-customizer-settings.php';

// LifterLMS functions.
require_once WPBF_THEME_DIR . '/inc/integration/lifterlms/lifterlms-functions.php';

// LifterLMS customizer styles.
require_once WPBF_THEME_DIR . '/inc/integration/lifterlms/lifterlms-styles.php';
