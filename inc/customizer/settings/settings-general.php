<?php
/**
 * General customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

use Kirki\Field\Toggle;
use Kirki\Pro\Field\Headline;
use Kirki\Pro\Field\HeadlineToggle;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// General.
Kirki::add_panel( 'layout_panel', array(
	'priority' => 2,
	'title'    => __( 'General', 'page-builder-framework' ),
) );

/* Sections */

// Layout.
Kirki::add_section( 'wpbf_page_options', array(
	'title'    => __( 'Layout', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 100,
) );

// Sidebar.
Kirki::add_section( 'wpbf_sidebar_options', array(
	'title'    => __( 'Sidebar', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 300,
) );

// 404.
Kirki::add_section( 'wpbf_404_options', array(
	'title'    => __( '404 Page', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 400,
) );

// Breadcrumbs.
Kirki::add_section( 'wpbf_breadcrumb_settings', array(
	'title'    => __( 'Breadcrumbs', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 500,
) );

// Buttons.
Kirki::add_section( 'wpbf_button_options', array(
	'title'    => __( 'Theme Buttons', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 600,
) );

// ScrollTop.
Kirki::add_section( 'wpbf_scrolltop_options', array(
	'title'    => __( 'Scroll to Top Button', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 700,
) );

/* Fields - Layout */

// Max width.
wpbf_customizer_field()
	->id( 'page_max_width' )
	->type( 'dimension' )
	->label( __( 'Page Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 0 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_page_options' );

// Padding.
Kirki::add_field( 'wpbf', array(
	'type'              => 'responsive_padding',
	'label'             => __( 'Page Padding', 'page-builder-framework' ),
	'section'           => 'wpbf_page_options',
	'settings'          => 'page_padding',
	'priority'          => 1,
	'transport'         => 'postMessage',
	'default'           => json_encode(
		array(
			'desktop_top'    => 40,
			'desktop_right'  => 20,
			'desktop_bottom' => 40,
			'desktop_left'   => 20,
		)
	),
	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wpbf_is_numeric_sanitization_helper' ),
) );

// Boxed.
new HeadlineToggle(
	[
		'settings' => 'page_boxed',
		'label'    => esc_html__( 'Boxed Layout', 'page-builder-framework' ),
		'section'  => 'wpbf_page_options',
		'default'  => 0,
		'priority' => 2,
	]
);

// Boxed margin.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_margin',
	'label'           => __( 'Margin', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 3,
	'default'         => 0,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Boxed padding.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_padding',
	'label'           => __( 'Padding', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 4,
	'default'         => 20,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 20,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Boxed padding.
// Kirki::add_field( 'wpbf', array(
// 	'type'              => 'responsive_padding',
// 	'label'             => __( 'Padding', 'page-builder-framework' ),
// 	'section'           => 'wpbf_page_options',
// 	'settings'          => 'page_boxed_padding',
// 	'priority'          => 4,
// 	'transport'         => 'postMessage',
// 	'default'           => json_encode(
// 		array(
// 			'desktop_top'    => 20,
// 			'desktop_right'  => 20,
// 			'desktop_bottom' => 20,
// 			'desktop_left'   => 20,
// 		)
// 	),
// 	'active_callback' => array(
// 		array(
// 			'setting'  => 'page_boxed',
// 			'operator' => '==',
// 			'value'    => 1,
// 		),
// 	),
// 	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wpbf_is_numeric_sanitization_helper' ),
// ) );

// Background color.
wpbf_customizer_field()
	->id( 'page_boxed_background' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow.
new HeadlineToggle(
	[
		'settings'        => 'page_boxed_box_shadow',
		'label'           => esc_html__( 'Box Shadow', 'page-builder-framework' ),
		'section'         => 'wpbf_page_options',
		'default'         => 0,
		'priority'        => 6,
		'active_callback' => [
			[
				'setting'  => 'page_boxed',
				'operator' => '==',
				'value'    => 1,
			],
		],
	]
);

// Box shadow blur.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_blur',
	'label'           => __( 'Blur', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 7,
	'default'         => 25,
	'choices'         => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow spread.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_spread',
	'label'           => __( 'Spread', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 8,
	'default'         => 0,
	'choices'         => array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow horizontal.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_horizontal',
	'label'           => __( 'Horizontal', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 9,
	'default'         => 0,
	'choices'         => array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow vertical.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_vertical',
	'label'           => __( 'Vertical', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 10,
	'default'         => 0,
	'choices'         => array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'page_boxed_box_shadow_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'default'         => 'rgba(0,0,0,.15)',
	'priority'        => 11,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

/* Fields - Sidebar */

wpbf_customizer_field()
	->id( 'sidebar_position' )
	->type( 'select' )
	->label( __( 'Position (Global)', 'page-builder-framework' ) )
	->priority( 1 )
	->defaultValue( 'right' )
	->choices( array(
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_sidebar_options' );

wpbf_customizer_field()
	->id( 'sidebar_gap' )
	->type( 'select' )
	->label( __( 'Gap', 'page-builder-framework' ) )
	->priority( 2 )
	->defaultValue( 'medium' )
	->choices( array(
		'divider'  => __( 'Divider', 'page-builder-framework' ),
		'xlarge'   => __( 'xLarge', 'page-builder-framework' ),
		'large'    => __( 'Large', 'page-builder-framework' ),
		'medium'   => __( 'Medium', 'page-builder-framework' ),
		'small'    => __( 'Small', 'page-builder-framework' ),
		'collapse' => __( 'Collapse', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_sidebar_options' );

wpbf_customizer_field()
	->id( 'sidebar_width' )
	->type( 'slider' )
	->transport( 'postMessage' )
	->label( __( 'Width', 'page-builder-framework' ) )
	->priority( 2 )
	->defaultValue( 33.3 )
	->properties( array(
		'min'  => 20,
		'max'  => 40,
		'step' => 0.1,
	) )
	->activeCallback( [
		array(
			'id'       => 'sidebar_position',
			'operator' => '!=',
			'value'    => 'none',
		)
	] )
	->addToSection( 'wpbf_sidebar_options' );

// Headline.
new Headline(
	[
		'settings' => 'widget_headline',
		'label'    => esc_html__( 'Sidebar Widgets', 'page-builder-framework' ),
		'section'  => 'wpbf_sidebar_options',
		'priority' => 2,
	]
);

// Padding.
Kirki::add_field( 'wpbf', array(
	'type'              => 'responsive_padding',
	'label'             => __( 'Padding', 'page-builder-framework' ),
	'section'           => 'wpbf_sidebar_options',
	'settings'          => 'sidebar_widget_padding',
	'priority'          => 3,
	'default'           => json_encode(
		array(
			'desktop_top'    => 20,
			'desktop_right'  => 20,
			'desktop_bottom' => 20,
			'desktop_left'   => 20,
			'tablet_top'     => 20,
			'tablet_right'   => 20,
			'tablet_bottom'  => 20,
			'tablet_left'    => 20,
			'mobile_top'     => 20,
			'mobile_right'   => 20,
			'mobile_bottom'  => 20,
			'mobile_left'    => 20,
		)
	),
	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wpbf_is_numeric_sanitization_helper' ),
) );

// Color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sidebar_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_sidebar_options',
	'default'   => '#f5f5f7',
	'priority'  => 4,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

/* Fields - 404 Page */

// 404 title.
Kirki::add_field( 'wpbf', array(
	'type'      => 'text',
	'label'     => __( 'Title', 'page-builder-framework' ),
	'settings'  => '404_headline',
	'section'   => 'wpbf_404_options',
	'default'   => __( "404 - This page couldn't be found.", "page-builder-framework" ),
	'transport' => 'postMessage',
	'priority'  => 1,
) );

// 404 text.
Kirki::add_field( 'wpbf', array(
	'type'      => 'text',
	'label'     => __( 'Text', 'page-builder-framework' ),
	'settings'  => '404_text',
	'section'   => 'wpbf_404_options',
	'default'   => __( "Oops! We're sorry, this page couldn't be found!", "page-builder-framework" ),
	'transport' => 'postMessage',
	'priority'  => 2,
) );

// Search form.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => '404_search_form',
	'label'           => __( 'Search Form', 'page-builder-framework' ),
	'section'         => 'wpbf_404_options',
	'default'         => 'show',
	'priority'        => 3,
	'multiple'        => 1,
	'partial_refresh' => array(
		'404searchform' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-404-content #searchform',
			'render_callback'     => function () {
				return get_search_form();
			},
		),
	),
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
) );

/* Fields - Breadcrumb Settings */

// Toggle.
wpbf_customizer_field()
	->id( 'breadcrumbs_toggle' )
	->type( 'toggle' )
	->label( __( 'Breadcrumbs', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 1 )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'breadcrumbs_toggle_separator' )
	->type( 'divider' )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Breadcrumbs.
wpbf_customizer_field()
	->id( 'breadcrumbs' )
	->type( 'select' )
	->label( __( 'Display Breadcrumbs on', 'page-builder-framework' ) )
	->defaultValue( array( 'archive', 'single' ) )
	->priority( 2 )
	->choices( array(
		'front_page' => __( 'Front Page', 'page-builder-framework' ),
		'archive'    => __( 'Archives', 'page-builder-framework' ),
		'single'     => __( 'Single', 'page-builder-framework' ),
		'search'     => __( 'Search Page', 'page-builder-framework' ),
		'404'        => __( '404 Page', 'page-builder-framework' ),
		'page'       => __( 'Pages', 'page-builder-framework' ),
	) )
	->properties( array(
		'multiple'       => true,
		'max_selections' => 6,
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Position.
wpbf_customizer_field()
	->id( 'breadcrumbs_position' )
	->type( 'select' )
	->label( __( 'Position', 'page-builder-framework' ) )
	->defaultValue( 'content' )
	->priority( 2 )
	->choices( array(
		'content' => __( 'Before Content', 'page-builder-framework' ),
		'header'  => __( 'Below Header', 'page-builder-framework' ),
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'breadcrumbs_separator' )
	->type( 'text' )
	->label( __( 'Separator', 'page-builder-framework' ) )
	->defaultValue( '/' )
	->priority( 2 )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->partialRefresh( [
		'breadcrumbs_separator' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-breadcrumbs',
			'render_callback'     => function () {
				return wpbf_do_breadcrumbs();
			}
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Alignment.
wpbf_customizer_field()
	->id( 'breadcrumbs_alignment' )
	->type( 'radio-image' )
	->label( __( 'Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->priority( 2 )
	->choices( array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'id'       => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Headline.
wpbf_customizer_field()
	->id( 'breadcrumbs_color_divider' )
	->type( 'divider' )
	->priority( 2 )
	->activeCallback( [
		[
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		],
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

wpbf_customizer_field()
	->id( 'breadcrumbs_background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#dedee5' )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		[
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		],
		[
			'id'       => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		],
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );


// Font color.
wpbf_customizer_field()
	->id( 'breadcrumbs_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Accent color.
wpbf_customizer_field()
	->id( 'breadcrumbs_accent_color' )
	->type( 'color' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Accent color hover.
wpbf_customizer_field()
	->id( 'breadcrumbs_accent_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

/* Fields - Buttons */

// Headline.
wpbf_customizer_field()
	->id( 'button_headline' )
	->type( 'headline' )
	->label( __( 'Theme Buttons', 'page-builder-framework' ) )
	->tooltip( __( 'Applies to default buttons such as "Read more" used throughout the theme.', 'page-builder-framework' ) )
	->priority( 0 )
	->addToSection( 'wpbf_button_options' );

// Background color.
wpbf_customizer_field()
	->id( 'button_bg_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Background color alt.
wpbf_customizer_field()
	->id( 'button_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Text color.
wpbf_customizer_field()
	->id( 'button_text_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Text color alt.
wpbf_customizer_field()
	->id( 'button_text_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Headline.
wpbf_customizer_field()
	->id( 'button_primary_headline' )
	->type( 'headline' )
	->label( __( 'Theme Buttons (Primary)', 'page-builder-framework' ) )
	->tooltip( __( 'Applies to buttons displayed in the themes accent color such as WooCommerce buttons.', 'page-builder-framework' ) )
	->priority( 1 )
	->addToSection( 'wpbf_button_options' );

// Primary background color.
wpbf_customizer_field()
	->id( 'button_primary_bg_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary background color alt.
wpbf_customizer_field()
	->id( 'button_primary_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary text color.
wpbf_customizer_field()
	->id( 'button_primary_text_color' )
	->type( 'color' )
	->label( __( 'Primary Font Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary text color alt.
wpbf_customizer_field()
	->id( 'button_primary_text_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Divider.
wpbf_customizer_field()
	->id( 'button_border_divider' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_button_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'button_border_radius' )
	->type( 'slider' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->addToSection( 'wpbf_button_options' );

// Border width.
wpbf_customizer_field()
	->id( 'button_border_width' )
	->type( 'slider' )
	->label( __( 'Border Width', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 10,
		'step' => 1,
	) )
	->addToSection( 'wpbf_button_options' );

// Divider.
wpbf_customizer_field()
	->id( 'button_border_divider_2' )
	->type( 'divider' )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Border color.
wpbf_customizer_field()
	->id( 'button_border_color' )
	->type( 'color' )
	->label( __( 'Border Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Border color alt.
wpbf_customizer_field()
	->id( 'button_border_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Primary border color.
wpbf_customizer_field()
	->id( 'button_primary_border_color' )
	->type( 'color' )
	->label( __( 'Primary Border Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Primary border color alt.
wpbf_customizer_field()
	->id( 'button_primary_border_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

/* Fields - ScrollTop */

// Toggle.
wpbf_customizer_field()
	->id( 'layout_scrolltop' )
	->type( 'toggle' )
	->label( __( 'Scroll to Top Button', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_scrolltop_options' );

// Separator.
wpbf_customizer_field()
	->id( 'layout_scrolltop_separator' )
	->type( 'divider' )
	->priority( 0 )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Alignment.
wpbf_customizer_field()
	->id( 'scrolltop_position' )
	->type( 'radio-image' )
	->label( __( 'Alignment', 'page-builder-framework' ) )
	->defaultValue( 'right' )
	->priority( 1 )
	->transport( 'postMessage' )
	->choices( array(
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Show after.
wpbf_customizer_field()
	->id( 'scrolltop_value' )
	->type( 'slider' )
	->label( __( 'Show after (px)', 'page-builder-framework' ) )
	->defaultValue( 400 )
	->priority( 2 )
	->properties( array(
		'min'  => 50,
		'max'  => 1000,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Divider.
wpbf_customizer_field()
	->id( 'layout_scrolltop_separator_2' )
	->type( 'divider' )
	->priority( 3 )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Background color.
wpbf_customizer_field()
	->id( 'scrolltop_bg_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( 'rgba(62,67,73,0.5)' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Background color hover.
wpbf_customizer_field()
	->id( 'scrolltop_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( 'rgba(62,67,73,0.7)' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );


// Icon color.
wpbf_customizer_field()
	->id( 'scrolltop_icon_color' )
	->type( 'color' )
	->label( __( 'Icon Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Icon color hover.
wpbf_customizer_field()
	->id( 'scrolltop_icon_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'scrolltop_border_radius' )
	->type( 'slider' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 8 )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );