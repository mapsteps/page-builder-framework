<?php
/**
 * Gutenberg editor styles.
 *
 * @package Page Builder Framework
 * @subpackage Integration/Gutenberg
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Global colors.
$base_color_global       = ( $val = get_theme_mod( 'base_color_global' ) ) === '#f5f5f7' ? false : $val;
$base_color_alt_global   = ( $val = get_theme_mod( 'base_color_alt_global' ) ) === '#dedee5' ? false : $val;
$brand_color_global      = ( $val = get_theme_mod( 'brand_color_global' ) ) === '#3e4349' ? false : $val;
$brand_color_alt_global  = ( $val = get_theme_mod( 'brand_color_alt_global' ) ) === '#6d7680' ? false : $val;
$accent_color_global     = ( $val = get_theme_mod( 'accent_color_global' ) ) === '#3ba9d2' ? false : $val;
$accent_color_alt_global = ( $val = get_theme_mod( 'accent_color_alt_global' ) ) === '#79c4e0' ? false : $val;

if ( $base_color_global || $base_color_alt_global || $brand_color_global || $brand_color_alt_global || $accent_color_global || $accent_color_alt_global ) {

	echo ':root {';

	if ( $base_color_global ) {
		echo sprintf( '--base-color-alt: %s;', esc_attr( $base_color_global ) );
	}

	if ( $base_color_alt_global ) {
		echo sprintf( '--base-color: %s;', esc_attr( $base_color_alt_global ) );
	}

	if ( $brand_color_global ) {
		echo sprintf( '--brand-color: %s;', esc_attr( $brand_color_global ) );
	}

	if ( $brand_color_alt_global ) {
		echo sprintf( '--brand-color-alt: %s;', esc_attr( $brand_color_alt_global ) );
	}

	if ( $accent_color_global ) {
		echo sprintf( '--accent-color: %s;', esc_attr( $accent_color_global ) );
	}

	if ( $accent_color_alt_global ) {
		echo sprintf( '--accent-color-alt: %s;', esc_attr( $accent_color_alt_global ) );
	}

	echo '}';

}

// Vars.
$page_width             = get_theme_mod( 'page_max_width' );
$single_custom_width    = get_theme_mod( 'single_custom_width' );
$content_width          = $single_custom_width ? $single_custom_width : $page_width;
$page_width_int         = strpos( $content_width, 'px' ) !== false ? (int) $content_width : false;
$background_color       = get_theme_mod( 'background_color' );
$page_boxed             = get_theme_mod( 'page_boxed' );
$page_boxed_background  = get_theme_mod( 'page_boxed_background', '#ffffff' );
$page_accent_color      = get_theme_mod( 'page_accent_color' );
$page_accent_color_alt  = get_theme_mod( 'page_accent_color_alt' );
$page_bold_color        = get_theme_mod( 'page_bold_color' );
$page_font_size         = json_decode( get_theme_mod( 'page_font_size' ), true );
$page_font_size_desktop = wpbf_get_theme_mod_value( $page_font_size, 'desktop', '16px' );
$page_font_toggle       = get_theme_mod( 'page_font_toggle' );
$page_font_family_value = get_theme_mod( 'page_font_family', array() );
$page_font_color        = get_theme_mod( 'page_font_color' );
$page_line_height       = get_theme_mod( 'page_line_height' );

// Page width.
// Apply width if we have a px value set in the customizer.
if ( $page_width_int ) {

	echo '.wp-block {';
	echo sprintf( 'max-width: %s;', esc_attr( $page_width_int ) . 'px' );
	echo '}';

	echo '.wp-block[data-align="wide"] {';
	echo sprintf( 'max-width: %s;', esc_attr( $page_width_int ) + 150 . 'px' );
	echo '}';

}

// Page background color.
if ( $page_boxed ) {

	echo '.editor-styles-wrapper {';
	echo sprintf( 'background-color: %s;', esc_attr( $page_boxed_background ) );
	echo '}';

} elseif ( $background_color ) {

	echo '.editor-styles-wrapper {';
	echo sprintf( 'background-color: %s;', '#' . esc_attr( $background_color ) );
	echo '}';
	
}

// Accent color.
if ( $page_accent_color ) {

	echo '.editor-styles-wrapper a {';
	echo sprintf( 'color: %s;', esc_attr( $page_accent_color ) );
	echo '}';

}

if ( $page_accent_color_alt ) {

	echo '.editor-styles-wrapper a:hover {';
	echo sprintf( 'color: %s;', esc_attr( $page_accent_color_alt ) );
	echo '}';

}

// Bold color.
if ( $page_bold_color ) {

	echo '.editor-styles-wrapper strong {';
	echo sprintf( 'color: %s;', esc_attr( $page_bold_color ) );
	echo '}';

}

// Page font settings.
if ( $page_font_toggle && $page_font_family_value ) {

	echo '#wpwrap .editor-styles-wrapper {';

	if ( ! empty( $page_font_family_value['font-family'] ) ) {

		if ( false !== strpos( $page_font_family_value['font-family'], ' ' ) && false === strpos( $page_font_family_value['font-family'], '"' ) && false === strpos( $page_font_family_value['font-family'], ',' ) ) {
			$page_font_family_value['font-family'] = '"' . $page_font_family_value['font-family'] . '"';
		}

		echo sprintf( 'font-family: %s !important;', html_entity_decode( esc_attr( $page_font_family_value['font-family'] ), ENT_QUOTES ) );
	}

	if ( ! empty( $page_font_family_value['variant'] ) ) {

		$page_font_family_font_weight = str_replace( 'italic', '', $page_font_family_value['variant'] );
		$page_font_family_font_weight = ( in_array( $page_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_font_family_font_weight;

		echo sprintf( 'font-weight: %s;', esc_attr( $page_font_family_font_weight ) );

	}

	echo '}';

}

if ( $page_line_height || $page_font_color ) {

	echo '.editor-styles-wrapper p, .editor-styles-wrapper .editor-block-list__block {';

	if ( $page_line_height ) {
		echo sprintf( 'line-height: %s;', esc_attr( $page_line_height ) );
	}

	if ( $page_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_font_color ) );
	}

	echo '}';

}

if ( $page_font_size_desktop ) {

	echo '#wpwrap .editor-styles-wrapper {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_font_size_desktop ) );
	echo '}';

}

// Font color.
// Global.
// Code & preformatted.
// Citation.
// Verse.
if ( $page_font_color ) {

	echo '#wpwrap .editor-styles-wrapper, .wp-block-code .block-editor-plain-text, .wp-block-preformatted pre, .wp-block-quote__citation, .wp-block-pullquote .wp-block-pullquote__citation, .wp-block-verse pre, pre.wp-block-verse {';
	echo sprintf( 'color: %s;', esc_attr( $page_font_color ) );
	echo '}';

}

// H1
$page_h1_toggle            = get_theme_mod( 'page_h1_toggle' );
$page_h1_font_family_value = get_theme_mod( 'page_h1_font_family', array() );
$page_h1_line_height       = get_theme_mod( 'page_h1_line_height' );
$page_h1_letter_spacing    = get_theme_mod( 'page_h1_letter_spacing' );
$page_h1_text_transform    = ( $val = get_theme_mod( 'page_h1_text_transform' ) ) === 'none' ? false : $val;
$page_h1_font_size         = json_decode( get_theme_mod( 'page_h1_font_size' ), true );
$page_h1_font_size_desktop = wpbf_get_theme_mod_value( $page_h1_font_size, 'desktop', '32px' );
$page_h1_font_color        = get_theme_mod( 'page_h1_font_color' );

if ( $page_h1_toggle && $page_h1_font_family_value ) {

	echo '#wpwrap .editor-post-title__block .editor-post-title__input, #wpwrap .editor-styles-wrapper h1, #wpwrap .editor-styles-wrapper h2, #wpwrap .editor-styles-wrapper h3, #wpwrap .editor-styles-wrapper h4, #wpwrap .editor-styles-wrapper h5, #wpwrap .editor-styles-wrapper h6 {';

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

if ( $page_h1_font_color || $page_h1_line_height || $page_h1_letter_spacing || $page_h1_text_transform ) {

	echo '#wpwrap .editor-post-title__block .editor-post-title__input, #wpwrap .editor-styles-wrapper h1, #wpwrap .editor-styles-wrapper h2, #wpwrap .editor-styles-wrapper h3, #wpwrap .editor-styles-wrapper h4, #wpwrap .editor-styles-wrapper h5, #wpwrap .editor-styles-wrapper h6 {';

	if ( $page_h1_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_h1_font_color ) );
	}

	if ( $page_h1_line_height ) {
		echo sprintf( 'line-height: %s;', esc_attr( $page_h1_line_height ) );
	}

	if ( $page_h1_letter_spacing ) {
		echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h1_letter_spacing ) . 'px' );
	}

	if ( $page_h1_text_transform ) {
		echo sprintf( 'text-transform: %s;', esc_attr( $page_h1_text_transform ) );
	}

	echo '}';

}

if ( $page_h1_font_size_desktop ) {

	echo '#wpwrap .editor-post-title__block .editor-post-title__input, #wpwrap .editor-styles-wrapper h1 {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h1_font_size_desktop ) );
	echo '}';

}

// H2
$page_h2_toggle            = get_theme_mod( 'page_h2_toggle' );
$page_h2_font_family_value = get_theme_mod( 'page_h2_font_family', array() );
$page_h2_line_height       = get_theme_mod( 'page_h2_line_height' );
$page_h2_letter_spacing    = get_theme_mod( 'page_h2_letter_spacing' );
$page_h2_text_transform    = get_theme_mod( 'page_h2_text_transform', 'none' );
$page_h2_font_size         = json_decode( get_theme_mod( 'page_h2_font_size' ), true );
$page_h2_font_size_desktop = wpbf_get_theme_mod_value( $page_h2_font_size, 'desktop', '28px' );
$page_h2_font_color        = get_theme_mod( 'page_h2_font_color' );

if ( $page_h2_toggle && $page_h2_font_family_value ) {

	echo '#wpwrap .editor-styles-wrapper h2 {';

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

if ( $page_h2_toggle ) {

	if ( $page_h2_line_height || $page_h2_letter_spacing || $page_h2_text_transform ) {

		echo '#wpwrap .editor-styles-wrapper h2 {';

		if ( $page_h2_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h2_line_height ) );
		}

		if ( $page_h2_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h2_letter_spacing ) . 'px' );
		}

		if ( $page_h2_text_transform ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h2_text_transform ) );
		}

		echo '}';

	}

}

if ( $page_h2_font_size_desktop || $page_h2_font_color ) {

	echo '#wpwrap .editor-styles-wrapper h2 {';

	if ( $page_h2_font_size_desktop ) {
		echo sprintf( 'font-size: %s;', esc_attr( $page_h2_font_size_desktop ) );
	}

	if ( $page_h2_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_h2_font_color ) );
	}

	echo '}';

}

// H3
$page_h3_toggle            = get_theme_mod( 'page_h3_toggle' );
$page_h3_font_family_value = get_theme_mod( 'page_h3_font_family', array() );
$page_h3_line_height       = get_theme_mod( 'page_h3_line_height' );
$page_h3_letter_spacing    = get_theme_mod( 'page_h3_letter_spacing' );
$page_h3_text_transform    = get_theme_mod( 'page_h3_text_transform', 'none' );
$page_h3_font_size         = json_decode( get_theme_mod( 'page_h3_font_size' ), true );
$page_h3_font_size_desktop = wpbf_get_theme_mod_value( $page_h3_font_size, 'desktop', '24px' );
$page_h3_font_color        = get_theme_mod( 'page_h3_font_color' );

if ( $page_h3_toggle && $page_h3_font_family_value ) {

	echo '#wpwrap .editor-styles-wrapper h3 {';

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

if ( $page_h3_toggle ) {

	if ( $page_h3_line_height || $page_h3_letter_spacing || $page_h3_text_transform ) {

		echo '#wpwrap .editor-styles-wrapper h3 {';

		if ( $page_h3_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h3_line_height ) );
		}

		if ( $page_h3_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h3_letter_spacing ) . 'px' );
		}

		if ( $page_h3_text_transform ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h3_text_transform ) );
		}

		echo '}';

	}

}

if ( $page_h3_font_size_desktop || $page_h3_font_color ) {

	echo '#wpwrap .editor-styles-wrapper h3 {';

	if ( $page_h3_font_size_desktop ) {
		echo sprintf( 'font-size: %s;', esc_attr( $page_h3_font_size_desktop ) );
	}

	if ( $page_h3_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_h3_font_color ) );
	}

	echo '}';

}

// H4
$page_h4_toggle            = get_theme_mod( 'page_h4_toggle' );
$page_h4_font_family_value = get_theme_mod( 'page_h4_font_family', array() );
$page_h4_line_height       = get_theme_mod( 'page_h4_line_height' );
$page_h4_letter_spacing    = get_theme_mod( 'page_h4_letter_spacing' );
$page_h4_text_transform    = get_theme_mod( 'page_h4_text_transform', 'none' );
$page_h4_font_size         = json_decode( get_theme_mod( 'page_h4_font_size' ), true );
$page_h4_font_size_desktop = wpbf_get_theme_mod_value( $page_h4_font_size, 'desktop', '20px' );
$page_h4_font_color        = get_theme_mod( 'page_h4_font_color' );

if ( $page_h4_toggle && $page_h4_font_family_value ) {

	echo '#wpwrap .editor-styles-wrapper h4 {';

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

if ( $page_h4_toggle ) {

	if ( $page_h4_line_height || $page_h4_letter_spacing || $page_h4_text_transform ) {

		echo '#wpwrap .editor-styles-wrapper h4 {';

		if ( $page_h4_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h4_line_height ) );
		}

		if ( $page_h4_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h4_letter_spacing ) . 'px' );
		}

		if ( $page_h4_text_transform ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h4_text_transform ) );
		}

		echo '}';

	}

}

if ( $page_h4_font_size_desktop || $page_h4_font_color ) {

	echo '#wpwrap .editor-styles-wrapper h4 {';

	if ( $page_h4_font_size_desktop ) {
		echo sprintf( 'font-size: %s;', esc_attr( $page_h4_font_size_desktop ) );
	}

	if ( $page_h4_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_h4_font_color ) );
	}

	echo '}';

}

// H5
$page_h5_toggle            = get_theme_mod( 'page_h5_toggle' );
$page_h5_font_family_value = get_theme_mod( 'page_h5_font_family', array() );
$page_h5_line_height       = get_theme_mod( 'page_h5_line_height' );
$page_h5_letter_spacing    = get_theme_mod( 'page_h5_letter_spacing' );
$page_h5_text_transform    = get_theme_mod( 'page_h5_text_transform', 'none' );
$page_h5_font_size         = json_decode( get_theme_mod( 'page_h5_font_size' ), true );
$page_h5_font_size_desktop = wpbf_get_theme_mod_value( $page_h5_font_size, 'desktop', '16px' );
$page_h5_font_color        = get_theme_mod( 'page_h5_font_color' );

if ( $page_h5_toggle && $page_h5_font_family_value ) {

	echo '#wpwrap .editor-styles-wrapper h5 {';

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

if ( $page_h5_toggle ) {

	if ( $page_h5_line_height || $page_h5_letter_spacing || $page_h5_text_transform ) {

		echo '#wpwrap .editor-styles-wrapper h5 {';

		if ( $page_h5_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h5_line_height ) );
		}

		if ( $page_h5_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h5_letter_spacing ) . 'px' );
		}

		if ( $page_h5_text_transform ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h5_text_transform ) );
		}

		echo '}';

	}

}

if ( $page_h5_font_size_desktop || $page_h5_font_color ) {

	echo '#wpwrap .editor-styles-wrapper h5 {';

	if ( $page_h5_font_size_desktop ) {
		echo sprintf( 'font-size: %s;', esc_attr( $page_h5_font_size_desktop ) );
	}

	if ( $page_h5_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_h5_font_color ) );
	}

	echo '}';

}

// H6
$page_h6_toggle            = get_theme_mod( 'page_h6_toggle' );
$page_h6_font_family_value = get_theme_mod( 'page_h6_font_family', array() );
$page_h6_line_height       = get_theme_mod( 'page_h6_line_height' );
$page_h6_letter_spacing    = get_theme_mod( 'page_h6_letter_spacing' );
$page_h6_text_transform    = get_theme_mod( 'page_h6_text_transform' );
$page_h6_font_size         = json_decode( get_theme_mod( 'page_h6_font_size' ), true );
$page_h6_font_size_desktop = wpbf_get_theme_mod_value( $page_h6_font_size, 'desktop', '16px' );
$page_h6_font_color        = get_theme_mod( 'page_h6_font_color' );

if ( $page_h6_toggle && $page_h6_font_family_value ) {

	echo '#wpwrap .editor-styles-wrapper h6 {';

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

if ( $page_h6_toggle ) {

	if ( $page_h6_line_height || $page_h6_letter_spacing || $page_h6_text_transform ) {

		echo '#wpwrap .editor-styles-wrapper h6 {';

		if ( $page_h6_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h6_line_height ) );
		}

		if ( $page_h6_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h6_letter_spacing ) . 'px' );
		}

		if ( $page_h6_text_transform ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h6_text_transform ) );
		}

		echo '}';

	}

}

if ( $page_h6_font_size_desktop || $page_h6_font_color ) {

	echo '#wpwrap .editor-styles-wrapper h6 {';

	if ( $page_h6_font_size_desktop ) {
		echo sprintf( 'font-size: %s;', esc_attr( $page_h6_font_size_desktop ) );
	}

	if ( $page_h6_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_h6_font_color ) );
	}

	echo '}';

}

// Buttons
$button_primary_bg_color       = get_theme_mod( 'button_primary_bg_color' );
$button_primary_text_color     = get_theme_mod( 'button_primary_text_color' );
$button_primary_bg_color_alt   = get_theme_mod( 'button_primary_bg_color_alt' );
$button_primary_text_color_alt = get_theme_mod( 'button_primary_text_color_alt' );

if ( $button_primary_text_color ) {

	echo '.wp-block-button__link:not(.has-text-color) {';
	echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color ) );
	echo '}';

	// Gutenberg sets the hover color to white so we need to override this if a custom color is set.
	echo '.wp-block-button__link:not(.has-text-color):hover {';
	echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color ) );
	echo '}';

}

if ( $button_primary_bg_color ) {

	echo '.wp-block-button__link:not(.has-background) {';
	echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color ) );
	echo '}';

	echo '.is-style-outline .wp-block-button__link:not(.has-text-color) {';
	echo sprintf( 'border-color: %s;', esc_attr( $button_primary_bg_color ) );
	echo sprintf( 'color: %s;', esc_attr( $button_primary_bg_color ) );
	echo '}';

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
