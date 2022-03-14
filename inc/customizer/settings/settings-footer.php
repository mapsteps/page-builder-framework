<?php
/**
 * Footer customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Footer.
Kirki::add_panel( 'footer_panel', array(
	'priority' => 5,
	'title'    => __( 'Footer', 'page-builder-framework' ),
) );

/* Sections - Footer */

// Widget footer.
Kirki::add_section( 'wpbf_widget_footer_options', array(
	'title'    => __( 'Widget Area', 'page-builder-framework' ),
	'panel'    => 'footer_panel',
	'priority' => 100,
) );

// Footer.
new \Kirki\Section(
	'wpbf_footer_options',
	[
		'title'    => __( 'Footer Bar', 'page-builder-framework' ),
		'panel'    => 'footer_panel',
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

/* Fields – Footer */

// Layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-buttonset',
	'settings'        => 'footer_layout',
	'label'           => __( 'Footer', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => 'two',
	'priority'        => 1,
	'tab'             => 'general',
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'one'  => __( 'One Column', 'page-builder-framework' ),
		'two'  => __( 'Two Columns', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'footerlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Column one layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'footer_column_one_layout',
	'label'           => __( 'Column 1', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
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
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'partial_refresh' => array(
		'footercolumnonelayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Column one.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'footer_column_one',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => __( '&copy; [year] - [blogname] | All rights reserved', 'page-builder-framework' ),
	'priority'        => 2,
	'tab'             => 'general',
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => 'footer_column_one_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	),
	'partial_refresh' => array(
		'footercolumnonecontent' => array(
			'selector'        => '#footer',
			'render_callback' => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings'        => 'footer_column_two_separator',
		'section'         => 'wpbf_footer_options',
		'priority'        => 3,
		'tab'             => 'general',
		'active_callback' => [
			[
				'setting'  => 'footer_layout',
				'operator' => '==',
				'value'    => 'two',
			],
		],
	]
);

// Column two layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'footer_column_two_layout',
	'label'           => __( 'Column 2', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => 'text',
	'priority'        => 3,
	'tab'             => 'general',
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	),
	'partial_refresh' => array(
		'footercolumntwolayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Column two.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'footer_column_two',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => __( 'Powered by [theme_author]', 'page-builder-framework' ),
	'priority'        => 3,
	'tab'             => 'general',
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '==',
			'value'    => 'two',
		),
		array(
			'setting'  => 'footer_column_two_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	),
	'partial_refresh' => array(
		'footercolumntwocontent' => array(
			'selector'        => '#footer',
			'render_callback' => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Width.
Kirki::add_field( 'wpbf', array(
	'type'            => 'dimension',
	'label'           => __( 'Footer Width', 'page-builder-framework' ),
	'description'     => __( 'Default: 1200px', 'page-builder-framework' ),
	'settings'        => 'footer_width',
	'section'         => 'wpbf_footer_options',
	'priority'        => 5,
	'transport'       => 'postMessage',
	'tab'             => 'general',
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Footer height.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'footer_height',
	'label'           => __( 'Height', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'priority'        => 6,
	'default'         => 20,
	'transport'       => 'postMessage',
	'tab'             => 'general',
	'choices'         => array(
		'min'  => 1,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_bg_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => '#f5f5f7',
	'transport'       => 'postMessage',
	'priority'        => 7,
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'transport'       => 'postMessage',
	'priority'        => 8,
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_accent_color',
	'label'           => __( 'Accent Color', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'priority'        => 9,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_accent_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'priority'        => 10,
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'label'           => __( 'Font Size', 'page-builder-framework' ),
	'settings'        => 'footer_font_size',
	'section'         => 'wpbf_footer_options',
	'priority'        => 11,
	'default'         => '14px',
	'transport'       => 'postMessage',
	'tab'             => 'design',
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
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

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/advanced-footer-settings/?utm_source=repository&utm_medium=customizer_footer_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_widget_footer',
		'section'  => 'wpbf_widget_footer_options',
		'default'  => $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/advanced-footer-settings/?utm_source=repository&utm_medium=customizer_footer_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_footer',
		'section'  => 'wpbf_footer_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}
