<?php
/**
 * Add the example of usage.
 *
 * @package kirki-pro/example
 */

/**
 * Add the demo panel.
 *
 * @link https://kirki.org/docs/setup/panels-sections/
 * @since 1.0.0
 */
new \Kirki\Panel(
	'kirki_pro_demo_panel',
	[
		'priority'    => 10,
		'title'       => esc_html__( 'Kirki PRO Demo Panel', 'control-tab' ),
		'description' => esc_html__( 'Contains sections for all Kirki PRO controls.', 'control-tab' ),
	]
);

/**
 * Add the input slider demo section.
 *
 * @link https://kirki.org/docs/setup/panels-sections/
 * @since 1.0.0
 */
new \Kirki\Section(
	'kirki_pro_demo_tab_section',
	[
		'title' => esc_html__( 'Tab', 'control-tab' ),
		'panel' => 'kirki_pro_demo_panel',
		'tabs'  => [
			'content' => [
				'label' => esc_html__( 'Content', 'control-tab' ),
			],
			'design'  => [
				'label' => esc_html__( 'Design', 'control-tab' ),
			],
		],
	]
);

/**
 * Generic text control inside "content" tab.
 */
new \Kirki\Field\Text(
	[
		'settings'    => 'kirki_pro_demo_text_inside_tab',
		'label'       => esc_html__( 'Text Control', 'control-tab' ),
		'description' => esc_html__( 'Text control under content tab.', 'control-tab' ),
		'section'     => 'kirki_pro_demo_tab_section',
		'tab'         => 'content',
		'default'     => '',
		'transport'   => 'postMessage',
	]
);

/**
 * Generic text control inside "design" tab.
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_pro_demo_color_inside_tab',
		'label'       => __( 'Color Control', 'control-tab' ),
		'description' => esc_html__( 'Color control under design tab.', 'control-tab' ),
		'section'     => 'kirki_pro_demo_tab_section',
		'tab'         => 'design',
		'transport'   => 'postMessage',
		'default'     => '#0008DC',
	]
);
