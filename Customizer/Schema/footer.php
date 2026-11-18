<?php
/**
 * Option schema: Footer.
 *
 * One entry per option that stores a value: control type, default (the value visitors see when nothing is saved)
 * and, for options saved as JSON text, 'json' => true. See Customizer/Schema/OptionSchema.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'footer_layout' => array(
		'type'    => 'radio-buttonset',
		'default' => 'two',
	),
	'footer_column_one_layout' => array(
		'type'    => 'select',
		'default' => 'text',
	),
	'footer_column_one' => array(
		'type'    => 'textarea',
		'default' => '&copy; [year] - [blogname] | All rights reserved',
	),
	'footer_column_two_layout' => array(
		'type'    => 'select',
		'default' => 'text',
	),
	'footer_column_two' => array(
		'type'    => 'textarea',
		'default' => 'Powered by [theme_author]',
	),
	'footer_width' => array(
		'type'    => 'dimension',
		'default' => '',
	),
	'footer_height' => array(
		'type'    => 'slider',
		'default' => 20,
	),
	'footer_bg_color' => array(
		'type'    => 'color',
		'default' => '#f5f5f7',
	),
	'footer_font_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'footer_accent_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'footer_accent_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'footer_font_size' => array(
		'type'    => 'input-slider',
		'default' => '14px',
	),
);
