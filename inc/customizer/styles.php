<?php
/**
 * Dynamic customizer CSS.
 *
 * Holds Customizer CSS styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

do_action( 'wpbf_before_customizer_css' );

$breakpoint_mobile_int  = function_exists( 'wpbf_breakpoint_mobile' ) ? wpbf_breakpoint_mobile() : 480;
$breakpoint_medium_int  = function_exists( 'wpbf_breakpoint_medium' ) ? wpbf_breakpoint_medium() : 768;
$breakpoint_desktop_int = function_exists( 'wpbf_breakpoint_desktop' ) ? wpbf_breakpoint_desktop() : 1024;

$breakpoint_mobile  = $breakpoint_mobile_int . 'px';
$breakpoint_medium  = $breakpoint_medium_int . 'px';
$breakpoint_desktop = $breakpoint_desktop_int . 'px';

$header_builder_enabled = wpbf_header_builder_enabled();

/* Typography */

// Page font settings.
$page_font_toggle  = wpbf_customize_bool_value( 'page_font_toggle' );
$page_font_setting = wpbf_customize_array_value( 'page_font_family' );

if ( $page_font_toggle && $page_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'body, button, input, optgroup, select, textarea, h1, h2, h3, h4, h5, h6',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_font_setting ),
		),
	) );

}

$page_font_color = wpbf_customize_str_value( 'page_font_color' );
$page_font_color = '#6d7680' === $page_font_color ? '' : $page_font_color;

if ( $page_font_color ) {

	wpbf_write_css( array(
		'selector' => 'body',
		'props'    => array( 'color' => $page_font_color ),
	) );

}

// Menu font settings.
$menu_font_toggle  = wpbf_customize_bool_value( 'menu_font_family_toggle' );
$menu_font_setting = wpbf_customize_array_value( 'menu_font_family' );

if ( $menu_font_toggle && $menu_font_setting ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-menu, .wpbf-mobile-menu',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $menu_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $menu_font_setting ),
			'font-style'  => wpbf_typography_font_style( $menu_font_setting ),
		),
	) );

}

// Sub Menu font settings.
$sub_menu_font_toggle  = wpbf_customize_bool_value( 'sub_menu_font_family_toggle' );
$sub_menu_font_setting = wpbf_customize_array_value( 'sub_menu_font_family' );

if ( $sub_menu_font_toggle && $sub_menu_font_setting ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-menu .sub-menu, .wpbf-mobile-menu .sub-menu',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $sub_menu_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $sub_menu_font_setting ),
			'font-style'  => wpbf_typography_font_style( $sub_menu_font_setting ),
		),
	) );

}

// H1 font settings.
$page_h1_font_toggle  = wpbf_customize_bool_value( 'page_h1_toggle' );
$page_h1_font_setting = wpbf_customize_array_value( 'page_h1_font_family' );

if ( $page_h1_font_toggle && $page_h1_font_setting ) {

	wpbf_write_css( array(
		// ? Why don't we use h1 only here? Why specify h1-h6?
		'selector' => 'h1, h2, h3, h4, h5, h6',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h1_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h1_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h1_font_setting ),
		),
	) );

}

// H2 font settings.
$page_h2_font_toggle  = wpbf_customize_bool_value( 'page_h2_toggle' );
$page_h2_font_setting = wpbf_customize_array_value( 'page_h2_font_family' );

if ( $page_h2_font_toggle && $page_h2_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h2',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h2_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h2_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h2_font_setting ),
		),
	) );

}

// H3 font settings.
$page_h3_font_setting = wpbf_customize_bool_value( 'page_h3_toggle' );
$page_h3_font_family  = wpbf_customize_array_value( 'page_h3_font_family' );

if ( $page_h3_font_setting && $page_h3_font_family ) {

	wpbf_write_css( array(
		'selector' => 'h3',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h3_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h3_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h3_font_setting ),
		),
	) );

}

// H4 font settings.
$page_h4_font_toggle  = wpbf_customize_bool_value( 'page_h4_toggle' );
$page_h4_font_setting = wpbf_customize_array_value( 'page_h4_font_family' );

if ( $page_h4_font_toggle && $page_h4_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h4',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h4_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h4_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h4_font_setting ),
		),
	) );

}

// H5 font settings.
$page_h5_font_toggle  = wpbf_customize_bool_value( 'page_h5_toggle' );
$page_h5_font_setting = wpbf_customize_array_value( 'page_h5_font_family' );

if ( $page_h5_font_toggle && $page_h5_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h5',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h5_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h5_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h5_font_setting ),
		),
	) );

}

// H6 font settings.
$page_h6_font_toggle  = wpbf_customize_bool_value( 'page_h6_toggle' );
$page_h6_font_setting = wpbf_customize_array_value( 'page_h6_font_family' );

if ( $page_h6_font_toggle && $page_h6_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h6',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h6_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h6_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h6_font_setting ),
		),
	) );

}

// Footer font settings.
$footer_font_toggle  = wpbf_customize_bool_value( 'footer_font_toggle' );
$footer_font_setting = wpbf_customize_array_value( 'footer_font_family' );

if ( $footer_font_toggle && $footer_font_setting ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-page-footer',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $footer_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $footer_font_setting ),
			'font-style'  => wpbf_typography_font_style( $footer_font_setting ),
		),
	) );

}

/* General */

// Page settings.
$page_padding = wpbf_customize_array_value( 'page_padding' );

$page_padding_top_desktop    = wpbf_get_theme_mod_value( $page_padding, 'desktop_top' );
$page_padding_right_desktop  = wpbf_get_theme_mod_value( $page_padding, 'desktop_right' );
$page_padding_bottom_desktop = wpbf_get_theme_mod_value( $page_padding, 'desktop_bottom' );
$page_padding_left_desktop   = wpbf_get_theme_mod_value( $page_padding, 'desktop_left' );

if ( is_numeric( $page_padding_top_desktop ) || is_numeric( $page_padding_right_desktop ) || is_numeric( $page_padding_bottom_desktop ) || is_numeric( $page_padding_left_desktop ) ) {

	wpbf_write_css( array(
		'selector' => '#inner-content',
		'props'    => array(
			'padding-top'    => is_numeric( $page_padding_top_desktop ) ? wpbf_maybe_append_suffix( $page_padding_top_desktop ) : null,
			'padding-right'  => is_numeric( $page_padding_right_desktop ) ? wpbf_maybe_append_suffix( $page_padding_right_desktop ) : null,
			'padding-bottom' => is_numeric( $page_padding_bottom_desktop ) ? wpbf_maybe_append_suffix( $page_padding_bottom_desktop ) : null,
			'padding-left'   => is_numeric( $page_padding_left_desktop ) ? wpbf_maybe_append_suffix( $page_padding_left_desktop ) : null,
		),
	) );

}

$page_padding_top_tablet    = wpbf_get_theme_mod_value( $page_padding, 'tablet_top' );
$page_padding_right_tablet  = wpbf_get_theme_mod_value( $page_padding, 'tablet_right' );
$page_padding_bottom_tablet = wpbf_get_theme_mod_value( $page_padding, 'tablet_bottom' );
$page_padding_left_tablet   = wpbf_get_theme_mod_value( $page_padding, 'tablet_left' );

if ( is_numeric( $page_padding_top_tablet ) || is_numeric( $page_padding_right_tablet ) || is_numeric( $page_padding_bottom_tablet ) || is_numeric( $page_padding_left_tablet ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
		'selector'    => '#inner-content',
		'props'       => array(
			'padding-top'    => is_numeric( $page_padding_top_tablet ) ? wpbf_maybe_append_suffix( $page_padding_top_tablet ) : null,
			'padding-right'  => is_numeric( $page_padding_right_tablet ) ? wpbf_maybe_append_suffix( $page_padding_right_tablet ) : null,
			'padding-bottom' => is_numeric( $page_padding_bottom_tablet ) ? wpbf_maybe_append_suffix( $page_padding_bottom_tablet ) : null,
			'padding-left'   => is_numeric( $page_padding_left_tablet ) ? wpbf_maybe_append_suffix( $page_padding_left_tablet ) : null,
		),
	) );

}

$page_padding_top_mobile    = wpbf_get_theme_mod_value( $page_padding, 'mobile_top' );
$page_padding_right_mobile  = wpbf_get_theme_mod_value( $page_padding, 'mobile_right' );
$page_padding_bottom_mobile = wpbf_get_theme_mod_value( $page_padding, 'mobile_bottom' );
$page_padding_left_mobile   = wpbf_get_theme_mod_value( $page_padding, 'mobile_left' );

if ( is_numeric( $page_padding_top_mobile ) || is_numeric( $page_padding_right_mobile ) || is_numeric( $page_padding_bottom_mobile ) || is_numeric( $page_padding_left_mobile ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
		'selector'    => '#inner-content',
		'props'       => array(
			'padding-top'    => is_numeric( $page_padding_top_mobile ) ? wpbf_maybe_append_suffix( $page_padding_top_mobile ) : null,
			'padding-right'  => is_numeric( $page_padding_right_mobile ) ? wpbf_maybe_append_suffix( $page_padding_right_mobile ) : null,
			'padding-bottom' => is_numeric( $page_padding_bottom_mobile ) ? wpbf_maybe_append_suffix( $page_padding_bottom_mobile ) : null,
			'padding-left'   => is_numeric( $page_padding_left_mobile ) ? wpbf_maybe_append_suffix( $page_padding_left_mobile ) : null,
		),
	) );

}

if ( is_numeric( $page_padding_right_desktop ) || is_numeric( $page_padding_left_desktop ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-container',
		'props'    => array(
			'padding-right' => is_numeric( $page_padding_right_desktop ) ? wpbf_maybe_append_suffix( $page_padding_right_desktop ) : null,
			'padding-left'  => is_numeric( $page_padding_left_desktop ) ? wpbf_maybe_append_suffix( $page_padding_left_desktop ) : null,
		),
	) );

}

if ( is_numeric( $page_padding_right_tablet ) || is_numeric( $page_padding_left_tablet ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
		'selector'    => '.wpbf-container',
		'props'       => array(
			'padding-right' => is_numeric( $page_padding_right_tablet ) ? wpbf_maybe_append_suffix( $page_padding_right_tablet ) : null,
			'padding-left'  => is_numeric( $page_padding_left_tablet ) ? wpbf_maybe_append_suffix( $page_padding_left_tablet ) : null,
		),
	) );

}

if ( is_numeric( $page_padding_right_mobile ) || is_numeric( $page_padding_left_mobile ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
		'selector'    => '.wpbf-container',
		'props'       => array(
			'padding-right' => is_numeric( $page_padding_right_mobile ) ? wpbf_maybe_append_suffix( $page_padding_right_mobile ) : null,
			'padding-left'  => is_numeric( $page_padding_left_mobile ) ? wpbf_maybe_append_suffix( $page_padding_left_mobile ) : null,
		),
	) );

}

$page_width = wpbf_customize_str_value( 'page_max_width' );
$page_width = '1200' === $page_width || '1200px' === $page_width ? '' : $page_width;

if ( $page_width ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-container',
		'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $page_width ) ),
	) );

}

$page_boxed = wpbf_customize_bool_value( 'page_boxed' );

if ( $page_boxed ) {

	$page_boxed_padding = wpbf_customize_str_value( 'page_boxed_padding' );
	$page_boxed_padding = '20' === $page_boxed_padding || '20px' === $page_boxed_padding ? '' : $page_boxed_padding;

	if ( $page_boxed_padding ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-container',
			'props'    => array(
				'padding-left'  => wpbf_maybe_append_suffix( $page_boxed_padding ),
				'padding-right' => wpbf_maybe_append_suffix( $page_boxed_padding ),
			),
		) );

	}

	$page_boxed_max_width  = $page_width ? $page_width : '1200px';
	$page_boxed_margin     = wpbf_customize_str_value( 'page_boxed_margin' );
	$page_boxed_background = wpbf_customize_str_value( 'page_boxed_background', '#ffffff' );

	wpbf_write_css( array(
		'selector' => '.wpbf-page',
		'props'    => array(
			'max-width'        => wpbf_maybe_append_suffix( $page_boxed_max_width ),
			'margin'           => '0 auto',
			'margin-top'       => $page_boxed_margin ? wpbf_maybe_append_suffix( $page_boxed_margin ) : null,
			'margin-bottom'    => $page_boxed_margin ? wpbf_maybe_append_suffix( $page_boxed_margin ) : null,
			'background-color' => $page_boxed_background ? $page_boxed_background : null,
		),
	) );

	$page_boxed_shadow = wpbf_customize_bool_value( 'page_boxed_box_shadow' );

	if ( $page_boxed_shadow ) {

		$page_boxed_shadow_horizontal = wpbf_customize_str_value( 'page_boxed_box_shadow_horizontal' );
		$page_boxed_shadow_horizontal = $page_boxed_shadow_horizontal ? wpbf_maybe_append_suffix( $page_boxed_shadow_horizontal ) : '0px';

		$page_boxed_shadow_vertical = wpbf_customize_str_value( 'page_boxed_box_shadow_vertical' );
		$page_boxed_shadow_vertical = $page_boxed_shadow_vertical ? wpbf_maybe_append_suffix( $page_boxed_shadow_vertical ) : '0px';

		$page_boxed_shadow_blur = wpbf_customize_str_value( 'page_boxed_box_shadow_blur' );
		$page_boxed_shadow_blur = $page_boxed_shadow_blur ? wpbf_maybe_append_suffix( $page_boxed_shadow_blur ) : '25px';

		$page_boxed_shadow_spread = wpbf_customize_str_value( 'page_boxed_box_shadow_spread' );
		$page_boxed_shadow_spread = $page_boxed_shadow_spread ? wpbf_maybe_append_suffix( $page_boxed_shadow_spread ) : '0px';

		$page_boxed_shadow_color = wpbf_customize_str_value( 'page_boxed_box_shadow_color', 'rgba(0, 0, 0, .15)' );

		wpbf_write_css( array(
			'selector' => '#container',
			'props'    => array(
				'box-shadow' => $page_boxed_shadow_horizontal . ' ' . $page_boxed_shadow_vertical . ' ' . $page_boxed_shadow_blur . ' ' . $page_boxed_shadow_spread . ' ' . $page_boxed_shadow_color,
			),
		) );

	}
}

// Scrolltop.
$scrolltop = wpbf_customize_bool_value( 'layout_scrolltop' );

if ( $scrolltop ) {

	$scrolltop_position = wpbf_customize_str_value( 'scrolltop_position', 'right' );

	if ( 'left' === $scrolltop_position ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop',
			'props'    => array(
				'right' => 'auto',
				'left'  => '20px',
			),
		) );

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . $breakpoint_medium . ')',
			'selector'    => '.scrolltop',
			'props'       => array(
				'left'   => '10px',
				'bottom' => '10px',
			),
		) );

	}

	if ( 'right' === $scrolltop_position ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ')',
			'selector'    => '.scrolltop',
			'props'       => array(
				'right'  => '10px',
				'bottom' => '10px',
			),
		) );

	}

	$scrolltop_bg_color = wpbf_customize_str_value( 'scrolltop_bg_color' );
	$scrolltop_bg_color = 'rgba(62,67,73,0.5)' === $scrolltop_bg_color || 'rgba(62, 67, 73, 0.5)' === $scrolltop_bg_color ? '' : $scrolltop_bg_color;

	$scrolltop_border_radius = wpbf_customize_str_value( 'scrolltop_border_radius' );

	if ( $scrolltop_bg_color || $scrolltop_border_radius ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop',
			'props'    => array(
				'background-color' => $scrolltop_bg_color ? $scrolltop_bg_color : null,
				'border-radius'    => $scrolltop_border_radius ? wpbf_maybe_append_suffix( $scrolltop_border_radius ) : null,
			),
		) );

	}

	$scrolltop_icon_color = wpbf_customize_str_value( 'scrolltop_icon_color' );
	$scrolltop_icon_color = '#ffffff' === $scrolltop_icon_color ? '' : $scrolltop_icon_color;

	if ( $scrolltop_icon_color ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop, .scrolltop:hover',
			'props'    => array( 'color' => $scrolltop_icon_color ),
		) );

	}

	$scrolltop_bg_color_alt = wpbf_customize_str_value( 'scrolltop_bg_color_alt' );
	$scrolltop_bg_color_alt = 'rgba(62,67,73,0.7)' === $scrolltop_bg_color_alt || 'rgba(62, 67, 73, 0.7)' === $scrolltop_bg_color_alt ? '' : $scrolltop_bg_color_alt;

	$scrolltop_icon_color_alt = wpbf_customize_str_value( 'scrolltop_icon_color_alt' );

	if ( $scrolltop_bg_color_alt || $scrolltop_icon_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop:hover',
			'props'    => array(
				'background-color' => $scrolltop_bg_color_alt ? $scrolltop_bg_color_alt : null,
				'color'            => $scrolltop_icon_color_alt ? $scrolltop_icon_color_alt : null,
			),
		) );

	}

}

// Background (backwards compatibility).
$page_background_color = wpbf_customize_str_value( 'page_background_color' );
$page_background_image = wpbf_customize_str_value( 'page_background_image' );

if ( $page_background_color || $page_background_image ) {

	$page_background_attachment = wpbf_customize_str_value( 'page_background_attachment' );
	$page_background_position   = wpbf_customize_str_value( 'page_background_position' );
	$page_background_repeat     = wpbf_customize_str_value( 'page_background_repeat' );
	$page_background_size       = wpbf_customize_str_value( 'page_background_size' );

	wpbf_write_css( array(
		'selector' => 'body',
		'props'    => array(
			'background-color'      => $page_background_color ? $page_background_color : null,
			'background-image'      => $page_background_image ? "url($page_background_image)" : null,
			'background-attachment' => $page_background_attachment ? $page_background_attachment : null,
			'background-position'   => $page_background_position ? $page_background_position : null,
			'background-repeat'     => $page_background_repeat ? $page_background_repeat : null,
			'background-size'       => $page_background_size ? $page_background_size : null,
		),
	) );

}

// Accent color.
$page_accent_color = wpbf_customize_str_value( 'page_accent_color' );
$page_accent_color = '#3ba9d2' === $page_accent_color ? '' : $page_accent_color;

if ( $page_accent_color ) {

	wpbf_write_css( array(
		'selector' => 'a',
		'props'    => array( 'color' => $page_accent_color ),
	) );

	wpbf_write_css( array(
		'selector' => '.bypostauthor',
		'props'    => array( 'border-color' => $page_accent_color ),
	) );

	wpbf_write_css( array(
		'selector' => '.wpbf-button-primary',
		'props'    => array( 'background-color' => $page_accent_color ),
	) );

}

$page_accent_color_alt = wpbf_customize_str_value( 'page_accent_color_alt' );
$page_accent_color_alt = '#79c4e0' === $page_accent_color_alt ? '' : $page_accent_color_alt;

