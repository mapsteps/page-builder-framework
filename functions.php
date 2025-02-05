<?php
/**
 * Functions.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

require_once __DIR__ . '/vendor/autoload.php';

// Constants.
define( 'WPBF_THEME_DIR', get_template_directory() );
define( 'WPBF_THEME_URI', get_template_directory_uri() );
define( 'WPBF_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'WPBF_CHILD_THEME_URI', get_stylesheet_directory_uri() );
define( 'WPBF_VERSION', wp_get_theme( 'page-builder-framework' )->get( 'Version' ) );
define( 'WPBF_CHILD_VERSION', '1.2' );

// Minimum required Premium Add-On Version.
define( 'WPBF_PREMIUM_MIN_VERSION', '2.10' );

/**
 * Theme setup.
 */
function wpbf_theme_setup() {

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
			'main_menu'   => __( 'Main Menu', 'page-builder-framework' ),
			'mobile_menu' => __( 'Mobile Menu', 'page-builder-framework' ),
		)
	);

	$pre_header_layout = get_theme_mod( 'pre_header_layout' );
	$footer_layout     = get_theme_mod( 'footer_layout' );

	if ( $pre_header_layout && 'none' !== $pre_header_layout ) {

		register_nav_menus(
			array(
				'pre_header_menu'       => __( 'Pre Header Left', 'page-builder-framework' ),
				'pre_header_menu_right' => __( 'Pre Header Right', 'page-builder-framework' ),
			)
		);

	}

	if ( 'none' !== $footer_layout ) {

		register_nav_menus(
			array(
				'footer_menu'       => __( 'Footer Left', 'page-builder-framework' ),
				'footer_menu_right' => __( 'Footer Right', 'page-builder-framework' ),
			)
		);

	}

}
add_action( 'after_setup_theme', 'wpbf_theme_setup' );

/**
 * Theme init.
 */
function wpbf_theme_init() {

	// Textdomain.
	load_theme_textdomain( 'page-builder-framework', WPBF_THEME_DIR . '/languages' );

}
add_action( 'init', 'wpbf_theme_init' );

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
	if ( wp_script_is( 'jquery', 'enqueued' ) ) {
		wp_enqueue_script( 'wpbf-site', get_template_directory_uri() . '/js/min/site-jquery-min.js', array( 'jquery' ), WPBF_VERSION, true );
	} else {
		wp_enqueue_script( 'wpbf-site', get_template_directory_uri() . '/js/min/site-min.js', array(), WPBF_VERSION, true );
	}

	wp_add_inline_script(
		'wpbf-site',
		'var WpbfObj = {
			ajaxurl: "' . admin_url( 'admin-ajax.php' ) . '"
		};',
		'before'
	);

	// Icon Font.
	if ( ! wpbf_svg_enabled() ) {
		wp_enqueue_style( 'wpbf-icon-font', get_template_directory_uri() . '/css/min/iconfont-min.css', '', WPBF_VERSION );
	}

	// Main stylesheet.
	wp_enqueue_style( 'wpbf-style', get_template_directory_uri() . '/css/min/style-min.css', '', WPBF_VERSION );

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

/**
 * Enqueue admin styles & scripts to targetted admin area.
 */
function wpbf_enqueue_admin_scripts() {

	if ( is_rtl() ) {
		// RTL.
		wp_enqueue_style( 'wpbf-admin-rtl', get_template_directory_uri() . '/css/min/admin-rtl-min.css', '', WPBF_VERSION );
	}

	wp_enqueue_style( 'wpbf-activation-notice', WPBF_THEME_URI . '/assets/css/admin-notices.css', array(), WPBF_VERSION );
	wp_enqueue_script( 'wpbf-activation-notice', WPBF_THEME_URI . '/js/min/activation-notice-min.js', array( 'jquery' ), WPBF_VERSION, true );

	wp_localize_script(
		'wpbf-activation-notice',
		'wpbfOpts',
		array(
			'activationNotice' => array(
				'dismissalNonce' => wp_create_nonce( 'WPBF_Dismiss_Activation_Notice' ),
			),
			'bfcmNotice'       => array(
				'dismissalNonce' => wp_create_nonce( 'WPBF_Dismiss_Bfcm_Notice' ),
			),
		)
	);

	$current_screen = get_current_screen();
	$post_types     = get_post_types( array( 'public' => true ) );

	if ( 'appearance_page_wpbf-premium' === $current_screen->id ) {
		// Enqueue on "Theme Settings" page.

		wp_enqueue_style( 'heatbox', WPBF_THEME_URI . '/assets/css/heatbox.css', array(), WPBF_VERSION );
		wp_enqueue_style( 'wpbf-admin-page', WPBF_THEME_URI . '/assets/css/admin-page.css', array(), WPBF_VERSION );

		wp_enqueue_script( 'wpbf-theme-settings', WPBF_THEME_URI . '/js/min/theme-settings-min.js', array( 'jquery' ), WPBF_VERSION, true );

	} elseif ( in_array( $current_screen->post_type, $post_types, true ) ) {

		if ( "edit-{$current_screen->post_type}" === $current_screen->id ) {
			// Enqueue on post list page.

			wp_enqueue_style( 'wpbf-post-list', WPBF_THEME_URI . '/css/min/post-list-min.css', array(), WPBF_VERSION );
			wp_enqueue_script( 'wpbf-post-list', WPBF_THEME_URI . '/js/min/post-list-min.js', array( 'jquery', 'wp-polyfill' ), WPBF_VERSION, true );

		} elseif ( $current_screen->post_type === $current_screen->id ) {
			// Enqueue on edit post page.

			wp_enqueue_style( 'wpbf-edit-post', WPBF_THEME_URI . '/css/min/edit-post-min.css', array(), WPBF_VERSION );
			wp_enqueue_script( 'wpbf-edit-post', WPBF_THEME_URI . '/js/min/edit-post-min.js', array( 'jquery', 'wp-polyfill' ), WPBF_VERSION, true );

		}
	}

}
add_action( 'admin_enqueue_scripts', 'wpbf_enqueue_admin_scripts' );

// Init.
require_once WPBF_THEME_DIR . '/inc/init.php';
