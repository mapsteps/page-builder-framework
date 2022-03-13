<?php
/**
 * General customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

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
Kirki::add_field( 'wpbf', array(
	'type'        => 'dimension',
	'label'       => __( 'Page Width', 'page-builder-framework' ),
	'settings'    => 'page_max_width',
	'section'     => 'wpbf_page_options',
	'transport'   => 'postMessage',
	'description' => __( 'Default: 1200px', 'page-builder-framework' ),
	'priority'    => 0,
) );

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
new \Kirki\Pro\Field\HeadlineToggle(
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

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'page_boxed_background',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'default'         => '#ffffff',
	'priority'        => 5,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow.
new \Kirki\Pro\Field\HeadlineToggle(
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
		'min'  => -100,
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
		'min'  => -100,
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
		'min'  => -100,
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

// Postion.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'sidebar_position',
	'label'    => __( 'Position (Global)', 'page-builder-framework' ),
	'section'  => 'wpbf_sidebar_options',
	'default'  => 'right',
	'priority' => 1,
	'multiple' => 1,
	'choices'  => array(
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	),
) );

// Gap.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'sidebar_gap',
	'label'    => __( 'Gap', 'page-builder-framework' ),
	'section'  => 'wpbf_sidebar_options',
	'default'  => 'medium',
	'priority' => 2,
	'multiple' => 1,
	'choices'  => array(
		'divider'  => __( 'Divider', 'page-builder-framework' ),
		'xlarge'   => __( 'xLarge', 'page-builder-framework' ),
		'large'    => __( 'Large', 'page-builder-framework' ),
		'medium'   => __( 'Medium', 'page-builder-framework' ),
		'small'    => __( 'Small', 'page-builder-framework' ),
		'collapse' => __( 'Collapse', 'page-builder-framework' ),
	),
) );

// Width.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'sidebar_width',
	'label'           => __( 'Width', 'page-builder-framework' ),
	'section'         => 'wpbf_sidebar_options',
	'priority'        => 2,
	'default'         => 33.3,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 20,
		'max'  => 40,
		'step' => .1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'sidebar_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Headline.
new \Kirki\Pro\Field\Headline(
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
new \Kirki\Field\Toggle(
	[
		'settings' => 'breadcrumbs_toggle',
		'label'    => esc_html__( 'Breadcrumbs', 'page-builder-framework' ),
		'section'  => 'wpbf_breadcrumb_settings',
		'default'  => 0,
		'priority' => 1,
	]
);

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'breadcrumbs_toggle_separator',
		'section'  => 'wpbf_breadcrumb_settings',
		'priority' => 1,
		'active_callback' => [
			[
				'setting'  => 'breadcrumbs_toggle',
				'operator' => '==',
				'value'    => 1,
			],
		],
	]
);

// Breadcrumbs.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'breadcrumbs',
	'label'           => __( 'Display Breadcrumbs on', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => array( 'archive', 'single' ),
	'priority'        => 2,
	'multiple'        => 6,
	'choices'         => array(
		'front_page' => __( 'Front Page', 'page-builder-framework' ),
		'archive'    => __( 'Archives', 'page-builder-framework' ),
		'single'     => __( 'Single', 'page-builder-framework' ),
		'search'     => __( 'Search Page', 'page-builder-framework' ),
		'404'        => __( '404 Page', 'page-builder-framework' ),
		'page'       => __( 'Pages', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Position.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'breadcrumbs_position',
	'label'           => __( 'Position', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => 'content',
	'priority'        => 2,
	'multiple'        => 1,
	'choices'         => array(
		'content' => __( 'Before Content', 'page-builder-framework' ),
		'header'  => __( 'Below Header', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'breadcrumbs_separator',
	'label'           => __( 'Separator', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => '/',
	'priority'        => 2,
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'partial_refresh' => array(
		'breadcrumbsseparator' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-breadcrumbs',
			'render_callback'     => function () {
				return wpbf_do_breadcrumbs();
			},
		),
	),
) );

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'breadcrumbs_alignment',
	'label'           => __( 'Alignment', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => 'left',
	'priority'        => 2,
	'multiple'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		),
	),
) );

// Headline.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'breadcrumbs_color_divider',
		'section'  => 'wpbf_breadcrumb_settings',
		'priority' => 2,
		'active_callback' => [
			[
				'setting'  => 'breadcrumbs_toggle',
				'operator' => '==',
				'value'    => 1,
			],
		],
	]
);

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_background_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => '#dedee5;',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		),
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_accent_color',
	'label'           => __( 'Accent Color', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Accent color hover.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_accent_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

/* Fields - Buttons */

