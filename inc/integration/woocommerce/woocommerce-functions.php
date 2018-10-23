<?php
/**
 * WooCommerce Functions
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */

// Styles & Scripts
add_action( 'wp_enqueue_scripts', 'wpbf_woo_fragment_refresh' );

function wpbf_woo_fragment_refresh() {

    wp_enqueue_script( 'wpbf-woocommerce-fragment-refresh', get_template_directory_uri() . '/assets/woocommerce/js/woocommerce-fragment-refresh.js', array(  'jquery', 'customize-preview' ), '', true  );

}

// Deregister Defaults
add_action( 'wp', 'wpbf_woo_deregister_defaults', 10 );
function wpbf_woo_deregister_defaults() {

	// Default Sidebar
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	// Default Wrappers
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	// Loop
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	// remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	// remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

}

add_action( 'wp', 'wpbf_woo_register_defaults', 20 );
function wpbf_woo_register_defaults() {
	add_action( 'woocommerce_after_shop_loop_item', 'wpbf_woo_loop_content' );
}

// remove first & last classes from WooCommerce Loop
add_filter( 'post_class', 'wpbf_woo_loop_remove_first_last_class', 21 );
function wpbf_woo_loop_remove_first_last_class( $classes ) {
	if( 'product' == get_post_type() ) {
		$classes = array_diff( $classes, array( 'first', 'last' ) );
	}
	return $classes;
}

