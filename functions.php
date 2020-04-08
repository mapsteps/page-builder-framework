<?php
/**
 * Functions.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Constants
define( 'WPBF_THEME_DIR', get_template_directory() );
define( 'WPBF_THEME_URI', get_template_directory_uri() );
define( 'WPBF_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'WPBF_CHILD_THEME_URI', get_stylesheet_directory_uri() );
define( 'WPBF_VERSION', wp_get_theme( 'page-builder-framework' )->get( 'Version' ) );
define( 'WPBF_CHILD_VERSION', '1.1' );

/**
 * Theme setup.
 */
function wpbf_theme_setup() {

	// Textdomain.
	load_theme_textdomain( 'page-builder-framework', WPBF_THEME_DIR . '/languages' );

	// Custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'width'       => 180,
			'height'      => 48,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Custom background.
	add_theme_support(
		'custom-background',
		array(
			'default-color'      => 'ffffff',
			'default-image'      => '',
			'default-repeat'     => 'repeat',
			'default-position-x' => 'left',
			'default-position-y' => 'top',
			'default-size'       => 'auto',
			'default-attachment' => 'scroll',
		)
	);

	// Title tag.
	add_theme_support( 'title-tag' );

	// Post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Automatic feed links.
	add_theme_support( 'automatic-feed-links' );

	// HTML5 support.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	// Selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Register nav menu's.
	register_nav_menus(
		array(
			'main_menu'             => __( 'Main Menu', 'page-builder-framework' ),
			'mobile_menu'           => __( 'Mobile Menu', 'page-builder-framework' ),
			'pre_header_menu'       => __( 'Pre Header Left', 'page-builder-framework' ),
			'pre_header_menu_right' => __( 'Pre Header Right', 'page-builder-framework' ),
			'footer_menu'           => __( 'Footer Left', 'page-builder-framework' ),
			'footer_menu_right'     => __( 'Footer Right', 'page-builder-framework' ),
		)
	);

}
add_action( 'after_setup_theme', 'wpbf_theme_setup' );

// Content width.
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

/**
 * Register sidebars.
 */
function wpbf_sidebars() {

	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'page-builder-framework' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="wpbf-widgettitle">',
			'after_title'   => '</h4>',
		)
	);

}
add_action( 'widgets_init', 'wpbf_sidebars' );

/**
 * Enqueue scripts & styles.
 */
function wpbf_scripts() {

	// Main JS file.
	wp_enqueue_script( 'wpbf-site', get_template_directory_uri() . '/js/min/site-min.js', array( 'jquery' ), WPBF_VERSION, true );

	// Main stylesheet.
	wp_enqueue_style( 'wpbf-style', get_template_directory_uri() . '/style.css', '', WPBF_VERSION );

	// Responsive styles.
	wp_enqueue_style( 'wpbf-responsive', get_template_directory_uri() . '/css/min/responsive-min.css', '', WPBF_VERSION );

	// Comment reply.
	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_rtl() ) {

		// RTL.
		wp_enqueue_style( 'wpbf-rtl', get_template_directory_uri() . '/css/min/rtl-min.css', '', WPBF_VERSION );

	}

}
add_action( 'wp_enqueue_scripts', 'wpbf_scripts', 10 );

// Init.
require_once WPBF_THEME_DIR . '/inc/init.php';