// Headline.
new \Kirki\Pro\Field\Headline(
	[
		'settings' => 'button_headline',
		'label'    => esc_html__( 'Theme Buttons', 'page-builder-framework' ),
		'tooltip'  => esc_html__( 'Applies to default buttons such as "Read more" used throughout the theme.', 'page-builder-framework' ),
		'section'  => 'wpbf_button_options',
		'priority' => 0,
	]
);

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Text color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_text_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Text color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_text_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Headline.
new \Kirki\Pro\Field\Headline(
	[
		'settings' => 'button_primary_headline',
		'label'    => esc_html__( 'Theme Buttons (Primary)', 'page-builder-framework' ),
		'tooltip'  => esc_html__( 'Applies to buttons displayed in the themes accent color such as WooCommerce buttons.', 'page-builder-framework' ),
		'section'  => 'wpbf_button_options',
		'priority' => 1,
	]
);

// Primary background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Primary background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Primary text color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_text_color',
	'label'     => __( 'Primary Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Primary text color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_text_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Divider.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'button_border_divider',
		'section'  => 'wpbf_button_options',
		'priority' => 1,
	]
);

// Border radius.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'button_border_radius',
	'label'     => __( 'Border Radius', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'default'   => 0,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
) );

// Border width.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'button_border_width',
	'label'     => __( 'Border Width', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'default'   => 0,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 10,
		'step' => 1,
	),
) );

// Divider.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'button_border_divider_2',
		'section'  => 'wpbf_button_options',
		'priority' => 1,
		'active_callback' => [
			[
				'setting'  => 'button_border_width',
				'operator' => '!=',
				'value'    => 0,
			],
		],
	]
);

// Border color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_border_color',
	'label'           => __( 'Border Color', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

// Border color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_border_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

// Primary border color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_primary_border_color',
	'label'           => __( 'Primary Border Color', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

// Primary border color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_primary_border_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

/* Fields - ScrollTop */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings'    => 'layout_scrolltop',
		'label'       => __( 'Scroll to Top Button', 'page-builder-framework' ),
		'section'     => 'wpbf_scrolltop_options',
		'default'     => 0,
		'priority'    => 0,
	]
);

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'layout_scrolltop_separator',
		'section'  => 'wpbf_scrolltop_options',
		'priority' => 0,
		'active_callback' => [
			[
				'setting'  => 'layout_scrolltop',
				'operator' => '==',
				'value'    => 1,
			],
		],
	]
);

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'scrolltop_position',
	'label'           => __( 'Alignment', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'default'         => 'right',
	'priority'        => 1,
	'multiple'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Show after.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'scrolltop_value',
	'label'           => __( 'Show after (px)', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 2,
	'default'         => 400,
	'choices'         => array(
		'min'  => 50,
		'max'  => 1000,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Divider.
new \Kirki\Pro\Field\Divider(
	[
		'settings'    => 'layout_scrolltop_separator_2',
		'section'     => 'wpbf_scrolltop_options',
		'priority'    => 3,
		'active_callback' => [
			[
				'setting'  => 'layout_scrolltop',
				'operator' => '==',
				'value'    => 1,
			],
		],
	]
);

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_bg_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'default'         => 'rgba(62,67,73,0.5)',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Background color hover.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_bg_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 5,
	'default'         => 'rgba(62,67,73,0.7)',
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Icon color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_icon_color',
	'label'           => __( 'Icon Color', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 6,
	'transport'       => 'postMessage',
	'default'         => '#ffffff',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Icon color hover.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_icon_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 7,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Border radius.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'scrolltop_border_radius',
	'label'           => __( 'Border Radius', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 8,
	'default'         => 0,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );
