<?php
/**
 * Gutenberg Admin Styles
 *
 * @package Page Builder Framework
 * @subpackage Integration/Gutenberg
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// variables
$page_width             = get_theme_mod( 'page_max_width' );
$single_custom_width    = get_theme_mod( 'single_custom_width' );
$content_width          = $single_custom_width ? $single_custom_width : $page_width;
$page_width_int         = strpos( $content_width, 'px' ) !== false ? (int) $content_width : false;
$background_color       = get_theme_mod( 'background_color' );
$page_accent_color      = get_theme_mod( 'page_accent_color' );
$page_bold_color        = get_theme_mod( 'page_bold_color' );
$page_font_size_desktop = get_theme_mod( 'page_font_size_desktop' );
$page_font_toggle       = get_theme_mod( 'page_font_toggle' );
$page_font_family_value = get_theme_mod( 'page_font_family', array() );
$page_font_color        = get_theme_mod( 'page_font_color' );
$page_line_height       = get_theme_mod( 'page_line_height' );

// Page Width – apply width if we have a px value set in the customizer
if( $page_width_int ) {

	echo '#wpwrap .edit-post-visual-editor .editor-post-title__block, #wpwrap .edit-post-visual-editor .editor-default-block-appender, #wpwrap .edit-post-visual-editor .editor-block-list__block {';
	echo sprintf( 'max-width: %s;', esc_attr( $page_width_int ) . 'px' );
	echo '}';

	echo '#wpwrap .edit-post-visual-editor .editor-block-list__block[data-align=wide] {';
	echo sprintf( 'max-width: %s;', esc_attr( $page_width_int ) + 150 . 'px' );
	echo '}';

}

// Page Background Color
if( $background_color ) {

	echo '#wpwrap .edit-post-visual-editor {';
	echo sprintf( 'background-color: %s;', '#' . esc_attr( $background_color ) );
	echo '}';

}

// Accent Color
if( $page_accent_color ) {

	echo '#wpwrap .edit-post-visual-editor a {';
	echo sprintf( 'color: %s;', esc_attr( $page_accent_color ) );
	echo '}';

}

// Bold Color
if( $page_bold_color ) {

	echo '#wpwrap .edit-post-visual-editor strong {';
	echo sprintf( 'color: %s;', esc_attr( $page_bold_color ) );
	echo '}';

}

// Page Font Settings
if( $page_font_toggle && $page_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor, #wpwrap .edit-post-visual-editor p {';

	if( !empty( $page_font_family_value['font-family'] ) ) {
		echo  sprintf( 'font-family: %s !important;', html_entity_decode( esc_attr( $page_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.
	}

	if( !empty( $page_font_family_value['variant'] ) ) {

		$page_font_family_font_weight = str_replace( 'italic', '', $page_font_family_value['variant'] );
		$page_font_family_font_weight = ( in_array( $page_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_font_family_font_weight;

		echo sprintf( 'font-weight: %s;', esc_attr( $page_font_family_font_weight ) );

	}

	echo '}';

}

if( $page_line_height || $page_font_color ) { 

	echo '#wpwrap .edit-post-visual-editor, #wpwrap .edit-post-visual-editor p {';

	if( $page_line_height ) {

		echo sprintf( 'line-height: %s;', esc_attr( $page_line_height ) );

	}

	if( $page_font_color ) {

		echo sprintf( 'color: %s;', esc_attr( $page_font_color ) );

	}

	echo '}';

}

// We do the font size separately because it outherwise interferes with the large blockquote
// going for #wpwrap .editor-styles-wrapper for as much of a global effect as possible
// (not goint for #wpwrap .editor-styles-wrapper p as it overrides other blocks paragraph styling)
// blockquotes
// code & preformatted text
if( $page_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor, #wpwrap .edit-post-visual-editor .wp-block-paragraph, #wpwrap .edit-post-visual-editor .wp-block-quote:not(.is-style-large) p:first-child, #wpwrap .edit-post-visual-editor .wp-block-code, #wpwrap .edit-post-visual-editor .wp-block-preformatted pre {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_font_size_desktop ) );
	echo '}';

}

// target specific elemenets that were not affected globally
// citation
// code & preformatted text
// verse
if( $page_font_color ) {

	echo '#wpwrap .edit-post-visual-editor .wp-block-code, #wpwrap .edit-post-visual-editor .wp-block-preformatted pre, #wpwrap .edit-post-visual-editor .wp-block-quote__citation, #wpwrap .edit-post-visual-editor .wp-block-pullquote .wp-block-pullquote__citation, #wpwrap .edit-post-visual-editor .wp-block-verse pre, #wpwrap .edit-post-visual-editor pre.wp-block-verse {';
	echo sprintf( 'color: %s;', esc_attr( $page_font_color ) );
	echo '}';

}

// H1
$page_h1_toggle					= get_theme_mod( 'page_h1_toggle' );
$page_h1_font_family_value		= get_theme_mod( 'page_h1_font_family', array() );
$page_h1_line_height			= get_theme_mod( 'page_h1_line_height' );
$page_h1_letter_spacing			= get_theme_mod( 'page_h1_letter_spacing' );
$page_h1_text_transform			= get_theme_mod( 'page_h1_text_transform' );
$page_h1_font_size_desktop		= get_theme_mod( 'page_h1_font_size_desktop' );
$page_h1_font_color				= get_theme_mod( 'page_h1_font_color' );

if( $page_h1_toggle && $page_h1_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor h1, #wpwrap .edit-post-visual-editor .editor-post-title__block .editor-post-title__input, #wpwrap .edit-post-visual-editor h2, #wpwrap .edit-post-visual-editor h3, #wpwrap .edit-post-visual-editor h4, #wpwrap .edit-post-visual-editor h5, #wpwrap .edit-post-visual-editor h6 {';

	if( !empty( $page_h1_font_family_value['font-family'] ) ) {
		echo  sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h1_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.
	}

	if( !empty( $page_h1_font_family_value['variant'] ) ) {

		$page_h1_font_family_font_weight = str_replace( 'italic', '', $page_h1_font_family_value['variant'] );
		$page_h1_font_family_font_weight = ( in_array( $page_h1_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h1_font_family_font_weight;

		$page_h1_font_family_is_italic = ( false !== strpos( $page_h1_font_family_value['variant'], 'italic' ) );
		$page_h1_font_family_is_style = $page_h1_font_family_is_italic ? 'italic' : 'normal' ;

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h1_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h1_font_family_is_style ) );

	}

	echo '}';

}

if( get_theme_mod( 'page_h1_font_color' ) || get_theme_mod( 'page_h1_line_height' ) || get_theme_mod( 'page_h1_letter_spacing' ) || get_theme_mod( 'page_h1_text_transform' ) ) {

	echo '#wpwrap .edit-post-visual-editor h1, #wpwrap .edit-post-visual-editor .editor-post-title__block .editor-post-title__input, #wpwrap .edit-post-visual-editor h2, #wpwrap .edit-post-visual-editor h3, #wpwrap .edit-post-visual-editor h4, #wpwrap .edit-post-visual-editor h5, #wpwrap .edit-post-visual-editor h6 {';

	if( $page_h1_font_color ) {
		echo sprintf( 'color: %s;', esc_attr( $page_h1_font_color ) );
	}

	if( $page_h1_line_height ) {
		echo sprintf( 'line-height: %s;', esc_attr( $page_h1_line_height ) );
	}

	if( $page_h1_letter_spacing ) {
		echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h1_letter_spacing ) . 'px' );
	}

	if( $page_h1_text_transform == 'uppercase' ) {
		echo sprintf( 'text-transform: %s;', esc_attr( $page_h1_text_transform ) );
	} else {
		echo 'text-transform: none;';
	}

	echo '}';

}

if( $page_h1_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor h1, #wpwrap .edit-post-visual-editor .editor-post-title__block .editor-post-title__input {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h1_font_size_desktop ) );
	echo '}';

}

// H2
$page_h2_toggle					= get_theme_mod( 'page_h2_toggle' );
$page_h2_font_family_value		= get_theme_mod( 'page_h2_font_family', array() );
$page_h2_line_height			= get_theme_mod( 'page_h2_line_height' );
$page_h2_letter_spacing			= get_theme_mod( 'page_h2_letter_spacing' );
$page_h2_text_transform			= get_theme_mod( 'page_h2_text_transform' );
$page_h2_font_size_desktop		= get_theme_mod( 'page_h2_font_size_desktop' );
$page_h2_font_color				= get_theme_mod( 'page_h2_font_color' );

if( $page_h2_toggle && $page_h2_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor h2 {';

	if( !empty( $page_h2_font_family_value['font-family'] ) ) {
		echo  sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h2_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.
	}

	if( !empty( $page_h2_font_family_value['variant'] ) ) {

		$page_h2_font_family_font_weight = str_replace( 'italic', '', $page_h2_font_family_value['variant'] );
		$page_h2_font_family_font_weight = ( in_array( $page_h2_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h2_font_family_font_weight;

		$page_h2_font_family_is_italic = ( false !== strpos( $page_h2_font_family_value['variant'], 'italic' ) );
		$page_h2_font_family_is_style = $page_h2_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h2_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h2_font_family_is_style ) );

	}

	echo '}';

}

if( $page_h2_toggle ) {

	if( $page_h2_line_height || $page_h2_letter_spacing || $page_h2_text_transform ) {

		echo '#wpwrap .edit-post-visual-editor h2 {';

		if( $page_h2_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h2_line_height ) );
		}

		if( $page_h2_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h2_letter_spacing ) . 'px' );
		}

		if( $page_h2_text_transform == 'uppercase' ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h2_text_transform ) );
		} else {
			echo 'text-transform: none;';
		}

		echo '}';

	}

}

if( $page_h2_font_size_desktop || $page_h2_font_color ) {

	echo '#wpwrap .edit-post-visual-editor h2 {';

	if( $page_h2_font_size_desktop ) {

		echo sprintf( 'font-size: %s;', esc_attr( $page_h2_font_size_desktop ) );

	}

	if( $page_h2_font_color ) {

		echo sprintf( 'color: %s;', esc_attr( $page_h2_font_color ) );

	}

	echo '}';

}

// H3
$page_h3_toggle					= get_theme_mod( 'page_h3_toggle' );
$page_h3_font_family_value		= get_theme_mod( 'page_h3_font_family', array() );
$page_h3_line_height			= get_theme_mod( 'page_h3_line_height' );
$page_h3_letter_spacing			= get_theme_mod( 'page_h3_letter_spacing' );
$page_h3_text_transform			= get_theme_mod( 'page_h3_text_transform' );
$page_h3_font_size_desktop		= get_theme_mod( 'page_h3_font_size_desktop' );
$page_h3_font_color				= get_theme_mod( 'page_h3_font_color' );

if( $page_h3_toggle && $page_h3_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor h3 {';

	if( !empty( $page_h3_font_family_value['font-family'] ) ) {
		echo  sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h3_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.
	}

	if( !empty( $page_h3_font_family_value['variant'] ) ) {

		$page_h3_font_family_font_weight = str_replace( 'italic', '', $page_h3_font_family_value['variant'] );
		$page_h3_font_family_font_weight = ( in_array( $page_h3_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h3_font_family_font_weight;

		$page_h3_font_family_is_italic = ( false !== strpos( $page_h3_font_family_value['variant'], 'italic' ) );
		$page_h3_font_family_is_style = $page_h3_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h3_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h3_font_family_is_style ) );

	}

	echo '}';

}

if( $page_h3_toggle ) {

	if( $page_h3_line_height || $page_h3_letter_spacing || $page_h3_text_transform ) {

		echo '#wpwrap .edit-post-visual-editor h3 {';

		if( $page_h3_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h3_line_height ) );
		}

		if( $page_h3_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h3_letter_spacing ) . 'px' );
		}

		if( $page_h3_text_transform == 'uppercase' ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h3_text_transform ) );
		} else {
			echo 'text-transform: none;';
		}

		echo '}';

	}

}

if( $page_h3_font_size_desktop || $page_h3_font_color ) {

	echo '#wpwrap .edit-post-visual-editor h3 {';

	if( $page_h3_font_size_desktop ) {

		echo sprintf( 'font-size: %s;', esc_attr( $page_h3_font_size_desktop ) );

	}

	if( $page_h3_font_color ) {

		echo sprintf( 'color: %s;', esc_attr( $page_h3_font_color ) );

	}

	echo '}';

}

// H4
$page_h4_toggle					= get_theme_mod( 'page_h4_toggle' );
$page_h4_font_family_value		= get_theme_mod( 'page_h4_font_family', array() );
$page_h4_line_height			= get_theme_mod( 'page_h4_line_height' );
$page_h4_letter_spacing			= get_theme_mod( 'page_h4_letter_spacing' );
$page_h4_text_transform			= get_theme_mod( 'page_h4_text_transform' );
$page_h4_font_size_desktop		= get_theme_mod( 'page_h4_font_size_desktop' );
$page_h4_font_color				= get_theme_mod( 'page_h4_font_color' );

if( $page_h4_toggle && $page_h4_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor h4 {';

	if( !empty( $page_h4_font_family_value['font-family'] ) ) {
		echo  sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h4_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.
	}

	if( !empty( $page_h4_font_family_value['variant'] ) ) {

		$page_h4_font_family_font_weight = str_replace( 'italic', '', $page_h4_font_family_value['variant'] );
		$page_h4_font_family_font_weight = ( in_array( $page_h4_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h4_font_family_font_weight;

		$page_h4_font_family_is_italic = ( false !== strpos( $page_h4_font_family_value['variant'], 'italic' ) );
		$page_h4_font_family_is_style = $page_h4_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h4_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h4_font_family_is_style ) );

	}

	echo '}';

}

if( $page_h4_toggle ) {

	if( $page_h4_line_height || $page_h4_letter_spacing || $page_h4_text_transform ) {

		echo '#wpwrap .edit-post-visual-editor h4 {';

		if( $page_h4_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h4_line_height ) );
		}

		if( $page_h4_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h4_letter_spacing ) . 'px' );
		}

		if( $page_h4_text_transform == 'uppercase' ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h4_text_transform ) );
		} else {
			echo 'text-transform: none;';
		}

		echo '}';

	}

}

if( $page_h4_font_size_desktop || $page_h4_font_color ) {

	echo '#wpwrap .edit-post-visual-editor h4 {';

	if( $page_h4_font_size_desktop ) {

		echo sprintf( 'font-size: %s;', esc_attr( $page_h4_font_size_desktop ) );

	}

	if( $page_h4_font_color ) {

		echo sprintf( 'color: %s;', esc_attr( $page_h4_font_color ) );

	}

	echo '}';

}

// H5
$page_h5_toggle					= get_theme_mod( 'page_h5_toggle' );
$page_h5_font_family_value		= get_theme_mod( 'page_h5_font_family', array() );
$page_h5_line_height			= get_theme_mod( 'page_h5_line_height' );
$page_h5_letter_spacing			= get_theme_mod( 'page_h5_letter_spacing' );
$page_h5_text_transform			= get_theme_mod( 'page_h5_text_transform' );
$page_h5_font_size_desktop		= get_theme_mod( 'page_h5_font_size_desktop' );
$page_h5_font_color				= get_theme_mod( 'page_h5_font_color' );

if( $page_h5_toggle && $page_h5_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor h5 {';

	if( !empty( $page_h5_font_family_value['font-family'] ) ) {
		echo  sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h5_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.
	}

	if( !empty( $page_h5_font_family_value['variant'] ) ) {

		$page_h5_font_family_font_weight = str_replace( 'italic', '', $page_h5_font_family_value['variant'] );
		$page_h5_font_family_font_weight = ( in_array( $page_h5_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h5_font_family_font_weight;

		$page_h5_font_family_is_italic = ( false !== strpos( $page_h5_font_family_value['variant'], 'italic' ) );
		$page_h5_font_family_is_style = $page_h5_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h5_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h5_font_family_is_style ) );

	}

	echo '}';

}

if( $page_h5_toggle ) {

	if( $page_h5_line_height || $page_h5_letter_spacing || $page_h5_text_transform ) {

		echo '#wpwrap .edit-post-visual-editor h5 {';

		if( $page_h5_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h5_line_height ) );
		}

		if( $page_h5_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h5_letter_spacing ) . 'px' );
		}

		if( $page_h5_text_transform == 'uppercase' ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h5_text_transform ) );
		} else {
			echo 'text-transform: none;';
		}

		echo '}';

	}

}

if( $page_h5_font_size_desktop || $page_h5_font_color ) {

	echo '#wpwrap .edit-post-visual-editor h5 {';

	if( $page_h5_font_size_desktop ) {

		echo sprintf( 'font-size: %s;', esc_attr( $page_h5_font_size_desktop ) );

	}

	if( $page_h5_font_color ) {

		echo sprintf( 'color: %s;', esc_attr( $page_h5_font_color ) );

	}

	echo '}';

}

// H6
$page_h6_toggle					= get_theme_mod( 'page_h6_toggle' );
$page_h6_font_family_value		= get_theme_mod( 'page_h6_font_family', array() );
$page_h6_line_height			= get_theme_mod( 'page_h6_line_height' );
$page_h6_letter_spacing			= get_theme_mod( 'page_h6_letter_spacing' );
$page_h6_text_transform			= get_theme_mod( 'page_h6_text_transform' );
$page_h6_font_size_desktop		= get_theme_mod( 'page_h6_font_size_desktop' );
$page_h6_font_color				= get_theme_mod( 'page_h6_font_color' );

if( $page_h6_toggle && $page_h6_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor h6 {';

	if( !empty( $page_h6_font_family_value['font-family'] ) ) {
		echo  sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_h6_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.
	}

	if( !empty( $page_h6_font_family_value['variant'] ) ) {

		$page_h6_font_family_font_weight = str_replace( 'italic', '', $page_h6_font_family_value['variant'] );
		$page_h6_font_family_font_weight = ( in_array( $page_h6_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h6_font_family_font_weight;

		$page_h6_font_family_is_italic = ( false !== strpos( $page_h6_font_family_value['variant'], 'italic' ) );
		$page_h6_font_family_is_style = $page_h6_font_family_is_italic ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $page_h6_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_h6_font_family_is_style ) );

	}

	echo '}';

}

if( $page_h6_toggle ) {

	if( $page_h6_line_height || $page_h6_letter_spacing || $page_h6_text_transform ) {

		echo '#wpwrap .edit-post-visual-editor h6 {';

		if( $page_h6_line_height ) {
			echo sprintf( 'line-height: %s;', esc_attr( $page_h6_line_height ) );
		}

		if( $page_h6_letter_spacing ) {
			echo sprintf( 'letter-spacing: %s;', esc_attr( $page_h6_letter_spacing ) . 'px' );
		}

		if( $page_h6_text_transform == 'uppercase' ) {
			echo sprintf( 'text-transform: %s;', esc_attr( $page_h6_text_transform ) );
		} else {
			echo 'text-transform: none;';
		}

		echo '}';

	}

}

if( $page_h6_font_size_desktop || $page_h6_font_color ) {

	echo '#wpwrap .edit-post-visual-editor h6 {';

	if( $page_h6_font_size_desktop ) {

		echo sprintf( 'font-size: %s;', esc_attr( $page_h6_font_size_desktop ) );

	}

	if( $page_h6_font_color ) {

		echo sprintf( 'color: %s;', esc_attr( $page_h6_font_color ) );

	}

	echo '}';

}