if ( $page_accent_color_alt ) {

	wpbf_write_css( array(
		'selector' => 'a:hover',
		'props'    => array( 'color' => $page_accent_color_alt ),
	) );

	wpbf_write_css( array(
		'selector' => '.wpbf-button-primary:hover',
		'props'    => array( 'background-color' => $page_accent_color_alt ),
	) );

	wpbf_write_css( array(
		'selector' => '.wpbf-menu > .current-menu-item > a',
		'props'    => array( 'color' => $page_accent_color_alt . '!important' ),
	) );

}

// Theme buttons.
$button_border_width             = wpbf_customize_str_value( 'button_border_width' );
$button_border_color             = wpbf_customize_str_value( 'button_border_color' );
$button_border_color_alt         = wpbf_customize_str_value( 'button_border_color_alt' );
$button_primary_border_color     = wpbf_customize_str_value( 'button_primary_border_color' );
$button_primary_border_color_alt = wpbf_customize_str_value( 'button_primary_border_color_alt' );
$button_bg_color                 = wpbf_customize_str_value( 'button_bg_color' );
$button_text_color               = wpbf_customize_str_value( 'button_text_color' );
$button_border_radius            = wpbf_customize_str_value( 'button_border_radius' );
$button_bg_color_alt             = wpbf_customize_str_value( 'button_bg_color_alt' );
$button_text_color_alt           = wpbf_customize_str_value( 'button_text_color_alt' );
$button_primary_bg_color         = wpbf_customize_str_value( 'button_primary_bg_color' );
$button_primary_text_color       = wpbf_customize_str_value( 'button_primary_text_color' );
$button_primary_bg_color_alt     = wpbf_customize_str_value( 'button_primary_bg_color_alt' );
$button_primary_text_color_alt   = wpbf_customize_str_value( 'button_primary_text_color_alt' );

if ( $button_border_width ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-button, input[type="submit"]',
		'props'    => array(
			'border-width' => wpbf_maybe_append_suffix( $button_border_width ),
			'border-style' => 'solid',
			'border-color' => $button_border_color ? $button_border_color : null,
		),
	) );

	if ( $button_border_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-button:hover, input[type="submit"]:hover',
			'props'    => array( 'border-color' => $button_border_color_alt ),
		) );

	}

	if ( $button_primary_border_color ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-button-primary',
			'props'    => array( 'border-color' => $button_primary_border_color ),
		) );

	}

	if ( $button_primary_border_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-button-primary:hover',
			'props'    => array( 'border-color' => $button_primary_border_color_alt ),
		) );

	}
}

if ( $button_bg_color || $button_text_color || $button_border_radius ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-button, input[type="submit"]',
		'props'    => array(
			'border-radius'    => $button_border_radius ? wpbf_maybe_append_suffix( $button_border_radius ) : null,
			'background-color' => $button_bg_color ? $button_bg_color : null,
			'color'            => $button_text_color ? $button_text_color : null,
		),
	) );

}

if ( $button_bg_color_alt || $button_text_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-button:hover, input[type="submit"]:hover',
		'props'    => array(
			'background-color' => $button_bg_color_alt ? $button_bg_color_alt : null,
			'color'            => $button_text_color_alt ? $button_text_color_alt : null,
		),
	) );

}

if ( $button_primary_bg_color || $button_primary_text_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-button-primary',
		'props'    => array(
			'background-color' => $button_primary_bg_color ? $button_primary_bg_color : null,
			'color'            => $button_primary_text_color ? $button_primary_text_color : null,
		),
	) );

}

if ( $button_primary_bg_color_alt || $button_primary_bg_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-button-primary:hover',
		'props'    => array(
			'background-color' => $button_primary_bg_color_alt ? $button_primary_bg_color_alt : null,
			'color'            => $button_primary_text_color_alt ? $button_primary_text_color_alt : null,
		),
	) );

}

// Gutenberg.
if ( $button_primary_text_color ) {

	wpbf_write_css( array(
		'selector' => '.wp-block-button__link:not(.has-text-color)',
		'props'    => array( 'color' => $button_primary_text_color ),
	) );

	// Gutenberg sets the hover color to white so we need to override this if a custom color is set.
	wpbf_write_css( array(
		'selector' => '.wp-block-button__link:not(.has-text-color):hover',
		'props'    => array( 'color' => $button_primary_text_color ),
	) );

}

if ( $button_primary_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wp-block-button__link:not(.has-background)',
		'props'    => array( 'background-color' => $button_primary_bg_color ),
	) );

	wpbf_write_css( array(
		'selector' => '.is-style-outline .wp-block-button__link:not(.has-text-color)',
		'props'    => array(
			'border-color' => $button_primary_bg_color,
			'color'        => $button_primary_bg_color,
		),
	) );

}

if ( $button_primary_bg_color_alt || $button_primary_text_color_alt ) {
	wpbf_write_css( array(
		'selector' => '.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover',
		'props'    => array(
			'background-color' => $button_primary_bg_color_alt ? $button_primary_bg_color_alt : null,
			'color'            => $button_primary_text_color_alt ? $button_primary_text_color_alt : null,
		),
	) );

	if ( $button_primary_bg_color_alt ) {
		wpbf_write_css( array(
			'selector' => '.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover',
			'props'    => array(
				'border-color' => $button_primary_bg_color_alt,
				'color'        => $button_primary_bg_color_alt,
			),
		) );
	}
}

if ( $page_width ) {
	wpbf_write_css( array(
		'selector' => '.wp-block-cover .wp-block-cover__inner-container, .wp-block-group .wp-block-group__inner-container',
		'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $page_width ) ),
	) );
}

// Sidebar.
$sidebar_widget_padding = wpbf_customize_array_value( 'sidebar_widget_padding' );

$sidebar_widget_padding_top_desktop    = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_top', 20 );
$sidebar_widget_padding_right_desktop  = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_right', 20 );
$sidebar_widget_padding_bottom_desktop = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_bottom', 20 );
$sidebar_widget_padding_left_desktop   = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_left', 20 );

$sidebar_bg_color = wpbf_customize_str_value( 'sidebar_bg_color' );
$sidebar_bg_color = '#f5f5f7' === $sidebar_bg_color ? '' : $sidebar_bg_color;

if ( $sidebar_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'    => array( 'background-color' => $sidebar_bg_color ),
	) );

}

if ( is_numeric( $sidebar_widget_padding_top_desktop ) || is_numeric( $sidebar_widget_padding_right_desktop ) || is_numeric( $sidebar_widget_padding_bottom_desktop ) || is_numeric( $sidebar_widget_padding_left_desktop ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'    => array(
			'padding-top'    => is_numeric( $sidebar_widget_padding_top_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_top_desktop ) : null,
			'padding-right'  => is_numeric( $sidebar_widget_padding_right_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_right_desktop ) : null,
			'padding-bottom' => is_numeric( $sidebar_widget_padding_bottom_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_bottom_desktop ) : null,
			'padding-left'   => is_numeric( $sidebar_widget_padding_left_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_left_desktop ) : null,
		),
	) );

}

$sidebar_widget_padding_top_tablet    = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_top', 20 );
$sidebar_widget_padding_right_tablet  = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_right', 20 );
$sidebar_widget_padding_bottom_tablet = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_bottom', 20 );
$sidebar_widget_padding_left_tablet   = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_left', 20 );

if ( is_numeric( $sidebar_widget_padding_top_tablet ) || is_numeric( $sidebar_widget_padding_right_tablet ) || is_numeric( $sidebar_widget_padding_bottom_tablet ) || is_numeric( $sidebar_widget_padding_left_tablet ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
		'selector'    => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'       => array(
			'padding-top'    => is_numeric( $sidebar_widget_padding_top_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_top_tablet ) : null,
			'padding-right'  => is_numeric( $sidebar_widget_padding_right_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_right_tablet ) : null,
			'padding-bottom' => is_numeric( $sidebar_widget_padding_bottom_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_bottom_tablet ) : null,
			'padding-left'   => is_numeric( $sidebar_widget_padding_left_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_left_tablet ) : null,
		),
	) );

}

$sidebar_widget_padding_top_mobile    = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_top', 20 );
$sidebar_widget_padding_right_mobile  = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_right', 20 );
$sidebar_widget_padding_bottom_mobile = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_bottom', 20 );
$sidebar_widget_padding_left_mobile   = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_left', 20 );

if ( is_numeric( $sidebar_widget_padding_top_mobile ) || is_numeric( $sidebar_widget_padding_right_mobile ) || is_numeric( $sidebar_widget_padding_bottom_mobile ) || is_numeric( $sidebar_widget_padding_left_mobile ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
		'selector'    => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'       => array(
			'padding-top'    => is_numeric( $sidebar_widget_padding_top_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_top_mobile ) : null,
			'padding-right'  => is_numeric( $sidebar_widget_padding_right_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_right_mobile ) : null,
			'padding-bottom' => is_numeric( $sidebar_widget_padding_bottom_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_bottom_mobile ) : null,
			'padding-left'   => is_numeric( $sidebar_widget_padding_left_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_left_mobile ) : null,
		),
	) );

}

$sidebar_width = wpbf_customize_str_value( 'sidebar_width' );
$sidebar_width = '33.3' === $sidebar_width || '33.3px' === $sidebar_width ? '' : $sidebar_width;

