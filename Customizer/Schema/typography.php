<?php
/**
 * Option schema: Typography.
 *
 * One entry per option that stores a value: control type, default (the value visitors see when nothing is saved)
 * and, for options saved as JSON text, 'json' => true. See Customizer/Schema/OptionSchema.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'page_font_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'page_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => 'regular',
		),
	),
	'page_font_color' => array(
		'type'    => 'color',
		'default' => '#6d7680',
	),
	'page_accent_color' => array(
		'type'    => 'color',
		'default' => '#3ba9d2',
	),
	'page_accent_color_alt' => array(
		'type'    => 'color',
		'default' => '#79c4e0',
	),
	'menu_logo_font_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'menu_logo_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
			'subsets'     => array( 'latin-ext' ),
		),
	),
	'menu_logo_description_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'menu_logo_description_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
			'subsets'     => array( 'latin-ext' ),
		),
	),
	'menu_font_family_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'menu_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => 'regular',
		),
	),
	'sub_menu_font_family_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'sub_menu_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => 'regular',
		),
	),
	'page_h1_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'page_h1_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
		),
	),
	'page_h2_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'page_h2_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
		),
	),
	'page_h3_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'page_h3_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
		),
	),
	'page_h4_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'page_h4_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
		),
	),
	'page_h5_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'page_h5_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
		),
	),
	'page_h6_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'page_h6_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => '700',
		),
	),
	'footer_font_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'footer_font_family' => array(
		'type'    => 'typography',
		'default' => array(
			'font-family' => 'Helvetica, Arial, sans-serif',
			'variant'     => 'regular',
		),
	),
);
