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
function wpbf_woocommerce_elementor_grid_fix() {

	echo '.elementor-grid {';
	echo 'display: flex;';
	echo '}';

}
add_action( 'wpbf_before_customizer_css', 'wpbf_woocommerce_elementor_grid_fix', 20 );
