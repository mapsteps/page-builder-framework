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
Kirki::add_panel( 'header_panel', array(
	'priority' => 4,
	'title'    => __( 'Header', 'page-builder-framework' ),
) );

/* Sections - Header */

// Pre header.
new \Kirki\Section(
	'wpbf_pre_header_options',
	[
		'title'    => __( 'Pre Header', 'page-builder-framework' ),
		'panel'    => 'header_panel',
		'priority' => 0,
		'tabs'     => [
			'general' => [
				'label' => esc_html__( 'General', 'page-builder-framework' ),
			],
			'design'  => [
				'label' => esc_html__( 'Design', 'page-builder-framework' ),
			],
		],
	]
);

// Navigation.
new \Kirki\Section(
	'wpbf_menu_options',
	[
		'title'    => __( 'Navigation', 'page-builder-framework' ),
		'panel'    => 'header_panel',
		'priority' => 200,
		'tabs'     => [
			'general' => [
				'label' => esc_html__( 'General', 'page-builder-framework' ),
			],
			'design'  => [
				'label' => esc_html__( 'Design', 'page-builder-framework' ),
			],
		],
	]
);

// Sub menu.
new \Kirki\Section(
	'wpbf_sub_menu_options',
	[
		'title'    => __( 'Sub Menu', 'page-builder-framework' ),
		'panel'    => 'header_panel',
		'priority' => 250,
		'tabs'     => [
			'general' => [
				'label' => esc_html__( 'General', 'page-builder-framework' ),
			],
			'design'  => [
				'label' => esc_html__( 'Design', 'page-builder-framework' ),
			],
		],
	]
);

// Mobile menu.
new \Kirki\Section(
	'wpbf_mobile_menu_options',
	[
		'title'    => __( 'Mobile Navigation', 'page-builder-framework' ),
		'panel'    => 'header_panel',
		'priority' => 300,
		'tabs'     => [
			'general' => [
				'label' => esc_html__( 'General', 'page-builder-framework' ),
			],
			'design'  => [
				'label' => esc_html__( 'Design', 'page-builder-framework' ),
			],
		],
	]
);

// Mobile menu.
Kirki::add_section( 'wpbf_mobile_sub_menu_options', array(
	'title'    => __( 'Mobile Sub Menu', 'page-builder-framework' ),
	'panel'    => 'header_panel',
	'priority' => 350,
) );

/* Fields – Pre Header */

// Pre header layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-buttonset',
	'settings'        => 'pre_header_layout',
	'label'           => __( 'Layout', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => 'none',
	'priority'        => 1,
	'tab'             => 'general',
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'one'  => __( 'One Column', 'page-builder-framework' ),
		'two'  => __( 'Two Columns', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'preheaderlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	),
) );

// Column one layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'pre_header_column_one_layout',
	'label'           => __( 'Column 1', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => 'text',
	'priority'        => 2,
	'tab'             => 'general',
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'partial_refresh' => array(
		'preheadercolumnonelayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	),
) );

// Column one.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'pre_header_column_one',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => __( 'Column 1', 'page-builder-framework' ),
	'priority'        => 2,
	'tab'             => 'general',
	'partial_refresh' => array(
		'preheadercolumnonecontent' => array(
			'selector'        => '.wpbf-inner-pre-header-left, .wpbf-inner-pre-header-content',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_one' ) );
			},
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => 'pre_header_column_one_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings'        => 'pre_header_column_two_layout_separator',
		'section'         => 'wpbf_pre_header_options',
		'priority'        => 2,
		'tab'             => 'general',
		'active_callback' => [
			[
				'setting'  => 'pre_header_layout',
				'operator' => '==',
				'value'    => 'two',
			],
		],
	]
);

// Column two layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'pre_header_column_two_layout',
	'label'           => __( 'Column 2', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => 'text',
	'priority'        => 2,
	'tab'             => 'general',
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	),
	'partial_refresh' => array(
		'preheadercolumntwolayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	),
) );

// Column two.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'pre_header_column_two',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => __( 'Column 2', 'page-builder-framework' ),
	'priority'        => 2,
	'tab'             => 'general',
	'partial_refresh' => array(
		'preheadercolumntwocontent' => array(
			'selector'        => '.wpbf-inner-pre-header-right',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_two' ) );
			},
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
		array(
			'setting'  => 'pre_header_column_two_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings'        => 'pre_header_separator',
		'section'         => 'wpbf_pre_header_options',
		'priority'        => 3,
		'tab'             => 'general',
		'active_callback' => [
			[
				'setting'  => 'pre_header_layout',
				'operator' => '!=',
				'value'    => 'none',
			],
		],
	]
);

