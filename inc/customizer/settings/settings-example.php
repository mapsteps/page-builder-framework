<?php
/**
 * Add the demo panel.
 *
 * @link https://kirki.org/docs/getting-started/panels.html
 * @package kirki-pro/example
 */

new \Kirki\Panel(
	'kirki_pro_demo_panel',
	[
		'priority'    => 10,
		'title'       => esc_html__( 'Kirki PRO Demo Panel', 'kirki-pro' ),
		'description' => esc_html__( 'Contains sections for all Kirki PRO controls.', 'kirki-pro' ),
	]
);

/**
 * Add the headline demo section.
 */
new \Kirki\Section(
	'kirki_pro_demo_headline_section',
	[
		'title' => esc_html__( 'Headline', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

/**
 * Headline control inside the "headline" section.
 */
new \Kirki\Pro\Field\Headline(
	[
		'settings'    => 'kirki_pro_demo_headline0',
		'label'       => esc_html__( 'Content', 'kirki-pro' ),
		'description' => esc_html__( 'Sample of headline control.', 'kirki-pro' ),
		'section'     => 'kirki_pro_demo_headline_section',
		'tooltip'     => 'Headline control visually groups controls together.',
	]
);

/**
 * Generic text control inside the "headline" section.
 */
new \Kirki\Field\Text(
	[
		'settings'    => 'kirki_pro_demo_text0',
		'label'       => esc_html__( 'Title', 'kirki-pro' ),
		'description' => esc_html__( 'Generic text demo inside Kirki PRO tab.', 'kirki-pro' ),
		'section'     => 'kirki_pro_demo_headline_section',
		'default'     => '',
		'transport'   => 'postMessage',
	]
);

/**
 * Generic textarea control inside the "headline" section.
 */
new \Kirki\Field\Textarea(
	[
		'settings'    => 'kirki_pro_demo_textarea0',
		'label'       => esc_html__( 'Content', 'kirki-pro' ),
		'description' => esc_html__( 'Generic textarea demo inside Kirki PRO tab.', 'kirki-pro' ),
		'section'     => 'kirki_pro_demo_headline_section',
		'default'     => '',
		'transport'   => 'postMessage',
	]
);

/**
 * Headline toggle control inside the "headline" section.
 */
new \Kirki\Pro\Field\HeadlineToggle(
	[
		'settings' => 'kirki_pro_demo_headline_toggle0',
		'label'    => esc_html__( 'Design', 'kirki-pro' ),
		// 'description' => esc_html__( 'Sample of headline toggle control.', 'kirki-pro' ),
		'section'  => 'kirki_pro_demo_headline_section',
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_pro_demo_color0',
		'label'       => __( 'Text Color', 'kirki' ),
		'description' => esc_html__( 'This is a color control under headline toggle.', 'kirki' ),
		'section'     => 'kirki_pro_demo_headline_section',
		'transport'   => 'postMessage',
		'default'     => '#0008DC',
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_pro_demo_color1',
		'label'       => __( 'Background Color', 'kirki' ),
		'description' => esc_html__( 'This is a color control under headline toggle.', 'kirki' ),
		'section'     => 'kirki_pro_demo_headline_section',
		'transport'   => 'postMessage',
		'default'     => '#0008DC',
	]
);

/**
 * Divider control inside the "headline" section.
 */
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'kirki_pro_demo_divider0',
		'section'  => 'kirki_pro_demo_headline_section',
		'choices'  => [
			'color' => '#c9c9c9',
		],
	]
);

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'kirki_pro_demo_dimensions_0',
		'label'       => esc_html__( 'Dimensions', 'kirki' ),
		'description' => esc_html__( 'Sample of dimensions control under headline toggle.', 'kirki' ),
		'section'     => 'kirki_pro_demo_headline_section',
		'default'     => [
			'width'  => '100px',
			'height' => '100px',
		],
	]
);

/**
 * Add the responsive demo section for free controls.
 */
new \Kirki\Section(
	'kirki_pro_demo_responsive_section',
	[
		'title' => esc_html__( 'Responsive', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_pro_demo_responsive_color',
		'label'       => __( 'Responsive Color', 'kirki' ),
		'description' => 'The CSS output is set to <code>.entry-title a</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => '#0000ff',
			'tablet'  => '#00ffff',
			'mobile'  => '#ff0000',
		],
		'output'      => [
			[
				'element'     => '.entry-title a',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			],
		],
	]
);

