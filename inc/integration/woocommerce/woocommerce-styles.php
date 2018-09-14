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

add_action( 'wpbf_after_customizer_css', 'wpbf_do_woocommerce_customizer_css', 10 );
function wpbf_do_woocommerce_customizer_css() { ?>

	<?php // Accent Color ?>

	<?php if( get_theme_mod( 'page_accent_color' ) ) { ?>
		p.demo_store,
		.woocommerce-store-notice {
			background: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
		}

		.woocommerce-info:before {
			color: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
		}
		.woocommerce-info {
			border-top-color: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
		}

	<?php } ?>

	<?php // Menu Item Desktop ?>
	
	<?php if( get_theme_mod( 'woocommerce_menu_item_desktop' ) !== 'hide' ) { ?>

		<?php if( get_theme_mod( 'woocommerce_menu_item_desktop_color' ) ) { ?>

			.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
				background: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_desktop_color' ) ) ?>;
			}

			.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
				color: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_desktop_color' ) ) ?>;
			}

		<?php } elseif( get_theme_mod( 'menu_font_color' ) ) { ?>

			.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
				background: <?php echo esc_attr( get_theme_mod( 'menu_font_color' ) ) ?>;
			}

			.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
				color: <?php echo esc_attr( get_theme_mod( 'menu_font_color' ) ) ?>;
			}

		<?php } elseif( get_theme_mod( 'page_accent_color' ) ) { ?>

			.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
				background: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
			}

			.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
				color: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
			}

		<?php } ?>

	<?php } ?>

	<?php // Menu Item Mobile ?>

	<?php if( ( get_theme_mod( 'woocommerce_menu_item_mobile' ) !== 'hide' ) ) { ?>

		<?php if( get_theme_mod( 'woocommerce_menu_item_mobile_font_size' ) ) { ?>

		.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item {
			font-size: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_mobile_font_size' ) ) ?>;
		}

		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_menu_item_mobile_color' ) ) { ?>

		.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
			background: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_mobile_color' ) ) ?>;
		}

		.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
			color: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_mobile_color' ) ) ?>;
		}

		<?php } elseif( get_theme_mod( 'woocommerce_menu_item_desktop_color' ) ) { ?>

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
				background: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_desktop_color' ) ) ?>;
			}

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
				color: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_desktop_color' ) ) ?>;
			}

		<?php } elseif( get_theme_mod( 'mobile_menu_font_color' ) ) { ?>

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
				background: <?php echo esc_attr( get_theme_mod( 'mobile_menu_font_color' ) ) ?>;
			}

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
				color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_font_color' ) ) ?>;
			}

		<?php } elseif( get_theme_mod( 'menu_font_color' ) ) { ?>

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
				background: <?php echo esc_attr( get_theme_mod( 'menu_font_color' ) ) ?>;
			}

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
				color: <?php echo esc_attr( get_theme_mod( 'menu_font_color' ) ) ?>;
			}

		<?php } elseif( get_theme_mod( 'page_accent_color' ) ) { ?>

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {
				background: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
			}

			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {
				color: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
			}

		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_menu_item_mobile_icon_color' ) ) { ?>
			.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item > a {
				color: <?php echo esc_attr( get_theme_mod( 'woocommerce_menu_item_mobile_icon_color' ) ) ?>;
			}
		<?php } ?>

	<?php } ?>

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

	<?php if( get_theme_mod( 'woocommerce_loop_custom_width' ) ) { ?>
	.archive.woocommerce #inner-content {
		max-width: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_custom_width' ) ) ?>;
	}
	<?php } ?>

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

	<?php if( get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'right' ) { ?>
	.woocommerce ul.products li.product .onsale {
		right: 0;
		left: auto;
		margin-right: -10px;
	}
	<?php } elseif( get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'center' ) { ?>
	.woocommerce ul.products li.product .onsale {
		left: 50%;
		width: 90px;
		margin: 0 0 0 -45px;
		height: auto;
		line-height: 1;
		padding: 8px 0;
		border-radius: 0px;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_sale_layout' ) == 'square' ) { ?>
	.woocommerce span.onsale {
		border-radius: 0;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_sale_position' ) == 'inside' ) { ?>

	<?php if( !get_theme_mod( 'woocommerce_loop_sale_alignment' ) || get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'left' ) { ?>
	.woocommerce ul.products li.product .onsale {
		margin: 10px 0 0 10px;
	}
	<?php } elseif( get_theme_mod( 'woocommerce_loop_sale_alignment' ) == 'right' ) { ?>
	.woocommerce ul.products li.product .onsale {
		margin: 10px 10px 0 0;
	}
	<?php } ?>

	.woocommerce span.onsale {
		margin: 10px 0 0 10px;
	}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_sale_font_size' ) || get_theme_mod( 'woocommerce_loop_sale_font_color' ) || get_theme_mod( 'woocommerce_loop_sale_background_color' )  ) { ?>

	.woocommerce ul.products li.product .onsale,
	.woocommerce span.onsale {

		<?php if( get_theme_mod( 'woocommerce_loop_sale_font_size' ) ) { ?>
		font-size: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_sale_font_size' ) ) ?>;
		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_loop_sale_font_color' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_sale_font_color' ) ) ?>;
		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_loop_sale_background_color' ) ) { ?>
		background-color: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_sale_background_color' ) ) ?>;
		<?php } ?>

	}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_title_size' ) || get_theme_mod( 'woocommerce_loop_title_color' ) ) { ?>

	.woocommerce ul.products li.product h3, .woocommerce ul.products li.product .woocommerce-loop-product__title, .woocommerce ul.products li.product .woocommerce-loop-category__title {

	<?php if( get_theme_mod( 'woocommerce_loop_title_size' ) ) { ?>
	font-size: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_title_size' ) ) ?>;
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_title_color' ) ) { ?>
	color: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_title_color' ) ) ?>;
	<?php } ?>

	}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_price_size' ) || get_theme_mod( 'woocommerce_loop_price_color' ) ) { ?>

	.woocommerce ul.products li.product .price {

	<?php if( get_theme_mod( 'woocommerce_loop_price_size' ) ) { ?>
	font-size: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_price_size' ) ) ?>;
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_price_color' ) ) { ?>
	color: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_price_color' ) ) ?>;
	<?php } ?>

	}

	<?php } ?>
	
	<?php if( !get_theme_mod( 'woocommerce_single_price_color' ) && get_theme_mod( 'woocommerce_loop_price_color' ) ) { ?>
	.woocommerce div.product span.price, .woocommerce div.product p.price {
		color: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_price_color' ) ) ?>;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_loop_out_of_stock_font_size' ) || get_theme_mod( 'woocommerce_loop_out_of_stock_font_color' ) || get_theme_mod( 'woocommerce_loop_out_of_stock_background_color' )  ) { ?>

	.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {

		<?php if( get_theme_mod( 'woocommerce_loop_out_of_stock_font_size' ) ) { ?>
		font-size: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_out_of_stock_font_size' ) ) ?>;
		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_loop_out_of_stock_font_color' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_out_of_stock_font_color' ) ) ?>;
		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_loop_out_of_stock_background_color' ) ) { ?>
		background-color: <?php echo esc_attr( get_theme_mod( 'woocommerce_loop_out_of_stock_background_color' ) ) ?>;
		<?php } ?>

	}

	<?php } ?>

	<?php // Single ?>

	<?php if( get_theme_mod( 'woocommerce_single_custom_width' ) ) { ?>
	.single.woocommerce #inner-content {
		max-width: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_custom_width' ) ) ?>;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_alignment' ) == 'right' ) { ?>

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

		.single-product.woocommerce span.onsale {
			display: none;
		}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_image_width' ) && get_theme_mod( 'woocommerce_single_image_width' ) !== "50" && !wpbf_has_responsive_breakpoints() ) { ?>

		@media screen and (min-width:769px) {

			.woocommerce div.product div.images,
			.woocommerce #content div.product div.images,
			.woocommerce-page div.product div.images,
			.woocommerce-page #content div.product div.images {
				width: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_image_width' ) - 2 ) ?>%;
			}

			.woocommerce div.product div.summary,
			.woocommerce #content div.product div.summary,
			.woocommerce-page div.product div.summary,
			.woocommerce-page #content div.product div.summary {
				width: <?php echo esc_attr( 98 - get_theme_mod( 'woocommerce_single_image_width' ) ) ?>%;
			}

		}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_summary_separator' ) == 'show' ) { ?>

		.woocommerce div.product form.cart {
			padding-top: 20px;
			padding-bottom: 20px;
			border-top: 1px solid #d9d9e0;
			border-bottom: 1px solid #d9d9e0;
		}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_tabs_font_size' ) || get_theme_mod( 'woocommerce_single_tabs_font_color' ) ) { ?>

		.woocommerce div.product .woocommerce-tabs ul.tabs li a {

			<?php if( get_theme_mod( 'woocommerce_single_tabs_font_size' ) ) { ?>
			font-size: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_font_size' ) ) ?>;
			<?php } ?>

			<?php if( get_theme_mod( 'woocommerce_single_tabs_font_color' ) ) { ?>
			color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_font_color' ) ) ?>;
			<?php } ?>

		}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_tabs_font_color_alt' ) ) { ?>

		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover {
			color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_font_color_alt' ) ) ?>;
		}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_tabs_font_color_active' ) ) { ?>

		.woocommerce div.product .woocommerce-tabs ul.tabs li.active a {
			color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_font_color_active' ) ) ?>;
		}

	<?php } ?>

	<?php if( !get_theme_mod( 'woocommerce_single_tabs' ) || get_theme_mod( 'woocommerce_single_tabs' ) == 'default' ) { ?>

		<?php if( get_theme_mod( 'woocommerce_single_tabs_background_color' ) ) { ?>
		.woocommerce div.product .woocommerce-tabs ul.tabs li {
			background-color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_background_color' ) ) ?>;
		}
		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_single_tabs_background_color_alt' ) ) { ?>
		.woocommerce div.product .woocommerce-tabs ul.tabs li:hover {
			background-color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_background_color_alt' ) ) ?>;
			border-bottom-color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_background_color_alt' ) ) ?>;
		}
		<?php } ?>

		<?php if( get_theme_mod( 'woocommerce_single_tabs_background_color_active' ) ) { ?>
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active:hover {
			background-color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_background_color_active' ) ) ?>;
			border-bottom-color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_background_color_active' ) ) ?>;
		}
		<?php } ?>

	<?php } elseif( get_theme_mod( 'woocommerce_single_tabs' ) == 'modern' ) { ?>

		.woocommerce div.product .woocommerce-tabs ul.tabs {
			border-top: 1px solid #d9d9e0;
		}

		.woocommerce div.product .woocommerce-tabs ul.tabs li {
			border: none;
			border-top: 5px solid transparent;
			background: none;
			margin: 0 40px 0 0;
		}

		.woocommerce div.product .woocommerce-tabs ul.tabs li a {
			padding-left: 0;
			padding-right: 0;
		}

		.woocommerce div.product .woocommerce-tabs ul.tabs li:last-child {
			border-right: none;
		}

		.woocommerce div.product .woocommerce-tabs ul.tabs li:hover {
			background: none;
		}

		.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
			background: none;
			<?php if( get_theme_mod( 'woocommerce_single_tabs_font_color_active' ) ) { ?>
			border-top: 5px solid <?php echo esc_attr( get_theme_mod( 'woocommerce_single_tabs_font_color_active' ) ) ?>;
			<?php } elseif( get_theme_mod( 'page_accent_color' ) ) { ?>
			border-top: 5px solid <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
			<?php } else { ?>
			border-top: 5px solid #3ba9d2;
			<?php } ?>
		}

		.woocommerce div.product .woocommerce-tabs .panel {
			padding: 0;
			border: none;
			margin-top: 30px;
		}

	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_tabs_remove_headline' ) == 'hide' ) { ?>
		.woocommerce div.product .woocommerce-tabs .panel h2:first-child {
			display: none;
		}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_price_size' ) ) { ?>
	.woocommerce div.product span.price, .woocommerce div.product p.price {
		font-size: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_price_size' ) ) ?>;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'woocommerce_single_price_color' ) ) { ?>
	.woocommerce div.product span.price, .woocommerce div.product p.price {
		color: <?php echo esc_attr( get_theme_mod( 'woocommerce_single_price_color' ) ) ?>;
	}
	<?php } ?>

	<?php // Checkout Page ?>

	<?php if( get_theme_mod( 'woocommerce_checkout_layout' ) == 'side' ) { ?>

	.woocommerce-checkout .col2-set {
		width: 53%;
		float: left;
	}

	.woocommerce-checkout .col2-set .col-1,
	.woocommerce-checkout .col2-set .col-2 {
		float: none;
		width: 100%;
	}

	#order_review_heading {
		float: right;
		width: 42%;
	}

	.woocommerce-checkout-review-order {
		width: 42%;
		float: right;
	}

	.woocommerce #payment #place_order,
	.woocommerce-page #payment #place_order {
		width: 100%;
	}

	<?php if( !wpbf_has_responsive_breakpoints() ) { ?>		

		@media screen and (max-width:768px) {

			.woocommerce-checkout .col2-set,
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