if ( $sidebar_width ) {

	wpbf_write_css( array(
		'media_query' => '@media (min-width: ' . ( $breakpoint_medium_int + 1 ) . 'px)',
		'blocks'      => array(
			array(
				'selector' => 'body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( $sidebar_width, '%' ) ),
			),
			array(
				'selector' => 'body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3',
				'props'    => array( 'width' => ( 100 - $sidebar_width ) . '%' ),
			),
		),
	) );

}

// Breadcrumbs.
$breadcrumbs_alignment = wpbf_customize_str_value( 'breadcrumbs_alignment', 'left' );

if ( 'left' !== $breadcrumbs_alignment ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs-container',
		'props'    => array( 'text-align' => $breadcrumbs_alignment ),
	) );

}

$breadcrumbs_background_color = wpbf_customize_str_value( 'breadcrumbs_background_color' );
$breadcrumbs_background_color = '#dedee5' === $breadcrumbs_background_color ? '' : $breadcrumbs_background_color;

if ( $breadcrumbs_background_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs-container',
		'props'    => array( 'background-color' => $breadcrumbs_background_color ),
	) );

}

$breadcrumbs_font_color = wpbf_customize_str_value( 'breadcrumbs_font_color' );

if ( $breadcrumbs_font_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs',
		'props'    => array( 'color' => $breadcrumbs_font_color ),
	) );

}

$breadcrumbs_accent_color = wpbf_customize_str_value( 'breadcrumbs_accent_color' );

if ( $breadcrumbs_accent_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs a',
		'props'    => array( 'color' => $breadcrumbs_accent_color ),
	) );

}

$breadcrumbs_accent_color_alt = wpbf_customize_str_value( 'breadcrumbs_accent_color_alt' );

if ( $breadcrumbs_accent_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs a:hover',
		'props'    => array( 'color' => $breadcrumbs_accent_color_alt ),
	) );

}

// Pagination.
$blog_pagination_border_radius    = wpbf_customize_str_value( 'blog_pagination_border_radius' );
$blog_pagination_font_size        = wpbf_customize_str_value( 'blog_pagination_font_size' );
$blog_pagination_background_color = wpbf_customize_str_value( 'blog_pagination_background_color' );
$blog_pagination_font_color       = wpbf_customize_str_value( 'blog_pagination_font_color' );

// ? Why does this exist? It's not being used anywhere in this file.
$blog_pagination_background_color_next_prev = wpbf_customize_str_value( 'blog_pagination_background_color_next_prev' );

if ( $blog_pagination_border_radius || $blog_pagination_font_size || $blog_pagination_background_color || $blog_pagination_font_color ) {

	wpbf_write_css( array(
		'selector' => '.pagination .page-numbers',
		'props'    => array(
			'border-radius'    => $blog_pagination_border_radius ? wpbf_maybe_append_suffix( $blog_pagination_border_radius ) : null,
			'font-size'        => $blog_pagination_font_size ? wpbf_maybe_append_suffix( $blog_pagination_font_size ) : null,
			'background-color' => $blog_pagination_background_color ? $blog_pagination_background_color : null,
			'color'            => $blog_pagination_font_color ? $blog_pagination_font_color : null,
		),
	) );

}

$blog_pagination_background_color_alt = wpbf_customize_str_value( 'blog_pagination_background_color_alt' );
$blog_pagination_font_color_alt       = wpbf_customize_str_value( 'blog_pagination_font_color_alt' );

if ( $blog_pagination_background_color_alt || $blog_pagination_font_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.pagination .page-numbers:hover',
		'props'    => array(
			'background-color' => $blog_pagination_background_color_alt ? $blog_pagination_background_color_alt : null,
			'color'            => $blog_pagination_font_color_alt ? $blog_pagination_font_color_alt : null,
		),
	) );

}

$blog_pagination_background_color_active = wpbf_customize_str_value( 'blog_pagination_background_color_active' );
$blog_pagination_font_color_active       = wpbf_customize_str_value( 'blog_pagination_font_color_active' );

if ( $blog_pagination_background_color_active || $blog_pagination_font_color_active ) {

	wpbf_write_css( array(
		'selector' => '.pagination .page-numbers.current',
		'props'    => array(
			'background-color' => $blog_pagination_background_color_active ? $blog_pagination_background_color_active . '!important' : null,
			'color'            => $blog_pagination_font_color_active ? $blog_pagination_font_color_active : null,
		),
	) );

}

/* Blog Layouts */

$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	// Custom width.
	$custom_width = wpbf_customize_str_value( $archive . '_custom_width' );

	if ( ! $custom_width ) {
		continue;
	}

	if ( 'archive' === $archive ) {
		// All archives.

		wpbf_write_css( array(
			'selector' => '.blog #inner-content, .search #inner-content, .' . $archive . ' #inner-content',
			'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
		) );

	} elseif ( strpos( $archive, '-' ) ) {
		// Custom post type archives & taxonomies.

		$cpt = substr( $archive, 0, strpos( $archive, '-' ) );

		wpbf_write_css( array(
			'selector' => '.tax-' . $cpt . '_category #inner-content, .tax-' . $cpt . '_tag #inner-content, .post-type-archive-' . $cpt . ' #inner-content',
			'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
		) );

	} else {
		// Other archives.

		wpbf_write_css( array(
			'selector' => '.' . $archive . ' #inner-content',
			'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
		) );

	}

	$layout    = wpbf_customize_str_value( $archive . '_layout' );
	$style     = wpbf_customize_str_value( $archive . '_post_style', 'plain' );
	$stretched = wpbf_customize_bool_value( $archive . '_boxed_image_streched' );

	$content_alignment = wpbf_customize_str_value( $archive . '_post_content_alignment', 'left' );

	// General layout settings.
	if ( $content_alignment ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post',
			'props'    => array( 'text-align' => $content_alignment ),
		) );

	}

	$accent_color = wpbf_customize_str_value( $archive . '_post_accent_color' );

	if ( $accent_color ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post a:not(.wpbf-read-more)',
			'props'    => array( 'color' => $accent_color ),
		) );

	}

	$accent_color_alt = wpbf_customize_str_value( $archive . '_post_accent_color_alt' );

	if ( $accent_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post a:not(.wpbf-read-more):hover',
			'props'    => array( 'color' => $accent_color_alt ),
		) );

	}

	$title_size = wpbf_customize_str_value( $archive . '_post_title_size' );

	if ( $title_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post .entry-title',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $title_size ) ),
		) );

	}

	$font_size = get_theme_mod( $archive . '_post_font_size' );

	if ( $font_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post .entry-summary',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
		) );

	}

	$space_between = wpbf_customize_str_value( $archive . '_post_space_between' );
	$space_between = '20' === $space_between || '20px' === $space_between ? '' : $space_between;

	if ( 'plain' === $style && $space_between ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-plain',
			'props'    => array(
				'margin-bottom'  => wpbf_maybe_append_suffix( $space_between ),
				'padding-bottom' => wpbf_maybe_append_suffix( $space_between ),
			),
		) );

	}

	// Boxed.
	if ( 'boxed' === $style ) {

		$background_color = wpbf_customize_str_value( $archive . '_post_background_color' );
		$background_color = '#f5f5f7' === $background_color ? '' : $background_color;

		if ( $background_color ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array( 'background-color' => $background_color ),
			) );

		}

		if ( $space_between ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array( 'margin-bottom' => wpbf_maybe_append_suffix( $space_between ) ),
			) );
		}

		$boxed_padding = wpbf_customize_array_value( $archive . '_boxed_padding' );

		$boxed_padding_top_desktop    = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_top' );
		$boxed_padding_right_desktop  = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_right' );
		$boxed_padding_bottom_desktop = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_bottom' );
		$boxed_padding_left_desktop   = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_left' );

		if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_desktop ? wpbf_maybe_append_suffix( $boxed_padding_top_desktop ) : null,
					'padding-right'  => $boxed_padding_right_desktop ? wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					'padding-bottom' => $boxed_padding_bottom_desktop ? wpbf_maybe_append_suffix( $boxed_padding_bottom_desktop ) : null,
					'padding-left'   => $boxed_padding_left_desktop ? wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
				),
			) );

			if ( $stretched && 'beside' !== $layout ) {

				wpbf_write_css( array(
					'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
						'margin-right' => $boxed_padding_right_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					),
				) );

				if ( $boxed_padding_top_desktop ) {

					wpbf_write_css( array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
						),
					) );

				}

			}
		}

		$boxed_padding_top_tablet    = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_top' );
		$boxed_padding_right_tablet  = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_right' );
		$boxed_padding_bottom_tablet = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_bottom' );
		$boxed_padding_left_tablet   = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_left' );

		if ( $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_tablet ? wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
					'padding-right'  => $boxed_padding_right_tablet ? wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					'padding-bottom' => $boxed_padding_bottom_tablet ? wpbf_maybe_append_suffix( $boxed_padding_bottom_tablet ) : null,
					'padding-left'   => $boxed_padding_left_tablet ? wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched && 'beside' !== $layout ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
						'margin-right' => $boxed_padding_right_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					),
				);

				if ( $boxed_padding_top_tablet ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_tablet ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_tablet ),
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}

		$boxed_padding_top_mobile    = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_top' );
		$boxed_padding_right_mobile  = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_right' );
		$boxed_padding_bottom_mobile = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_bottom' );
		$boxed_padding_left_mobile   = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_left' );

		if ( $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_mobile ? wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
					'padding-right'  => $boxed_padding_right_mobile ? wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					'padding-bottom' => $boxed_padding_bottom_mobile ? wpbf_maybe_append_suffix( $boxed_padding_bottom_mobile ) : null,
					'padding-left'   => $boxed_padding_left_mobile ? wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched && 'beside' !== $layout ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
						'margin-right' => $boxed_padding_right_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					),
				);

				if ( $boxed_padding_top_mobile ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $archive . '-content  .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_mobile ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_mobile ),
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}
	}

	// Beside.
	if ( 'beside' === $layout ) {

		$image_width = wpbf_customize_str_value( $archive . '_post_image_width' );
		$image_width = '40' === $image_width || '40px' === $image_width ? '' : $image_width;

		if ( $image_width ) {

			wpbf_write_css( array(
				'media_query' => '@media (min-width: ' . esc_attr( $breakpoint_desktop_int + 1 ) . 'px)',
				'blocks'      => array(
					array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-large-2-5',
						'props'    => array( 'width' => wpbf_maybe_append_suffix( $image_width, '%' ) ),
					),
					array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-large-3-5',
						'props'    => array( 'width' => wpbf_maybe_append_suffix( ( 100 - $image_width ), '%' ) ),
					),
				),
			) );

		}

		$image_alignment = wpbf_customize_str_value( $archive . '_post_image_alignment', 'left' );

		if ( $image_alignment ) {

			$image_alignment_direction = 'left' === $image_alignment ? 'row' : ( 'right' === $image_alignment ? 'row-reverse' : null );

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-grid',
				'props'    => array(
					'flex-direction' => $image_alignment_direction,
				),
			) );

		}
	}
}

