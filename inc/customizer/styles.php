<?php
/**
 * Dynamic customizer CSS.
 *
 * Holds Customizer CSS styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

do_action( 'wpbf_before_customizer_css' );

$breakpoint_mobile_int  = function_exists( 'wpbf_breakpoint_mobile' ) ? wpbf_breakpoint_mobile() : 480;
$breakpoint_medium_int  = function_exists( 'wpbf_breakpoint_medium' ) ? wpbf_breakpoint_medium() : 768;
$breakpoint_desktop_int = function_exists( 'wpbf_breakpoint_desktop' ) ? wpbf_breakpoint_desktop() : 1024;

$breakpoint_mobile  = $breakpoint_mobile_int . 'px';
$breakpoint_medium  = $breakpoint_medium_int . 'px';
$breakpoint_desktop = $breakpoint_desktop_int . 'px';

$header_builder_enabled = wpbf_header_builder_enabled();

/* Typography */
require_once WPBF_THEME_DIR . '/inc/customizer/styles/typography-styles.php';


/* General */
require_once WPBF_THEME_DIR . '/inc/customizer/styles/layout-styles.php';


// Scrolltop.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/scrolltop-styles.php';


// Background.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/background-styles.php';


// Accent color.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/accent-color-styles.php';


// Theme buttons & Gutenberg blocks.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/button-styles.php';


// Sidebar.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/sidebar-styles.php';


// Breadcrumbs.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/breadcrumbs-styles.php';


// Pagination.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/pagination-styles.php';


// Blog layouts (archives & single).
require_once WPBF_THEME_DIR . '/inc/customizer/styles/blog-styles.php';


// Header (old, non-builder).
require_once WPBF_THEME_DIR . '/inc/customizer/styles/header-styles.php';


require_once WPBF_THEME_DIR . '/inc/customizer/styles/header-builder-styles.php';


// Footer.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/footer-styles.php';

do_action( 'wpbf_after_customizer_css' );
