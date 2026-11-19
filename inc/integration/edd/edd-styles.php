<?php
/**
 * Dynamic Easy Digital Downloads CSS.
 *
 * The CSS itself is in inc/customizer/styles/edd.php (written with wpbf_css(), so the Customizer preview shows changes
 * instantly). It's printed here, on wpbf_after_customizer_css, at the same place as before.
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Print the EDD Customizer CSS.
 */
function wpbf_do_edd_customizer_css() {

	wpbf_css_area( 'edd' );

}
add_action( 'wpbf_after_customizer_css', 'wpbf_do_edd_customizer_css', 10 );
