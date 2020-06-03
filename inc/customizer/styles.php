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
$breakpoint_mobile      = $breakpoint_mobile_int . 'px';
$breakpoint_medium      = $breakpoint_medium_int . 'px';
$breakpoint_desktop     = $breakpoint_desktop_int . 'px';

/* Typography */

// Page font settings.
$page_font_toggle       = get_theme_mod( 'page_font_toggle' );
$page_font_family_value = get_theme_mod( 'page_font_family' );
$page_font_color        = ( $val = get_theme_mod( 'page_font_color' ) ) === '#6d7680' ? false : $val;

if ( $page_font_toggle && $page_font_family_value ) {

	echo 'body, button, input, optgroup, select, textarea, h1, h2, h3, h4, h5, h6 {';

	if ( ! empty( $page_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_font_family_value['font-family'], ' ' ) && false === strpos( $page_font_family_value['font-family'], '"' ) && false === strpos( $page_font_family_value['font-family'], ',' ) ) {
			$page_font_family_value['font-family'] = '"' . $page_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_font_family_value['font-family'] ), ENT_QUOTES ) );
	}

	if ( ! empty( $page_font_family_value['variant'] ) ) {

		$page_font_family_font_weight = str_replace( 'italic', '', $page_font_family_value['variant'] );
		$page_font_family_font_weight = ( in_array( $page_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_font_family_font_weight;

		$page_font_family_is_italic  = ( false !== strpos( $page_font_family_value['variant'], 'italic' ) );
		$page_font_family_font_style = $page_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_font_family_font_style ) );

	}

	echo '}';

}

if ( $page_font_color ) {

	echo 'body {';
	echo sprintf( 'color: %s;', esc_attr( $page_font_color ) );
	echo '}';

}

// Menu font settings.
$menu_font_family_toggle = get_theme_mod( 'menu_font_family_toggle' );
$menu_font_family_value  = get_theme_mod( 'menu_font_family' );

if ( $menu_font_family_toggle && $menu_font_family_value ) {

	echo '.wpbf-menu, .wpbf-mobile-menu {';

	if ( ! empty( $menu_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $menu_font_family_value['font-family'], ' ' ) && false === strpos( $menu_font_family_value['font-family'], '"' ) && false === strpos( $menu_font_family_value['font-family'], ',' ) ) {
			$menu_font_family_value['font-family'] = '"' . $menu_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $menu_font_family_value['font-family'] ), ENT_QUOTES ) );

	}

	if ( ! empty( $menu_font_family_value['variant'] ) ) {

		$menu_font_family_font_weight = str_replace( 'italic', '', $menu_font_family_value['variant'] );
		$menu_font_family_font_weight = ( in_array( $menu_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $menu_font_family_font_weight;

		$menu_font_family_is_italic = ( false !== strpos( $menu_font_family_value['variant'], 'italic' ) );
		$menu_font_family_is_style  = $menu_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $menu_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $menu_font_family_is_style ) );

	}

	echo '}';

}

// H1 font settings.
$page_h1_toggle            = get_theme_mod( 'page_h1_toggle' );
$page_h1_font_family_value = get_theme_mod( 'page_h1_font_family' );

if ( $page_h1_toggle && $page_h1_font_family_value ) {

	echo 'h1, h2, h3, h4, h5, h6 {';

	if ( ! empty( $page_h1_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_h1_font_family_value['font-family'], ' ' ) && false === strpos( $page_h1_font_family_value['font-family'], '"' ) && false === strpos( $page_h1_font_family_value['font-family'], ',' ) ) {
			$page_h1_font_family_value['font-family'] = '"' . $page_h1_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h1_font_family_value['font-family'] ), ENT_QUOTES ) );

	}

	if ( ! empty( $page_h1_font_family_value['variant'] ) ) {

		$page_h1_font_family_font_weight = str_replace( 'italic', '', $page_h1_font_family_value['variant'] );
		$page_h1_font_family_font_weight = ( in_array( $page_h1_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h1_font_family_font_weight;

		$page_h1_font_family_is_italic = ( false !== strpos( $page_h1_font_family_value['variant'], 'italic' ) );
		$page_h1_font_family_is_style  = $page_h1_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h1_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h1_font_family_is_style ) );

	}

	echo '}';

}

// H2 font settings.
$page_h2_font_family_value = get_theme_mod( 'page_h2_font_family' );
$page_h2_toggle            = get_theme_mod( 'page_h2_toggle' );

if ( $page_h2_toggle && $page_h2_font_family_value ) {

	echo 'h2 {';

	if ( ! empty( $page_h2_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_h2_font_family_value['font-family'], ' ' ) && false === strpos( $page_h2_font_family_value['font-family'], '"' ) && false === strpos( $page_h2_font_family_value['font-family'], ',' ) ) {
			$page_h2_font_family_value['font-family'] = '"' . $page_h2_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h2_font_family_value['font-family'] ), ENT_QUOTES ) );

	}

	if ( ! empty( $page_h2_font_family_value['variant'] ) ) {

		$page_h2_font_family_font_weight = str_replace( 'italic', '', $page_h2_font_family_value['variant'] );
		$page_h2_font_family_font_weight = ( in_array( $page_h2_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h2_font_family_font_weight;

		$page_h2_font_family_is_italic = ( false !== strpos( $page_h2_font_family_value['variant'], 'italic' ) );
		$page_h2_font_family_is_style  = $page_h2_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h2_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h2_font_family_is_style ) );

	}

	echo '}';

}

// H3 font settings.
$page_h3_toggle            = get_theme_mod( 'page_h3_toggle' );
$page_h3_font_family_value = get_theme_mod( 'page_h3_font_family' );

if ( $page_h3_toggle && $page_h3_font_family_value ) {

	echo 'h3 {';

	if ( ! empty( $page_h3_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_h3_font_family_value['font-family'], ' ' ) && false === strpos( $page_h3_font_family_value['font-family'], '"' ) && false === strpos( $page_h3_font_family_value['font-family'], ',' ) ) {
			$page_h3_font_family_value['font-family'] = '"' . $page_h3_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h3_font_family_value['font-family'] ), ENT_QUOTES ) );

	}

	if ( ! empty( $page_h3_font_family_value['variant'] ) ) {

		$page_h3_font_family_font_weight = str_replace( 'italic', '', $page_h3_font_family_value['variant'] );
		$page_h3_font_family_font_weight = ( in_array( $page_h3_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h3_font_family_font_weight;

		$page_h3_font_family_is_italic = ( false !== strpos( $page_h3_font_family_value['variant'], 'italic' ) );
		$page_h3_font_family_is_style  = $page_h3_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h3_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h3_font_family_is_style ) );

	}

	echo '}';

}

// H4 font settings.
$page_h4_toggle            = get_theme_mod( 'page_h4_toggle' );
$page_h4_font_family_value = get_theme_mod( 'page_h4_font_family' );

if ( $page_h4_toggle && $page_h4_font_family_value ) {

	echo 'h4 {';

	if ( ! empty( $page_h4_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_h4_font_family_value['font-family'], ' ' ) && false === strpos( $page_h4_font_family_value['font-family'], '"' ) && false === strpos( $page_h4_font_family_value['font-family'], ',' ) ) {
			$page_h4_font_family_value['font-family'] = '"' . $page_h4_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h4_font_family_value['font-family'] ), ENT_QUOTES ) );

	}

	if ( ! empty( $page_h4_font_family_value['variant'] ) ) {

		$page_h4_font_family_font_weight = str_replace( 'italic', '', $page_h4_font_family_value['variant'] );
		$page_h4_font_family_font_weight = ( in_array( $page_h4_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h4_font_family_font_weight;

		$page_h4_font_family_is_italic = ( false !== strpos( $page_h4_font_family_value['variant'], 'italic' ) );
		$page_h4_font_family_is_style  = $page_h4_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h4_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h4_font_family_is_style ) );

	}

	echo '}';

}

// H5 font settings.
$page_h5_toggle            = get_theme_mod( 'page_h5_toggle' );
$page_h5_font_family_value = get_theme_mod( 'page_h5_font_family' );

if ( $page_h5_toggle && $page_h5_font_family_value ) {

	echo 'h5 {';

	if ( ! empty( $page_h5_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_h5_font_family_value['font-family'], ' ' ) && false === strpos( $page_h5_font_family_value['font-family'], '"' ) && false === strpos( $page_h5_font_family_value['font-family'], ',' ) ) {
			$page_h5_font_family_value['font-family'] = '"' . $page_h5_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h5_font_family_value['font-family'] ), ENT_QUOTES ) );

	}

	if ( ! empty( $page_h5_font_family_value['variant'] ) ) {

		$page_h5_font_family_font_weight = str_replace( 'italic', '', $page_h5_font_family_value['variant'] );
		$page_h5_font_family_font_weight = ( in_array( $page_h5_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h5_font_family_font_weight;

		$page_h5_font_family_is_italic = ( false !== strpos( $page_h5_font_family_value['variant'], 'italic' ) );
		$page_h5_font_family_is_style  = $page_h5_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h5_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h5_font_family_is_style ) );

	}

	echo '}';

}