new \Kirki\Field\Color(
	[
		'settings'   => 'kirki_pro_demo_color_responsive_1',
		'label'      => __( 'Title Only', 'kirki' ),
		'section'    => 'kirki_pro_demo_responsive_section',
		'transport'  => 'postMessage',
		'tooltip'    => 'The CSS output is set to <code>.article-content p</code> using Page Builder Framework.',
		'responsive' => true,
		'default'    => [
			'desktop' => '#000',
			'tablet'  => '#00f',
			'mobile'  => '#f00',
		],
		'output'     => [
			[
				'element'     => '.article-content p',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			],
		],
	]
);

/**
 * Checkbox control.
 *
 * @link https://kirki.org/docs/controls/checkbox.html
 */
new \Kirki\Field\Checkbox(
	[
		'settings'    => 'kirki_pro_demo_responsive_checkbox',
		'label'       => esc_html__( 'Responsive Checkbox', 'kirki' ),
		'description' => 'Checkbox in responsive mode without the <code>output</code> argument.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => true,
			'tablet'  => false,
			'mobile'  => false,
		],
	]
);

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'kirki_pro_demo_responsive_switch',
		'label'       => esc_html__( 'Responsive Switch', 'kirki' ),
		'description' => 'Switch control in responsive mode without the <code>output</code> argument.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => true,
			'tablet'  => false,
			'mobile'  => false,
		],
	]
);

new \Kirki\Field\Checkbox_Toggle(
	[
		'settings'    => 'kirki_pro_demo_responsive_toggle',
		'label'       => esc_html__( 'Responsive Toggle', 'kirki-pro' ),
		'description' => 'Toggle in responsive mode without the <code>output</code> argument.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => 1,
			'tablet'  => 0,
			'mobile'  => 1,
		],
	]
);

new \Kirki\Field\Dimension(
	[
		'settings'    => 'kirki_pro_demo_responsive_dimension',
		'label'       => esc_html__( 'Responsive Dimension', 'kirki' ),
		'description' => 'The CSS output is set as <code>padding</code> to <code>.wpbf-sidebar .widget</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => '20px',
			'tablet'  => '30px',
			'mobile'  => '40px',
		],
		'choices'     => [
			'accept_unitless' => true,
		],
		'output'      => [
			[
				'element'     => '.wpbf-sidebar .widget',
				'property'    => 'padding',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			],
		],
	]
);

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'kirki_pro_demo_responsive_dimensions',
		'label'       => esc_html__( 'Responsive Dimensions', 'kirki' ),
		'description' => 'The CSS output is set to <code>.wpbf-sidebar</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => [
				'padding-top'    => '80px',
				'padding-right'  => '50px',
				'padding-bottom' => '80px',
				'padding-left'   => '50px',
			],
			'tablet'  => [
				'padding-top'    => '60px',
				'padding-right'  => '40px',
				'padding-bottom' => '60px',
				'padding-left'   => '40px',
			],
			'mobile'  => [
				'padding-top'    => '40px',
				'padding-right'  => '20px',
				'padding-bottom' => '40px',
				'padding-left'   => '20px',
			],
		],
		'output'      => [
			[
				'element'     => '.wpbf-sidebar',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			],
		],
	]
);

/**
 * Allow SVG upload
 *
 * @link https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
 *
 * @param array $mimes The existing allowed mime types.
 * @return array
 */
function kirki_upload_mime_types( $mimes ) {

	$mimes['svg'] = 'image/svg+xml';
	return $mimes;

}
add_filter( 'upload_mimes', 'kirki_upload_mime_types' );

new \Kirki\Field\Image(
	[
		'settings'    => 'kirki_pro_demo_responsive_image',
		'label'       => esc_html__( 'Responsive Image Control', 'kirki' ),
		'description' => esc_html__( 'Image control in responsive mode.', 'kirki' ),
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => '',
			'tablet'  => '',
			'mobile'  => '',
		],
	]
);

new \Kirki\Field\Number(
	[
		'settings'    => 'kirki_pro_demo_responsive_number',
		'label'       => esc_html__( 'Responsive Number Control', 'kirki' ),
		'description' => 'The output CSS is set as <code>letter-spacing</code> to <code>.wpbf-sidebar .widget h2</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'responsive'  => true,
		// 'tooltip'     => 'Number control in responsive mode.',
		'default'     => [
			'desktop' => 0,
			'tablet'  => 1,
			'mobile'  => 0,
		],
		'choices'     => [
			'min'  => 0,
			'max'  => 5,
			'step' => 1,
		],
		'output'      => [
			[
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
				'element'     => '.wpbf-sidebar .widget h2',
				'property'    => 'letter-spacing',
				'suffix'      => 'px',
			],
		],
	]
);

