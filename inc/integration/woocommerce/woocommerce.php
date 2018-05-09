<?php
/**
 * WooCommerce Integration
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// WooCommerce Customizer Settings
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/wpbf-kirki-woocommerce.php' );

// WooCommerce Customizer Styles
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-styles.php' );

// WooCommerce Sidebar
add_action( 'widgets_init', 'wpbf_woocommerce_sidebar' );
function wpbf_woocommerce_sidebar() {

	register_sidebar( array(
		'id'			=> 'wpbf-woocommerce-sidebar',
		'name'			=> __( 'WooCommerce Sidebar', 'page-builder-framework' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4 class="wpbf-widgettitle">',
		'after_title'	=> '</h4>',
		'description'	=> __( 'WooCommerce sidebar widgets will appear here.', 'page-builder-framework' ),
	) );

	register_sidebar( array(
		'id'			=> 'wpbf-woocommerce-product-sidebar',
		'name'			=> __( 'WooCommerce Product Page Sidebar', 'page-builder-framework' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'	=> '<h4 class="wpbf-widgettitle">',
		'after_title'	=> '</h4>',
		'description'	=> __( 'WooCommerce sidebar widgets will appear here.', 'page-builder-framework' ),
	) );

}

// Shop Sidebars
function wpbf_woocommerce_sidebars( $sidebar ) {

	if( is_woocommerce() ) {

		if( is_product() ) {

			$sidebar ='wpbf-woocommerce-product-sidebar';

		} else {

			$sidebar = 'wpbf-woocommerce-sidebar';

		}

	}

	return $sidebar;

}
add_filter( 'wpbf_do_sidebar', 'wpbf_woocommerce_sidebars' );

// remove default wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Add custom wrappers.
add_action( 'woocommerce_before_main_content', 'wpbf_output_content_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'wpbf_output_content_wrapper_end', 10 );

function wpbf_output_content_wrapper() {

	// vars
	$single_sidebar_position_global = get_theme_mod( 'woocommerce_single_sidebar_layout' );
	$sidebar_position_global = get_theme_mod( 'woocommerce_sidebar_layout' );
	$grid_gap = get_theme_mod('sidebar_gap') ? get_theme_mod('sidebar_gap') : 'divider';

	echo '<div id="content">';

	if ( is_product() ) {

		$id = get_the_ID();
		$single_sidebar_position = get_post_meta( $id, 'wpbf_sidebar_position', true );

		wpbf_inner_content();

		if( $single_sidebar_position && $single_sidebar_position !== 'global' ) {

			echo $single_sidebar_position !== 'none' ? '<div class="wpbf-grid wpbf-grid-'. esc_attr( $grid_gap ) .'">' : '';

			$single_sidebar_position == 'left' ? get_sidebar() : '';

			echo $single_sidebar_position !== 'none' ? '<main id="main" class="wpbf-main wpbf-woocommerce-content wpbf-medium-2-3" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">' : '<main id="main" class="wpbf-main wpbf-woocommerce-content" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">';

		} elseif( $single_sidebar_position_global && $single_sidebar_position_global !== 'none' ) {

			echo '<div class="wpbf-grid wpbf-grid-'. esc_attr( $grid_gap ) .'">';

			$single_sidebar_position_global == 'left' ? get_sidebar() : '';

			echo '<main id="main" class="wpbf-main wpbf-woocommerce-content wpbf-medium-2-3" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">';

		} else {

			echo '<div id="inner-content" class="wpbf-container wpbf-container-center wpbf-padding-medium">';

			echo '<main id="main" class="wpbf-main wpbf-woocommerce-content">';

		}

	} else {

		echo '<div id="inner-content" class="wpbf-container wpbf-container-center wpbf-padding-medium">';

		if ( $sidebar_position_global && $sidebar_position_global !== 'none' ) {

			echo '<div class="wpbf-grid wpbf-grid-'. esc_attr( $grid_gap ) .'">';

			$sidebar_position_global == 'left' ? get_sidebar() : '';

			echo '<main id="main" class="wpbf-main wpbf-woocommerce-content wpbf-medium-2-3" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">';

		} else {

			echo '<main id="main" class="wpbf-main wpbf-woocommerce-content">';

		}
	}

}

function wpbf_output_content_wrapper_end() {

	$single_sidebar_position_global = get_theme_mod( 'woocommerce_single_sidebar_layout' );
	$sidebar_position_global = get_theme_mod( 'woocommerce_sidebar_layout' );

	if ( is_product() ) {

		$id = get_the_ID();
		$single_sidebar_position = get_post_meta( $id, 'wpbf_sidebar_position', true );

		if( $single_sidebar_position && $single_sidebar_position !== 'global' ) {

			// main
			echo '</main>';

			// right sidebar
			$single_sidebar_position == 'right' ? get_sidebar() : '';

			// grid
			echo $single_sidebar_position !== 'none' ? '</div>' : '';

			wpbf_inner_content_close();

		} elseif( $single_sidebar_position_global && $single_sidebar_position_global !== 'none' ) {

			// main
			echo '</main>';

			// right sidebar
			$single_sidebar_position_global == 'right' ? get_sidebar() : '';

			// grid
			echo '</div>';

		} else {

			// main
			echo '</main>';

			// inner content
			echo '</div>';

		}

	} else {

		if( $sidebar_position_global && $sidebar_position_global !== 'none' ) {

			// main
			echo '</main>';

			// right sidebar
			$sidebar_position_global == 'right' ? get_sidebar() : '';

			// grid
			echo '</div>';

		} else {

			// main
			echo '</main>';

		}

		// inner content
		echo '</div>';

	}

	// content
	echo '</div>';

}

// remove default sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/* Theme Mods */

// Hide Star Rating from Catalog
add_action( 'wp', 'wpbf_woocommerce_loop_remove_star_rating' );
function wpbf_woocommerce_loop_remove_star_rating() {
	if ( get_theme_mod( 'woocommerce_loop_remove_star_rating' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}
}

// remove sales badge from loop
add_action( 'wp', 'wpbf_woocommerce_loop_remove_sale_badge' );
function wpbf_woocommerce_loop_remove_sale_badge() {
	if ( get_theme_mod( 'woocommerce_loop_sale_position' ) && get_theme_mod( 'woocommerce_loop_sale_position' ) == 'none' ) {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	}
}


// hide woocommerce page title for archives
add_filter( 'woocommerce_show_page_title' , 'wpbf_woocommerce_loop_show_page_title' );
function wpbf_woocommerce_loop_show_page_title() {
	if ( !get_theme_mod( 'woocommerce_loop_show_page_title' ) ) {
		return false;
	} else {
		return true;
	}
}

// remove woocommerce breadcrumbs from shop pages
add_action( 'wp', 'wpbf_woocommerce_loop_show_breadcrumbs' );
function wpbf_woocommerce_loop_show_breadcrumbs() {
	if( !get_theme_mod( 'woocommerce_loop_show_breadcrumbs' ) ) {
    	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}

// Remove the result count from WooCommerce
add_action( 'wp', 'wpbf_woocommerce_loop_remove_result_count' );
function wpbf_woocommerce_loop_remove_result_count() {
	if( get_theme_mod( 'woocommerce_loop_remove_result_count' ) ) {
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
	}
}

// Remove the sorting dropdown from Woocommerce
add_action( 'wp', 'wpbf_woocommerce_loop_remove_ordering' );
function wpbf_woocommerce_loop_remove_ordering() {
	if( get_theme_mod( 'woocommerce_loop_remove_ordering' ) ) {
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );
	}
}

// remove sales badge from product pages
// remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );