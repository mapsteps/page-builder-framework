<?php
/**
 * Typography panel and sections.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Typography.
wpbf_customizer_panel()
	->id( 'typo_panel' )
	->title( __( 'Typography', 'page-builder-framework' ) )
	->priority( 3 )
	->add();

/* Sections */

// Title & tagline.
wpbf_customizer_section()
	->id( 'wpbf_title_tagline_options' )
	->title( __( 'Site Title / Tagline', 'page-builder-framework' ) )
	->priority( 0 )
	->addToPanel( 'typo_panel' );

// Menu.
wpbf_customizer_section()
	->id( 'wpbf_menu_font_options' )
	->title( __( 'Navigation', 'page-builder-framework' ) )
	->priority( 50 )
	->addToPanel( 'typo_panel' );

// Sub Menu.
wpbf_customizer_section()
	->id( 'wpbf_sub_menu_font_options' )
	->title( __( 'Sub Menu', 'page-builder-framework' ) )
	->priority( 75 )
	->addToPanel( 'typo_panel' );

// Text.
wpbf_customizer_section()
	->id( 'wpbf_font_options' )
	->title( __( 'Text', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'typo_panel' );

// H1.
wpbf_customizer_section()
	->id( 'wpbf_h1_options' )
	->title( __( 'H1', 'page-builder-framework' ) )
	->priority( 200 )
	->addToPanel( 'typo_panel' );

// H2.
wpbf_customizer_section()
	->id( 'wpbf_h2_options' )
	->title( __( 'H2', 'page-builder-framework' ) )
	->priority( 300 )
	->addToPanel( 'typo_panel' );

// H3.
wpbf_customizer_section()
	->id( 'wpbf_h3_options' )
	->title( __( 'H3', 'page-builder-framework' ) )
	->priority( 400 )
	->addToPanel( 'typo_panel' );

// H4.
wpbf_customizer_section()
	->id( 'wpbf_h4_options' )
	->title( __( 'H4', 'page-builder-framework' ) )
	->priority( 500 )
	->addToPanel( 'typo_panel' );

// H5.
wpbf_customizer_section()
	->id( 'wpbf_h5_options' )
	->title( __( 'H5', 'page-builder-framework' ) )
	->priority( 600 )
	->addToPanel( 'typo_panel' );

// H6.
wpbf_customizer_section()
	->id( 'wpbf_h6_options' )
	->title( __( 'H6', 'page-builder-framework' ) )
	->priority( 700 )
	->addToPanel( 'typo_panel' );

// Footer.
wpbf_customizer_section()
	->id( 'wpbf_footer_font_options' )
	->title( __( 'Footer', 'page-builder-framework' ) )
	->priority( 800 )
	->addToPanel( 'typo_panel' );
