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
		'title'       => esc_html__( 'Kirki PRO Demo Panel', 'control-input-slider' ),
		'description' => esc_html__( 'Contains sections for all Kirki PRO controls.', 'control-input-slider' ),
	]
);

/**
 * Add the input slider demo section.
 *
 * @link https://kirki.org/docs/setup/panels-sections/
 * @since 1.0.0
 */
new \Kirki\Section(
	'kirki_pro_demo_responsive_section',
	[
		'title' => esc_html__( 'Responsive', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

/**
 * Responsive Color Control.
 *
 * @since 1.0.0
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_pro_demo_responsive_color',
		'label'       => __( 'Responsive Color', 'kirki-pro' ),
		'description' => __( 'A color control in responsive mode.', 'kirki-pro' ),
		'section'     => 'kirki_pro_demo_responsive_section',
		'transport'   => 'postMessage',
		'responsive'  => true,
		'default'     => [
			'desktop' => '#0000ff',
			'tablet'  => '#00ffff',
			'mobile'  => '#ff0000',
		],
	]
);