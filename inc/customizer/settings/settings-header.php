<?php
/**
 * Header customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Header.
wpbf_customizer_panel()
	->id( 'header_panel' )
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

/* Fields – Pre Header */

// Pre header layout.
wpbf_customizer_field()
	->id( 'pre_header_layout' )
	->type( 'radio-buttonset' )
	->tab( 'general' )
	->label( __( 'Layout', 'page-builder-framework' ) )
	->defaultValue( 'none' )
	->priority( 1 )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'one'  => __( 'One Column', 'page-builder-framework' ),
		'two'  => __( 'Two Columns', 'page-builder-framework' ),
	] )
	->partialRefresh( [
		'preheaderlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Column one layout.
wpbf_customizer_field()
	->id( 'pre_header_column_one_layout' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 1', 'page-builder-framework' ) )
	->defaultValue( 'text' )
	->choices( [
		'text'    => __( 'Text', 'page-builder-framework' ),
		'button'  => __( 'Button', 'page-builder-framework' ),
		'primary' => __( 'Button (Primary)', 'page-builder-framework' ),
	] )
	->priority( 2 )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	] )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->partialRefresh( [
		'preheadercolumnonelayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );


// Column one.
wpbf_customizer_field()
	->id( 'pre_header_column_one' )
	->type( 'textarea' )
	->tab( 'general' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( __( 'Column 1', 'page-builder-framework' ) )
	->priority( 2 )
	->partialRefresh( [
		'preheadercolumnonecontent' => array(
			'selector'        => '.wpbf-inner-pre-header-left, .wpbf-inner-pre-header-content',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_one' ) );
			},
		),
	] )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'id'       => 'pre_header_column_one_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Separator.
wpbf_customizer_field()
	->id( 'pre_header_column_two_layout_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->priority( 2 )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Column two layout.
wpbf_customizer_field()
	->id( 'pre_header_column_two_layout' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 2', 'page-builder-framework' ) )
	->defaultValue( 'text' )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	] )
	->priority( 2 )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	] )
	->partialRefresh( [
		'preheadercolumntwolayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Column two.
wpbf_customizer_field()
	->id( 'pre_header_column_two' )
	->type( 'textarea' )
	->tab( 'general' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( __( 'Column 2', 'page-builder-framework' ) )
	->priority( 2 )
	->partialRefresh( [
		'preheadercolumntwocontent' => array(
			'selector'        => '.wpbf-inner-pre-header-right',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_two' ) );
			},
		),
	] )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
		array(
			'id'       => 'pre_header_column_two_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Separator.
wpbf_customizer_field()
	->id( 'pre_header_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->priority( 3 )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Width.
wpbf_customizer_field()
	->id( 'pre_header_width' )
	->type( 'dimension' )
	->tab( 'general' )
	->label( __( 'Pre Header Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Height.
wpbf_customizer_field()
	->id( 'pre_header_height' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Height', 'page-builder-framework' ) )
	->priority( 3 )
	->defaultValue( 10 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 1,
		'max'  => 25,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Background color.
wpbf_customizer_field()
	->id( 'pre_header_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Font color.
wpbf_customizer_field()
	->id( 'pre_header_font_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Accent color.
wpbf_customizer_field()
	->id( 'pre_header_accent_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Accent color alt.
wpbf_customizer_field()
	->id( 'pre_header_accent_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Font size.
wpbf_customizer_field()
	->id( 'pre_header_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 4 )
	->defaultValue( '14px' )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_pre_header_options' );

/* Fields – Logo */

// Mobile logo.
wpbf_customizer_field()
	->id( 'menu_mobile_logo' )
	->type( 'image' )
	->label( __( 'Mobile Logo', 'page-builder-framework' ) )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->partialRefresh( [
		'mobilelogo' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-mobile-logo',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/logo/logo-mobile' );
			},
		),
	] )
	->addToSection( 'title_tagline' );

// Size.
wpbf_customizer_field()
	->id( 'menu_logo_size' )
	->type( 'responsive-input-slider' )
	->label( __( 'Logo Width', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'min'          => 0,
		'max'          => 500,
		'step'         => 1,
		'save_as_json' => true,
	] )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'logo_image_separator' )
	->type( 'divider' )
	->priority( 4 )
	->addToSection( 'title_tagline' );

// Color.
wpbf_customizer_field()
	->id( 'menu_logo_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->priority( 11 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Hover color.
wpbf_customizer_field()
	->id( 'menu_logo_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 12 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Font size.
wpbf_customizer_field()
	->id( 'menu_logo_font_size' )
	->type( 'responsive-input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 13 )
	->transport( 'postMessage' )
	->defaultValue( [
		'desktop' => '22px',
		'tablet'  => '',
		'mobile'  => '',
	] )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->properties( [
		'min'          => 0,
		'max'          => 50,
		'step'         => 1,
		'save_as_json' => true,
	] )
	->addToSection( 'title_tagline' );


// Separator.
wpbf_customizer_field()
	->id( 'tagline_separator' )
	->type( 'divider' )
	->priority( 14 )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

/* Fields – Tagline */

// Toggle.
wpbf_customizer_field()
	->id( 'menu_logo_description' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Display Tagline', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 20 )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->partialRefresh( [
		'displaytagline' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'title_tagline' );

// Mobile toggle.
wpbf_customizer_field()
	->id( 'menu_logo_description_mobile' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Display Tagline on Mobile', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 20 )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'id'       => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->partialRefresh( [
		'displaytaglinemobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'title_tagline' );

// Color.
wpbf_customizer_field()
	->id( 'menu_logo_description_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->priority( 22 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'id'       => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'title_tagline' );

// Font size.
wpbf_customizer_field()
	->id( 'menu_logo_description_font_size' )
	->type( 'responsive-input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 23 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'id'       => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->properties( [
		'min'          => 0,
		'max'          => 50,
		'step'         => 1,
		'save_as_json' => true,
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'logo_settings_separator' )
	->type( 'divider' )
	->priority( 24 )
	->addToSection( 'title_tagline' );

/* Fields – Logo Settings */

// Logo URL.
wpbf_customizer_field()
	->id( 'menu_logo_url' )
	->type( 'url' )
	->tab( 'general' )
	->label( __( 'Custom Logo URL', 'page-builder-framework' ) )
	->priority( 30 )
	->transport( 'postMessage' )
	->addToSection( 'title_tagline' );

// Alt tag.
wpbf_customizer_field()
	->id( 'menu_logo_alt' )
	->type( 'text' )
	->tab( 'general' )
	->label( __( 'Custom "alt" Tag', 'page-builder-framework' ) )
	->priority( 31 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Title tag.
wpbf_customizer_field()
	->id( 'menu_logo_title' )
	->type( 'text' )
	->label( __( 'Custom "title" Tag', 'page-builder-framework' ) )
	->priority( 32 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'logo_container_separator' )
	->type( 'divider' )
	->priority( 33 )
	->addToSection( 'title_tagline' );

/* Fields – Logo Container Width */

// Container width.
wpbf_customizer_field()
	->id( 'menu_logo_container_width' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Logo Container Width', 'page-builder-framework' ) )
	->description( __( 'Defines the space in % the logo area takes in the navigation.', 'page-builder-framework' ) )
	->defaultValue( 25 )
	->priority( 40 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 10,
		'max'  => 40,
		'step' => 1,
	] )
	->addToSection( 'title_tagline' );

// Mobile container width.
wpbf_customizer_field()
	->id( 'mobile_menu_logo_container_width' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Logo Container Width (Mobile)', 'page-builder-framework' ) )
	->description( __( 'Defines the space in % the logo area takes in the navigation.', 'page-builder-framework' ) )
	->defaultValue( 66 )
	->priority( 41 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 10,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'favicon_separator' )
	->type( 'divider' )
	->priority( 42 )
	->addToSection( 'title_tagline' );

/* Fields – Navigation */

$menu_position_choices = apply_filters(
	'wpbf_menu_position',
	array(
		'menu-right'    => __( 'Right (default)', 'page-builder-framework' ),
		'menu-left'     => __( 'Left', 'page-builder-framework' ),
		'menu-centered' => __( 'Centered', 'page-builder-framework' ),
		'menu-stacked'  => __( 'Stacked', 'page-builder-framework' ),
	)
);

// Variations.
wpbf_customizer_field()
	->id( 'menu_position' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Menu', 'page-builder-framework' ) )
	->defaultValue( 'menu-right' )
	->priority( 0 )
	->choices( $menu_position_choices )
	->partialRefresh( [
		'headerlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'menu_position_separator' )
	->type( 'divider' )
	->priority( 0 )
	->tab( 'general' )
	->addToSection( 'wpbf_menu_options' );

// Search icon.
wpbf_customizer_field()
	->id( 'menu_search_icon' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Search Icon', 'page-builder-framework' ) )
	->priority( 1 )
	->partialRefresh( [
		'menusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'menu_search_icon_separator' )
	->type( 'divider' )
	->priority( 1 )
	->tab( 'general' )
	->addToSection( 'wpbf_menu_options' );

// Width.
wpbf_customizer_field()
	->id( 'menu_width' )
	->type( 'dimension' )
	->tab( 'general' )
	->label( __( 'Navigation Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_menu_options' );

// Height.
wpbf_customizer_field()
	->id( 'menu_height' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Menu Height', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( 'wpbf_menu_options' );

// Padding.
wpbf_customizer_field()
	->id( 'menu_padding' )
	->type( 'slider' )
	->tab( 'design' )
	->label( __( 'Menu Item Spacing', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 5,
		'max'  => 40,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'id'       => 'menu_position',
			'operator' => '!=',
			'value'    => 'menu-off-canvas',
		),
		array(
			'id'       => 'menu_position',
			'operator' => '!=',
			'value'    => 'menu-off-canvas-left',
		),
	] )
	->addToSection( 'wpbf_menu_options' );

// Background color.
wpbf_customizer_field()
	->id( 'menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#f5f5f7' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_menu_options' );

// Font color.
wpbf_customizer_field()
	->id( 'menu_font_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_menu_options' );

// Font color alt.
wpbf_customizer_field()
	->id( 'menu_font_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_menu_options' );

// Font size.
wpbf_customizer_field()
	->id( 'menu_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 7 )
	->defaultValue( '16px' )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( 'wpbf_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_menu_options' );

}

/* Fields – Sub Menu */

// Width.
wpbf_customizer_field()
	->id( 'sub_menu_width' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Sub Menu Width', 'page-builder-framework' ) )
	->defaultValue( 220 )
	->priority( 0 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 100,
		'max'  => 400,
		'step' => 1,
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Alignment.
wpbf_customizer_field()
	->id( 'sub_menu_alignment' )
	->type( 'radio-image' )
	->tab( 'general' )
	->label( __( 'Sub Menu Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->choices( [
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->priority( 1 )
	->transport( 'postMessage' )
	->partialRefresh( [
		'submenualignment' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Text alignment.
wpbf_customizer_field()
	->id( 'sub_menu_text_alignment' )
	->type( 'radio-image' )
	->tab( 'general' )
	->label( __( 'Text Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->choices( [
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->priority( 2 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_sub_menu_options' );

// Padding.
wpbf_customizer_field()
	->id( 'sub_menu_padding' )
	->type( 'padding' )
	->tab( 'general' )
	->label( __( 'Menu Item Padding', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->defaultValue( [
		'top'    => 10,
		'right'  => 20,
		'bottom' => 10,
		'left'   => 20,
	] )
	->properties( [
		'save_as_json'   => true,
		'dont_save_unit' => true,
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Background color.
wpbf_customizer_field()
	->id( 'sub_menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Background color alt.
wpbf_customizer_field()
	->id( 'sub_menu_bg_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Accent color.
wpbf_customizer_field()
	->id( 'sub_menu_accent_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Accent color alt.
wpbf_customizer_field()
	->id( 'sub_menu_accent_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );


// Font size.
wpbf_customizer_field()
	->id( 'sub_menu_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Separator toggle.
wpbf_customizer_field()
	->id( 'sub_menu_separator' )
	->type( 'headline-toggle' )
	->tab( 'design' )
	->label( __( 'Sub Menu Separator', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 9 )
	->addToSection( 'wpbf_sub_menu_options' );

// Separator color.
wpbf_customizer_field()
	->id( 'sub_menu_separator_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->defaultValue( '#f5f5f7' )
	->priority( 10 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'id'       => 'sub_menu_separator',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_sub_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/sub-menu/?utm_source=repository&utm_medium=customizer_sub_menu_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_sub_menu' )
		->type( 'custom' )
		->tab( 'general' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_sub_menu_options' );

}

/* Fields – Mobile Navigation */

$mobile_menu_choices = array(
	'menu-mobile-default'   => __( 'Default', 'page-builder-framework' ),
	'menu-mobile-hamburger' => __( 'Hamburger', 'page-builder-framework' ),
);

// Variations.
wpbf_customizer_field()
	->id( 'mobile_menu_options' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Menu', 'page-builder-framework' ) )
	->defaultValue( 'menu-mobile-hamburger' )
	->priority( 1 )
	->choices( apply_filters( 'wpbf_mobile_menu_options', $mobile_menu_choices ) )
	->partialRefresh( [
		'mobilemenuoptions' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'mobile_menu_position_separator' )
	->type( 'divider' )
	->priority( 1 )
	->tab( 'general' )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Mobile search icon.
wpbf_customizer_field()
	->id( 'mobile_menu_search_icon' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Search Icon', 'page-builder-framework' ) )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	] )
	->partialRefresh( [
		'mobilemenusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'mobile_menu_search_icon_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Height.
wpbf_customizer_field()
	->id( 'mobile_menu_height' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Height', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Background color.
wpbf_customizer_field()
	->id( 'mobile_menu_background_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => '!=',
			'value'    => 'menu-mobile-elementor',
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Icon color.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Icon Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Hamburger size.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Icon Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );


// Hamburger background color.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hamburger Icon Button', 'page-builder-framework' ) )
	->tooltip( __( 'Define a background color & turn the hamburger icon into a button.', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_border_radius' )
	->type( 'slider' )
	->tab( 'design' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'id'       => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
		array(
			'id'       => 'mobile_menu_hamburger_bg_color',
			'operator' => '!=',
			'value'    => false,
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Headline.
wpbf_customizer_field()
	->id( 'mobile_menu_item_settings_headline' )
	->type( 'headline' )
	->label( esc_html__( 'Menu Item Settings', 'page-builder-framework' ) )
	->priority( 6 )
	->addToSection( 'wpbf_mobile_menu_options' );

// Padding.
wpbf_customizer_field()
	->id( 'mobile_menu_padding' )
	->type( 'padding' )
	->tab( 'general' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->defaultValue( [
		'top'    => 10,
		'right'  => 20,
		'bottom' => 10,
		'left'   => 20,
	] )
	->properties( [
		'save_as_json'   => true,
		'dont_save_unit' => true,
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Menu item background color.
wpbf_customizer_field()
	->id( 'mobile_menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 9 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Menu item background color alt.
wpbf_customizer_field()
	->id( 'mobile_menu_bg_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 10 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Font color.
wpbf_customizer_field()
	->id( 'mobile_menu_font_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 11 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Font color hover.
wpbf_customizer_field()
	->id( 'mobile_menu_font_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 12 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Divider color.
wpbf_customizer_field()
	->id( 'mobile_menu_border_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Divider Color', 'page-builder-framework' ) )
	->defaultValue( '#d9d9e0' )
	->priority( 13 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Sub menu arrow color.
wpbf_customizer_field()
	->id( 'mobile_menu_submenu_arrow_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Sub Menu Arrow Color', 'page-builder-framework' ) )
	->priority( 14 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Font size.
wpbf_customizer_field()
	->id( 'mobile_menu_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( 15 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_mobile_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_mobile_menu_options' );

}

/* Fields – Mobile Sub Menu */

// Auto collapse other sub-menu when a sub-menu is expanded.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_auto_collapse' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Auto Collapse', 'page-builder-framework' ) )
	->description( __( 'Auto collapse open sub-menu if other sub-menu is being opened.', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Indent.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_indent' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Indent', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_separator' )
	->type( 'divider' )
	->priority( 2 )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Menu item background color.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Menu item background color alt.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Font color.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Font color hover.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_font_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Sub menu arrow color.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_arrow_color' )
	->type( 'color' )
	->label( __( 'Sub Menu Arrow Color', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Font size.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_font_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 9 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_mobile_sub_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_mobile_sub_menu_options' );

}