// Width.
Kirki::add_field( 'wpbf', array(
	'type'            => 'dimension',
	'label'           => __( 'Pre Header Width', 'page-builder-framework' ),
	'description'     => __( 'Default: 1200px', 'page-builder-framework' ),
	'settings'        => 'pre_header_width',
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 3,
	'transport'       => 'postMessage',
	'tab'             => 'general',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Height.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'pre_header_height',
	'label'           => __( 'Height', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 3,
	'default'         => 10,
	'transport'       => 'postMessage',
	'tab'             => 'general',
	'choices'         => array(
		'min'  => 1,
		'max'  => 25,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_bg_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => '#ffffff',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'choices'         => array(
		'alpha' => true,
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'choices'         => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_accent_color',
	'label'           => __( 'Accent Color', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_accent_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'label'           => __( 'Font Size', 'page-builder-framework' ),
	'settings'        => 'pre_header_font_size',
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'default'         => '14px',
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

/* Fields – Logo */

// Mobile logo.
Kirki::add_field( 'wpbf', array(
	'type'            => 'image',
	'settings'        => 'menu_mobile_logo',
	'label'           => __( 'Mobile Logo', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 1,
	'partial_refresh' => array(
		'mobilelogo' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-mobile-logo',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/logo/logo-mobile' );
			},
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '!=',
			'value'    => '',
		),
	),
) );

// Size.
Kirki::add_field( 'wpbf', array(
	'type'              => 'responsive_input_slider',
	'label'             => __( 'Logo Width', 'page-builder-framework' ),
	'section'           => 'title_tagline',
	'settings'          => 'menu_logo_size',
	'priority'          => 2,
	'transport'         => 'postMessage',
	'choices'           => array(
		'min'  => 0,
		'max'  => 500,
		'step' => 1,
	),
	'active_callback'   => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '!=',
			'value'    => '',
		),
	),
	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wp_filter_nohtml_kses' ),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'logo_image_separator',
		'section'  => 'title_tagline',
		'priority' => 4,
	]
);

// Color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'menu_logo_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 11,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	),
) );

// Hover color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'menu_logo_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 12,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'              => 'responsive_input_slider',
	'label'             => __( 'Font Size', 'page-builder-framework' ),
	'section'           => 'title_tagline',
	'settings'          => 'menu_logo_font_size',
	'priority'          => 13,
	'transport'         => 'postMessage',
	'default'           => json_encode(
		array(
			'desktop' => '22px',
			'tablet'  => '',
			'mobile'  => '',
		)
	),
	'choices'           => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback'   => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	),
	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wp_filter_nohtml_kses' ),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings'        => 'tagline_separator',
		'section'         => 'title_tagline',
		'priority'        => 14,
		'active_callback' => [
			[
				'setting'  => 'custom_logo',
				'operator' => '==',
				'value'    => '',
			],
		],
	]
);

/* Fields – Tagline */

// Toggle.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'menu_logo_description',
	'label'           => __( 'Display Tagline', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'default'         => 0,
	'priority'        => 20,
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	),
	'partial_refresh' => array(
		'displaytagline' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Mobile toggle.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'menu_logo_description_mobile',
	'label'           => __( 'Display Tagline on Mobile', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'default'         => 0,
	'priority'        => 20,
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'setting'  => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	),
	'partial_refresh' => array(
		'displaytaglinemobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'menu_logo_description_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 22,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'setting'  => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'              => 'responsive_input_slider',
	'label'             => __( 'Font Size', 'page-builder-framework' ),
	'section'           => 'title_tagline',
	'settings'          => 'menu_logo_description_font_size',
	'priority'          => 23,
	'transport'         => 'postMessage',
	'choices'           => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback'   => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'setting'  => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	),
	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wp_filter_nohtml_kses' ),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'logo_settings_separator',
		'section'  => 'title_tagline',
		'priority' => 24,
	]
);

/* Fields – Logo Settings */

// Logo URL.
Kirki::add_field( 'wpbf', array(
	'type'      => 'link',
	'settings'  => 'menu_logo_url',
	'label'     => __( 'Custom Logo URL', 'page-builder-framework' ),
	'section'   => 'title_tagline',
	'transport' => 'postMessage',
	'priority'  => 30,
) );

// Alt tag.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'menu_logo_alt',
	'label'           => __( 'Custom "alt" Tag', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 31,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	),
) );