// Register Sidebar
add_action( 'widgets_init', 'wpbf_woo_sidebar' );
function wpbf_woo_sidebar() {

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

// Filter Sidebar
function wpbf_woo_sidebars( $sidebar ) {

	if( is_woocommerce() ) {

		if( is_product() ) {

			$sidebar ='wpbf-woocommerce-product-sidebar';

		} else {

			$sidebar = 'wpbf-woocommerce-sidebar';

		}

	}

	return $sidebar;

}
add_filter( 'wpbf_do_sidebar', 'wpbf_woo_sidebars' );

/* Wrappers */

// Add custom wrappers
add_action( 'woocommerce_before_main_content', 'wpbf_woo_output_content_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'wpbf_woo_output_content_wrapper_end', 10 );

// Start
function wpbf_woo_output_content_wrapper() {

	// vars
	$single_sidebar_position_global = get_theme_mod( 'woocommerce_single_sidebar_layout' );
	$sidebar_position_global = get_theme_mod( 'woocommerce_sidebar_layout' );
	$grid_gap = get_theme_mod( 'sidebar_gap', 'medium' );

	echo '<div id="content">';

	if ( is_product() ) {

		$id = get_the_ID();
		$single_sidebar_position = get_post_meta( $id, 'wpbf_sidebar_position', true );

		wpbf_inner_content();

		if( $single_sidebar_position && $single_sidebar_position !== 'global' ) {

			echo $single_sidebar_position !== 'none' ? '<div class="wpbf-grid wpbf-grid-'. esc_attr( $grid_gap ) .'">' : '';

			$single_sidebar_position == 'left' ? get_sidebar() : '';

			echo $single_sidebar_position !== 'none' ? '<main id="main" class="wpbf-main wpbf-medium-2-3'. wpbf_singular_class() .'">' : '<main id="main" class="wpbf-main'. wpbf_singular_class() .'">';

		} elseif( $single_sidebar_position_global && $single_sidebar_position_global !== 'none' ) {

			echo '<div class="wpbf-grid wpbf-grid-'. esc_attr( $grid_gap ) .'">';

			$single_sidebar_position_global == 'left' ? get_sidebar() : '';

			echo '<main id="main" class="wpbf-main wpbf-medium-2-3'. wpbf_singular_class() .'">';

		} else {

			echo '<main id="main" class="wpbf-main'. wpbf_singular_class() .'">';

		}

	} else {

		echo '<div id="inner-content" class="wpbf-container wpbf-container-center wpbf-padding-medium">';

		if ( $sidebar_position_global && $sidebar_position_global !== 'none' ) {

			echo '<div class="wpbf-grid wpbf-grid-'. esc_attr( $grid_gap ) .'">';

			$sidebar_position_global == 'left' ? get_sidebar() : '';

			echo '<main id="main" class="wpbf-main wpbf-medium-2-3'. wpbf_archive_class() .'">';

		} else {

			echo '<main id="main" class="wpbf-main'. wpbf_archive_class() .'">';

		}
	}

}

// End
function wpbf_woo_output_content_wrapper_end() {

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

// Loop Start
function wpbf_woo_product_loop_start() {
	$mobile_breakpoint = get_theme_mod( 'woocommerce_loop_products_per_row_mobile', 1 );
	$tablet_breakpoint = get_theme_mod( 'woocommerce_loop_products_per_row_tablet', 3 );
	$desktop_breakpoint = get_theme_mod( 'woocommerce_loop_products_per_row_desktop', 4 );
	$grid_gap = get_theme_mod( 'woocommerce_loop_grid_gap', 'large' );

	return '<ul class="wpbf-grid wpbf-grid-'. esc_attr( $grid_gap ) .' wpbf-grid-1-'. esc_attr( $mobile_breakpoint ) .' wpbf-grid-small-1-'. esc_attr( $tablet_breakpoint ) .' wpbf-grid-large-1-'. esc_attr( $desktop_breakpoint ) .' products">'; 

}

add_filter( 'woocommerce_product_loop_start', 'wpbf_woo_product_loop_start', 0 );

// Loop End
function wpbf_woo_product_loop_end() {
	return '</ul>'; 
}

add_filter( 'woocommerce_product_loop_end', 'wpbf_woo_product_loop_end', 0 );

// Thumbnail Wrapper Start
function wpbf_woo_loop_thumbnail_wrap_start() {
	echo '<div class="wpbf-woo-loop-thumbnail-wrapper">';
	echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'wpbf_woo_loop_thumbnail_wrap_start', 5 );

// Thumbnail Wrapper End
function wpbf_woo_loop_thumbnail_wrap_end() {
	echo '</a>';
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'wpbf_woo_loop_thumbnail_wrap_end', 12 );

/* Theme Mods */

// remove sales badge from loop
add_action( 'wp', 'wpbf_woo_loop_remove_sale_badge' );
function wpbf_woo_loop_remove_sale_badge() {
	if ( get_theme_mod( 'woocommerce_loop_sale_position' ) && get_theme_mod( 'woocommerce_loop_sale_position' ) == 'none' ) {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	}
}

// hide woocommerce page title for archives
add_filter( 'woocommerce_show_page_title' , 'wpbf_woo_loop_remove_page_title' );
function wpbf_woo_loop_remove_page_title() {
	if ( get_theme_mod( 'woocommerce_loop_remove_page_title' ) ) {
		return false;
	} else {
		return true;
	}
}

// remove woocommerce breadcrumbs from shop pages
add_action( 'wp', 'wpbf_woo_loop_remove_breadcrumbs' );
function wpbf_woo_loop_remove_breadcrumbs() {
	if( get_theme_mod( 'woocommerce_loop_remove_breadcrumbs' ) ) {
    	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}

// Remove the result count from shop pages
add_action( 'wp', 'wpbf_woo_loop_remove_result_count' );
function wpbf_woo_loop_remove_result_count() {
	if( get_theme_mod( 'woocommerce_loop_remove_result_count' ) ) {
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
	}
}

// Remove the sorting dropdown from shop pages
add_action( 'wp', 'wpbf_woo_loop_remove_ordering' );
function wpbf_woo_loop_remove_ordering() {
	if( get_theme_mod( 'woocommerce_loop_remove_ordering' ) ) {
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );
	}
}

/* General Functions */

// Out of Stock Notice
function wpbf_woo_loop_out_of_stock() {

	if( !get_theme_mod( 'woocommerce_loop_out_of_stock_notice' ) || get_theme_mod( 'woocommerce_loop_out_of_stock_notice' ) !== 'hide' ) {

	$out_of_stock = get_post_meta( get_the_ID(), '_stock_status', true );
	$out_of_stock_string = apply_filters( 'wpbf_woo_loop_out_of_stock_string', __( 'Out of stock', 'page-builder-framework' ) );

	if ( $out_of_stock == 'outofstock' ) { ?>
		<span class="wpbf-woo-loop-out-of-stock"><?php echo esc_attr( $out_of_stock_string ); ?></span>
	<?php }

	}

}
add_action( 'woocommerce_before_shop_loop_item_title', 'wpbf_woo_loop_out_of_stock', 11 );

// Add Parent Category to Loop
function wpbf_woo_loop_category() { ?>

	<span class="wpbf-woo-product-category">
		<?php
		global $product;
		$categories = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( get_the_ID(), ',', '', '' ) : $product->get_categories( ',', '', '' );

		$categories = strip_tags( $categories );
		if ( $categories ) {
			list( $parent_category ) = explode( ',', $categories );
			echo esc_attr( $parent_category );
		}
		?>
	</span> 

<?php }

// Title
function wpbf_woo_loop_title() {

	echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
	echo '<h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3>';
	echo '</a>';

}

// Short Description
function wpbf_woo_loop_short_description() {
?>
<?php if ( has_excerpt() ) { ?>
	<div class="wpbf-woo-loop-excerpt">
		<?php the_excerpt(); ?>
	</div>
<?php } ?>
<?php
}

// Loop Content
function wpbf_woo_loop_content() {

	$content = get_theme_mod( 'woocommerce_loop_sortable_content', array( 'category', 'title', 'price', 'add_to_cart' ) );

	if ( is_array( $content ) && ! empty( $content ) ) {

		do_action( 'wpbf_woo_loop_before_summary' );
		echo '<div class="wpbf-woo-loop-summary">';
		do_action( 'wpbf_woo_loop_summary_open' );

		foreach ( $content as $value ) {

			switch ( $value ) {
				case 'title':
					do_action( 'wpbf_woo_loop_before_title' );
					wpbf_woo_loop_title();
					do_action( 'wpbf_woo_loop_after_title' );
					break;
				case 'price':
					do_action( 'wpbf_woo_loop_before_price' );
					woocommerce_template_loop_price();
					do_action( 'wpbf_woo_loop_after_price' );
					break;
				case 'rating':
					do_action( 'wpbf_woo_loop_before_rating' );
					woocommerce_template_loop_rating();
					do_action( 'wpbf_woo_loop_after_rating' );
					break;
				case 'excerpt':
					do_action( 'wpbf_woo_loop_before_excerpt' );
					wpbf_woo_loop_short_description();
					do_action( 'wpbf_woo_loop_after_excerpt' );
					break;
				case 'add_to_cart':
					do_action( 'wpbf_woo_loop_before_add_to_cart' );
					woocommerce_template_loop_add_to_cart();
					do_action( 'wpbf_woo_loop_after_add_to_cart' );
					break;
				case 'category':
					do_action( 'wpbf_woo_loop_before_category' );
					wpbf_woo_loop_category();
					do_action( 'wpbf_woo_loop_after_category' );
					break;
				default:
					break;
			}
		}

		do_action( 'wpbf_woo_loop_summary_close' );
		echo '</div>';
		do_action( 'wpbf_woo_loop_after_summary' );
	}
}

// Products per Row
add_filter( 'loop_shop_columns', 'wpbf_loop_columns' );
function wpbf_loop_columns() {

	$columns = get_theme_mod( 'woocommerce_loop_products_per_row_desktop', 4 );

	return $columns;

}

function wpbf_woo_menu_item_class_current( $css_classes ) {

	if ( is_cart() ) $css_classes .= ' current-menu-item';
	return $css_classes;

}
add_filter( 'wpbf_woo_menu_item_classes', 'wpbf_woo_menu_item_class_current' );

/* Menu Item */
function wpbf_woo_menu_item() {

	// vars
	$icon = get_theme_mod( 'woocommerce_menu_item_icon', 'cart' );
	$css_classes = apply_filters( 'wpbf_woo_menu_item_classes', 'menu-item wpbf-woo-menu-item' );
	$title = apply_filters( 'wpbf_woo_menu_item_title', __( 'Shopping Cart', 'page-builder-framework' ) );
	$cart_count = WC()->cart->get_cart_contents_count();
	$cart_url = wc_get_cart_url();

	// construct menu item
	$menu_item = '';

	$menu_item .= '<li class="'. esc_attr( $css_classes ) .'">';

		$menu_item .= '<a href="' . esc_url( $cart_url ) . '" title="'. esc_attr( $title ) .'">';

			$menu_item .= apply_filters( 'wpbf_woo_before_menu_item', '' );

			$menu_item .= '<i class="wpbff wpbff-'. esc_attr( $icon ) .'"></i>';
			if( get_theme_mod( 'woocommerce_menu_item_count' ) !== 'hide' ) $menu_item .= '<span class="wpbf-woo-menu-item-count">' . wp_kses_data( $cart_count ) . '</span>';

			$menu_item .= apply_filters( 'wpbf_woo_after_menu_item', '' );

		$menu_item .= '</a>';

		$menu_item .= apply_filters( 'wpbf_woo_menu_item_dropdown', '' );

	$menu_item .= '</li>';

	return $menu_item;

}

// Add menu item to mobile menu toggle
add_action( 'wpbf_before_mobile_toggle', 'wpbf_woo_menu_item_mobile_menu', 10 );
function wpbf_woo_menu_item_mobile_menu() {

	if( get_theme_mod( 'woocommerce_menu_item_mobile' ) == 'hide' ) return;

	$menu_item = '';
	$menu_item .= '<ul class="wpbf-woo-menu-item-wrapper">';
	$menu_item .= wpbf_woo_menu_item();
	$menu_item .= '</ul>';

	echo $menu_item; // WPCS: XSS ok.

}

// Add menu item to main navigation
add_filter( 'wp_nav_menu_items', 'wpbf_woo_cart_menu_icon', 10, 2 );
function wpbf_woo_cart_menu_icon( $items, $args ) {

	// stop right here if menu item is hidden
	if( get_theme_mod( 'woocommerce_menu_item_desktop' ) == 'hide' ) return $items;

	// stop here if we're on a off canvas menu
	if( wpbf_is_off_canvas_menu() ) return $items;

	if ( $args->theme_location === 'main_menu' ) {

		$items .= wpbf_woo_menu_item();
	}

	return $items;

}

// WooCommerce Fragments
add_filter( 'woocommerce_add_to_cart_fragments', 'wpbf_woo_fragments' );

function wpbf_woo_fragments( $fragments ) {

	global $woocommerce;

	ob_start();
	echo wpbf_woo_menu_item(); // WPCS: XSS ok.
	$fragments['li.wpbf-woo-menu-item'] = ob_get_clean();

	return $fragments;

}