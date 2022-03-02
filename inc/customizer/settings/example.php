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
		'title'       => esc_html__( 'Kirki PRO Demo Panel', 'control-headline-divider' ),
		'description' => esc_html__( 'Contains sections for all Kirki PRO controls.', 'control-headline-divider' ),
	]
);

/**
 * Add the input slider demo section.
 *
 * @link https://kirki.org/docs/setup/panels-sections/
 * @since 1.0.0
 */
new \Kirki\Section(
	'kirki_pro_demo_headline_divider_section',
	[
		'title' => esc_html__( 'Headlines & Divider', 'control-headline-divider' ),
		'panel' => 'kirki_pro_demo_panel',
	]
);

/**
 * Headline Control.
 *
 * @since 1.0.0
 */
new \Kirki\Pro\Field\HeadlineToggle(
	[
		'settings'    => 'kirki_pro_demo_headline0',
		'label'       => esc_html__( 'Headline', 'control-headline-divider' ),
		'description' => esc_html__( 'Sample of headline control.', 'control-headline-divider' ),
		'section'     => 'kirki_pro_demo_headline_divider_section',
		'tooltip'     => 'Headline control visually groups controls together.',
	]
);

/**
 * Divider control.
 */
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'kirki_pro_demo_divider0',
		'section'  => 'kirki_pro_demo_headline_divider_section',
		'choices'  => [
			'color' => '#c9c9c9',
		],
	]
);

/**
 * Headline toggle control.
 */
new \Kirki\Pro\Field\HeadlineToggle(
	[
		'settings' => 'kirki_pro_demo_headline_toggle0',
		'label'    => esc_html__( 'Headline Toggle', 'control-headline-divider' ),
		// 'description' => esc_html__( 'Sample of headline toggle control.', 'control-headline-divider' ),
		'section'  => 'kirki_pro_demo_headline_divider_section',
	]
);