// Title tag.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'menu_logo_title',
	'label'           => __( 'Custom "title" Tag', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 32,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'logo_container_separator',
		'section'  => 'title_tagline',
		'priority' => 33,
	]
);

/* Fields – Logo Container Width */

// Container width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'slider',
	'settings'    => 'menu_logo_container_width',
	'label'       => __( 'Logo Container Width', 'page-builder-framework' ),
	'description' => __( 'Defines the space in % the logo area takes in the navigation.', 'page-builder-framework' ),
	'section'     => 'title_tagline',
	'priority'    => 40,
	'default'     => 25,
	'transport'   => 'postMessage',
	'choices'     => array(
		'min'  => 10,
		'max'  => 40,
		'step' => 1,
	),
) );

// Mobile container width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'slider',
	'settings'    => 'mobile_menu_logo_container_width',
	'label'       => __( 'Logo Container Width (Mobile)', 'page-builder-framework' ),
	'description' => __( 'Defines the space in % the logo area takes in the navigation.', 'page-builder-framework' ),
	'section'     => 'title_tagline',
	'priority'    => 41,
	'default'     => 66,
	'transport'   => 'postMessage',
	'choices'     => array(
		'min'  => 10,
		'max'  => 80,
		'step' => 1,
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'favicon_separator',
		'section'  => 'title_tagline',
		'priority' => 42,
	]
);

/* Fields – Navigation */

// Variations.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'menu_position',
	'label'           => __( 'Menu', 'page-builder-framework' ),
	'section'         => 'wpbf_menu_options',
	'default'         => 'menu-right',
	'priority'        => 0,
	'multiple'        => 1,
	'tab'             => 'general',
	'choices'         => apply_filters( 'wpbf_menu_position', array(
		'menu-right'    => __( 'Right (default)', 'page-builder-framework' ),
		'menu-left'     => __( 'Left', 'page-builder-framework' ),
		'menu-centered' => __( 'Centered', 'page-builder-framework' ),
		'menu-stacked'  => __( 'Stacked', 'page-builder-framework' ),
	) ),
	'partial_refresh' => array(
		'headerlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'menu_position_separator',
		'section'  => 'wpbf_menu_options',
		'priority' => 0,
		'tab'      => 'general',
	]
);

// Search icon.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'menu_search_icon',
	'label'           => __( 'Search Icon', 'page-builder-framework' ),
	'section'         => 'wpbf_menu_options',
	'priority'        => 1,
	'tab'             => 'general',
	'partial_refresh' => array(
		'menusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'menu_search_icon_separator',
		'section'  => 'wpbf_menu_options',
		'priority' => 1,
		'tab'      => 'general',
	]
);

// Width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'dimension',
	'label'       => __( 'Navigation Width', 'page-builder-framework' ),
	'description' => __( 'Default: 1200px', 'page-builder-framework' ),
	'settings'    => 'menu_width',
	'section'     => 'wpbf_menu_options',
	'transport'   => 'postMessage',
	'priority'    => 2,
	'tab'         => 'general',
) );

// Height.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'label'     => __( 'Menu Height', 'page-builder-framework' ),
	'settings'  => 'menu_height',
	'section'   => 'wpbf_menu_options',
	'priority'  => 3,
	'default'   => 20,
	'transport' => 'postMessage',
	'tab'       => 'general',
	'choices'   => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
) );