/* Single */

$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

foreach ( $singles as $single ) {

	$custom_width = get_theme_mod( $single . '_custom_width' );

	// All post types.
	if ( 'single' === $single && $custom_width ) {

		wpbf_write_css( array(
			'blocks' => array(
				array(
					'selector' => '.single #inner-content',
					'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
				),
				// Change the max-width of the cover block contents.
				array(
					'selector' => '.single .wp-block-cover .wp-block-cover__inner-container, .single .wp-block-group .wp-block-group__inner-container',
					'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
				),
			),
		) );

		// Individual post types.
	} elseif ( 'single' !== $single && $custom_width ) {

		wpbf_write_css( array(
			'blocks' => array(
				array(
					'selector' => '.single-' . $single . ' #inner-content',
					'props'    => array(
						'max-width' => wpbf_maybe_append_suffix( $custom_width ),
					),
				),
				// Change the max-width of the cover block contents.
				array(
					'selector' => '.single-' . $single . ' .wp-block-cover .wp-block-cover__inner-container, .single-' . $single . ' .wp-block-group .wp-block-group__inner-container',
					'props'    => array(
						'max-width' => wpbf_maybe_append_suffix( $custom_width ),
					),
				),
			),
		) );

	}

	// General Layout Settings.
	/*
	$content_alignment = get_theme_mod( $single . '_post_content_alignment', 'left' );

	if ( $content_alignment ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $single . '-content .wpbf-post',
			'props'    => array( 'text-align' => $content_alignment ),
		) );

	}
	*/

	$title_size = wpbf_customize_str_value( $single . '_post_title_size' );

	if ( $title_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $single . '-content .wpbf-post .entry-title',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $title_size ) ),
		) );

	}

	$font_size = wpbf_customize_str_value( $single . '_post_font_size' );

	if ( $font_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $single . '-content .wpbf-post .entry-content',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
		) );

	}

	$style = wpbf_customize_str_value( $single . '_post_style' );

	// Boxed.
	if ( 'boxed' === $style ) {

		$background_color = wpbf_customize_str_value( $single . '_post_background_color' );
		$background_color = '#f5f5f7' === $background_color ? '' : $background_color;

		if ( $background_color ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'background-color' => $background_color,
				),
			) );

		}

		$stretched     = wpbf_customize_bool_value( $single . '_boxed_image_stretched' );
		$boxed_padding = wpbf_customize_array_value( $single . '_boxed_padding' );

		$boxed_padding_top_desktop    = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_top' );
		$boxed_padding_right_desktop  = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_right' );
		$boxed_padding_bottom_desktop = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_bottom' );
		$boxed_padding_left_desktop   = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_left' );

		if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_desktop ? wpbf_maybe_append_suffix( $boxed_padding_top_desktop ) : null,
					'padding-right'  => $boxed_padding_right_desktop ? wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					'padding-bottom' => $boxed_padding_bottom_desktop ? wpbf_maybe_append_suffix( $boxed_padding_bottom_desktop ) : null,
					'padding-left'   => $boxed_padding_left_desktop ? wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
				),
			) );

			if ( $stretched ) {

				wpbf_write_css( array(
					'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
						'margin-right' => $boxed_padding_right_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					),
				) );

				if ( $boxed_padding_top_desktop ) {

					wpbf_write_css( array(
						'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
						),
					) );

				}

			}
		}

		$boxed_padding_top_tablet    = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_top' );
		$boxed_padding_right_tablet  = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_right' );
		$boxed_padding_bottom_tablet = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_bottom' );
		$boxed_padding_left_tablet   = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_left' );

		if ( $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_tablet ? wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
					'padding-right'  => $boxed_padding_right_tablet ? wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					'padding-bottom' => $boxed_padding_bottom_tablet ? wpbf_maybe_append_suffix( $boxed_padding_bottom_tablet ) : null,
					'padding-left'   => $boxed_padding_left_tablet ? wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
						'margin-right' => $boxed_padding_right_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					),
				);

				if ( $boxed_padding_top_tablet ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => $boxed_padding_top_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
							'margin-bottom' => $boxed_padding_top_tablet ? wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}

		$boxed_padding_top_mobile    = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_top' );
		$boxed_padding_right_mobile  = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_right' );
		$boxed_padding_bottom_mobile = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_bottom' );
		$boxed_padding_left_mobile   = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_left' );

		if ( $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_mobile ? wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
					'padding-right'  => $boxed_padding_right_mobile ? wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					'padding-bottom' => $boxed_padding_bottom_mobile ? wpbf_maybe_append_suffix( $boxed_padding_bottom_mobile ) : null,
					'padding-left'   => $boxed_padding_left_mobile ? wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
						'margin-right' => $boxed_padding_right_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					),
				);

				if ( $boxed_padding_top_mobile ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => $boxed_padding_top_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
							'margin-bottom' => $boxed_padding_top_mobile ? wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}
	}
}

/* Header */

// Logo container.
$menu_logo_container_width = wpbf_customize_str_value( 'menu_logo_container_width' );
$menu_logo_container_width = '25' === $menu_logo_container_width || '25px' === $menu_logo_container_width ? '' : $menu_logo_container_width;

if ( $menu_logo_container_width ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-navigation .wpbf-1-4',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( $menu_logo_container_width, '%' ) ),
			),
			array(
				'selector' => '.wpbf-navigation .wpbf-3-4',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( ( 100 - $menu_logo_container_width ), '%' ) ),
			),
		),
	) );

}

$mobile_menu_logo_container_width = ( $val = get_theme_mod( 'mobile_menu_logo_container_width' ) ) === '66' ? false : $val;

if ( $mobile_menu_logo_container_width ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-navigation .wpbf-2-3',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( $mobile_menu_logo_container_width, '%' ) ),
			),
			array(
				'selector' => '.wpbf-navigation .wpbf-1-3',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( ( 100 - $mobile_menu_logo_container_width ), '%' ) ),
			),
		),
	) );

}

// Logo.
$custom_logo_id = wpbf_customize_absint_value( 'custom_logo' );
$menu_logo_size = wpbf_customize_array_value( 'menu_logo_size' );

if ( ! $custom_logo_id ) {

	$menu_logo_font_toggle  = wpbf_customize_bool_value( 'menu_logo_font_toggle' );
	$menu_logo_font_setting = wpbf_customize_array_value( 'menu_logo_font_family' );

	if ( $menu_logo_font_toggle && $menu_logo_font_setting ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'    => array(
				'font-family' => wpbf_typography_font_family( $menu_logo_font_setting ),
				'font-weight' => wpbf_typography_font_weight( $menu_logo_font_setting ),
				'font-style'  => wpbf_typography_font_style( $menu_logo_font_setting ),
				'color'       => ! empty( $menu_logo_font_setting['color'] ) ? $menu_logo_font_setting['color'] : null,
			),
		) );

	}

	$menu_logo_color = wpbf_customize_str_value( 'menu_logo_color' );

	if ( $menu_logo_color ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'    => array( 'color' => $menu_logo_color ),
		) );

	}

	$menu_logo_color_alt = wpbf_customize_str_value( 'menu_logo_color_alt' );

	if ( $menu_logo_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a:hover, .wpbf-mobile-logo a:hover',
			'props'    => array( 'color' => $menu_logo_color_alt ),
		) );

	}

	$menu_logo_font_size = wpbf_customize_array_value( 'menu_logo_font_size', true );

	$menu_logo_font_size_desktop = wpbf_get_theme_mod_value( $menu_logo_font_size, 'desktop', '22px' );

	if ( $menu_logo_font_size_desktop ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'    => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_font_size_desktop ),
			),
		) );

	}

	$menu_logo_font_size_tablet = wpbf_get_theme_mod_value( $menu_logo_font_size, 'tablet' );

	if ( $menu_logo_font_size_tablet ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ')',
			'selector'    => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'       => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_font_size_tablet ),
			),
		) );

	}

	$menu_logo_font_size_mobile = wpbf_get_theme_mod_value( $menu_logo_font_size, 'mobile' );

	if ( $menu_logo_font_size_mobile ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
			'selector'    => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'       => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_font_size_mobile ),
			),
		) );

	}
}

