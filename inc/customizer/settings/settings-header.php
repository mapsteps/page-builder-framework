<?php
/**
 * Header customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

use Mapsteps\Wpbf\Customizer\Controls\Builder\BuilderStore;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Header.
wpbf_customizer_panel()
	->id( 'header_panel' )
	->type( 'builder' )
	->title( __( 'Header', 'page-builder-framework' ) )
	->priority( 4 )
	->add();

/* Sections - Header */

// Pre header.
wpbf_customizer_section()
	->id( 'wpbf_pre_header_options' )
	->title( __( 'Pre Header', 'page-builder-framework' ) )
	->priority( 0 )
	->tabs( [
		'general' => [
			'label' => esc_html__( 'General', 'page-builder-framework' ),
		],
		'design'  => [
			'label' => esc_html__( 'Design', 'page-builder-framework' ),
		],
	] )
	->addToPanel( 'header_panel' );

// Navigation.
wpbf_customizer_section()
	->id( 'wpbf_menu_options' )
	->title( __( 'Navigation', 'page-builder-framework' ) )
	->priority( 200 )
	->tabs( [
		'general' => [
			'label' => esc_html__( 'General', 'page-builder-framework' ),
		],
		'design'  => [
			'label' => esc_html__( 'Design', 'page-builder-framework' ),
		],
	] )
	->addToPanel( 'header_panel' );

// Sub menu.
wpbf_customizer_section()
	->id( 'wpbf_sub_menu_options' )
	->title( __( 'Sub Menu', 'page-builder-framework' ) )
	->priority( 250 )
	->tabs( [
		'general' => [
			'label' => esc_html__( 'General', 'page-builder-framework' ),
		],
		'design'  => [
			'label' => esc_html__( 'Design', 'page-builder-framework' ),
		],
	] )
	->addToPanel( 'header_panel' );

// Mobile menu.
wpbf_customizer_section()
	->id( 'wpbf_mobile_menu_options' )
	->title( __( 'Mobile Navigation', 'page-builder-framework' ) )
	->priority( 300 )
	->tabs( [
		'general' => [
			'label' => esc_html__( 'General', 'page-builder-framework' ),
		],
		'design'  => [
			'label' => esc_html__( 'Design', 'page-builder-framework' ),
		],
	] )
	->addToPanel( 'header_panel' );

// Mobile menu.
wpbf_customizer_section()
	->id( 'wpbf_mobile_sub_menu_options' )
	->title( __( 'Mobile Sub Menu', 'page-builder-framework' ) )
	->priority( 350 )
	->addToPanel( 'header_panel' );

// Include split header settings files.
require_once __DIR__ . '/header/pre-header.php';
require_once __DIR__ . '/header/logo.php';
require_once __DIR__ . '/header/navigation.php';
require_once __DIR__ . '/header/sub-menu.php';
require_once __DIR__ . '/header/mobile-navigation.php';
require_once __DIR__ . '/header/mobile-sub-menu.php';