// H6 font settings.
$page_h6_toggle            = get_theme_mod( 'page_h6_toggle' );
$page_h6_font_family_value = get_theme_mod( 'page_h6_font_family' );

if ( $page_h6_toggle && $page_h6_font_family_value ) {

	echo 'h6 {';

	if ( ! empty( $page_h6_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_h6_font_family_value['font-family'], ' ' ) && false === strpos( $page_h6_font_family_value['font-family'], '"' ) && false === strpos( $page_h6_font_family_value['font-family'], ',' ) ) {
			$page_h6_font_family_value['font-family'] = '"' . $page_h6_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h6_font_family_value['font-family'] ), ENT_QUOTES ) );

	}

	if ( ! empty( $page_h6_font_family_value['variant'] ) ) {

		$page_h6_font_family_font_weight = str_replace( 'italic', '', $page_h6_font_family_value['variant'] );
		$page_h6_font_family_font_weight = ( in_array( $page_h6_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h6_font_family_font_weight;

		$page_h6_font_family_is_italic = ( false !== strpos( $page_h6_font_family_value['variant'], 'italic' ) );
		$page_h6_font_family_is_style  = $page_h6_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h6_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h6_font_family_is_style ) );

	}

	echo '}';

}

/* General */

// Page settings.
$page_width                   = ( $val = get_theme_mod( 'page_max_width' ) ) === '1200px' ? false : $val;
$page_boxed                   = get_theme_mod( 'page_boxed' );
$page_boxed_padding           = ( $val = get_theme_mod( 'page_boxed_padding' ) ) === '20' ? false : $val;
$page_boxed_margin            = get_theme_mod( 'page_boxed_margin' );
$page_boxed_background        = get_theme_mod( 'page_boxed_background', '#ffffff' );
$page_boxed_shadow            = get_theme_mod( 'page_boxed_box_shadow' );
$page_boxed_shadow_horizontal = ( $val = get_theme_mod( 'page_boxed_box_shadow_horizontal' ) ) ? $val . 'px' : '0px';
$page_boxed_shadow_vertical   = ( $val = get_theme_mod( 'page_boxed_box_shadow_vertical' ) ) ? $val . 'px' : '0px';
$page_boxed_shadow_blur       = ( $val = get_theme_mod( 'page_boxed_box_shadow_blur' ) ) ? $val . 'px' : '25px';
$page_boxed_shadow_spread     = ( $val = get_theme_mod( 'page_boxed_box_shadow_spread' ) ) ? $val . 'px' : '0px';
$page_boxed_shadow_color      = get_theme_mod( 'page_boxed_box_shadow_color', 'rgba(0,0,0,.15)' );

if ( $page_width ) {

	echo '.wpbf-container {';
	echo sprintf( 'max-width: %s;', esc_attr( $page_width ) );
	echo '}';

}

if ( $page_boxed ) {

	if ( $page_boxed_padding ) {

		echo '.wpbf-container {';
		echo sprintf( 'padding-left: %s;', esc_attr( $page_boxed_padding ) . 'px' );
		echo sprintf( 'padding-right: %s;', esc_attr( $page_boxed_padding ) . 'px' );
		echo '}';

	}

	echo '.wpbf-page {';

	if ( $page_width ) {

		echo sprintf( 'max-width: %s;', esc_attr( $page_width ) );

	} else {

		echo 'max-width: 1200px;';

	}

	echo 'margin: 0 auto;';

	if ( $page_boxed_margin ) {

		echo sprintf( 'margin-top: %s;', esc_attr( $page_boxed_margin ) . 'px' );
		echo sprintf( 'margin-bottom: %s;', esc_attr( $page_boxed_margin ) . 'px' );

	}

	if ( $page_boxed_background ) {
		echo sprintf( 'background-color: %s;', esc_attr( $page_boxed_background ) );
	}

	echo '}';

	if ( $page_boxed_shadow ) {

		echo '#container {';
		echo sprintf( 'box-shadow: %1$s %2$s %3$s %4$s %5$s;', esc_attr( $page_boxed_shadow_horizontal ), esc_attr( $page_boxed_shadow_vertical ), esc_attr( $page_boxed_shadow_blur ), esc_attr( $page_boxed_shadow_spread ), esc_attr( $page_boxed_shadow_color ) );
		echo '}';

	}

}

// ScrollTop.
$scrolltop                 = get_theme_mod( 'layout_scrolltop' );
$scrolltop_position        = get_theme_mod( 'scrolltop_position' );
$scrolltop_bg_color        = ( $val = get_theme_mod( 'scrolltop_bg_color' ) ) === 'rgba(62,67,73,0.5)' ? false : $val;
$scrolltop_bg_color_alt    = ( $val = get_theme_mod( 'scrolltop_bg_color_alt' ) ) === 'rgba(62,67,73,0.7)' ? false : $val;
$scrolltop_icon_color      = ( $val = get_theme_mod( 'scrolltop_icon_color' ) ) === '#ffffff' ? false : $val;
$scrolltop_icon_color_alt  = get_theme_mod( 'scrolltop_icon_color_alt' );
$scrolltop_border_radius   = get_theme_mod( 'scrolltop_border_radius' );

if ( $scrolltop ) {

	if ( 'left' === $scrolltop_position ) {

		echo '.scrolltop {';
		echo 'right: auto;';
		echo 'left: 20px;';
		echo '}';

	}

	if ( $scrolltop_bg_color || $scrolltop_border_radius ) {

		echo '.scrolltop {';

		if ( $scrolltop_bg_color ) {
			echo sprintf( 'background-color: %s;', esc_attr( $scrolltop_bg_color ) );
		}

		if ( $scrolltop_border_radius ) {
			echo sprintf( 'border-radius: %s;', esc_attr( $scrolltop_border_radius ) . 'px' );
		}

		echo '}';

	}

	if ( $scrolltop_icon_color ) {

		echo '.scrolltop, .scrolltop:hover {';
		echo sprintf( 'color: %s;', esc_attr( $scrolltop_icon_color ) );
		echo '}';

	}

	if ( $scrolltop_bg_color_alt || $scrolltop_icon_color_alt ) {

		echo '.scrolltop:hover {';

		if ( $scrolltop_bg_color_alt ) {
			echo sprintf( 'background-color: %s;', esc_attr( $scrolltop_bg_color_alt ) );
		}

		if ( $scrolltop_icon_color_alt ) {
			echo sprintf( 'color: %s;', esc_attr( $scrolltop_icon_color_alt ) );
		}

		echo '}';

	}

}

// Background (backwards compatibility).
$page_background_color      = get_theme_mod( 'page_background_color' );
$page_background_image      = get_theme_mod( 'page_background_image' );
$page_background_attachment = get_theme_mod( 'page_background_attachment' );
$page_background_position   = get_theme_mod( 'page_background_position' );
$page_background_repeat     = get_theme_mod( 'page_background_repeat' );
$page_background_size       = get_theme_mod( 'page_background_size' );

if ( $page_background_color || $page_background_image ) {

	echo 'body{';

	if ( $page_background_color ) {
		echo sprintf( 'background-color: %s;', esc_attr( $page_background_color ) );
	}

	if ( $page_background_image ) {
		echo sprintf( 'background-image: url(%s);', esc_url( $page_background_image ) );
	}

	if ( $page_background_attachment ) {
		echo sprintf( 'background-attachment: %s;', esc_attr( $page_background_attachment ) );
	}

	if ( $page_background_position ) {
		echo sprintf( 'background-position: %s;', esc_attr( $page_background_position ) );
	}

	if ( $page_background_repeat ) {
		echo sprintf( 'background-repeat: %s;', esc_attr( $page_background_repeat ) );
	}

	if ( $page_background_size ) {
		echo sprintf( 'background-size: %s;', esc_attr( $page_background_size ) );
	}

	echo '}';

}

// Accent color.
$page_accent_color     = ( $val = get_theme_mod( 'page_accent_color' ) ) === '#3ba9d2' ? false : $val;
$page_accent_color_alt = ( $val = get_theme_mod( 'page_accent_color_alt' ) ) === '#8ecde5' ? false : $val;