if ( $custom_logo_id ) {

	$menu_logo_size_desktop = wpbf_get_theme_mod_value( $menu_logo_size, 'desktop' );

	if ( $menu_logo_size_desktop ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo img, .wpbf-mobile-logo img',
			'props'    => array(
				'width' => wpbf_maybe_append_suffix( $menu_logo_size_desktop ),
			),
		) );

	}

	$menu_logo_size_tablet = wpbf_get_theme_mod_value( $menu_logo_size, 'tablet' );

	if ( $menu_logo_size_tablet ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
			'selector'    => '.wpbf-mobile-logo img',
			'props'       => array(
				'width' => wpbf_maybe_append_suffix( $menu_logo_size_tablet ),
			),
		) );

	}

	$menu_logo_size_mobile = wpbf_get_theme_mod_value( $menu_logo_size, 'mobile' );

	if ( $menu_logo_size_mobile ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
			'selector'    => '.wpbf-mobile-logo img',
			'props'       => array(
				'width' => wpbf_maybe_append_suffix( $menu_logo_size_mobile ),
			),
		) );

	}
}

// Tagline.
$menu_logo_description                   = get_theme_mod( 'menu_logo_description' );
$menu_logo_description_toggle            = get_theme_mod( 'menu_logo_description_toggle' );
$menu_logo_description_font_size         = json_decode( get_theme_mod( 'menu_logo_description_font_size' ), true );
$menu_logo_description_font_size_desktop = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'desktop' );
$menu_logo_description_font_size_tablet  = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'tablet' );
$menu_logo_description_font_size_mobile  = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'mobile' );
$menu_logo_description_color             = get_theme_mod( 'menu_logo_description_color' );
$menu_logo_description_font_family_value = get_theme_mod( 'menu_logo_description_font_family' );

if ( ! $custom_logo_id && $menu_logo_description ) {

	if ( $menu_logo_description_toggle && $menu_logo_description_font_family_value ) {

		echo '.wpbf-tagline {';

		if ( ! empty( $menu_logo_description_font_family_value['font-family'] ) ) {

			echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $menu_logo_description_font_family_value['font-family'] ) );

		}

		if ( ! empty( $menu_logo_description_font_family_value['variant'] ) ) {

			$menu_logo_description_font_family_font_weight = str_replace( 'italic', '', $menu_logo_description_font_family_value['variant'] );
			$menu_logo_description_font_family_font_weight = ( in_array( $menu_logo_description_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $menu_logo_description_font_family_font_weight;

			$menu_logo__description_font_family_is_italic = ( false !== strpos( $menu_logo_description_font_family_value['variant'], 'italic' ) );
			$menu_logo_description_font_family_font_style = $menu_logo__description_font_family_is_italic ? 'italic' : 'normal';

			echo sprintf( 'font-weight: %s;', esc_attr( $menu_logo_description_font_family_font_weight ) );
			echo sprintf( 'font-style: %s;', esc_attr( $menu_logo_description_font_family_font_style ) );

		}

		echo '}';

	}

	if ( $menu_logo_description_color ) {

		echo '.wpbf-tagline {';
		echo sprintf( 'color: %s;', esc_attr( $menu_logo_description_color ) );
		echo '}';

	}

	if ( $menu_logo_description_font_size_desktop ) {

		$suffix = is_numeric( $menu_logo_description_font_size_desktop ) ? 'px' : '';

		echo '.wpbf-tagline {';
		echo sprintf( 'font-size: %s;', esc_attr( $menu_logo_description_font_size_desktop . $suffix ) );
		echo '}';

	}

	if ( $menu_logo_description_font_size_tablet ) {

		$suffix = is_numeric( $menu_logo_description_font_size_tablet ) ? 'px' : '';

		echo '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ') {';
		echo '.wpbf-tagline {';
		echo sprintf( 'font-size: %s;', esc_attr( $menu_logo_description_font_size_tablet . $suffix ) );
		echo '}';
		echo '}';

	}

	if ( $menu_logo_description_font_size_mobile ) {

		$suffix = is_numeric( $menu_logo_description_font_size_mobile ) ? 'px' : '';

		echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';
		echo '.wpbf-tagline {';
		echo sprintf( 'font-size: %s;', esc_attr( $menu_logo_description_font_size_mobile . $suffix ) );
		echo '}';
		echo '}';

	}
}

// Navigation.
$menu_position  = get_theme_mod( 'menu_position' );
$menu_width     = ( $val = get_theme_mod( 'menu_width' ) ) === '1200px' ? false : $val;
$menu_padding   = ( $val = get_theme_mod( 'menu_padding' ) ) === '20' ? false : $val;
$menu_bg_color  = ( $val = get_theme_mod( 'menu_bg_color' ) ) === '#f5f5f7' ? false : $val;
$menu_font_size = get_theme_mod( 'menu_font_size' );

if ( $menu_width ) {

	echo '.wpbf-nav-wrapper {';
	echo sprintf( 'max-width: %s;', esc_attr( $menu_width ) );
	echo '}';

}

$menu_height = wpbf_customize_str_value( 'menu_height' );
$menu_height = '20' === $menu_height || '20px' === $menu_height ? '' : $menu_height;

if ( $menu_height ) {

	wpbf_write_css( array(
		'selector' => $header_builder_enabled ? '.wpbf-header-row-row_2 .wpbf-row-content' : '.wpbf-nav-wrapper',
		'props'    => array(
			'padding-top'    => wpbf_maybe_append_suffix( $menu_height ),
			'padding-bottom' => wpbf_maybe_append_suffix( $menu_height ),
		),
	) );

	if ( ! $header_builder_enabled && 'menu-stacked' === $menu_position ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-menu-stacked nav',
			'props'    => array(
				'margin-top' => wpbf_maybe_append_suffix( $menu_height ),
			),
		) );

	}

}


if ( $menu_padding ) {

	echo '.wpbf-navigation .wpbf-menu > .menu-item > a {';
	echo sprintf( 'padding-left: %s;', esc_attr( $menu_padding ) . 'px' );
	echo sprintf( 'padding-right: %s;', esc_attr( $menu_padding ) . 'px' );
	echo '}';

	if ( 'menu-centered' === $menu_position ) {

		echo '.wpbf-menu-centered .logo-container {';
		echo sprintf( 'padding: 0 %s;', esc_attr( $menu_padding ) . 'px' );
		echo '}';

	}
}

if ( $menu_bg_color ) {

	echo '.wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active) {';
	echo sprintf( 'background-color: %s;', esc_attr( $menu_bg_color ) );
	echo '}';

}

$menu_font_colors = get_theme_mod( 'menu_font_colors', array() );
$menu_font_colors = ! is_array( $menu_font_colors ) ? array() : $menu_font_colors;

if ( ! empty( $menu_font_colors ) ) {

	$menu_font_color_default = ! empty( $menu_font_colors['default'] ) && is_string( $menu_font_colors['default'] ) ? $menu_font_colors['default'] : null;
	$menu_font_color_hover   = ! empty( $menu_font_colors['hover'] ) && is_string( $menu_font_colors['hover'] ) ? $menu_font_colors['hover'] : null;

	if ( $menu_font_color_default ) {

		echo '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close {';
		echo sprintf( 'color: %s;', esc_attr( $menu_font_color_default ) );
		echo '}';

	}

	if ( $menu_font_color_hover ) {

		echo '.wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover {';
		echo sprintf( 'color: %s;', esc_attr( $menu_font_color_hover ) );
		echo '}';

		echo '.wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a {';
		echo sprintf( 'color: %s;', esc_attr( $menu_font_color_hover ) . '!important' );
		echo '}';

	}

}

if ( $menu_font_size ) {

	$suffix = is_numeric( $menu_font_size ) ? 'px' : '';
	echo '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a {';
	echo sprintf( 'font-size: %s;', esc_attr( $menu_font_size ) . $suffix );
	echo '}';

}

// Sub menu.
$sub_menu_text_alignment   = get_theme_mod( 'sub_menu_text_alignment' );
$sub_menu_bg_color         = ( $val = get_theme_mod( 'sub_menu_bg_color' ) ) === '#ffffff' ? false : $val;
$sub_menu_bg_color_alt     = get_theme_mod( 'sub_menu_bg_color_alt' );
$sub_menu_width            = ( $val = get_theme_mod( 'sub_menu_width' ) ) === '220' ? false : $val;
$sub_menu_padding          = json_decode( get_theme_mod( 'sub_menu_padding' ), true );
$sub_menu_padding_top      = wpbf_get_theme_mod_value( $sub_menu_padding, 'top', 10 );
$sub_menu_padding_right    = wpbf_get_theme_mod_value( $sub_menu_padding, 'right', 20 );
$sub_menu_padding_bottom   = wpbf_get_theme_mod_value( $sub_menu_padding, 'bottom', 10 );
$sub_menu_padding_left     = wpbf_get_theme_mod_value( $sub_menu_padding, 'left', 20 );
$sub_menu_accent_color     = get_theme_mod( 'sub_menu_accent_color' );
$sub_menu_font_size        = get_theme_mod( 'sub_menu_font_size' );
$sub_menu_accent_color_alt = get_theme_mod( 'sub_menu_accent_color_alt' );
$sub_menu_separator        = get_theme_mod( 'sub_menu_separator' );
$sub_menu_separator_color  = ( $val = get_theme_mod( 'sub_menu_separator_color' ) ) === '#f5f5f7' ? false : $val;

