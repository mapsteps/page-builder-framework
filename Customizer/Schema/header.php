<?php
/**
 * Option schema: Header: pre header, logo, navigation, sub menu, mobile navigation.
 *
 * One entry per option that stores a value: control type, default (the value visitors see when nothing is saved)
 * and, for options saved as JSON text, 'json' => true. See Customizer/Schema/OptionSchema.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'pre_header_layout' => array(
		'type'    => 'radio-buttonset',
		'default' => 'none',
	),
	'pre_header_column_one_layout' => array(
		'type'    => 'select',
		'default' => 'text',
	),
	'pre_header_column_one' => array(
		'type'    => 'textarea',
		'default' => function () {
			return __( 'Column 1', 'page-builder-framework' );
		},
	),
	'pre_header_column_two_layout' => array(
		'type'    => 'select',
		'default' => 'text',
	),
	'pre_header_column_two' => array(
		'type'    => 'textarea',
		'default' => function () {
			return __( 'Column 2', 'page-builder-framework' );
		},
	),
	'pre_header_width' => array(
		'type'    => 'dimension',
		'default' => '',
	),
	'pre_header_height' => array(
		'type'    => 'slider',
		'default' => 10,
	),
	'pre_header_bg_color' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'pre_header_font_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'pre_header_accent_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'pre_header_accent_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'pre_header_font_size' => array(
		'type'    => 'input-slider',
		'default' => '14px',
	),
	'menu_mobile_logo' => array(
		'type'    => 'image',
		'default' => '',
	),
	'menu_logo_size' => array(
		'type'    => 'responsive-input-slider',
		'default' => array(),
		'json'    => true,
	),
	'menu_logo_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'menu_logo_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'menu_logo_font_size' => array(
		'type'    => 'responsive-input-slider',
		'default' => array(
			'desktop' => '22px',
			'tablet'  => '',
			'mobile'  => '',
		),
		'json'    => true,
	),
	'menu_logo_description' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'menu_logo_description_mobile' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'menu_logo_description_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'menu_logo_description_font_size' => array(
		'type'    => 'responsive-input-slider',
		'default' => array(),
		'json'    => true,
	),
	'menu_logo_url' => array(
		'type'    => 'url',
		'default' => '',
	),
	'menu_logo_alt' => array(
		'type'    => 'text',
		'default' => function () {
			return get_bloginfo( 'name' );
		},
	),
	'menu_logo_title' => array(
		'type'    => 'text',
		'default' => function () {
			return get_bloginfo( 'name' );
		},
	),
	'menu_logo_container_width' => array(
		'type'    => 'slider',
		'default' => 25,
	),
	'mobile_menu_logo_container_width' => array(
		'type'    => 'slider',
		'default' => 66,
	),
	'menu_position' => array(
		'type'    => 'select',
		'default' => 'menu-right',
	),
	'menu_search_icon' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'menu_width' => array(
		'type'    => 'dimension',
		'default' => '',
	),
	'menu_height' => array(
		'type'    => 'slider',
		'default' => 20,
	),
	'menu_padding' => array(
		'type'    => 'slider',
		'default' => 20,
	),
	'menu_bg_color' => array(
		'type'    => 'color',
		'default' => '#f5f5f7',
	),
	'menu_font_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'menu_font_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'menu_font_size' => array(
		'type'    => 'input-slider',
		'default' => '16px',
	),
	'sub_menu_width' => array(
		'type'    => 'slider',
		'default' => 220,
	),
	'sub_menu_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'sub_menu_text_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'sub_menu_padding' => array(
		'type'    => 'padding',
		'default' => array(
			'top'    => 10,
			'right'  => 20,
			'bottom' => 10,
			'left'   => 20,
		),
		'json'    => true,
	),
	'sub_menu_bg_color' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'sub_menu_bg_color_alt' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'sub_menu_accent_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'sub_menu_accent_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'sub_menu_font_size' => array(
		'type'    => 'input-slider',
		'default' => '',
	),
	'sub_menu_separator' => array(
		'type'    => 'headline-toggle',
		'default' => false,
	),
	'sub_menu_separator_color' => array(
		'type'    => 'color',
		'default' => '#f5f5f7',
	),
	'mobile_menu_options' => array(
		'type'    => 'select',
		'default' => 'menu-mobile-hamburger',
	),
	'mobile_menu_search_icon' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'mobile_menu_height' => array(
		'type'    => 'slider',
		'default' => 20,
	),
	'mobile_menu_background_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_menu_hamburger_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_menu_hamburger_size' => array(
		'type'    => 'input-slider',
		'default' => '16px',
	),
	'mobile_menu_hamburger_bg_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_menu_hamburger_border_radius' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'mobile_menu_padding' => array(
		'type'    => 'padding',
		'default' => array(
			'top'    => 10,
			'right'  => 20,
			'bottom' => 10,
			'left'   => 20,
		),
		'json'    => true,
	),
	'mobile_menu_bg_color' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'mobile_menu_bg_color_alt' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'mobile_menu_font_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_menu_font_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_menu_border_color' => array(
		'type'    => 'color',
		'default' => '#d9d9e0',
	),
	'mobile_menu_submenu_arrow_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_menu_font_size' => array(
		'type'    => 'input-slider',
		'default' => '16px',
	),
	'mobile_sub_menu_auto_collapse' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'mobile_sub_menu_indent' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'mobile_sub_menu_bg_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_sub_menu_bg_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_sub_menu_font_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_sub_menu_font_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_sub_menu_arrow_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'mobile_sub_menu_font_size' => array(
		'type'    => 'input-slider',
		'default' => '',
	),
);
