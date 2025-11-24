<?php
/**
 * Button customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

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