if ( $sub_menu_text_alignment ) {

	echo '.wpbf-sub-menu .sub-menu {';
	echo sprintf( 'text-align: %s;', esc_attr( $sub_menu_text_alignment ) );
	echo '}';

}

if ( $sub_menu_bg_color ) {

	echo '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li, .wpbf-sub-menu > .wpbf-mega-menu > .sub-menu {';
	echo sprintf( 'background-color: %s;', esc_attr( $sub_menu_bg_color ) );
	echo '}';

}

if ( $sub_menu_bg_color_alt ) {

	echo '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover {';
	echo sprintf( 'background-color: %s;', esc_attr( $sub_menu_bg_color_alt ) );
	echo '}';

}

if ( $sub_menu_separator ) {

	echo '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li {';
	echo 'border-bottom: 1px solid #f5f5f7;';

	if ( $sub_menu_separator_color ) {
		echo sprintf( 'border-bottom-color: %s;', esc_attr( $sub_menu_separator_color ) );
	}

	echo '}';

	echo '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li:last-child {';
	echo 'border-bottom: none';
	echo '}';

}

if ( $sub_menu_width ) {

	echo '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu {';
	echo sprintf( 'width: %s;', esc_attr( $sub_menu_width ) . 'px' );
	echo '}';

}

if ( $sub_menu_padding_top || $sub_menu_padding_right || $sub_menu_padding_bottom || $sub_menu_padding_left ) {

	echo '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {';

	if ( $sub_menu_padding_top ) {
		echo sprintf( 'padding-top: %s;', esc_attr( $sub_menu_padding_top ) . 'px' );
	}

	if ( $sub_menu_padding_right ) {
		echo sprintf( 'padding-right: %s;', esc_attr( $sub_menu_padding_right ) . 'px' );
	}

	if ( $sub_menu_padding_bottom ) {
		echo sprintf( 'padding-bottom: %s;', esc_attr( $sub_menu_padding_bottom ) . 'px' );
	}

	if ( $sub_menu_padding_left ) {
		echo sprintf( 'padding-left: %s;', esc_attr( $sub_menu_padding_left ) . 'px' );
	}

	echo '}';

}

if ( $sub_menu_accent_color || $sub_menu_font_size ) {

	echo '.wpbf-navigation .wpbf-menu .sub-menu a {';

	if ( $sub_menu_accent_color ) {
		echo sprintf( 'color: %s;', esc_attr( $sub_menu_accent_color ) );
	}

	if ( $sub_menu_font_size ) {
		$suffix = is_numeric( $sub_menu_font_size ) ? 'px' : '';
		echo sprintf( 'font-size: %s;', esc_attr( $sub_menu_font_size ) . $suffix );
	}

	echo '}';

}

if ( $sub_menu_accent_color_alt ) {

	echo '.wpbf-navigation .wpbf-menu .sub-menu a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $sub_menu_accent_color_alt ) );
	echo '}';

}

// Mobile navigation.
$mobile_menu_height                  = ( $val = get_theme_mod( 'mobile_menu_height' ) ) === '20' ? false : $val;
$mobile_menu_background_color        = get_theme_mod( 'mobile_menu_background_color' );
$mobile_menu_padding                 = json_decode( get_theme_mod( 'mobile_menu_padding' ), true );
$mobile_menu_padding_top             = wpbf_get_theme_mod_value( $mobile_menu_padding, 'top', 10 );
$mobile_menu_padding_right           = wpbf_get_theme_mod_value( $mobile_menu_padding, 'right', 20 );
$mobile_menu_padding_bottom          = wpbf_get_theme_mod_value( $mobile_menu_padding, 'bottom', 10 );
$mobile_menu_padding_left            = wpbf_get_theme_mod_value( $mobile_menu_padding, 'left', 20 );
$mobile_menu_font_color              = get_theme_mod( 'mobile_menu_font_color' );
$mobile_menu_font_color_alt          = get_theme_mod( 'mobile_menu_font_color_alt' );
$mobile_menu_border_color            = ( $val = get_theme_mod( 'mobile_menu_border_color' ) ) === '#d9d9e0' ? false : $val;
$mobile_menu_options                 = get_theme_mod( 'mobile_menu_options', 'menu-mobile-hamburger' );
$mobile_menu_hamburger_color         = get_theme_mod( 'mobile_menu_hamburger_color' );
$mobile_menu_hamburger_size          = ( $val = get_theme_mod( 'mobile_menu_hamburger_size' ) ) === '16px' ? false : $val;
$mobile_menu_hamburger_border_radius = get_theme_mod( 'mobile_menu_hamburger_border_radius' );
$mobile_menu_hamburger_bg_color      = get_theme_mod( 'mobile_menu_hamburger_bg_color' );
$mobile_menu_bg_color                = ( $val = get_theme_mod( 'mobile_menu_bg_color' ) ) === '#ffffff' ? false : $val;
$mobile_menu_bg_color_alt            = get_theme_mod( 'mobile_menu_bg_color_alt' );
$mobile_menu_submenu_arrow_color     = get_theme_mod( 'mobile_menu_submenu_arrow_color' );
$mobile_menu_font_size               = ( $val = get_theme_mod( 'mobile_menu_font_size' ) ) === '16px' ? false : $val;

if ( $mobile_menu_height !== false ) {

	echo '.wpbf-mobile-nav-wrapper {';
	echo sprintf( 'padding-top: %s;', esc_attr( $mobile_menu_height ) . 'px' );
	echo sprintf( 'padding-bottom: %s;', esc_attr( $mobile_menu_height ) . 'px' );
	echo '}';

}

if ( $mobile_menu_background_color ) {

	echo '.wpbf-mobile-nav-wrapper {';
	echo sprintf( 'background: %s;', esc_attr( $mobile_menu_background_color ) );
	echo '}';

}

if ( $mobile_menu_padding_top || $mobile_menu_padding_right || $mobile_menu_padding_bottom || $mobile_menu_padding_left ) {

	echo '.wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {';

	if ( $mobile_menu_padding_top ) {
		echo sprintf( 'padding-top: %s;', esc_attr( $mobile_menu_padding_top ) . 'px' );
	}

	if ( $mobile_menu_padding_right ) {
		echo sprintf( 'padding-right: %s;', esc_attr( $mobile_menu_padding_right ) . 'px' );
	}

	if ( $mobile_menu_padding_bottom ) {
		echo sprintf( 'padding-bottom: %s;', esc_attr( $mobile_menu_padding_bottom ) . 'px' );
	}

	if ( $mobile_menu_padding_left ) {
		echo sprintf( 'padding-left: %s;', esc_attr( $mobile_menu_padding_left ) . 'px' );
	}

	echo '}';

}

if ( $mobile_menu_font_color ) {

	echo '.wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_menu_font_color ) );
	echo '}';

}

if ( $mobile_menu_font_color_alt ) {

	echo '.wpbf-mobile-menu a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_menu_font_color_alt ) );
	echo '}';

	echo '.wpbf-mobile-menu > .current-menu-item > a {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_menu_font_color_alt ) . '!important' );
	echo '}';

}

if ( $mobile_menu_border_color ) {

	echo '.wpbf-mobile-menu .menu-item {';
	echo sprintf( 'border-top-color: %s;', esc_attr( $mobile_menu_border_color ) );
	echo '}';

	echo '.wpbf-mobile-menu > .menu-item:last-child {';
	echo sprintf( 'border-bottom-color: %s;', esc_attr( $mobile_menu_border_color ) );
	echo '}';

}

if ( in_array( $mobile_menu_options, array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ) ) ) {

	if ( $mobile_menu_hamburger_color || $mobile_menu_hamburger_size ) {

		echo '.wpbf-mobile-nav-item {';

		if ( $mobile_menu_hamburger_color ) {
			echo sprintf( 'color: %s;', esc_attr( $mobile_menu_hamburger_color ) );
		}

		if ( $mobile_menu_hamburger_size ) {
			$suffix = is_numeric( $mobile_menu_hamburger_size ) ? 'px' : '';
			echo sprintf( 'font-size: %s;', esc_attr( $mobile_menu_hamburger_size ) . $suffix );
		}

		echo '}';

		if ( $mobile_menu_hamburger_color ) {

			echo '.wpbf-mobile-nav-item a {';
			echo sprintf( 'color: %s;', esc_attr( $mobile_menu_hamburger_color ) );
			echo '}';

		}
	}

	if ( $mobile_menu_hamburger_bg_color ) {

		echo '.wpbf-mobile-menu-toggle {';
		echo sprintf( 'background: %s;', esc_attr( $mobile_menu_hamburger_bg_color ) );
		echo 'color: #ffffff !important;';
		echo 'padding: 10px;';
		echo 'line-height: 1;';

		if ( $mobile_menu_hamburger_border_radius ) {
			echo sprintf( 'border-radius: %s;', esc_attr( $mobile_menu_hamburger_border_radius ) . 'px' );
		}

		echo '}';

	}
}

if ( $mobile_menu_bg_color ) {

	echo '.wpbf-mobile-menu > .menu-item a {';
	echo sprintf( 'background-color: %s;', esc_attr( $mobile_menu_bg_color ) );
	echo '}';

}

if ( $mobile_menu_bg_color_alt ) {

	echo '.wpbf-mobile-menu > .menu-item a:hover {';
	echo sprintf( 'background-color: %s;', esc_attr( $mobile_menu_bg_color_alt ) );
	echo '}';

}

