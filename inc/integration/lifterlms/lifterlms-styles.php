<?php
/**
 * Dynamic LifterLMS CSS.
 *
 * Holds Customizer LifterLMS CSS styles.
 *
 * @package Page Builder Framework
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

function wpbf_do_lifterlms_customizer_css() {

	$breakpoint_mobile_int = function_exists( 'wpbf_breakpoint_mobile' ) ? wpbf_breakpoint_mobile() : 480;
	$breakpoint_medium_int = function_exists( 'wpbf_breakpoint_medium' ) ? wpbf_breakpoint_medium() : 768;
	$breakpoint_mobile     = $breakpoint_mobile_int . 'px';
	$breakpoint_medium     = $breakpoint_medium_int . 'px';

}
// add_action( 'wpbf_after_customizer_css', 'wpbf_do_lifterlms_customizer_css', 10 );
