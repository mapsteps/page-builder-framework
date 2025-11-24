<?php
/**
 * Background customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

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
