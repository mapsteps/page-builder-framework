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

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $page_font_family_value['font-family'] ) );

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

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $menu_font_family_value['font-family'] ) );

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

// Sub Menu font settings.
$sub_menu_font_family_toggle = get_theme_mod( 'sub_menu_font_family_toggle' );
$sub_menu_font_family_value  = get_theme_mod( 'sub_menu_font_family' );

if ( $sub_menu_font_family_toggle && $sub_menu_font_family_value ) {

	echo '.wpbf-menu .sub-menu, .wpbf-mobile-menu .sub-menu {';

	if ( ! empty( $sub_menu_font_family_value['font-family'] ) ) {

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $sub_menu_font_family_value['font-family'] ) );

	}

	if ( ! empty( $sub_menu_font_family_value['variant'] ) ) {

		$sub_menu_font_family_font_weight = str_replace( 'italic', '', $sub_menu_font_family_value['variant'] );
		$sub_menu_font_family_font_weight = ( in_array( $sub_menu_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $sub_menu_font_family_font_weight;

		$sub_menu_font_family_is_italic = ( false !== strpos( $sub_menu_font_family_value['variant'], 'italic' ) );
		$sub_menu_font_family_is_style  = $sub_menu_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $sub_menu_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $sub_menu_font_family_is_style ) );

	}

	echo '}';

}

// H1 font settings.
$page_h1_toggle            = get_theme_mod( 'page_h1_toggle' );
$page_h1_font_family_value = get_theme_mod( 'page_h1_font_family' );

if ( $page_h1_toggle && $page_h1_font_family_value ) {

	echo 'h1, h2, h3, h4, h5, h6 {';

	if ( ! empty( $page_h1_font_family_value['font-family'] ) ) {

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $page_h1_font_family_value['font-family'] ) );

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

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $page_h2_font_family_value['font-family'] ) );

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

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $page_h3_font_family_value['font-family'] ) );

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

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $page_h4_font_family_value['font-family'] ) );

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

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $page_h5_font_family_value['font-family'] ) );

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

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $page_h6_font_family_value['font-family'] ) );

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

// Footer font settings.
$footer_font_toggle       = get_theme_mod( 'footer_font_toggle' );
$footer_font_family_value = get_theme_mod( 'footer_font_family' );

if ( $footer_font_toggle && $footer_font_family_value ) {

	echo '.wpbf-page-footer {';

	if ( ! empty( $footer_font_family_value['font-family'] ) ) {

		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $footer_font_family_value['font-family'] ) );

	}

	if ( ! empty( $footer_font_family_value['variant'] ) ) {

		$footer_font_family_font_weight = str_replace( 'italic', '', $footer_font_family_value['variant'] );
		$footer_font_family_font_weight = ( in_array( $footer_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $footer_font_family_font_weight;

		$footer_font_family_is_italic = ( false !== strpos( $footer_font_family_value['variant'], 'italic' ) );
		$footer_font_family_is_style  = $footer_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $footer_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $footer_font_family_is_style ) );

	}

	echo '}';

}

/* General */

