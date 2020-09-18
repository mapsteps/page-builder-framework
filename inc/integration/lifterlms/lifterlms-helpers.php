<?php
/**
 * LifterLMS helpers.
 *
 * @package Page Builder Framework
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Basic function to check if we're on a LifterLMS archive.
 *
 * @return boolean
 */
function wpbf_is_lifterlms_archive() {

	if ( is_courses() || is_memberships() || is_membership_taxonomy() || is_course_taxonomy() ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Basic function to check if we're on a LifterLMS single page.
 *
 * @return boolean
 */
function wpbf_is_lifterlms_single() {

	if ( is_course() || is_lesson() || is_quiz() || is_membership() ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Hex to rgb.
 */
function wpbf_lifterlms_hex_to_rgb( $hex ) {

	$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );

	if ( strlen( $hex ) < 6 ) {
		$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
	}

	$rgb = array(
		hexdec( $hex[0] . $hex[1] ),
		hexdec( $hex[2] . $hex[3] ),
		hexdec( $hex[4] . $hex[5] ),
	);

	return $rgb;

}

/**
 * Adjust hex.
 */
function wpbf_lifterlms_adjust_hex( $hex, $percent ) {

	$rgb = wpbf_lifterlms_hex_to_rgb( $hex );
	$new_hex = '#';

	// convert to decimal and change luminosity
	foreach( $rgb as $part ) {
		$dec = min( max( 0, $part + $part * $percent ), 255 );
		$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
	}

	return $new_hex;

}

/**
 * Get luminance.
 */
function wpbf_lifterlms_get_luminance( $hex ) {

	$rgb = wpbf_lifterlms_hex_to_rgb( $hex );

	foreach ( $rgb as &$c ) {
		$c = $c / 255;
		if ( $c <= 0.03928 ) {
			$c = $c / 12.92;
		} else {
			$c = pow( ( ( $c + 0.055 ) / 1.055 ), 2.4 );
		}
	}

	return ( 0.2126 * $rgb[0] ) + ( 0.7152 * $rgb[1] ) + ( 0.0722 * $rgb[2] );

}
