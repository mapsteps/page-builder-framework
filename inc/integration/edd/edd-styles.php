<?php
/**
 * Dynamic EDD CSS
 *
 * Holds Customizer EDD CSS styles
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wpbf_after_customizer_css', 'wpbf_do_edd_customizer_css', 10 );

function wpbf_do_edd_customizer_css() {

	// Theme Buttons
	$button_border_width				= get_theme_mod( 'button_border_width' );
	$button_border_color				= get_theme_mod( 'button_border_color' );
	$button_border_color_alt			= get_theme_mod( 'button_border_color_alt' );
	$button_primary_border_color		= get_theme_mod( 'button_primary_border_color' );
	$button_primary_border_color_alt	= get_theme_mod( 'button_primary_border_color_alt' );
	$button_bg_color					= get_theme_mod( 'button_bg_color' );
	$button_text_color					= get_theme_mod( 'button_text_color' );
	$button_border_radius				= get_theme_mod( 'button_border_radius' );
	$button_bg_color_alt				= get_theme_mod( 'button_bg_color_alt' );
	$button_text_color_alt				= get_theme_mod( 'button_text_color_alt' );
	$button_primary_bg_color			= get_theme_mod( 'button_primary_bg_color' );
	$button_primary_text_color			= get_theme_mod( 'button_primary_text_color' );
	$button_primary_bg_color_alt		= get_theme_mod( 'button_primary_bg_color_alt' );
	$button_primary_text_color_alt		= get_theme_mod( 'button_primary_text_color_alt' );

	if( $button_border_width ) {

		echo '.edd-submit.button, .edd-submit.button.gray {';
		echo sprintf( 'border-width: %s;', esc_attr( $button_border_width ) . 'px' );
		echo 'border-style: solid;';

		if( $button_border_color ) {

			echo sprintf( 'border-color: %s;', esc_attr( $button_border_color ) );

		}

		echo '}';

		if( $button_border_color_alt ) {

			echo '.edd-submit.button:hover, .edd-submit.button.gray:hover {';

			echo sprintf( 'border-color: %s;', esc_attr( $button_border_color_alt ) );

			echo '}';

		}

		if( $button_primary_border_color ) {

			echo '.edd-submit.button.blue {';

			echo sprintf( 'border-color: %s;', esc_attr( $button_primary_border_color ) );

			echo '}';

		}

		if( $button_primary_border_color_alt ) {

			echo '.edd-submit.button.blue:hover {';

			echo sprintf( 'border-color: %s;', esc_attr( $button_primary_border_color_alt ) );

			echo '}';

		}

	}

	if( $button_bg_color || $button_text_color || $button_border_radius ) {

		echo '.edd-submit.button, .edd-submit.button.gray {';

		if( $button_border_radius ) {

			echo sprintf( 'border-radius: %s;', esc_attr( $button_border_radius ) . 'px' );

		}

		if( $button_bg_color ) {

			echo sprintf( 'background: %s;', esc_attr( $button_bg_color ) );

		}

		if( $button_text_color ) {

			echo sprintf( 'color: %s;', esc_attr( $button_text_color ) );

		}

		echo '}';

	}

	if( $button_bg_color_alt || $button_text_color_alt ) {

		echo '.edd-submit.button:hover, .edd-submit.button.gray:hover {';

		if( $button_bg_color_alt ) {

			echo sprintf( 'background: %s;', esc_attr( $button_bg_color_alt ) );

		}

		if( $button_text_color_alt ) {

			echo sprintf( 'color: %s;', esc_attr( $button_text_color_alt ) );

		}

		echo '}';

	}

	if( $button_primary_bg_color || $button_primary_text_color ) {

		echo '.edd-submit.button.blue {';

		if( $button_primary_bg_color ) {

			echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color ) );

		}

		if( $button_primary_text_color ) {

			echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color ) );

		}

		echo '}';

	}

	if( $button_primary_bg_color_alt || $button_primary_text_color_alt ) {

		echo '.edd-submit.button.blue:hover {';

		if( $button_primary_bg_color_alt ) {

			echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color_alt ) );

		}

		if( $button_primary_text_color_alt ) {

			echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color_alt ) );

		}

		echo '}';

	}

}