wpbf_css_area( 'general' );

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
	$custom_width = get_theme_mod( $archive . '_custom_width' );

	// All archives.
	if ( 'archive' === $archive && $custom_width ) {

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
	$style             = wpbf_mod( $archive . '_post_style' );
	$content_alignment = wpbf_mod( $archive . '_post_content_alignment' );
	$accent_color      = get_theme_mod( $archive . '_post_accent_color' );
	$accent_color_alt  = get_theme_mod( $archive . '_post_accent_color_alt' );
	$space_between     = ( $val = get_theme_mod( $archive . '_post_space_between' ) ) === '20' ? false : $val;
	$title_size        = get_theme_mod( $archive . '_post_title_size' );
	$font_size         = get_theme_mod( $archive . '_post_font_size' );
	$stretched         = wpbf_mod( $archive . '_boxed_image_streched' );

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

		$boxed_padding                = json_decode( get_theme_mod( $archive . '_boxed_padding' ), true );
		$boxed_padding_top_desktop    = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_top' );
		$boxed_padding_right_desktop  = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_right' );
		$boxed_padding_bottom_desktop = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_bottom' );
		$boxed_padding_left_desktop   = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_left' );
		$boxed_padding_top_tablet     = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_top' );
		$boxed_padding_right_tablet   = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_right' );
		$boxed_padding_bottom_tablet  = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_bottom' );
		$boxed_padding_left_tablet    = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_left' );
		$boxed_padding_top_mobile     = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_top' );
		$boxed_padding_right_mobile   = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_right' );
		$boxed_padding_bottom_mobile  = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_bottom' );
		$boxed_padding_left_mobile    = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_left' );

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
		$image_alignment = wpbf_mod( $archive . '_post_image_alignment' );

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

	$custom_width = get_theme_mod( $single . '_custom_width' );
	$style        = get_theme_mod( $single . '_post_style' );
	$title_size   = get_theme_mod( $single . '_post_title_size' );
	$font_size    = get_theme_mod( $single . '_post_font_size' );
	// $content_alignment = get_theme_mod( $single . '_post_content_alignment', 'left' );

	// All post types.
	if ( 'single' === $single && $custom_width ) {

		echo '.single #inner-content {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

		// Chang the max-width of the cover block contents.
		echo '.single .wp-block-cover .wp-block-cover__inner-container, .single .wp-block-group .wp-block-group__inner-container {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

		// Individual post types.
	} elseif ( 'single' !== $single && $custom_width ) {

		echo '.single-' . $single . ' #inner-content {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

		// Chang the max-width of the cover block contents.
		echo '.single-' . $single . ' .wp-block-cover .wp-block-cover__inner-container, .single-' . $single . ' .wp-block-group .wp-block-group__inner-container {';
		echo sprintf( 'max-width: %s;', esc_attr( $custom_width ) );
		echo '}';

	}

	// General Layout Settings
	// if ( $content_alignment ) {

	// echo '.wpbf-' . $single . '-content .wpbf-post {';
	// echo sprintf( 'text-align: %s;', esc_attr( $content_alignment ) );
	// echo '}';

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

		$stretched                    = wpbf_mod( $single . '_boxed_image_stretched' );
		$boxed_padding                = json_decode( get_theme_mod( $single . '_boxed_padding' ), true );
		$boxed_padding_top_desktop    = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_top' );
		$boxed_padding_right_desktop  = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_right' );
		$boxed_padding_bottom_desktop = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_bottom' );
		$boxed_padding_left_desktop   = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_left' );
		$boxed_padding_top_tablet     = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_top' );
		$boxed_padding_right_tablet   = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_right' );
		$boxed_padding_bottom_tablet  = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_bottom' );
		$boxed_padding_left_tablet    = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_left' );
		$boxed_padding_top_mobile     = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_top' );
		$boxed_padding_right_mobile   = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_right' );
		$boxed_padding_bottom_mobile  = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_bottom' );
		$boxed_padding_left_mobile    = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_left' );

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
$menu_logo_font_size         = json_decode( get_theme_mod( 'menu_logo_font_size' ), true );
$menu_logo_font_size_desktop = wpbf_get_theme_mod_value( $menu_logo_font_size, 'desktop', '22px' );
$menu_logo_font_size_tablet  = wpbf_get_theme_mod_value( $menu_logo_font_size, 'tablet' );
$menu_logo_font_size_mobile  = wpbf_get_theme_mod_value( $menu_logo_font_size, 'mobile' );
$menu_logo_color             = get_theme_mod( 'menu_logo_color' );
$menu_logo_font_family_value = get_theme_mod( 'menu_logo_font_family' );
$menu_logo_color_alt         = get_theme_mod( 'menu_logo_color_alt' );
$menu_logo_size              = json_decode( get_theme_mod( 'menu_logo_size' ), true );
$menu_logo_size_desktop      = wpbf_get_theme_mod_value( $menu_logo_size, 'desktop' );
$menu_logo_size_tablet       = wpbf_get_theme_mod_value( $menu_logo_size, 'tablet' );
$menu_logo_size_mobile       = wpbf_get_theme_mod_value( $menu_logo_size, 'mobile' );

if ( ! $custom_logo ) {

	if ( $menu_logo_font_toggle && $menu_logo_font_family_value ) {

		echo '.wpbf-logo a, .wpbf-mobile-logo a {';

		if ( ! empty( $menu_logo_font_family_value['font-family'] ) ) {

			echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $menu_logo_font_family_value['font-family'] ) );

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
$menu_logo_description_font_size         = json_decode( get_theme_mod( 'menu_logo_description_font_size' ), true );
$menu_logo_description_font_size_desktop = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'desktop' );
$menu_logo_description_font_size_tablet  = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'tablet' );
$menu_logo_description_font_size_mobile  = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'mobile' );
$menu_logo_description_color             = get_theme_mod( 'menu_logo_description_color' );
$menu_logo_description_font_family_value = get_theme_mod( 'menu_logo_description_font_family' );

if ( ! $custom_logo && $menu_logo_description ) {

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
$menu_position       = get_theme_mod( 'menu_position' );
$menu_width          = ( $val = get_theme_mod( 'menu_width' ) ) === '1200px' ? false : $val;
$menu_height         = ( $val = get_theme_mod( 'menu_height' ) ) === '20' ? false : $val;
$menu_padding        = ( $val = get_theme_mod( 'menu_padding' ) ) === '20' ? false : $val;
$menu_bg_color       = ( $val = get_theme_mod( 'menu_bg_color' ) ) === '#f5f5f7' ? false : $val;
$menu_font_color     = get_theme_mod( 'menu_font_color' );
$menu_font_color_alt = get_theme_mod( 'menu_font_color_alt' );
$menu_font_size      = get_theme_mod( 'menu_font_size' );

if ( $menu_width ) {

	echo '.wpbf-nav-wrapper {';
	echo sprintf( 'max-width: %s;', esc_attr( $menu_width ) );
	echo '}';

}

if ( $menu_height !== false ) {

	echo '.wpbf-nav-wrapper {';

	echo sprintf( 'padding-top: %s;', esc_attr( $menu_height ) . 'px' );
	echo sprintf( 'padding-bottom: %s;', esc_attr( $menu_height ) . 'px' );

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
$mobile_menu_options                 = wpbf_mod( 'mobile_menu_options' );
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

wpbf_css_area( 'footer' );

do_action( 'wpbf_after_customizer_css' );
