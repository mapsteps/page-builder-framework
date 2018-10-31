<?php
/**
 * Gutenberg Admin Styles
 *
 * @package Page Builder Framework
 * @subpackage Integration/Gutenberg
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


$page_width						= get_theme_mod( 'page_max_width' );

if (strpos($page_width, 'px') !== false) {
    $page_width_int				= (int) $page_width;
}

$page_accent_color				= get_theme_mod( 'page_accent_color' );
$page_h1_font_size_desktop		= get_theme_mod( 'page_h1_font_size_desktop' );
$page_h2_font_size_desktop		= get_theme_mod( 'page_h2_font_size_desktop' );
$page_h3_font_size_desktop		= get_theme_mod( 'page_h3_font_size_desktop' );
$page_h4_font_size_desktop		= get_theme_mod( 'page_h4_font_size_desktop' );
$page_h5_font_size_desktop		= get_theme_mod( 'page_h5_font_size_desktop' );
$page_h6_font_size_desktop		= get_theme_mod( 'page_h6_font_size_desktop' );
$background_color				= get_theme_mod( 'background_color' );
$page_font_size_desktop			= get_theme_mod( 'page_font_size_desktop' );
$page_font_toggle				= get_theme_mod( 'page_font_toggle' );
$page_font_family_value			= get_theme_mod( 'page_font_family', array() );
$page_font_color				= get_theme_mod( 'page_font_color' );
$page_line_height				= get_theme_mod( 'page_line_height' );

// Page Width
if( $page_width ) {

	echo '#wpwrap .edit-post-visual-editor .editor-post-title__block, #wpwrap .edit-post-visual-editor .editor-default-block-appender, #wpwrap .edit-post-visual-editor .editor-block-list__block {';
	echo sprintf( 'max-width: %s;', esc_attr( $page_width ) );
	echo '}';

	if( $page_width_int ) {

		echo '#wpwrap .edit-post-visual-editor .editor-block-list__block[data-align=wide] {';
		echo sprintf( 'max-width: %s;', esc_attr( $page_width_int ) + 150 . 'px' );
		echo '}';

	}

}

// Accent Color
if( $page_accent_color ) {

	echo '#wpwrap .edit-post-visual-editor a {';
	echo sprintf( 'color: %s;', esc_attr( $page_accent_color ) );
	echo '}';

}

// Page Font
if( $page_font_toggle && $page_font_family_value ) {

	echo '#wpwrap .edit-post-visual-editor p, #wpwrap .edit-post-visual-editor .editor-block-list__block p {';

	// if( isset( $page_font_family_value['font-family'] ) && !empty( $page_font_family_value['font-family'] ) ) {

	// 	echo  sprintf( 'font-family: %s;', html_entity_decode( esc_attr( $page_font_family_value['font-family'] ), ENT_QUOTES ) ); // WPCS: XSS ok.

	// }

	if( isset( $page_font_family_value['variant'] ) && !empty( $page_font_family_value['variant'] ) ) {

		$page_font_family_font_weight = str_replace( 'italic', '', $page_font_family_value['variant'] );
		$page_font_family_font_weight = ( in_array( $page_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_font_family_font_weight;

		$page_font_family_is_italic = ( false !== strpos( $page_font_family_value['variant'], 'italic' ) );
		$page_font_family_font_style = $page_font_family_is_italic ? 'italic' : 'normal' ;

		echo sprintf( 'font-weight: %s;', esc_attr( $page_font_family_font_weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $page_font_family_font_style ) );

	}

	echo '}';

}

if( $page_font_size_desktop || $page_line_height || $page_font_color ) { 

	echo '#wpwrap .edit-post-visual-editor p, #wpwrap .edit-post-visual-editor .editor-block-list__block p {';

	if( $page_font_size_desktop ) {

		echo sprintf( 'font-size: %s;', esc_attr( $page_font_size_desktop ) );

	}

	if( $page_line_height ) {

		echo sprintf( 'line-height: %s;', esc_attr( $page_line_height ) );

	}

	if( $page_font_color ) {

		echo sprintf( 'color: %s;', esc_attr( $page_font_color ) );

	}

	echo '}';

}

// make citation adopt front-end styles
if( $page_font_color ) {

	echo '.wp-block-quote__citation, .wp-block-pullquote .wp-block-pullquote__citation {';
	echo sprintf( 'color: %s;', esc_attr( $page_font_color ) );
	echo 'opacity: .75';
	echo '}';

}

// Headlines
if( $page_h1_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor h1, .editor-post-title__block .editor-post-title__input {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h1_font_size_desktop ) );
	echo '}';

}

if( $page_h2_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor h2 {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h2_font_size_desktop ) );
	echo '}';

}

if( $page_h3_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor h3 {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h3_font_size_desktop ) );
	echo '}';

}

if( $page_h4_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor h4 {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h4_font_size_desktop ) );
	echo '}';

}

if( $page_h5_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor h5 {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h5_font_size_desktop ) );
	echo '}';

}

if( $page_h6_font_size_desktop ) {

	echo '#wpwrap .edit-post-visual-editor h6 {';
	echo sprintf( 'font-size: %s;', esc_attr( $page_h6_font_size_desktop ) );
	echo '}';

}

if( $background_color ) {

	echo '#wpwrap .edit-post-visual-editor {';
	echo sprintf( 'background-color: %s;', '#' . esc_attr( $background_color ) );
	echo '}';

}



// Standardize blockquote look throughout the thing
// Headline styles