<?php
/**
 * Customizer settings helpers.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

if ( ! function_exists( 'wpbf_kirki_sanitize_helper' ) ) {

	/**
	 * Kirki sanitization helper.
	 *
	 * @param string $callback The sanitization callback.
	 *
	 * @return mixed The sanitized json.
	 */
	function wpbf_kirki_sanitize_helper( $callback ) {

		return function ( $value ) use ( $callback ) {

			if ( ! empty( $value ) ) {
				$value = json_decode( trim( $value ), true );
				$value = array_map( $callback, $value );
				$value = json_encode( $value );
			}

			return $value;

		};

	}

}

/**
 * Helper function to sanitize padding fields.
 */
function wpbf_is_numeric_sanitization_helper( $value ) {

	if ( ! is_numeric( $value ) ) {
		return "";
	}

	return absint( $value );

}

/**
 * Default font choices.
 *
 * This exists so we can filter and extend the font choices in Kirki.
 *
 * @return array The default font choices.
 */
function wpbf_default_font_choices() {
	return array(
		'fonts' => apply_filters( 'wpbf_kirki_font_choices', array() ),
	);
}
