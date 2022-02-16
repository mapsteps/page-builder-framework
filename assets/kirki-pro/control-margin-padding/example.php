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
 * Add the margin & padding demo section.
 *
 * @link https://kirki.org/docs/setup/panels-sections/
 * @since 1.0.0
 */
new \Kirki\Section(
	'kirki_pro_demo_margin_padding_section',
	[
		'title' => esc_html__( 'Margin & Padding', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
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
		'description' => 'Example of margin control.',
		'section'     => 'kirki_pro_demo_margin_padding_section',
		'default'     => [
			'top'    => 30,
			'bottom' => 30,
			'left'   => 30,
		],
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This margin control', 'kirki' ),
	]
);

new \Kirki\Pro\Field\Padding(
	[
		'settings'    => 'kirki_pro_demo_padding',
		'label'       => esc_html__( 'Padding Control', 'kirki' ),
		'description' => 'Example of padding control.',
		'section'     => 'kirki_pro_demo_margin_padding_section',
		'default'     => [
			'top'    => 1,
			'bottom' => 2,
		],
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This padding control', 'kirki' ),
		'choices'     => [
			'unit' => 'rem',
		],
	]
);
