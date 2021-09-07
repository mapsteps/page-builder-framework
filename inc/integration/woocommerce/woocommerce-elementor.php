<?php
/**
 * Elementor integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Fix WooCommerce/Elementor grid issue.
 *
 * https://github.com/elementor/elementor/issues/16057
 */
function wpbf_woo_elementor_grid_fix() {
	echo '<style id="wpbf-elementor-woocommerce-product-loop-fix">.elementor-grid { display:  flex }</style>';
}
add_action( 'wp_head', 'wpbf_woo_elementor_grid_fix', 999 );