if ( $page_accent_color ) {

	echo 'a {';
	echo sprintf( 'color: %s;', esc_attr( $page_accent_color ) );
	echo '}';

	echo '.bypostauthor {';
	echo sprintf( 'border-color: %s;', esc_attr( $page_accent_color ) );
	echo '}';

	echo '.wpbf-button-primary {';
	echo sprintf( 'background: %s;', esc_attr( $page_accent_color ) );
	echo '}';

}

if ( $page_accent_color_alt ) {

	echo 'a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $page_accent_color_alt ) );
	echo '}';

	echo '.wpbf-button-primary:hover {';
	echo sprintf( 'background: %s;', esc_attr( $page_accent_color_alt ) );
	echo '}';

	echo '.wpbf-menu > .current-menu-item > a {';
	echo sprintf( 'color: %s;', esc_attr( $page_accent_color_alt ) . '!important' );
	echo '}';

}

// Theme buttons.
$button_border_width             = get_theme_mod( 'button_border_width' );
$button_border_color             = get_theme_mod( 'button_border_color' );
$button_border_color_alt         = get_theme_mod( 'button_border_color_alt' );
$button_primary_border_color     = get_theme_mod( 'button_primary_border_color' );
$button_primary_border_color_alt = get_theme_mod( 'button_primary_border_color_alt' );
$button_bg_color                 = get_theme_mod( 'button_bg_color' );
$button_text_color               = get_theme_mod( 'button_text_color' );
$button_border_radius            = get_theme_mod( 'button_border_radius' );
$button_bg_color_alt             = get_theme_mod( 'button_bg_color_alt' );
$button_text_color_alt           = get_theme_mod( 'button_text_color_alt' );
$button_primary_bg_color         = get_theme_mod( 'button_primary_bg_color' );
$button_primary_text_color       = get_theme_mod( 'button_primary_text_color' );
$button_primary_bg_color_alt     = get_theme_mod( 'button_primary_bg_color_alt' );
$button_primary_text_color_alt   = get_theme_mod( 'button_primary_text_color_alt' );

if ( $button_border_width ) {

	echo '.wpbf-button, input[type="submit"] {';

	echo sprintf( 'border-width: %s;', esc_attr( $button_border_width ) . 'px' );
	echo 'border-style: solid;';

	if ( $button_border_color ) {
		echo sprintf( 'border-color: %s;', esc_attr( $button_border_color ) );
	}

	echo '}';

	if ( $button_border_color_alt ) {

		echo '.wpbf-button:hover, input[type="submit"]:hover {';
		echo sprintf( 'border-color: %s;', esc_attr( $button_border_color_alt ) );
		echo '}';

	}

	if ( $button_primary_border_color ) {

		echo '.wpbf-button-primary {';
		echo sprintf( 'border-color: %s;', esc_attr( $button_primary_border_color ) );
		echo '}';

	}

	if ( $button_primary_border_color_alt ) {

		echo '.wpbf-button-primary:hover {';
		echo sprintf( 'border-color: %s;', esc_attr( $button_primary_border_color_alt ) );
		echo '}';

	}

}

if ( $button_bg_color || $button_text_color || $button_border_radius ) {

	echo '.wpbf-button, input[type="submit"] {';

	if ( $button_border_radius ) {
		echo sprintf( 'border-radius: %s;', esc_attr( $button_border_radius ) . 'px' );
	}

	if ( $button_bg_color ) {
		echo sprintf( 'background: %s;', esc_attr( $button_bg_color ) );
	}

	if ( $button_text_color ) {
		echo sprintf( 'color: %s;', esc_attr( $button_text_color ) );
	}

	echo '}';

}

if ( $button_bg_color_alt || $button_text_color_alt ) {

	echo '.wpbf-button:hover, input[type="submit"]:hover {';

	if ( $button_bg_color_alt ) {
		echo sprintf( 'background: %s;', esc_attr( $button_bg_color_alt ) );
	}

	if ( $button_text_color_alt ) {
		echo sprintf( 'color: %s;', esc_attr( $button_text_color_alt ) );
	}

	echo '}';

}

if ( $button_primary_bg_color || $button_primary_text_color ) {

	echo '.wpbf-button-primary {';

	if ( $button_primary_bg_color ) {
		echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color ) );
	}

	if ( $button_primary_text_color ) {
		echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color ) );
	}

	echo '}';

}

if ( $button_primary_bg_color_alt || $button_primary_bg_color_alt ) {

	echo '.wpbf-button-primary:hover {';

	if ( $button_primary_bg_color_alt ) {
		echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color_alt ) );
	}

	if ( $button_primary_text_color_alt ) {
		echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color_alt ) );
	}

	echo '}';

}

// Gutenberg
if ( $button_primary_bg_color || $button_primary_text_color ) {

	echo '.wp-block-button__link {';

	if ( $button_primary_bg_color ) {
		echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color ) );
	}

	if ( $button_primary_text_color ) {
		echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color ) );
	}

	echo '}';

	if ( $button_primary_text_color ) {
		// Gutenberg sets the hover color to white so we need to override thise if a custom color is set.
		// Thank you, Gutenberg.
		// Let's also exclude those that have custom font colors.
		echo '.wp-block-button__link:not(.has-text-color):hover {';
			echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color ) );
		echo '}';
	}

	if ( $button_primary_bg_color ) {
		echo '.is-style-outline .wp-block-button__link:not(.has-text-color) {';
			echo sprintf( 'border-color: %s;', esc_attr( $button_primary_bg_color ) );
			echo sprintf( 'color: %s;', esc_attr( $button_primary_bg_color ) );
		echo '}';
	}

}

if ( $button_primary_bg_color_alt || $button_primary_text_color_alt ) {

	echo '.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover {';

	if ( $button_primary_bg_color_alt ) {
		echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color_alt ) );
	}

	if ( $button_primary_text_color_alt ) {
		echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color_alt ) );
	}

	echo '}';

	if ( $button_primary_bg_color_alt ) {
		echo '.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover {';
			echo sprintf( 'border-color: %s;', esc_attr( $button_primary_bg_color_alt ) );
			echo sprintf( 'color: %s;', esc_attr( $button_primary_bg_color_alt ) );
		echo '}';
	}

}

// Sidebar.
$sidebar_bg_color                      = ( $val = get_theme_mod( 'sidebar_bg_color' ) ) === '#f5f5f7' ? false : $val;
$sidebar_width                         = ( $val = get_theme_mod( 'sidebar_width' ) ) === 33.3 ? false : $val;
$sidebar_widget_padding_top_desktop    = ( $val = get_theme_mod( 'sidebar_widget_padding_top_desktop' ) ) === 20 ? false : $val;
$sidebar_widget_padding_right_desktop  = ( $val = get_theme_mod( 'sidebar_widget_padding_right_desktop' ) ) === 20 ? false : $val;
$sidebar_widget_padding_bottom_desktop = ( $val = get_theme_mod( 'sidebar_widget_padding_bottom_desktop' ) ) === 20 ? false : $val;
$sidebar_widget_padding_left_desktop   = ( $val = get_theme_mod( 'sidebar_widget_padding_left_desktop' ) ) === 20 ? false : $val;
$sidebar_widget_padding_top_tablet     = ( $val = get_theme_mod( 'sidebar_widget_padding_top_tablet' ) ) === 20 ? false : $val;
$sidebar_widget_padding_right_tablet   = ( $val = get_theme_mod( 'sidebar_widget_padding_right_tablet' ) ) === 20 ? false : $val;
$sidebar_widget_padding_bottom_tablet  = ( $val = get_theme_mod( 'sidebar_widget_padding_bottom_tablet' ) ) === 20 ? false : $val;
$sidebar_widget_padding_left_tablet    = ( $val = get_theme_mod( 'sidebar_widget_padding_left_tablet' ) ) === 20 ? false : $val;
$sidebar_widget_padding_top_mobile     = ( $val = get_theme_mod( 'sidebar_widget_padding_top_mobile' ) ) === 20 ? false : $val;
$sidebar_widget_padding_right_mobile   = ( $val = get_theme_mod( 'sidebar_widget_padding_right_mobile' ) ) === 20 ? false : $val;
$sidebar_widget_padding_bottom_mobile  = ( $val = get_theme_mod( 'sidebar_widget_padding_bottom_mobile' ) ) === 20 ? false : $val;
$sidebar_widget_padding_left_mobile    = ( $val = get_theme_mod( 'sidebar_widget_padding_left_mobile' ) ) === 20 ? false : $val;

