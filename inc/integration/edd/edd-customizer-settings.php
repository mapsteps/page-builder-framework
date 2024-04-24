<?php
/**
 * Easy Digital Downloads customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Load textdomain. This is required to make strings translatable.
load_theme_textdomain( 'page-builder-framework' );

/* Panels */

// Easy Digital Downloads.
wpbf_customizer_panel()
	->id( 'edd_panel' )
	->title( __( 'Easy Digital Downloads', 'page-builder-framework' ) )
	->priority( 200 )
	->add();

/* Sections */

// Menu item.
wpbf_customizer_section()
	->id( 'wpbf_edd_menu_item_options' )
	->title( __( 'Cart Menu Item', 'page-builder-framework' ) )
	->priority( 1 )
	->addToPanel( 'edd_panel' );

// Sidebar.
wpbf_customizer_section()
	->id( 'wpbf_edd_sidebar_options' )
	->title( __( 'Sidebar', 'page-builder-framework' ) )
	->priority( 2 )
	->addToPanel( 'edd_panel' );

/* Fields - Sidebar */

// Shop sidebar layout.
wpbf_customizer_field()
	->id( 'edd_sidebar_layout' )
	->type( 'select' )
	->label( __( 'Shop Page Sidebar', 'page-builder-framework' ) )
	->defaultValue( 'global' )
	->priority( 0 )
	->choices( array(
		'global' => __( 'Inherit Global Settings', 'page-builder-framework' ),
		'right'  => __( 'Right', 'page-builder-framework' ),
		'left'   => __( 'Left', 'page-builder-framework' ),
		'none'   => __( 'No Sidebar', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_edd_sidebar_options' );

// Product sidebar layout.
wpbf_customizer_field()
	->id( 'edd_single_sidebar_layout' )
	->type( 'select' )
	->label( __( 'Product Page Sidebar', 'page-builder-framework' ) )
	->defaultValue( 'global' )
	->priority( 0 )
	->choices( array(
		'global' => __( 'Inherit Global Settings', 'page-builder-framework' ),
		'right'  => __( 'Right', 'page-builder-framework' ),
		'left'   => __( 'Left', 'page-builder-framework' ),
		'none'   => __( 'No Sidebar', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_edd_sidebar_options' );

/* Fields - Menu Item */

// Hide from non-EDD pages.
wpbf_customizer_field()
	->id( 'edd_menu_item_hide_if_not_edd' )
	->type( 'toggle' )
	->label( __( 'Hide from non-Shop Pages', 'page-builder-framework' ) )
	->description( __( 'Display Menu Item only on EDD related pages.', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 5 )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Separator.
wpbf_customizer_field()
	->id( 'edd_menu_item_separator_1' )
	->type( 'divider' )
	->priority( 5 )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Menu item.
wpbf_customizer_field()
	->id( 'edd_menu_item_desktop' )
	->type( 'select' )
	->label( __( 'Visibility (Desktop)', 'page-builder-framework' ) )
	->description( __( 'Add a Cart Icon to your Main Navigation.', 'page-builder-framework' ) )
	->defaultValue( 'show' )
	->priority( 10 )
	->choices( array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	) )
	->partialRefresh( array(
		'eddmenuitemdesktop' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	) )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Menu item color.
wpbf_customizer_field()
	->id( 'edd_menu_item_desktop_color' )
	->type( 'color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->defaultValue( '' )
	->priority( 11 )
	->transport( 'postMessage' )
	->activeCallback( array(
		array(
			'id'       => 'edd_menu_item_desktop',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'id'       => 'edd_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	) )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Separator.
wpbf_customizer_field()
	->id( 'edd_menu_item_separator_2' )
	->type( 'divider' )
	->priority( 12 )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Mobile menu item.
wpbf_customizer_field()
	->id( 'edd_menu_item_mobile' )
	->type( 'select' )
	->label( __( 'Visibility (Mobile)', 'page-builder-framework' ) )
	->description( __( 'Add a Cart Icon to your Mobile Navigation.', 'page-builder-framework' ) )
	->defaultValue( 'show' )
	->priority( 13 )
	->choices( array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	) )
	->partialRefresh( array(
		'eddmenuitemmobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	) )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Menu item color.
wpbf_customizer_field()
	->id( 'edd_menu_item_mobile_color' )
	->type( 'color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->defaultValue( '' )
	->priority( 14 )
	->transport( 'postMessage' )
	->activeCallback( array(
		array(
			'id'       => 'edd_menu_item_mobile',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'id'       => 'edd_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	) )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Separator.
wpbf_customizer_field()
	->id( 'edd_menu_item_separator_3' )
	->type( 'divider' )
	->priority( 15 )
	->addToSection( 'wpbf_edd_menu_item_options' );

// Menu item count.
wpbf_customizer_field()
	->id( 'edd_menu_item_count' )
	->type( 'select' )
	->label( __( 'Count', 'page-builder-framework' ) )
	->defaultValue( 'show' )
	->priority( 16 )
	->choices( array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	) )
	->partialRefresh( array(
		'eddmenuitemcount' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'renderCallback'      => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	) )
	->addToSection( 'wpbf_edd_menu_item_options' );
