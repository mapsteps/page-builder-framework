<?php
/**
 * Dynamic WooCommerce CSS.
 *
 * The CSS itself is in inc/customizer/styles/woocommerce.php (written with wpbf_css(), so the Customizer preview shows
 * changes instantly). It's printed here, on wpbf_after_customizer_css, at the same place as before.
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Print the WooCommerce Customizer CSS.
 */
function wpbf_do_woocommerce_customizer_css() {

	wpbf_css_area( 'woocommerce' );

}
add_action( 'wpbf_after_customizer_css', 'wpbf_do_woocommerce_customizer_css', 10 );