if ( $mobile_menu_submenu_arrow_color ) {

	echo '.wpbf-mobile-menu .wpbf-submenu-toggle {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_menu_submenu_arrow_color ) );
	echo '}';

}

if ( $mobile_menu_font_size ) {

	$suffix = is_numeric( $mobile_menu_font_size ) ? 'px' : '';
	echo '.wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {';
	echo sprintf( 'font-size: %s;', esc_attr( $mobile_menu_font_size ) . $suffix );
	echo '}';

}

// Mobile sub menu.
$mobile_sub_menu_indent         = get_theme_mod( 'mobile_sub_menu_indent' );
$mobile_sub_menu_bg_color       = get_theme_mod( 'mobile_sub_menu_bg_color' );
$mobile_sub_menu_bg_color_alt   = get_theme_mod( 'mobile_sub_menu_bg_color_alt' );
$mobile_sub_menu_arrow_color    = get_theme_mod( 'mobile_sub_menu_arrow_color' );
$mobile_sub_menu_font_size      = get_theme_mod( 'mobile_sub_menu_font_size' );
$mobile_sub_menu_font_color     = get_theme_mod( 'mobile_sub_menu_font_color' );
$mobile_sub_menu_font_color_alt = get_theme_mod( 'mobile_sub_menu_font_color_alt' );
$mobile_sub_menu_border_color   = get_theme_mod( 'mobile_sub_menu_border_color' );

if ( $mobile_sub_menu_indent ) {

	$default                = get_theme_mod( 'mobile_menu_padding_left', '20' );
	$mobile_sub_menu_indent = $mobile_sub_menu_indent + $default;

	echo '.wpbf-mobile-menu .sub-menu a {';
	echo sprintf( 'padding-left: %s;', esc_attr( $mobile_sub_menu_indent ) . 'px' );
	echo '}';

}

if ( $mobile_sub_menu_bg_color ) {

	echo '.wpbf-mobile-menu .sub-menu a {';
	echo sprintf( 'background-color: %s;', esc_attr( $mobile_sub_menu_bg_color ) );
	echo '}';

}

if ( $mobile_sub_menu_bg_color_alt ) {

	echo '.wpbf-mobile-menu .sub-menu a:hover {';
	echo sprintf( 'background-color: %s;', esc_attr( $mobile_sub_menu_bg_color_alt ) );
	echo '}';

}

if ( $mobile_sub_menu_arrow_color ) {

	echo '.wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_sub_menu_arrow_color ) );
	echo '}';

}

if ( $mobile_sub_menu_font_size ) {

	$suffix = is_numeric( $mobile_sub_menu_font_size ) ? 'px' : '';
	echo '.wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle {';
	echo sprintf( 'font-size: %s;', esc_attr( $mobile_sub_menu_font_size ) . $suffix );
	echo '}';

}

if ( $mobile_sub_menu_font_color ) {

	echo '.wpbf-mobile-menu .sub-menu a {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_sub_menu_font_color ) );
	echo '}';

}

if ( $mobile_sub_menu_font_color_alt ) {

	echo '.wpbf-mobile-menu .sub-menu a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_sub_menu_font_color_alt ) );
	echo '}';

	echo '.wpbf-mobile-menu .sub-menu > .current-menu-item > a {';
	echo sprintf( 'color: %s;', esc_attr( $mobile_sub_menu_font_color_alt ) . '!important' );
	echo '}';

}

if ( $mobile_sub_menu_border_color ) {

	echo '.wpbf-mobile-menu .sub-menu .menu-item {';
	echo sprintf( 'border-top-color: %s;', esc_attr( $mobile_sub_menu_border_color ) );
	echo '}';

}

// Pre header.
$pre_header_layout     = get_theme_mod( 'pre_header_layout' );
$pre_header_width      = ( $val = get_theme_mod( 'pre_header_width' ) ) === '1200px' ? false : $val;
$pre_header_height     = ( $val = get_theme_mod( 'pre_header_height' ) ) === '10' ? false : $val;
$pre_header_bg_color   = ( $val = get_theme_mod( 'pre_header_bg_color' ) ) === '#ffffff' ? false : $val;
$pre_header_font_color = get_theme_mod( 'pre_header_font_color' );

$pre_header_accent_colors = get_theme_mod( 'pre_header_accent_colors', array() );
$pre_header_accent_colors = ! is_array( $pre_header_accent_colors ) ? array() : $pre_header_accent_colors;

$pre_header_font_size = ( $val = get_theme_mod( 'pre_header_font_size' ) ) === '14px' ? false : $val;

$render_pre_header_style = false;

if ( $header_builder_enabled || 'none' !== $pre_header_layout ) {
	$render_pre_header_style = true;
}

if ( $render_pre_header_style && ( $pre_header_height || $pre_header_width ) ) {

	echo '.wpbf-inner-pre-header {';

	if ( $pre_header_height ) {

		echo sprintf( 'padding-top: %s;', esc_attr( $pre_header_height ) . 'px' );
		echo sprintf( 'padding-bottom: %s;', esc_attr( $pre_header_height ) . 'px' );

	}

	if ( $pre_header_width ) {
		echo sprintf( 'max-width: %s;', esc_attr( $pre_header_width ) );
	}

	echo '}';

}

if ( $render_pre_header_style && ( $pre_header_bg_color || $pre_header_font_color ) ) {

	echo '.wpbf-pre-header {';

	if ( $pre_header_bg_color ) {
		echo sprintf( 'background-color: %s;', esc_attr( $pre_header_bg_color ) );
	}

	if ( $pre_header_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $pre_header_font_color ) );
	}

	echo '}';

}

if ( $render_pre_header_style && ! empty( $pre_header_accent_colors['default'] ) ) {

	echo '.wpbf-pre-header a {';
	echo sprintf( 'color: %s;', esc_attr( $pre_header_accent_colors['default'] ) );
	echo '}';

}

if ( $render_pre_header_style && ! empty( $pre_header_accent_colors['hover'] ) ) {

	echo '.wpbf-pre-header a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $pre_header_accent_colors['hover'] ) );
	echo '}';

	echo '.wpbf-pre-header .wpbf-menu > .current-menu-item > a {';
	echo sprintf( 'color: %s;', esc_attr( $pre_header_accent_colors['hover'] ) . '!important' );
	echo '}';

}

if ( $render_pre_header_style && $pre_header_font_size ) {

	$suffix = is_numeric( $pre_header_font_size ) ? 'px' : '';
	echo '.wpbf-pre-header, .wpbf-pre-header .wpbf-menu, .wpbf-pre-header .wpbf-menu .sub-menu a {';
	echo sprintf( 'font-size: %s;', esc_attr( $pre_header_font_size . $suffix ) );
	echo '}';

}

require_once WPBF_THEME_DIR . '/inc/customizer/styles/header-builder-styles.php';

/* Footer */

$footer_layout           = get_theme_mod( 'footer_layout' );
$footer_width            = ( $val = get_theme_mod( 'footer_width' ) ) === '1200px' ? false : $val;
$footer_height           = ( $val = get_theme_mod( 'footer_height' ) ) === '20' ? false : $val;
$footer_bg_color         = ( $val = get_theme_mod( 'footer_bg_color' ) ) === '#f5f5f7' ? false : $val;
$footer_font_color       = get_theme_mod( 'footer_font_color' );
$footer_accent_color     = get_theme_mod( 'footer_accent_color' );
$footer_accent_color_alt = get_theme_mod( 'footer_accent_color_alt' );
$footer_font_size        = ( $val = get_theme_mod( 'footer_font_size' ) ) === '14px' ? false : $val;

if ( 'none' !== $footer_layout && ( $footer_height || $footer_width ) ) {

	echo '.wpbf-inner-footer {';

	if ( $footer_height ) {

		echo sprintf( 'padding-top: %s;', esc_attr( $footer_height ) . 'px' );
		echo sprintf( 'padding-bottom: %s;', esc_attr( $footer_height ) . 'px' );

	}

	if ( $footer_width ) {
		echo sprintf( 'max-width: %s;', esc_attr( $footer_width ) );
	}

	echo '}';

}

if ( 'none' !== $footer_layout && $footer_bg_color ) {

	echo '.wpbf-page-footer {';

	echo sprintf( 'background-color: %s;', esc_attr( $footer_bg_color ) );

	echo '}';

}

if ( 'none' !== $footer_layout && $footer_font_color ) {

	echo '.wpbf-inner-footer {';

	echo sprintf( 'color: %s;', esc_attr( $footer_font_color ) );

	echo '}';

}

if ( 'none' !== $footer_layout && $footer_accent_color ) {

	echo '.wpbf-inner-footer a {';
	echo sprintf( 'color: %s;', esc_attr( $footer_accent_color ) );
	echo '}';

}

if ( 'none' !== $footer_layout && $footer_accent_color_alt ) {

	echo '.wpbf-inner-footer a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $footer_accent_color_alt ) );
	echo '}';

	echo '.wpbf-inner-footer .wpbf-menu > .current-menu-item > a {';
	echo sprintf( 'color: %s;', esc_attr( $footer_accent_color_alt ) . '!important' );
	echo '}';

}

if ( 'none' !== $footer_layout && $footer_font_size ) {

	$suffix = is_numeric( $footer_font_size ) ? 'px' : '';
	echo '.wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu {';
	echo sprintf( 'font-size: %s;', esc_attr( $footer_font_size ) . $suffix );
	echo '}';

}

do_action( 'wpbf_after_customizer_css' );
