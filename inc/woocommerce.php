<?php
/**
 * WooCommerce
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

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

// shop sidebars
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