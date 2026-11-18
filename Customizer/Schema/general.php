<?php
/**
 * Option schema: General: layout, sidebar, 404 page, breadcrumbs, theme buttons, scroll to top.
 *
 * One entry per option that stores a value: control type, default (the value visitors see when nothing is saved)
 * and, for options saved as JSON text, 'json' => true. See Customizer/Schema/OptionSchema.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'page_max_width' => array(
		'type'    => 'dimension',
		'default' => '1200px',
	),
	'page_padding' => array(
		'type'    => 'responsive-padding',
		'default' => array(
			'desktop_top'    => 40,
			'desktop_right'  => 20,
			'desktop_bottom' => 40,
			'desktop_left'   => 20,
		),
		'json'    => true,
	),
	'page_boxed' => array(
		'type'    => 'headline-toggle',
		'default' => false,
	),
	'page_boxed_margin' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'page_boxed_padding' => array(
		'type'    => 'slider',
		'default' => 20,
	),
	'page_boxed_background' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'page_boxed_box_shadow' => array(
		'type'    => 'headline-toggle',
		'default' => false,
	),
	'page_boxed_box_shadow_blur' => array(
		'type'    => 'slider',
		'default' => 25,
	),
	'page_boxed_box_shadow_spread' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'page_boxed_box_shadow_horizontal' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'page_boxed_box_shadow_vertical' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'page_boxed_box_shadow_color' => array(
		'type'    => 'color',
		'default' => 'rgba(0,0,0,.15)',
	),
	'sidebar_position' => array(
		'type'    => 'select',
		'default' => 'right',
	),
	'sidebar_gap' => array(
		'type'    => 'select',
		'default' => 'medium',
	),
	'sidebar_width' => array(
		'type'    => 'slider',
		'default' => 33.3,
	),
	'sidebar_widget_padding' => array(
		'type'    => 'responsive-padding',
		'default' => array(
			'desktop_top'    => 20,
			'desktop_right'  => 20,
			'desktop_bottom' => 20,
			'desktop_left'   => 20,
			'tablet_top'     => 20,
			'tablet_right'   => 20,
			'tablet_bottom'  => 20,
			'tablet_left'    => 20,
			'mobile_top'     => 20,
			'mobile_right'   => 20,
			'mobile_bottom'  => 20,
			'mobile_left'    => 20,
		),
		'json'    => true,
	),
	'sidebar_bg_color' => array(
		'type'    => 'color',
		'default' => '#f5f5f7',
	),
	'404_headline' => array(
		'type'    => 'text',
		'default' => function () {
			return __( "404 - This page couldn't be found.", 'page-builder-framework' );
		},
	),
	'404_text' => array(
		'type'    => 'text',
		'default' => function () {
			return __( "Oops! We're sorry, this page couldn't be found!", 'page-builder-framework' );
		},
	),
	'404_search_form' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'breadcrumbs_toggle' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'breadcrumbs' => array(
		'type'    => 'select',
		'default' => array( 'archive', 'single' ),
	),
	'breadcrumbs_position' => array(
		'type'    => 'select',
		'default' => 'content',
	),
	'breadcrumbs_separator' => array(
		'type'    => 'text',
		'default' => '/',
	),
	'breadcrumbs_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'breadcrumbs_background_color' => array(
		'type'    => 'color',
		'default' => '#dedee5',
	),
	'breadcrumbs_font_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'breadcrumbs_accent_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'breadcrumbs_accent_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_bg_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_bg_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_text_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_text_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_primary_bg_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_primary_bg_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_primary_text_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_primary_text_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_border_radius' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'button_border_width' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'button_border_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_border_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_primary_border_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'button_primary_border_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'layout_scrolltop' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'scrolltop_position' => array(
		'type'    => 'radio-image',
		'default' => 'right',
	),
	'scrolltop_value' => array(
		'type'    => 'slider',
		'default' => 400,
	),
	'scrolltop_bg_color' => array(
		'type'    => 'color',
		'default' => 'rgba(62,67,73,0.5)',
	),
	'scrolltop_bg_color_alt' => array(
		'type'    => 'color',
		'default' => 'rgba(62,67,73,0.7)',
	),
	'scrolltop_icon_color' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'scrolltop_icon_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'scrolltop_border_radius' => array(
		'type'    => 'slider',
		'default' => 0,
	),
);
