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
function wpbf_do_woocommerce_customizer_css() { ?>

	<?php // Buttons ?>

	<?php if( get_theme_mod( 'button_border_width' ) ) { ?>

		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt {
			border-width: <?php echo esc_attr( get_theme_mod( 'button_border_width' ) ) ?>px;
			border-style: solid;
		<?php if( get_theme_mod( 'button_primary_border_color' ) ) { ?>
			border-color: <?php echo esc_attr( get_theme_mod( 'button_primary_border_color' ) ) ?>;
		<?php } ?>
		}	

		<?php if( get_theme_mod( 'button_primary_border_color_alt' ) ) { ?>
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button.alt:hover {
			border-color: <?php echo esc_attr( get_theme_mod( 'button_primary_border_color_alt' ) ) ?>;
		}
		<?php } ?>

	<?php } ?>

	<?php if( get_theme_mod( 'button_primary_bg_color' ) || get_theme_mod( 'button_primary_text_color' ) || get_theme_mod( 'button_border_radius' ) ) { ?>

		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt,
		.woocommerce a.button.alt.disabled,
		.woocommerce a.button.alt:disabled,
		.woocommerce a.button.alt:disabled[disabled],
		.woocommerce a.button.alt.disabled:hover,
		.woocommerce a.button.alt:disabled:hover,
		.woocommerce a.button.alt:disabled[disabled]:hover,
		.woocommerce button.button.alt.disabled,
		.woocommerce button.button.alt:disabled,
		.woocommerce button.button.alt:disabled[disabled],
		.woocommerce button.button.alt.disabled:hover,
		.woocommerce button.button.alt:disabled:hover,
		.woocommerce button.button.alt:disabled[disabled]:hover {
		<?php if( get_theme_mod( 'button_border_radius' ) ) { ?>
			border-radius: <?php echo esc_attr( get_theme_mod( 'button_border_radius' ) ) ?>px;
		<?php } ?>
		<?php if( get_theme_mod( 'button_primary_bg_color' ) ) { ?>
			background: <?php echo esc_attr( get_theme_mod( 'button_primary_bg_color' ) ) ?>;
		<?php } ?>
		<?php if( get_theme_mod( 'button_primary_text_color' ) ) { ?>
			color: <?php echo esc_attr( get_theme_mod( 'button_primary_text_color' ) ) ?>;
		<?php } ?>
		}

	<?php } ?>

	<?php if( get_theme_mod( 'button_primary_bg_color_alt' ) || get_theme_mod( 'button_primary_text_color_alt' ) ) { ?>

		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button.alt:hover {
		<?php if( get_theme_mod( 'button_primary_bg_color_alt' ) ) { ?>
			background: <?php echo esc_attr( get_theme_mod( 'button_primary_bg_color_alt' ) ) ?>;
		<?php } ?>
		<?php if( get_theme_mod( 'button_primary_text_color_alt' ) ) { ?>
			color: <?php echo esc_attr( get_theme_mod( 'button_primary_text_color_alt' ) ) ?>;
		<?php } ?>
		}

	<?php } ?>

	<?php // Loop ?>

	<?php if( get_theme_mod( 'woocommerce_loop_content_alignment' ) ) { ?>
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

	<?php } ?>

	<?php // Product Page ?>

	<?php if( get_theme_mod( 'woocommerce_product_alignment' ) == 'right' ) { ?>

		.woocommerce div.product div.summary,
		.woocommerce #content div.product div.summary,
		.woocommerce-page div.product div.summary,
		.woocommerce-page #content div.product div.summary {

			float: left;
			
		}

		.woocommerce div.product div.images,
		.woocommerce #content div.product div.images,
		.woocommerce-page div.product div.images,
		.woocommerce-page #content div.product div.images {
			float: right;
		}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_checkout_layout' ) == 'side' ) { ?>

	.woocommerce .col2-set,
	.woocommerce-page .col2-set {
		width: 48%;
		float: left;
	}

	.woocommerce .col2-set .col-1,
	.woocommerce-page .col2-set .col-1,
	.woocommerce .col2-set .col-2,
	.woocommerce-page .col2-set .col-2 {
		float: none;
		width: 100%;
	}

	#order_review_heading {
		float: right;
		width: 48%;
	}

	.woocommerce-checkout-review-order {
		width: 48%;
		float: right;
	}

	<?php if( !wpbf_has_responsive_breakpoints() ) { ?>		

		@media screen and (max-width:768px) {

			.woocommerce .col2-set,
			.woocommerce-page .col2-set,
			#order_review_heading,
			.woocommerce-checkout-review-order {
				width: 100%;
				float: none;
			}

		}

	<?php } ?>

	<?php } ?>

<?php

}