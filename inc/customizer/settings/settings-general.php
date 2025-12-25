<?php
/**
 * General customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// General.
wpbf_customizer_panel()
	->id( 'layout_panel' )
	->title( __( 'General', 'page-builder-framework' ) )
	->priority( 2 )
	->add();

/* Sections */

// Layout.
wpbf_customizer_section()
	->id( 'wpbf_page_options' )
	->title( __( 'Layout', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'layout_panel' );

// Sidebar.
wpbf_customizer_section()
	->id( 'wpbf_sidebar_options' )
	->title( __( 'Sidebar', 'page-builder-framework' ) )
	->priority( 300 )
	->addToPanel( 'layout_panel' );

// 404.
wpbf_customizer_section()
	->id( 'wpbf_404_options' )
	->title( __( '404 Page', 'page-builder-framework' ) )
	->priority( 400 )
	->addToPanel( 'layout_panel' );

// Breadcrumbs.
wpbf_customizer_section()
	->id( 'wpbf_breadcrumb_settings' )
	->title( __( 'Breadcrumbs', 'page-builder-framework' ) )
	->priority( 500 )
	->addToPanel( 'layout_panel' );

// Buttons.
wpbf_customizer_section()
	->id( 'wpbf_button_options' )
	->title( __( 'Theme Buttons', 'page-builder-framework' ) )
	->priority( 600 )
	->addToPanel( 'layout_panel' );

// ScrollTop.
wpbf_customizer_section()
	->id( 'wpbf_scrolltop_options' )
	->title( __( 'Scroll to Top Button', 'page-builder-framework' ) )
	->priority( 700 )
	->addToPanel( 'layout_panel' );

/* Fields */

// Layout fields.
require_once __DIR__ . '/general/layout.php';

// Sidebar fields.
require_once __DIR__ . '/general/sidebar.php';

// 404 Page fields.
require_once __DIR__ . '/general/404.php';

// Breadcrumbs fields.
require_once __DIR__ . '/general/breadcrumbs.php';

// Theme Buttons fields.
require_once __DIR__ . '/general/buttons.php';

// Scroll to Top fields.
require_once __DIR__ . '/general/scrolltop.php';