if ( $sidebar_bg_color ) {

	echo '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget {';
	echo sprintf( 'background: %s;', esc_attr( $sidebar_bg_color ) );
	echo '}';

}

if ( ! is_bool( $sidebar_widget_padding_top_desktop ) || ! is_bool( $sidebar_widget_padding_right_desktop ) || ! is_bool( $sidebar_widget_padding_bottom_desktop ) || ! is_bool( $sidebar_widget_padding_left_desktop ) ) {

	echo '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget {';

	if ( ! is_bool( $sidebar_widget_padding_top_desktop ) ) {
		echo sprintf( 'padding-top: %s;', esc_attr( $sidebar_widget_padding_top_desktop ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_right_desktop ) ) {
		echo sprintf( 'padding-right: %s;', esc_attr( $sidebar_widget_padding_right_desktop ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_bottom_desktop ) ) {
		echo sprintf( 'padding-bottom: %s;', esc_attr( $sidebar_widget_padding_bottom_desktop ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_left_desktop ) ) {
		echo sprintf( 'padding-left: %s;', esc_attr( $sidebar_widget_padding_left_desktop ) . 'px' );
	}

	echo '}';

}

if ( ! is_bool( $sidebar_widget_padding_top_tablet ) || ! is_bool( $sidebar_widget_padding_right_tablet ) || ! is_bool( $sidebar_widget_padding_bottom_tablet ) || ! is_bool( $sidebar_widget_padding_left_tablet ) ) {

	echo '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ') {';

	echo '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget {';

	if ( ! is_bool( $sidebar_widget_padding_top_tablet ) ) {
		echo sprintf( 'padding-top: %s;', esc_attr( $sidebar_widget_padding_top_tablet ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_right_tablet ) ) {
		echo sprintf( 'padding-right: %s;', esc_attr( $sidebar_widget_padding_right_tablet ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_bottom_tablet ) ) {
		echo sprintf( 'padding-bottom: %s;', esc_attr( $sidebar_widget_padding_bottom_tablet ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_left_tablet ) ) {
		echo sprintf( 'padding-left: %s;', esc_attr( $sidebar_widget_padding_left_tablet ) . 'px' );
	}

	echo '}';

	echo '}';

}

if ( ! is_bool( $sidebar_widget_padding_top_mobile ) || ! is_bool( $sidebar_widget_padding_right_mobile ) || ! is_bool( $sidebar_widget_padding_bottom_mobile ) || ! is_bool( $sidebar_widget_padding_left_mobile ) ) {

	echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';

	echo '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget {';

	if ( ! is_bool( $sidebar_widget_padding_top_mobile ) ) {
		echo sprintf( 'padding-top: %s;', esc_attr( $sidebar_widget_padding_top_mobile ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_right_mobile ) ) {
		echo sprintf( 'padding-right: %s;', esc_attr( $sidebar_widget_padding_right_mobile ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_bottom_mobile ) ) {
		echo sprintf( 'padding-bottom: %s;', esc_attr( $sidebar_widget_padding_bottom_mobile ) . 'px' );
	}

	if ( ! is_bool( $sidebar_widget_padding_left_mobile ) ) {
		echo sprintf( 'padding-left: %s;', esc_attr( $sidebar_widget_padding_left_mobile ) . 'px' );
	}

	echo '}';

	echo '}';

}

if ( $sidebar_width ) {

	echo '@media (min-width: ' . esc_attr( $breakpoint_medium_int + 1 ) . 'px) {';

	echo 'body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3 {';
	echo sprintf( 'width: %s;', esc_attr( $sidebar_width ) . '%' );
	echo '}';

	echo 'body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3 {';
	echo sprintf( 'width: %s;', 100 - esc_attr( $sidebar_width ) . '%' );
	echo '}';

	echo '}';

}

// Breadcrumbs.
$breadcrumbs_alignment        = get_theme_mod( 'breadcrumbs_alignment', 'left' );
$breadcrumbs_background_color = ( $val = get_theme_mod( 'breadcrumbs_background_color' ) ) === '#dedee5' ? false : $val;
$breadcrumbs_font_color       = get_theme_mod( 'breadcrumbs_font_color' );
$breadcrumbs_accent_color     = get_theme_mod( 'breadcrumbs_accent_color' );
$breadcrumbs_accent_color_alt = get_theme_mod( 'breadcrumbs_accent_color_alt' );

if ( 'left' !== $breadcrumbs_alignment ) {

	echo '.wpbf-breadcrumbs-container {';
	echo sprintf( 'text-align: %s;', esc_attr( $breadcrumbs_alignment ) );
	echo '}';

}

if ( $breadcrumbs_background_color ) {

	echo '.wpbf-breadcrumbs-container {';
	echo sprintf( 'background: %s;', esc_attr( $breadcrumbs_background_color ) );
	echo '}';

}

if ( $breadcrumbs_font_color ) {

	echo '.wpbf-breadcrumbs {';
	echo sprintf( 'color: %s;', esc_attr( $breadcrumbs_font_color ) );
	echo '}';

}

if ( $breadcrumbs_accent_color ) {

	echo '.wpbf-breadcrumbs a {';
	echo sprintf( 'color: %s;', esc_attr( $breadcrumbs_accent_color ) );
	echo '}';

}

if ( $breadcrumbs_accent_color_alt ) {

	echo '.wpbf-breadcrumbs a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $breadcrumbs_accent_color_alt ) );
	echo '}';

}

// Pagination.
$blog_pagination_background_color           = get_theme_mod( 'blog_pagination_background_color' );
$blog_pagination_background_color_alt       = get_theme_mod( 'blog_pagination_background_color_alt' );
$blog_pagination_background_color_active    = get_theme_mod( 'blog_pagination_background_color_active' );
$blog_pagination_font_color                 = get_theme_mod( 'blog_pagination_font_color' );
$blog_pagination_font_color_alt             = get_theme_mod( 'blog_pagination_font_color_alt' );
$blog_pagination_font_color_active          = get_theme_mod( 'blog_pagination_font_color_active' );
$blog_pagination_font_size                  = get_theme_mod( 'blog_pagination_font_size' );
$blog_pagination_border_radius              = get_theme_mod( 'blog_pagination_border_radius' );
$blog_pagination_background_color_next_prev = get_theme_mod( 'blog_pagination_background_color_next_prev' );

if ( $blog_pagination_border_radius || $blog_pagination_font_size || $blog_pagination_background_color || $blog_pagination_font_color ) {

	echo '.pagination .page-numbers {';

	if ( $blog_pagination_border_radius ) {
		echo sprintf( 'border-radius: %s;', esc_attr( $blog_pagination_border_radius ) . 'px' );
	}

	if ( $blog_pagination_font_size ) {
		$suffix = is_numeric( $blog_pagination_font_size ) ? 'px' : '';
		echo sprintf( 'font-size: %s;', esc_attr( $blog_pagination_font_size ) . $suffix );
	}

	if ( $blog_pagination_background_color ) {
		echo sprintf( 'background: %s;', esc_attr( $blog_pagination_background_color ) );
	}

	if ( $blog_pagination_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $blog_pagination_font_color ) );
	}

	echo '}';

}

if ( $blog_pagination_background_color_alt || $blog_pagination_font_color_alt ) {

	echo '.pagination .page-numbers:hover {';

	if ( $blog_pagination_background_color_alt ) {
		echo sprintf( 'background: %s;', esc_attr( $blog_pagination_background_color_alt ) );
	}

	if ( $blog_pagination_font_color_alt ) {
		echo sprintf( 'color: %s;', esc_attr( $blog_pagination_font_color_alt ) );
	}

	echo '}';

}

if ( $blog_pagination_background_color_active || $blog_pagination_font_color_active ) {

	echo '.pagination .page-numbers.current {';

	if ( $blog_pagination_background_color_active ) {
		echo sprintf( 'background: %s;', esc_attr( $blog_pagination_background_color_active ) . '!important' );
	}

	if ( $blog_pagination_font_color_active ) {
		echo sprintf( 'color: %s;', esc_attr( $blog_pagination_font_color_active ) );
	}

	echo '}';

}

/* Blog Layouts */

$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	// Custom width.
	$custom_width = ( $val = get_theme_mod( $archive . '_custom_width' ) ) === '1200px' ? false : $val;

	// All archives.
	if ( 'archive' === $custom_width && $archive ) {

		echo '.blog #inner-content,';
		echo '.search #inner-content,';
		echo '.' . $archive . ' #inner-content {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

	// Custom post type archives & taxonomies.
	} elseif ( $custom_width && strpos( $archive, '-' ) ) {

		$cpt = substr( $archive, 0, strpos( $archive, '-' ) );

		echo '.tax-' . $cpt . '_category #inner-content,';
		echo '.tax-' . $cpt . '_tag #inner-content,';
		echo '.post-type-archive-' . $cpt . ' #inner-content {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

	// Other archives.
	} elseif ( $custom_width ) {

		echo '.' . $archive . ' #inner-content {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

	}

	$layout            = get_theme_mod( $archive . '_layout' );
	$style             = get_theme_mod( $archive . '_post_style', 'plain' );
	$content_alignment = get_theme_mod( $archive . '_post_content_alignment', 'left' );
	$accent_color      = get_theme_mod( $archive . '_post_accent_color' );
	$accent_color_alt  = get_theme_mod( $archive . '_post_accent_color_alt' );
	$space_between     = ( $val = get_theme_mod( $archive . '_post_space_between' ) ) === '20' ? false : $val;
	$title_size        = get_theme_mod( $archive . '_post_title_size' );
	$font_size         = get_theme_mod( $archive . '_post_font_size' );
	$stretched         = get_theme_mod( $archive . '_boxed_image_streched', false );

	// General layout settings.
	if ( $content_alignment ) {

		echo '.wpbf-' . $archive . '-content .wpbf-post {';
		echo sprintf( 'text-align: %s;', esc_attr( $content_alignment ) );
		echo '}';

	}

	if ( $accent_color ) {

		echo '.wpbf-' . $archive . '-content .wpbf-post a:not(.wpbf-read-more) {';
		echo sprintf( 'color: %s;', esc_attr( $accent_color ) );
		echo '}';

	}

	if ( $accent_color_alt ) {

		echo '.wpbf-' . $archive . '-content .wpbf-post a:not(.wpbf-read-more):hover {';
		echo sprintf( 'color: %s;', esc_attr( $accent_color_alt ) );
		echo '}';

	}

	if ( $title_size ) {

		$suffix = is_numeric( $title_size ) ? 'px' : '';

		echo '.wpbf-' . $archive . '-content .wpbf-post .entry-title {';
		echo sprintf( 'font-size: %s;', esc_attr( $title_size ) . $suffix );
		echo '}';

	}

	if ( $font_size ) {

		$suffix = is_numeric( $font_size ) ? 'px' : '';

		echo '.wpbf-' . $archive . '-content .wpbf-post .entry-summary {';
		echo sprintf( 'font-size: %s;', esc_attr( $font_size ) . $suffix );
		echo '}';

	}

	if ( 'plain' === $style && $space_between ) {

		echo '.wpbf-' . $archive . '-content .wpbf-post-style-plain {';
		echo sprintf( 'margin-bottom: %s;', esc_attr( $space_between ) . 'px' );
		echo sprintf( 'padding-bottom: %s;', esc_attr( $space_between ) . 'px' );
		echo '}';

	}

	// Boxed
	if ( 'boxed' === $style ) {

		$background_color = ( $val = get_theme_mod( $archive . '_post_background_color' ) ) === '#f5f5f7' ? false : $val;

		if ( $background_color ) {

			echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed {';
			echo sprintf( 'background-color: %s;', esc_attr( $background_color ) );
			echo '}';

		}

		if ( $space_between ) {

			echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed {';
			echo sprintf( 'margin-bottom: %s;', esc_attr( $space_between ) . 'px' );
			echo '}';

		}

		$boxed_padding_top_desktop    = get_theme_mod( $archive . '_boxed_padding_top_desktop' );
		$boxed_padding_right_desktop  = get_theme_mod( $archive . '_boxed_padding_right_desktop' );
		$boxed_padding_bottom_desktop = get_theme_mod( $archive . '_boxed_padding_bottom_desktop' );
		$boxed_padding_left_desktop   = get_theme_mod( $archive . '_boxed_padding_left_desktop' );
		$boxed_padding_top_tablet     = get_theme_mod( $archive . '_boxed_padding_top_tablet' );
		$boxed_padding_right_tablet   = get_theme_mod( $archive . '_boxed_padding_right_tablet' );
		$boxed_padding_bottom_tablet  = get_theme_mod( $archive . '_boxed_padding_bottom_tablet' );
		$boxed_padding_left_tablet    = get_theme_mod( $archive . '_boxed_padding_left_tablet' );
		$boxed_padding_top_mobile     = get_theme_mod( $archive . '_boxed_padding_top_mobile' );
		$boxed_padding_right_mobile   = get_theme_mod( $archive . '_boxed_padding_right_mobile' );
		$boxed_padding_bottom_mobile  = get_theme_mod( $archive . '_boxed_padding_bottom_mobile' );
		$boxed_padding_left_mobile    = get_theme_mod( $archive . '_boxed_padding_left_mobile' );

		if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop ) {

			echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed {';

			if ( $boxed_padding_top_desktop ) {
				echo sprintf( 'padding-top: %s;', esc_attr( $boxed_padding_top_desktop ) . 'px' );
			}

			if ( $boxed_padding_right_desktop ) {
				echo sprintf( 'padding-right: %s;', esc_attr( $boxed_padding_right_desktop ) . 'px' );
			}

			if ( $boxed_padding_bottom_desktop ) {
				echo sprintf( 'padding-bottom: %s;', esc_attr( $boxed_padding_bottom_desktop ) . 'px' );
			}

			if ( $boxed_padding_left_desktop ) {
				echo sprintf( 'padding-left: %s;', esc_attr( $boxed_padding_left_desktop ) . 'px' );
			}

			echo '}';

			if ( $stretched && 'beside' !== $layout ) {

				echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper {';

				if ( $boxed_padding_left_desktop ) {
					echo sprintf( 'margin-left: -%s;', esc_attr( $boxed_padding_left_desktop ) . 'px' );
				}

				if ( $boxed_padding_right_desktop ) {
					echo sprintf( 'margin-right: -%s;', esc_attr( $boxed_padding_right_desktop ) . 'px' );
				}

				echo '}';

				echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child {';

				if ( $boxed_padding_top_desktop ) {

					echo sprintf( 'margin-top: -%s;', esc_attr( $boxed_padding_top_desktop ) . 'px' );
					echo sprintf( 'margin-bottom: %s;', esc_attr( $boxed_padding_top_desktop ) . 'px' );

				}

				echo '}';

			}

		}

		if ( $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet ) {

			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ') {';

			echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed {';

			if ( $boxed_padding_top_tablet ) {
				echo sprintf( 'padding-top: %s;', esc_attr( $boxed_padding_top_tablet ) . 'px' );
			}

			if ( $boxed_padding_right_tablet ) {
				echo sprintf( 'padding-right: %s;', esc_attr( $boxed_padding_right_tablet ) . 'px' );
			}

			if ( $boxed_padding_bottom_tablet ) {
				echo sprintf( 'padding-bottom: %s;', esc_attr( $boxed_padding_bottom_tablet ) . 'px' );
			}

			if ( $boxed_padding_left_tablet ) {
				echo sprintf( 'padding-left: %s;', esc_attr( $boxed_padding_left_tablet ) . 'px' );
			}

			echo '}';

			if ( $stretched && 'beside' !== $layout ) {

				echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper {';

				if ( $boxed_padding_left_tablet ) {
					echo sprintf( 'margin-left: -%s;', esc_attr( $boxed_padding_left_tablet ) . 'px' );
				}

				if ( $boxed_padding_right_tablet ) {
					echo sprintf( 'margin-right: -%s;', esc_attr( $boxed_padding_right_tablet ) . 'px' );
				}

				echo '}';

				echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child {';

				if ( $boxed_padding_top_tablet ) {

					echo sprintf( 'margin-top: -%s;', esc_attr( $boxed_padding_top_tablet ) . 'px' );
					echo sprintf( 'margin-bottom: %s;', esc_attr( $boxed_padding_top_tablet ) . 'px' );

				}

				echo '}';

			}

			echo '}';

		}

		if ( $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';

			echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed {';

			if ( $boxed_padding_top_mobile ) {
				echo sprintf( 'padding-top: %s;', esc_attr( $boxed_padding_top_mobile ) . 'px' );
			}

			if ( $boxed_padding_right_mobile ) {
				echo sprintf( 'padding-right: %s;', esc_attr( $boxed_padding_right_mobile ) . 'px' );
			}

			if ( $boxed_padding_bottom_mobile ) {
				echo sprintf( 'padding-bottom: %s;', esc_attr( $boxed_padding_bottom_mobile ) . 'px' );
			}

			if ( $boxed_padding_left_mobile ) {
				echo sprintf( 'padding-left: %s;', esc_attr( $boxed_padding_left_mobile ) . 'px' );
			}

			echo '}';

			if ( $stretched && 'beside' !== $layout ) {

				echo '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper {';

				if ( $boxed_padding_left_mobile ) {
					echo sprintf( 'margin-left: -%s;', esc_attr( $boxed_padding_left_mobile ) . 'px' );
				}

				if ( $boxed_padding_right_mobile ) {
					echo sprintf( 'margin-right: -%s;', esc_attr( $boxed_padding_right_mobile ) . 'px' );
				}

				echo '}';

				echo '.wpbf-' . $archive . '-content  .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child {';

				if ( $boxed_padding_top_mobile ) {

					echo sprintf( 'margin-top: -%s;', esc_attr( $boxed_padding_top_mobile ) . 'px' );
					echo sprintf( 'margin-bottom: %s;', esc_attr( $boxed_padding_top_mobile ) . 'px' );

				}

				echo '}';

			}

			echo '}';

		}

	}

	// Beside
	if ( 'beside' === $layout ) {

		$image_width     = ( $val = get_theme_mod( $archive . '_post_image_width' ) ) === '40' ? false : $val;
		$image_alignment = get_theme_mod( $archive . '_post_image_alignment', 'left' );

		if ( $image_width ) {

			echo '@media (min-width: ' . esc_attr( $breakpoint_desktop_int + 1 ) . 'px) {';

			echo '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-large-2-5 {';
			echo sprintf( 'width: %s;', esc_attr( $image_width ) . '%' );
			echo '}';

			echo '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-large-3-5 {';
			echo sprintf( 'width: %s;', 100 - esc_attr( $image_width ) . '%' );
			echo '}';

			echo '}';

		}

		if ( $image_alignment ) {

			echo '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-grid {';

			if ( 'left' === $image_alignment ) {
				echo 'flex-direction: row;';
			}

			if ( 'right' === $image_alignment ) {
				echo 'flex-direction: row-reverse;';
			}

			echo '}';

		}

	}

}

/* Single */

$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

foreach ( $singles as $single ) {

	$custom_width = ( $val = get_theme_mod( $single . '_custom_width' ) ) === '1200px' ? false : $val;
	$style        = get_theme_mod( $single . '_post_style' );
	$title_size   = get_theme_mod( $single . '_post_title_size' );
	$font_size    = get_theme_mod( $single . '_post_font_size' );
	// $content_alignment = get_theme_mod( $single . '_post_content_alignment', 'left' );

	if ( $custom_width ) {

		$pt = 'single' === $single ? 'post' : $single;

		echo '.single-' . $pt . ' #inner-content {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

	}

	// General Layout Settings
	// if( $content_alignment ) {

	// 	echo '.wpbf-' . $single . '-content .wpbf-post {';
	// 	echo sprintf( 'text-align: %s;', esc_attr( $content_alignment ) );
	// 	echo '}';

	// }

	if ( $title_size ) {

		$suffix = is_numeric( $title_size ) ? 'px' : '';

		echo '.wpbf-' . $single . '-content .wpbf-post .entry-title {';
		echo sprintf( 'font-size: %s;', esc_attr( $title_size ) . $suffix );
		echo '}';

	}

	if ( $font_size ) {

		$suffix = is_numeric( $font_size ) ? 'px' : '';

		echo '.wpbf-' . $single . '-content .wpbf-post .entry-content {';
		echo sprintf( 'font-size: %s;', esc_attr( $font_size ) . $suffix );
		echo '}';

	}

	// Boxed
	if ( 'boxed' === $style ) {

		$background_color = ( $val = get_theme_mod( $single . '_post_background_color' ) ) === '#f5f5f7' ? false : $val;

		if ( $background_color ) {

			echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond {';
			echo sprintf( 'background: %s;', esc_attr( $background_color ) );
			echo '}';

		}

		$stretched                    = get_theme_mod( $single . '_boxed_image_stretched', false );
		$boxed_padding_top_desktop    = get_theme_mod( $single . '_boxed_padding_top_desktop' );
		$boxed_padding_right_desktop  = get_theme_mod( $single . '_boxed_padding_right_desktop' );
		$boxed_padding_bottom_desktop = get_theme_mod( $single . '_boxed_padding_bottom_desktop' );
		$boxed_padding_left_desktop   = get_theme_mod( $single . '_boxed_padding_left_desktop' );
		$boxed_padding_top_tablet     = get_theme_mod( $single . '_boxed_padding_top_tablet' );
		$boxed_padding_right_tablet   = get_theme_mod( $single . '_boxed_padding_right_tablet' );
		$boxed_padding_bottom_tablet  = get_theme_mod( $single . '_boxed_padding_bottom_tablet' );
		$boxed_padding_left_tablet    = get_theme_mod( $single . '_boxed_padding_left_tablet' );
		$boxed_padding_top_mobile     = get_theme_mod( $single . '_boxed_padding_top_mobile' );
		$boxed_padding_right_mobile   = get_theme_mod( $single . '_boxed_padding_right_mobile' );
		$boxed_padding_bottom_mobile  = get_theme_mod( $single . '_boxed_padding_bottom_mobile' );
		$boxed_padding_left_mobile    = get_theme_mod( $single . '_boxed_padding_left_mobile' );

		if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop ) {

			echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond {';

			if ( $boxed_padding_top_desktop ) {
				echo sprintf( 'padding-top: %s;', esc_attr( $boxed_padding_top_desktop ) . 'px' );
			}

			if ( $boxed_padding_right_desktop ) {
				echo sprintf( 'padding-right: %s;', esc_attr( $boxed_padding_right_desktop ) . 'px' );
			}

			if ( $boxed_padding_bottom_desktop ) {
				echo sprintf( 'padding-bottom: %s;', esc_attr( $boxed_padding_bottom_desktop ) . 'px' );
			}

			if ( $boxed_padding_left_desktop ) {
				echo sprintf( 'padding-left: %s;', esc_attr( $boxed_padding_left_desktop ) . 'px' );
			}

			echo '}';

			if ( $stretched ) {

				echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper {';

				if ( $boxed_padding_left_desktop ) {
					echo sprintf( 'margin-left: -%s;', esc_attr( $boxed_padding_left_desktop ) . 'px' );
				}

				if ( $boxed_padding_right_desktop ) {
					echo sprintf( 'margin-right: -%s;', esc_attr( $boxed_padding_right_desktop ) . 'px' );
				}

				echo '}';

				echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child {';

				if ( $boxed_padding_top_desktop ) {

					echo sprintf( 'margin-top: -%s;', esc_attr( $boxed_padding_top_desktop ) . 'px' );
					echo sprintf( 'margin-bottom: %s;', esc_attr( $boxed_padding_top_desktop ) . 'px' );

				}

				echo '}';

			}

		}

		if ( $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet ) {

			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ') {';

			echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond {';

			if ( $boxed_padding_top_tablet ) {
				echo sprintf( 'padding-top: %s;', esc_attr( $boxed_padding_top_tablet ) . 'px' );
			}

			if ( $boxed_padding_right_tablet ) {
				echo sprintf( 'padding-right: %s;', esc_attr( $boxed_padding_right_tablet ) . 'px' );
			}

			if ( $boxed_padding_bottom_tablet ) {
				echo sprintf( 'padding-bottom: %s;', esc_attr( $boxed_padding_bottom_tablet ) . 'px' );
			}

			if ( $boxed_padding_left_tablet ) {
				echo sprintf( 'padding-left: %s;', esc_attr( $boxed_padding_left_tablet ) . 'px' );
			}

			echo '}';

			if ( $stretched ) {

				echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper {';

				if ( $boxed_padding_left_tablet ) {
					echo sprintf( 'margin-left: -%s;', esc_attr( $boxed_padding_left_tablet ) . 'px' );
				}

				if ( $boxed_padding_right_tablet ) {
					echo sprintf( 'margin-right: -%s;', esc_attr( $boxed_padding_right_tablet ) . 'px' );
				}

				echo '}';

				echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child {';

				if ( $boxed_padding_top_tablet ) {

					echo sprintf( 'margin-top: -%s;', esc_attr( $boxed_padding_top_tablet ) . 'px' );
					echo sprintf( 'margin-bottom: %s;', esc_attr( $boxed_padding_top_tablet ) . 'px' );

				}

				echo '}';

			}

			echo '}';

		}

		if ( $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';

			echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond {';

			if ( $boxed_padding_top_mobile ) {
				echo sprintf( 'padding-top: %s;', esc_attr( $boxed_padding_top_mobile ) . 'px' );
			}

			if ( $boxed_padding_right_mobile ) {
				echo sprintf( 'padding-right: %s;', esc_attr( $boxed_padding_right_mobile ) . 'px' );
			}

			if ( $boxed_padding_bottom_mobile ) {
				echo sprintf( 'padding-bottom: %s;', esc_attr( $boxed_padding_bottom_mobile ) . 'px' );
			}

			if ( $boxed_padding_left_mobile ) {
				echo sprintf( 'padding-left: %s;', esc_attr( $boxed_padding_left_mobile ) . 'px' );
			}

			echo '}';

			if ( $stretched ) {

				echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper {';

				if ( $boxed_padding_left_mobile ) {
					echo sprintf( 'margin-left: -%s;', esc_attr( $boxed_padding_left_mobile ) . 'px' );
				}

				if ( $boxed_padding_right_mobile ) {
					echo sprintf( 'margin-right: -%s;', esc_attr( $boxed_padding_right_mobile ) . 'px' );
				}

				echo '}';

				echo '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child {';

				if ( $boxed_padding_top_mobile ) {

					echo sprintf( 'margin-top: -%s;', esc_attr( $boxed_padding_top_mobile ) . 'px' );
					echo sprintf( 'margin-bottom: %s;', esc_attr( $boxed_padding_top_mobile ) . 'px' );

				}

				echo '}';

			}

			echo '}';

		}

	}

}

/* Header */

// Logo container.
$menu_logo_container_width        = ( $val = get_theme_mod( 'menu_logo_container_width' ) ) === '25' ? false : $val;
$mobile_menu_logo_container_width = ( $val = get_theme_mod( 'mobile_menu_logo_container_width' ) ) === '66' ? false : $val;

if ( $menu_logo_container_width ) {

	echo '.wpbf-navigation .wpbf-1-4 {';
	echo sprintf( 'width: %s;', esc_attr( $menu_logo_container_width ) . '%' );
	echo '}';

	echo '.wpbf-navigation .wpbf-3-4 {';
	echo sprintf( 'width: %s;', 100 - esc_attr( $menu_logo_container_width ) . '%' );
	echo '}';

}

if ( $mobile_menu_logo_container_width ) {

	echo '.wpbf-navigation .wpbf-2-3 {';
	echo sprintf( 'width: %s;', esc_attr( $mobile_menu_logo_container_width ) . '%' );
	echo '}';

	echo '.wpbf-navigation .wpbf-1-3 {';
	echo sprintf( 'width: %s;', 100 - esc_attr( $mobile_menu_logo_container_width ) . '%' );
	echo '}';

}

// Logo.
$custom_logo                 = get_theme_mod( 'custom_logo' );
$menu_logo_font_toggle       = get_theme_mod( 'menu_logo_font_toggle' );
$menu_logo_font_size_desktop = ( $val = get_theme_mod( 'menu_logo_font_size_desktop' ) ) === '22px' ? false : $val;
$menu_logo_font_size_tablet  = get_theme_mod( 'menu_logo_font_size_tablet' );
$menu_logo_font_size_mobile  = get_theme_mod( 'menu_logo_font_size_mobile' );
$menu_logo_color             = get_theme_mod( 'menu_logo_color' );
$menu_logo_font_family_value = get_theme_mod( 'menu_logo_font_family' );
$menu_logo_color_alt         = get_theme_mod( 'menu_logo_color_alt' );
$menu_logo_size              = get_theme_mod( 'menu_logo_size' ); // Backwards compatibility.
$menu_mobile_logo_size       = get_theme_mod( 'menu_mobile_logo_size' ); // Backwards compatibility.
$menu_logo_size_desktop      = get_theme_mod( 'menu_logo_size_desktop' );
$menu_logo_size_tablet       = get_theme_mod( 'menu_logo_size_tablet' );
$menu_logo_size_mobile       = get_theme_mod( 'menu_logo_size_mobile' );

if ( ! $custom_logo ) {

	if ( $menu_logo_font_toggle && $menu_logo_font_family_value ) {

		echo '.wpbf-logo a, .wpbf-mobile-logo a {';

		if ( ! empty( $menu_logo_font_family_value['font-family'] ) ) {

			if ( false !== strpos( $menu_logo_font_family_value['font-family'], ' ' ) && false === strpos( $menu_logo_font_family_value['font-family'], '"' ) && false === strpos( $menu_logo_font_family_value['font-family'], ',' ) ) {
				$menu_logo_font_family_value['font-family'] = '"' . $menu_logo_font_family_value['font-family'] . '"';
			}

			echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $menu_logo_font_family_value['font-family'] ), ENT_QUOTES ) );

		}

		if ( ! empty( $menu_logo_font_family_value['variant'] ) ) {

			$menu_logo_font_family_font_weight = str_replace( 'italic', '', $menu_logo_font_family_value['variant'] );
			$menu_logo_font_family_font_weight = ( in_array( $menu_logo_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $menu_logo_font_family_font_weight;

			$menu_logo_font_family_is_italic  = ( false !== strpos( $menu_logo_font_family_value['variant'], 'italic' ) );
			$menu_logo_font_family_font_style = $menu_logo_font_family_is_italic ? 'italic' : 'normal';

			echo sprintf( 'font-weight: %s;', esc_attr( $menu_logo_font_family_font_weight ) );
			echo sprintf( 'font-style: %s;', esc_attr( $menu_logo_font_family_font_style ) );

		}

		if ( ! empty( $menu_logo_font_family_value['color'] ) ) {
			echo sprintf( 'color: %s;', esc_attr( $menu_logo_font_family_value['color'] ) );
		}

		echo '}';

	}

	if ( $menu_logo_color ) {

		echo '.wpbf-logo a, .wpbf-mobile-logo a {';
		echo sprintf( 'color: %s;', esc_attr( $menu_logo_color ) );
		echo '}';

	}

	if ( $menu_logo_color_alt ) {

		echo '.wpbf-logo a:hover, .wpbf-mobile-logo a:hover {';
		echo sprintf( 'color: %s;', esc_attr( $menu_logo_color_alt ) );
		echo '}';

	}

	if ( $menu_logo_font_size_desktop ) {

		$suffix = is_numeric( $menu_logo_font_size_desktop ) ? 'px' : '';

		echo '.wpbf-logo a, .wpbf-mobile-logo a {';
		echo sprintf( 'font-size: %s;', esc_attr( $menu_logo_font_size_desktop ) . $suffix );
		echo '}';

	}

	if ( $menu_logo_font_size_tablet ) {

		$suffix = is_numeric( $menu_logo_font_size_tablet ) ? 'px' : '';

		echo '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ') {';
		echo '.wpbf-logo a, .wpbf-mobile-logo a {';
		echo sprintf( 'font-size: %s;', esc_attr( $menu_logo_font_size_tablet ) . $suffix );
		echo '}';
		echo '}';

	}

	if ( $menu_logo_font_size_mobile ) {

		$suffix = is_numeric( $menu_logo_font_size_mobile ) ? 'px' : '';

		echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';
		echo '.wpbf-logo a, .wpbf-mobile-logo a {';
		echo sprintf( 'font-size: %s;', esc_attr( $menu_logo_font_size_mobile ) . $suffix );
		echo '}';
		echo '}';

	}

}

if ( $custom_logo ) {

	// Backwards compatibility.
	if ( $menu_logo_size && ! $menu_logo_size_desktop ) {

		echo '.wpbf-logo img {';
		echo sprintf( 'height: %s;', esc_attr( $menu_logo_size ) . 'px' );
		echo '}';

	}

	// Backwards compatibility.
	if ( $menu_mobile_logo_size && ! $menu_logo_size_tablet && ! $menu_logo_size_mobile ) {

		echo '.wpbf-mobile-logo img {';
		echo sprintf( 'height: %s;', esc_attr( $menu_mobile_logo_size ) . 'px' );
		echo '}';

	}

	if ( $menu_logo_size_desktop ) {

		$suffix = is_numeric( $menu_logo_size_desktop ) ? 'px' : '';

		echo '.wpbf-logo img, .wpbf-mobile-logo img {';
		echo sprintf( 'width: %s;', esc_attr( $menu_logo_size_desktop ) . $suffix );
		echo '}';

	}

	if ( $menu_logo_size_tablet ) {

		$suffix = is_numeric( $menu_logo_size_tablet ) ? 'px' : '';

		echo '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ') {';
		echo '.wpbf-mobile-logo img {';
		echo sprintf( 'width: %s;', esc_attr( $menu_logo_size_tablet ) . $suffix );
		echo '}';
		echo '}';

	}

	if ( $menu_logo_size_mobile ) {

		$suffix = is_numeric( $menu_logo_size_mobile ) ? 'px' : '';

		echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';
		echo '.wpbf-mobile-logo img {';
		echo sprintf( 'width: %s;', esc_attr( $menu_logo_size_mobile ) . $suffix );
		echo '}';
		echo '}';

	}

}

// Tagline.
$menu_logo_description                   = get_theme_mod( 'menu_logo_description' );
$menu_logo_description_toggle            = get_theme_mod( 'menu_logo_description_toggle' );
$menu_logo_description_font_size_desktop = get_theme_mod( 'menu_logo_description_font_size_desktop' );
$menu_logo_description_font_size_tablet  = get_theme_mod( 'menu_logo_description_font_size_tablet' );
$menu_logo_description_font_size_mobile  = get_theme_mod( 'menu_logo_description_font_size_mobile' );
$menu_logo_description_color             = get_theme_mod( 'menu_logo_description_color' );
$menu_logo_description_font_family_value = get_theme_mod( 'menu_logo_description_font_family' );

if ( ! $custom_logo && $menu_logo_description ) {

	if ( $menu_logo_description_toggle && $menu_logo_description_font_family_value ) {

		echo '.wpbf-tagline {';

		if ( ! empty( $menu_logo_description_font_family_value['font-family'] ) ) {

			if ( false !== strpos( $menu_logo_description_font_family_value['font-family'], ' ' ) && false === strpos( $menu_logo_description_font_family_value['font-family'], '"' ) && false === strpos( $menu_logo_description_font_family_value['font-family'], ',' ) ) {
				$menu_logo_description_font_family_value['font-family'] = '"' . $menu_logo_description_font_family_value['font-family'] . '"';
			}

			echo sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $menu_logo_description_font_family_value['font-family'] ), ENT_QUOTES ) );
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
$menu_position       = get_theme_mod( 'menu_position' );
$menu_width          = ( $val = get_theme_mod( 'menu_width' ) ) === '1200px' ? false : $val;
$menu_height         = ( $val = get_theme_mod( 'menu_height' ) ) === '20' ? false : $val;
$menu_padding        = ( $val = get_theme_mod( 'menu_padding' ) ) === '20' ? false : $val;
$menu_bg_color       = ( $val = get_theme_mod( 'menu_bg_color' ) ) === '#f5f5f7' ? false : $val;
$menu_font_color     = get_theme_mod( 'menu_font_color' );
$menu_font_color_alt = get_theme_mod( 'menu_font_color_alt' );
$menu_font_size      = ( $val = get_theme_mod( 'menu_font_size' ) ) === '16px' ? false : $val;

if ( $menu_width || $menu_height ) {

	echo '.wpbf-nav-wrapper {';

	if ( $menu_width ) {
		echo sprintf( 'max-width: %s;', esc_attr( $menu_width ) );
	}

	if ( $menu_height ) {

		echo sprintf( 'padding-top: %s;', esc_attr( $menu_height ) . 'px' );
		echo sprintf( 'padding-bottom: %s;', esc_attr( $menu_height ) . 'px' );

	}

	echo '}';

}

if ( $menu_height && 'menu-stacked' === $menu_position ) {

	echo '.wpbf-menu-stacked nav {';
	echo sprintf( 'margin-top: %s;', esc_attr( $menu_height ) . 'px' );
	echo '}';

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

if ( $menu_font_color ) {

	echo '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close {';
	echo sprintf( 'color: %s;', esc_attr( $menu_font_color ) );
	echo '}';

}

if ( $menu_font_color_alt ) {

	echo '.wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $menu_font_color_alt ) );
	echo '}';

	echo '.wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a {';
	echo sprintf( 'color: %s;', esc_attr( $menu_font_color_alt ) . '!important' );
	echo '}';

}

if ( $menu_font_size ) {

	$suffix = is_numeric( $menu_font_size ) ? 'px' : '';
	echo '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a {';
	echo sprintf( 'font-size: %s;', esc_attr( $menu_font_size ) . $suffix );
	echo '}';

}

// Sub menu.
$sub_menu_bg_color         = ( $val = get_theme_mod( 'sub_menu_bg_color' ) ) === '#ffffff' ? false : $val;
$sub_menu_bg_color_alt     = get_theme_mod( 'sub_menu_bg_color_alt' );
$sub_menu_width            = ( $val = get_theme_mod( 'sub_menu_width' ) ) === '220' ? false : $val;
$sub_menu_padding_top      = ( $val = get_theme_mod( 'sub_menu_padding_top' ) ) === 10 ? false : $val;
$sub_menu_padding_right    = ( $val = get_theme_mod( 'sub_menu_padding_right' ) ) === 20 ? false : $val;
$sub_menu_padding_bottom   = ( $val = get_theme_mod( 'sub_menu_padding_bottom' ) ) === 10 ? false : $val;
$sub_menu_padding_left     = ( $val = get_theme_mod( 'sub_menu_padding_left' ) ) === 20 ? false : $val;
$sub_menu_accent_color     = get_theme_mod( 'sub_menu_accent_color' );
$sub_menu_font_size        = get_theme_mod( 'sub_menu_font_size' );
$sub_menu_accent_color_alt = get_theme_mod( 'sub_menu_accent_color_alt' );
$sub_menu_separator        = get_theme_mod( 'sub_menu_separator' );
$sub_menu_separator_color  = ( $val = get_theme_mod( 'sub_menu_separator_color' ) ) === '#f5f5f7' ? false : $val;

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
$mobile_menu_padding_top             = ( $val = get_theme_mod( 'mobile_menu_padding_top' ) ) === 10 ? false : $val;
$mobile_menu_padding_right           = ( $val = get_theme_mod( 'mobile_menu_padding_right' ) ) === 20 ? false : $val;
$mobile_menu_padding_bottom          = ( $val = get_theme_mod( 'mobile_menu_padding_bottom' ) ) === 10 ? false : $val;
$mobile_menu_padding_left            = ( $val = get_theme_mod( 'mobile_menu_padding_left' ) ) === 20 ? false : $val;
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

if ( $mobile_menu_height ) {

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
	echo '.wpbf-mobile-menu a {';
	echo sprintf( 'font-size: %s;', esc_attr( $mobile_menu_font_size ) . $suffix );
	echo '}';

}

// Pre header.
$pre_header_layout           = get_theme_mod( 'pre_header_layout' );
$pre_header_width            = ( $val = get_theme_mod( 'pre_header_width' ) ) === '1200px' ? false : $val;
$pre_header_height           = ( $val = get_theme_mod( 'pre_header_height' ) ) === '10' ? false : $val;
$pre_header_bg_color         = ( $val = get_theme_mod( 'pre_header_bg_color' ) ) === '#ffffff' ? false : $val;
$pre_header_font_color       = get_theme_mod( 'pre_header_font_color' );
$pre_header_accent_color     = get_theme_mod( 'pre_header_accent_color' );
$pre_header_accent_color_alt = get_theme_mod( 'pre_header_accent_color_alt' );
$pre_header_font_size        = ( $val = get_theme_mod( 'pre_header_font_size' ) ) === '14px' ? false : $val;

if ( 'none' !== $pre_header_layout && ( $pre_header_height || $pre_header_width ) ) {

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

if ( 'none' !== $pre_header_layout && ( $pre_header_bg_color || $pre_header_font_color ) ) {

	echo '.wpbf-pre-header {';

	if ( $pre_header_bg_color ) {
		echo sprintf( 'background-color: %s;', esc_attr( $pre_header_bg_color ) );
	}

	if ( $pre_header_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $pre_header_font_color ) );
	}

	echo '}';

}

if ( 'none' !== $pre_header_layout && $pre_header_accent_color ) {

	echo '.wpbf-pre-header a {';
	echo sprintf( 'color: %s;', esc_attr( $pre_header_accent_color ) );
	echo '}';

}

if ( 'none' !== $pre_header_layout && $pre_header_accent_color_alt ) {

	echo '.wpbf-pre-header a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $pre_header_accent_color_alt ) );
	echo '}';

	echo '.wpbf-pre-header .wpbf-menu > .current-menu-item > a {';
	echo sprintf( 'color: %s;', esc_attr( $pre_header_accent_color_alt ) . '!important' );
	echo '}';

}

if ( 'none' !== $pre_header_layout && $pre_header_font_size ) {

	$suffix = is_numeric( $pre_header_font_size ) ? 'px' : '';
	echo '.wpbf-pre-header, .wpbf-pre-header .wpbf-menu, .wpbf-pre-header .wpbf-menu .sub-menu a {';
	echo sprintf( 'font-size: %s;', esc_attr( $pre_header_font_size ) . $suffix );
	echo '}';

}

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