// Padding.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'label'           => __( 'Menu Item Spacing', 'page-builder-framework' ),
	'settings'        => 'menu_padding',
	'section'         => 'wpbf_menu_options',
	'priority'        => 4,
	'default'         => 20,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'min'  => 5,
		'max'  => 40,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'menu_position',
			'operator' => '!=',
			'value'    => 'menu-off-canvas',
		),
		array(
			'setting'  => 'menu_position',
			'operator' => '!=',
			'value'    => 'menu-off-canvas-left',
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'menu_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_menu_options',
	'default'   => '#f5f5f7',
	'priority'  => 5,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'menu_font_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_menu_options',
	'priority'  => 6,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'menu_font_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_menu_options',
	'priority'  => 7,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'menu_font_size',
	'section'   => 'wpbf_menu_options',
	'priority'  => 7,
	'default'   => '16px',
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_header_menu',
		'section'  => 'wpbf_menu_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields – Sub Menu */

// Width.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'sub_menu_width',
	'label'     => __( 'Sub Menu Width', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'priority'  => 0,
	'default'   => 220,
	'transport' => 'postMessage',
	'tab'       => 'general',
	'choices'   => array(
		'min'  => 100,
		'max'  => 400,
		'step' => 1,
	),
) );

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'sub_menu_alignment',
	'label'           => __( 'Sub Menu Alignment', 'page-builder-framework' ),
	'section'         => 'wpbf_sub_menu_options',
	'default'         => 'left',
	'priority'        => 1,
	'multiple'        => 1,
	'tab'             => 'general',
	'choices'         => array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'partial_refresh' => array(
		'submenualignment' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Text alignment.
Kirki::add_field( 'wpbf', array(
	'type'      => 'radio-image',
	'settings'  => 'sub_menu_text_alignment',
	'label'     => __( 'Text Alignment', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'default'   => 'left',
	'priority'  => 2,
	'multiple'  => 1,
	'transport' => 'postMessage',
	'tab'       => 'general',
	'choices'   => array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
) );

// Padding.
Kirki::add_field( 'wpbf', array(
	'type'              => 'padding_control',
	'label'             => __( 'Menu Item Padding', 'page-builder-framework' ),
	'section'           => 'wpbf_sub_menu_options',
	'settings'          => 'sub_menu_padding',
	'priority'          => 3,
	'transport'         => 'postMessage',
	'tab'               => 'general',
	'default'           => json_encode(
		array(
			'top'    => 10,
			'right'  => 20,
			'bottom' => 10,
			'left'   => 20,
		)
	),
	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wpbf_is_numeric_sanitization_helper' ),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'default'   => '#ffffff',
	'transport' => 'postMessage',
	'priority'  => 4,
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'default'   => '#ffffff',
	'priority'  => 5,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_accent_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'transport' => 'postMessage',
	'tab'       => 'design',
	'priority'  => 6,
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_accent_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'priority'  => 7,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'sub_menu_font_size',
	'section'   => 'wpbf_sub_menu_options',
	'priority'  => 8,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

// Separator toggle.
new \Kirki\Pro\Field\HeadlineToggle(
	[
		'settings' => 'sub_menu_separator',
		'label'    => __( 'Sub Menu Separator', 'page-builder-framework' ),
		'section'  => 'wpbf_sub_menu_options',
		'default'  => 0,
		'priority' => 9,
		'tab'      => 'design',
	]
);

// Separator color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'sub_menu_separator_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_sub_menu_options',
	'default'         => '#f5f5f7',
	'priority'        => 10,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'sub_menu_separator',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/sub-menu/?utm_source=repository&utm_medium=customizer_sub_menu_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_header_sub_menu',
		'section'  => 'wpbf_sub_menu_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
		'tab'      => 'general',
	) );

}

/* Fields – Mobile Navigation */

// Variations.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'mobile_menu_options',
	'label'           => __( 'Menu', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'default'         => 'menu-mobile-hamburger',
	'priority'        => 1,
	'multiple'        => 1,
	'tab'             => 'general',
	'choices'         => apply_filters( 'wpbf_mobile_menu_options', array(
		'menu-mobile-default'   => __( 'Default', 'page-builder-framework' ),
		'menu-mobile-hamburger' => __( 'Hamburger', 'page-builder-framework' ),
	) ),
	'partial_refresh' => array(
		'mobilemenuoptions' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings'        => 'mobile_menu_position_separator',
		'section'         => 'wpbf_mobile_menu_options',
		'priority'        => 1,
		'tab'             => 'general',
		'active_callback' => [
			[
				'setting'  => 'mobile_menu_options',
				'operator' => '!==',
				'value'    => 'menu-mobile-default',
			],
		],
	]
);

// Mobile search icon.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'mobile_menu_search_icon',
	'label'           => __( 'Search Icon', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 1,
	'tab'             => 'general',
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	),
	'partial_refresh' => array(
		'mobilemenusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings'        => 'mobile_menu_search_icon_separator',
		'section'         => 'wpbf_mobile_menu_options',
		'priority'        => 1,
		'tab'             => 'general',
		'active_callback' => [
			[
				'setting'  => 'mobile_menu_options',
				'operator' => '!==',
				'value'    => 'menu-mobile-default',
			],
		],
	]
);

// Height.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'mobile_menu_height',
	'label'     => __( 'Height', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 2,
	'default'   => 20,
	'transport' => 'postMessage',
	'tab'       => 'general',
	'choices'   => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'mobile_menu_background_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 3,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!=',
			'value'    => 'menu-mobile-elementor',
		),
	),
) );

// Icon color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'mobile_menu_hamburger_color',
	'label'           => __( 'Icon Color', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	),
) );

