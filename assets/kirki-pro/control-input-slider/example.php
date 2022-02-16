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
	'kirki_pro_demo_input_slider_section',
	[
		'title' => esc_html__( 'Input Slider', 'kirki-pro' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

/**
 * Slider Control.
 *
 * @since 1.0.0
 */
new \Kirki\Pro\Field\InputSlider(
	[
		'settings'    => 'kirki_pro_demo_input_slider',
		'label'       => esc_html__( 'Input Slider Control', 'control-input-slider' ),
		'description' => 'Example of input slider.',
		'section'     => 'kirki_pro_demo_input_slider_section',
		'default'     => '30px',
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'The input slider is more flexible compared to the "Slider" control in free version.', 'control-input-slider' ),
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	]
);
