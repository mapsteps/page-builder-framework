<?php
/**
 * Dynamic WooCommerce CSS
 *
 * Holds Customizer WooCommerce CSS styles
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wpbf_woocommerce_customizer_css', 'wpbf_do_woocommerce_customizer_css', 10 );
function wpbf_do_woocommerce_customizer_css() {

	if( get_theme_mod( 'woocommerce_loop_content_alignment' ) ) { ?>
	.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
		text-align: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_content_alignment' ) ); ?>;
	}
	<?php if( get_theme_mod( 'woocommerce_loop_content_alignment' ) == 'center' ) { ?>
	.woocommerce .products .star-rating {
		margin: 0 auto 10px auto;
	}
	<?php } elseif( get_theme_mod( 'woocommerce_loop_content_alignment' ) == 'right' ) { ?>
	.woocommerce .products .star-rating {
		display: inline-block;
		text-align: right;
	}
	<?php } ?>
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_remove_button' ) ) { ?>
	.woocommerce ul.products li.product .button {
		display: none;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'left' ) { ?>
	.woocommerce ul.products li.product .onsale {
		left: 0;
		right: auto;
		margin-left: -20px;
	}
	<?php } elseif( get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'center' ) { ?>
	.woocommerce ul.products li.product .onsale {
		right: auto;
		left: 50%;
		width: 90px;
		margin: 0 0 0 -45px;
		height: auto;
		line-height: 1;
		padding: 10px 20px;
		border-radius: 0px;
		border-bottom-left-radius: 6px;
		border-bottom-right-radius: 6px;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_sale_position' ) == 'inside' ) { ?>

	<?php if( !get_theme_mod( 'woocommerce_loop_sale_alignment' ) || get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'right' ) { ?>
	.woocommerce ul.products li.product .onsale {
		margin: 10px 10px 0 0;
	}
	<?php } elseif( get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'left' ) { ?>
	.woocommerce ul.products li.product .onsale {
		margin: 10px 0 0 10px;
	}
	<?php } ?>

	<?php }

}