new \Kirki\Field\Slider(
	[
		'settings'    => 'kirki_pro_demo_responsive_slider',
		'label'       => esc_html__( 'Slider Control', 'kirki' ),
		'description' => 'Slider control in responsive mode. The output CSS is set as <code>line-height</code> to <code>.article-content p</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'Responsive regular slider', 'kirki' ),
		'responsive'  => true,
		'default'     => [
			'desktop' => 1.8,
			'tablet'  => 1.6,
			'mobile'  => 1.4,
		],
		'output'      => [
			[
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
				'element'     => '.article-content p',
				'property'    => 'line-height',
			],
		],
		'choices'     => [
			'min'  => 0,
			'max'  => 30,
			'step' => 0.1,
		],
	]
);

/**
 * Add the responsive demo section for Pro controls.
 */
new \Kirki\Section(
	'kirki_pro_demo_responsive_section_pro',
	[
		'title' => esc_html__( 'Responsive - Using Pro Controls', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

new \Kirki\Pro\Field\Margin(
	[
		'settings'    => 'kirki_pro_demo_responsive_margin',
		'label'       => esc_html__( 'Responsive Margin', 'kirki' ),
		'description' => 'The output is set to <code>.article-footer</code>.',
		'section'     => 'kirki_pro_demo_responsive_section_pro',
		'responsive'  => true,
		'default'     => [
			'desktop' => [
				'top'   => 40,
				'right' => 50,
				'left'  => 30,
			],
			'tablet'  => [
				'top'    => 90,
				'bottom' => 80,
				'left'   => 70,
			],
			'mobile'  => [
				'right'  => 15,
				'bottom' => 20,
				'left'   => 5,
			],
		],
		'output'      => [
			[
				'element'     => '.article-footer',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			],
		],
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This is the tooltip', 'kirki' ),
		'choices'     => [
			'unit' => 'px',
		],
	]
);

new \Kirki\Pro\Field\Padding(
	[
		'settings'    => 'kirki_pro_demo_responsive_padding',
		'label'       => esc_html__( 'Responsive Padding', 'kirki' ),
		'description' => 'The output is set to <code>.wpbf-read-more</code>.',
		'section'     => 'kirki_pro_demo_responsive_section_pro',
		'responsive'  => true,
		'default'     => [
			'desktop' => [
				'right'  => 15,
				'bottom' => 20,
				'left'   => 5,
			],
			'tablet'  => [
				'top'    => 77,
				'bottom' => 87,
				'left'   => 97,
			],
			'mobile'  => [
				'top'   => 40,
				'right' => 50,
				'left'  => 30,
			],
		],
		'output'      => [
			[
				'element'     => '.wpbf-read-more',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			],
		],
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This is the tooltip', 'kirki' ),
	]
);

new \Kirki\Pro\Field\InputSlider(
	[
		'settings'    => 'kirki_pro_demo_responsive_input_slider',
		'label'       => esc_html__( 'Input Slider Control', 'kirki' ),
		'description' => 'Input slider in responsive mode. The output CSS is set as <code>font-size</code> to <code>.article-content p</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_responsive_section_pro',
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'Responsive input slider with various unit', 'kirki' ),
		'responsive'  => true,
		'default'     => [
			'desktop' => '18px',
			'tablet'  => '16px',
			'mobile'  => '14px',
		],
		'output'      => [
			[
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
				'element'     => '.article-content p',
				'property'    => 'font-size',
			],
		],
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	]
);

/**
 * Add the margin-padding demo section.
 */
new \Kirki\Section(
	'kirki_pro_demo_margin_padding_section',
	[
		'title' => esc_html__( 'Margin & Padding', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

new \Kirki\Pro\Field\Margin(
	[
		'settings'    => 'kirki_pro_demo_margin',
		'label'       => esc_html__( 'Margin Control', 'kirki' ),
		'description' => 'Sample of margin control. The output CSS is set to <code>.wpbf-logo</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_margin_padding_section',
		'default'     => [
			'top'    => 30,
			'bottom' => 30,
			'left'   => 30,
		],
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This is the tooltip', 'kirki' ),
		'output'      => [
			[
				'element' => '.wpbf-logo',
			],
		],
	]
);

new \Kirki\Pro\Field\Padding(
	[
		'settings'    => 'kirki_pro_demo_padding',
		'label'       => esc_html__( 'Padding Control', 'kirki' ),
		'description' => 'Sample of padding control. The output CSS is set to <code>.entry-title</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_margin_padding_section',
		'default'     => [
			'top'    => 1,
			'bottom' => 2,
		],
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This is the tooltip', 'kirki' ),
		'choices'     => [
			'unit' => 'rem',
		],
		'output'      => [
			[
				'element' => '.entry-title',
			],
		],
	]
);

/**
 * Add the input slider demo section.
 */
new \Kirki\Section(
	'kirki_pro_demo_input_slider_section',
	[
		'title' => esc_html__( 'Input Slider', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

/**
 * Slider Control.
 */
new \Kirki\Pro\Field\InputSlider(
	[
		'settings'    => 'kirki_pro_demo_input_slider',
		'label'       => esc_html__( 'Input Slider Control', 'kirki' ),
		'description' => 'Sample of input slider. The output CSS is set as <code>font-size</code> to <code>.article-header .entry-title</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_input_slider_section',
		'default'     => '30px',
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This is the tooltip', 'kirki' ),
		'output'      => [
			[
				'element'  => '.article-header .entry-title',
				'property' => 'font-size',
			],
		],
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	]
);

/**
 * Add the tab demo section.
 */
new \Kirki\Section(
	'kirki_pro_demo_tabs_section',
	[
		'title' => esc_html__( 'Tabs', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
		'tabs'  => [
			'content' => [
				'icon'  => 'dashicons dashicons-media-document',
				'label' => esc_html__( 'Content', 'kirki-pro' ),
			],
			'design'  => [
				'icon'  => 'dashicons dashicons-admin-appearance',
				'label' => esc_html__( 'Design', 'kirki-pro' ),
			],
		],
	]
);

/**
 * Generic text control inside "content" tab.
 */
new \Kirki\Field\Text(
	[
		'settings'    => 'kirki_pro_demo_text',
		'label'       => esc_html__( 'Title', 'kirki-pro' ),
		'description' => esc_html__( 'Generic text demo inside Kirki PRO tab.', 'kirki-pro' ),
		'section'     => 'kirki_pro_demo_tabs_section',
		'tab'         => 'content',
		'default'     => '',
		'transport'   => 'postMessage',
	]
);

/**
 * Divider control inside "content" tab.
 */
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'kirki_pro_demo_divider',
		'section'  => 'kirki_pro_demo_tabs_section',
		'tab'      => 'content',
		'choices'  => [
			'color' => '#c9c9c9',
		],
	]
);

/**
 * Generic textarea control inside "content" tab.
 */
new \Kirki\Field\Textarea(
	[
		'settings'    => 'kirki_pro_demo_textarea',
		'label'       => esc_html__( 'Content', 'kirki-pro' ),
		'description' => esc_html__( 'Generic textarea demo inside Kirki PRO tab.', 'kirki-pro' ),
		'section'     => 'kirki_pro_demo_tabs_section',
		'tab'         => 'content',
		'default'     => '',
		'transport'   => 'postMessage',
	]
);

/**
 * Slider control inside "design" tab.
 */
new \Kirki\Field\Slider(
	[
		'settings'    => 'kirki_pro_demo_slider',
		'label'       => esc_html__( 'Line Height', 'kirki-pro' ),
		'description' => 'Slider demo inside Kirki PRO tab. The output CSS is set as <code>letter-spacing</code> to <code>.wpbf-page-footer</code> using Page Builder Framework.',
		'section'     => 'kirki_pro_demo_tabs_section',
		'tab'         => 'design',
		'default'     => 1.2,
		'transport'   => 'postMessage',
		'output'      => [
			[
				'element'  => '.entry-title',
				'property' => 'padding-left',
			],
		],
		'tooltip'     => esc_html__( 'This is the tooltip', 'kirki-pro' ),
		'choices'     => [
			'min'  => 0,
			'max'  => 30,
			'step' => 0.1,
		],
		'output'      => [
			[
				'element'  => '.article-header .entry-title',
				'property' => 'line-height',
			],
		],
	]
);