// Hamburger size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'settings'        => 'mobile_menu_hamburger_size',
	'label'           => __( 'Icon Size', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'default'         => '16px',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	),
) );

// Hamburger background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'mobile_menu_hamburger_bg_color',
	'label'           => __( 'Hamburger Icon Button', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'tooltip'         => __( 'Define a background color & turn the hamburger icon into a button.', 'page-builder-framework' ),
	'priority'        => 5,
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	),
) );

// Border radius.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'mobile_menu_hamburger_border_radius',
	'label'           => __( 'Border Radius', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 5,
	'default'         => 0,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
		array(
			'setting'  => 'mobile_menu_hamburger_bg_color',
			'operator' => '!=',
			'value'    => false,
		),
	),
) );

// Headline.
new \Kirki\Pro\Field\Headline(
	[
		'settings' => 'mobile_menu_item_settings_headline',
		'label'    => esc_html__( 'Menu Item Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_mobile_menu_options',
		'priority' => 6,
	]
);

// Padding.
Kirki::add_field( 'wpbf', array(
	'type'              => 'padding_control',
	'label'             => __( 'Padding', 'page-builder-framework' ),
	'section'           => 'wpbf_mobile_menu_options',
	'settings'          => 'mobile_menu_padding',
	'priority'          => 8,
	'transport'         => 'postMessage',
	'tab'               => 'general',
	'default'           => json_encode(
		array(
			'top'    => 10,
			'right'  => 20,
			'bottom' => 10,
			'left'   => 20,
		)
	),
	'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wpbf_is_numeric_sanitization_helper' ),
) );

// Menu item background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 9,
	'default'   => '#ffffff',
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Menu item background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 10,
	'default'   => '#ffffff',
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_font_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'transport' => 'postMessage',
	'tab'       => 'design',
	'priority'  => 11,
) );

// Font color hover.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_font_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 12,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Divider color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_border_color',
	'label'     => __( 'Divider Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'default'   => '#d9d9e0',
	'priority'  => 13,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Sub menu arrow color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_submenu_arrow_color',
	'label'     => __( 'Sub Menu Arrow Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 14,
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'mobile_menu_font_size',
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 15,
	'default'   => '16px',
	'transport' => 'postMessage',
	'tab'       => 'design',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_header_mobile_menu',
		'section'  => 'wpbf_mobile_menu_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields – Mobile Sub Menu */

// Auto collapse other sub-menu when a sub-menu is expanded.
Kirki::add_field( 'wpbf', array(
	'type'        => 'toggle',
	'settings'    => 'mobile_sub_menu_auto_collapse',
	'label'       => __( 'Auto Collapse', 'page-builder-framework' ),
	'description' => __( 'Auto collapse open sub-menu if other sub-menu is being opened.', 'page-builder-framework' ),
	'section'     => 'wpbf_mobile_sub_menu_options',
	'priority'    => 1,
	'transport'   => 'postMessage',
) );

// Indent.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'mobile_sub_menu_indent',
	'label'     => __( 'Indent', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_sub_menu_options',
	'priority'  => 2,
	'default'   => 0,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'mobile_sub_menu_separator',
		'section'  => 'wpbf_mobile_sub_menu_options',
		'priority' => 2,
	]
);

// Menu item background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_sub_menu_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_sub_menu_options',
	'priority'  => 3,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Menu item background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_sub_menu_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_sub_menu_options',
	'priority'  => 4,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_sub_menu_font_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_sub_menu_options',
	'transport' => 'postMessage',
	'priority'  => 5,
) );

// Font color hover.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_sub_menu_font_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_sub_menu_options',
	'priority'  => 6,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Divider color.
// Kirki::add_field( 'wpbf', array(
//  'type'      => 'color',
//  'settings'  => 'mobile_sub_menu_border_color',
//  'label'     => __( 'Divider Color', 'page-builder-framework' ),
//  'section'   => 'wpbf_mobile_sub_menu_options',
//  'priority'  => 7,
//  'transport' => 'postMessage',
//  'choices'   => array(
//      'alpha' => true,
//  ),
// ) );

// Sub menu arrow color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_sub_menu_arrow_color',
	'label'     => __( 'Sub Menu Arrow Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_sub_menu_options',
	'priority'  => 8,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'mobile_sub_menu_font_size',
	'section'   => 'wpbf_mobile_sub_menu_options',
	'priority'  => 9,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_header_mobile_sub_menu',
		'section'  => 'wpbf_mobile_sub_menu_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}
