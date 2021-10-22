<?php
/**
 * Theme mods.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Excerpt length.
 *
 * @param integer $excerpt_length The excerpt length.
 *
 * @return integer The updated excerpt lenght.
 */
function wpbf_excerpt_length( $excerpt_length ) {

	$wpbf_excerpt_length = get_theme_mod( 'excerpt_lenght' );

	if ( empty( $wpbf_excerpt_length ) ) {
		return $excerpt_length;
	}

	return $wpbf_excerpt_length;

}
add_filter( 'excerpt_length', 'wpbf_excerpt_length', 999 );

/**
 * Excerpt more.
 *
 * @param integer $excerpt_more The excerpt indicator.
 *
 * @return integer The updated excerpt indicator.
 */
function wpbf_excerpt_more( $excerpt_more ) {

	$wpbf_excerpt_more = get_theme_mod( 'excerpt_more' );

	if ( ! $wpbf_excerpt_more ) {
		return $excerpt_more;
	}

	return $wpbf_excerpt_more;

}
add_filter( 'excerpt_more', 'wpbf_excerpt_more', 999 );

/**
 * Filter 404 page title.
 *
 * @param string $title The page title.
 *
 * @return string The updated page title.
 */
function wpbf_custom_404_title( $title ) {

	$custom_title = get_theme_mod( '404_headline' );

	if ( $custom_title ) {
		return $custom_title;
	}

	return $title;

}
add_filter( 'wpbf_404_headline', 'wpbf_custom_404_title' );


/**
 * Filter 404 page text.
 *
 * @param string $text The page text.
 *
 * @return string The updated page text.
 */
function wpbf_custom_404_text( $text ) {

	$custom_text = get_theme_mod( '404_text' );

	if ( $custom_text ) {
		return $custom_text;
	}

	return $text;

}
add_filter( 'wpbf_404_text', 'wpbf_custom_404_text' );

/**
 * Hide search form from 404 page.
 */
function wpbf_remove_404_search_form() {

	if ( is_404() && 'hide' === get_theme_mod( '404_search_form' ) ) {

		add_filter( 'get_search_form', '__return_false' );

	}

}
add_action( 'wp', 'wpbf_remove_404_search_form' );

/**
 * Construct search menu item.
 *
 * @param boolean $is_inside_main_menu If we're inside the navigation.
 * @param boolean $is_mobile If we're on mobile.
 *
 * @return string The search menu item.
 */
function wpbf_search_menu_item( $is_inside_main_menu = true, $is_mobile = false ) {

	$class = $is_mobile ? 'wpbf-mobile-nav-item' : 'wpbf-nav-item';

	// If we have a shop, let's call the product search form
	if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'woocommerce_search_menu_item' ) ) {
		$search_form = get_product_search_form( $echo = false );
	} else {
		$search_form = get_search_form( $echo = false );
	}

	// Allow the search form to be filtered for more flexibility.
	$search_form = apply_filters( 'wpbf_search_menu_item_form', $search_form );

	// We have a slightly different markup for the search menu item if it's being displayed outside the main menu.
	$search_item  = $is_inside_main_menu ? '<li class="menu-item wpbf-menu-item-search" aria-haspopup="true" aria-expanded="false"><a href="javascript:void(0)" role="button">' : '<div class="' . $class . ' wpbf-menu-item-search" aria-haspopup="true" aria-expanded="false" role="button">';
	$search_item .= '<span class="screen-reader-text">' . __( 'Search Toggle', 'page-builder-framework' ) . '</span>';
	$search_item .= '<div class="wpbf-menu-search">';
	$search_item .= $search_form;
	$search_item .= '</div>';

	if ( wpbf_svg_enabled() ) {

		$search_item .= '
		<span class="wpbf-icon">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32" role="img" aria-hidden="true">
				<path d="M16 20.784c-1.094 0.463-2.259 0.698-3.462 0.698s-2.367-0.235-3.462-0.698c-1.059-0.448-2.011-1.090-2.829-1.908s-1.46-1.77-1.908-2.829c-0.463-1.094-0.698-2.259-0.698-3.462s0.235-2.367 0.698-3.462c0.448-1.059 1.090-2.011 1.908-2.829s1.77-1.46 2.829-1.908c1.094-0.463 2.259-0.698 3.462-0.698s2.367 0.235 3.462 0.698c1.059 0.448 2.011 1.090 2.829 1.908s1.46 1.77 1.908 2.829c0.463 1.094 0.698 2.259 0.698 3.462s-0.235 2.367-0.698 3.462c-0.448 1.059-1.090 2.011-1.908 2.829s-1.77 1.46-2.829 1.908zM31.661 29.088l-9.068-9.068c1.539-2.078 2.45-4.65 2.45-7.435 0-6.906-5.598-12.505-12.505-12.505s-12.505 5.598-12.505 12.505c0 6.906 5.598 12.505 12.505 12.505 2.831 0 5.442-0.941 7.537-2.526l9.055 9.055c0.409 0.409 1.073 0.409 1.482 0l1.048-1.048c0.409-0.409 0.409-1.073 0-1.482z"></path>
			</svg>
		</span>';

	} else {

		$search_item .= '<i class="wpbff wpbff-search" aria-hidden="true"></i>';

	}

	$search_item .= $is_inside_main_menu ? '</a></li>' : '</div>';

	return $search_item;

}

/**
 * Add search menu item to main menu.
 *
 * @param string $items The menu items.
 * @param object $args The arguments.
 *
 * @return string The updated menu items.
 */
function wpbf_search_menu_icon( $items, $args ) {

	// Stop here, if we have an off canvas menu.
	if ( wpbf_is_off_canvas_menu() ) {
		return $items;
	}

	// Only add the search menu item to the main navigation and if it's enabled.
	if ( 'main_menu' === $args->theme_location && get_theme_mod( 'menu_search_icon' ) ) {
		$items .= wpbf_search_menu_item();
	}

	return $items;

}
add_filter( 'wp_nav_menu_items', 'wpbf_search_menu_icon', 20, 2 );

/**
 * Add search menu item to mobile menu.
 */
function wpbf_search_menu_icon_mobile() {

	// Stop here if search menu item is turned off.
	if ( ! get_theme_mod( 'mobile_menu_search_icon' ) ) {
		return;
	}

	echo wpbf_search_menu_item( $is_navigation = false, $is_mobile = true );

}
add_action( 'wpbf_before_mobile_toggle', 'wpbf_search_menu_icon_mobile', 20 );

/**
 * Custom breadcrumbs separator.
 *
 * @param string $separator The separator.
 *
 * @return string The updated separator.
 */
function wpbf_breadcrumbs_custom_separator( $separator ) {

	$custom_separator = get_theme_mod( 'breadcrumbs_separator' );

	if ( $custom_separator ) {
		return $custom_separator;
	}

	return $separator;

}
add_filter( 'wpbf_breadcrumbs_separator', 'wpbf_breadcrumbs_custom_separator' );

/**
 * Next post link.
 *
 * @param string $next The next post link.
 *
 * @return string The updated post link.
 */
function wpbf_next_post_link( $next ) {

	if ( 'default' !== get_theme_mod( 'single_post_nav' ) ) {
		return $next;
	}

	return '%title &rarr;';

}
add_filter( 'wpbf_next_post_link', 'wpbf_next_post_link' );

/**
 * Previous post link.
 *
 * @param string $next The previous post link.
 *
 * @return string The updated post link.
 */
function wpbf_previous_post_link( $prev ) {

	if ( 'default' !== get_theme_mod( 'single_post_nav' ) ) {
		return $prev;
	}

	return '&larr; %title';

}
add_filter( 'wpbf_previous_post_link', 'wpbf_previous_post_link' );

/**
 * Categories title.
 *
 * @param string $title The categories title.
 *
 * @return string The updated categories title.
 */
function wpbf_categories_title( $title ) {

	$cat_title = get_theme_mod( 'blog_categories_title' );

	if ( $cat_title ) {
		return $cat_title;
	}

	return $title;

}
add_filter( 'wpbf_categories_title', 'wpbf_categories_title' );

/**
 * Read more text.
 *
 * @param string $text The read more text.
 *
 * @return string The updated read more text.
 */
function wpbf_read_more_text( $text ) {

	$read_more_text = get_theme_mod( 'blog_read_more_text' );

	if ( $read_more_text ) {
		return $read_more_text;
	}

	return $text;

}
add_filter( 'wpbf_read_more_text', 'wpbf_read_more_text' );

/**
 * Article meta separatpr.
 *
 * @param string $separator The separator.
 *
 * @return string The updated separator.
 */
function wpbf_article_meta_separator( $separator ) {

	$blog_meta_separator = get_theme_mod( 'blog_meta_separator' );

	if ( $blog_meta_separator ) {
		return ' ' . $blog_meta_separator . ' ';
	}

	return $separator;

}
add_filter( 'wpbf_article_meta_separator', 'wpbf_article_meta_separator' );

/**
 * Custom mobile logo.
 *
 * @param string $logo_url The logo url.
 *
 * @return string The updated logo url.
 */
function wpbf_mobile_logo( $logo_url ) {

	$custom_logo_url = get_theme_mod( 'menu_mobile_logo' );

	if ( $custom_logo_url ) {
		return $custom_logo_url;
	}

	return $logo_url;

}
add_filter( 'wpbf_logo_mobile', 'wpbf_mobile_logo' );

/**
 * Auto collapse mobile sub-menu navigation class.
 *
 * Add class to .wpbf-navigation if auto collapse sub-menu enabled.
 */
function wpbf_mobile_sub_menu_auto_collapse_class( $classes ) {

	return ( get_theme_mod( 'mobile_sub_menu_auto_collapse' ) ? $classes . ' wpbf-mobile-sub-menu-auto-collapse' : $classes );

}
add_filter( 'wpbf_navigation_classes', 'wpbf_mobile_sub_menu_auto_collapse_class' );
