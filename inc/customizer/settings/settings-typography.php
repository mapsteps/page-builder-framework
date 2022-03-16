<?php
/**
 * Typography customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Typography.
Kirki::add_panel( 'typo_panel', array(
	'priority' => 3,
	'title'    => __( 'Typography', 'page-builder-framework' ),
) );

/* Sections */

// Title & tagline.
Kirki::add_section( 'wpbf_title_tagline_options', array(
	'title'    => __( 'Site Title / Tagline', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 0,
) );

// Menu.
Kirki::add_section( 'wpbf_menu_font_options', array(
	'title'    => __( 'Navigation', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 50,
) );

// Sub Menu.
Kirki::add_section( 'wpbf_sub_menu_font_options', array(
	'title'    => __( 'Sub Menu', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 75,
) );


// Text.
Kirki::add_section( 'wpbf_font_options', array(
	'title'    => __( 'Text', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 100,
) );

// H1.
Kirki::add_section( 'wpbf_h1_options', array(
	'title'    => __( 'H1', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 200,
) );

// H2.
Kirki::add_section( 'wpbf_h2_options', array(
	'title'    => __( 'H2', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 300,
) );

// H3.
Kirki::add_section( 'wpbf_h3_options', array(
	'title'    => __( 'H3', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 400,
) );

// H4.
Kirki::add_section( 'wpbf_h4_options', array(
	'title'    => __( 'H4', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 500,
) );

// H5.
Kirki::add_section( 'wpbf_h5_options', array(
	'title'    => __( 'H5', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 600,
) );

// H6.
Kirki::add_section( 'wpbf_h6_options', array(
	'title'    => __( 'H6', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 700,
) );

// Footer.
Kirki::add_section( 'wpbf_footer_font_options', array(
	'title'    => __( 'Footer', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 800,
) );

/* Fields - Text */

// Text font toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'page_font_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_font_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_font_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings'        => 'page_font_toggle_separator',
		'section'         => 'wpbf_font_options',
		'priority'        => 1,
	]
);

// Color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'page_font_color',
	'label'     => __( 'Color', 'page-builder-framework' ),
	'section'   => 'wpbf_font_options',
	'default'   => '#6d7680',
	'priority'  => 2,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'page_accent_color',
	'label'    => __( 'Accent Color', 'page-builder-framework' ),
	'section'  => 'wpbf_font_options',
	'priority' => 4,
	'default'  => '#3ba9d2',
	'choices'  => array(
		'alpha' => true,
	),
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'page_accent_color_alt',
	'label'    => __( 'Hover', 'page-builder-framework' ),
	'section'  => 'wpbf_font_options',
	'priority' => 4,
	'default'  => '#79c4e0',
	'choices'  => array(
		'alpha' => true,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_text',
		'section'  => 'wpbf_font_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - Title & tagline */

// Title font toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'menu_logo_font_toggle',
		'label'    => esc_html__( 'Title - Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_title_tagline_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'menu_logo_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_title_tagline_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	),
	'choices'         => wpbf_default_font_choices(),
	'priority'        => 1,
	'active_callback' => array(
		array(
			'setting'  => 'menu_logo_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

// Divider.
new \Kirki\PRO\Field\Divider(
	[
		'settings' => 'menu_logo_tagline_divider',
		'section'  => 'wpbf_title_tagline_options',
		'default'  => 0,
		'priority' => 2,
	]
);

// Title font toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'menu_logo_description_toggle',
		'label'    => esc_html__( 'Tagline - Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_title_tagline_options',
		'default'  => 0,
		'priority' => 3,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'menu_logo_description_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_title_tagline_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	),
	'choices'         => wpbf_default_font_choices(),
	'priority'        => 4,
	'active_callback' => array(
		array(
			'setting'  => 'menu_logo_description_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

/* Fields - Menu */

// Menu font toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'menu_font_family_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_menu_font_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'menu_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_menu_font_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'menu_font_family_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_menu',
		'section'  => 'wpbf_menu_font_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - Sub Menu */

// Sub Menu font toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'sub_menu_font_family_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_sub_menu_font_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'sub_menu_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_sub_menu_font_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'sub_menu_font_family_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_sub_menu',
		'section'  => 'wpbf_sub_menu_font_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - H1 */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings'    => 'page_h1_toggle',
		'label'       => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'description' => __( 'The settings below will apply to all headlines if not configured individually.', 'page-builder-framework' ),
		'section'     => 'wpbf_h1_options',
		'default'     => 0,
		'priority'    => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h1_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_h1_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h1_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h1',
		'section'  => 'wpbf_h1_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - H2 */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'page_h2_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_h2_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h2_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_h2_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h2_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h2',
		'section'  => 'wpbf_h2_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - H3 */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'page_h3_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_h3_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h3_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_h3_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h3_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h3',
		'section'  => 'wpbf_h3_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - H4 */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'page_h4_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_h4_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h4_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_h4_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h4_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h4',
		'section'  => 'wpbf_h4_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - H5 */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'page_h5_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_h5_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h5_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_h5_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h5_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h5',
		'section'  => 'wpbf_h5_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - H6 */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'page_h6_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_h6_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h6_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_h6_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h6_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h6',
		'section'  => 'wpbf_h6_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields - Footer */

// Toggle.
new \Kirki\Field\Toggle(
	[
		'settings' => 'footer_font_toggle',
		'label'    => esc_html__( 'Font Settings', 'page-builder-framework' ),
		'section'  => 'wpbf_footer_font_options',
		'default'  => 0,
		'priority' => 0,
	]
);

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'footer_font_family',
	'label'           => __( 'Font Family', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_font_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'footer_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_footer',
		'section'  => 'wpbf_footer_font_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}
