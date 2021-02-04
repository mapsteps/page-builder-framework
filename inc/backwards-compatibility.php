<?php
/**
 * Backwards compatibility.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$sidebar_widget_padding_top      = get_theme_mod( 'sidebar_widget_padding_top' );
$sidebar_widget_padding_right    = get_theme_mod( 'sidebar_widget_padding_right' );
$sidebar_widget_padding_bottom   = get_theme_mod( 'sidebar_widget_padding_bottom' );
$sidebar_widget_padding_left     = get_theme_mod( 'sidebar_widget_padding_left' );

if ( $sidebar_widget_padding_top ) {
	remove_theme_mod( 'sidebar_widget_padding_top' );
}

if ( $sidebar_widget_padding_right ) {
	remove_theme_mod( 'sidebar_widget_padding_right' );
}

if ( $sidebar_widget_padding_bottom ) {
	remove_theme_mod( 'sidebar_widget_padding_bottom' );
}

if ( $sidebar_widget_padding_left ) {
	remove_theme_mod( 'sidebar_widget_padding_left' );
}

$article_meta  = get_theme_mod( 'blog_sortable_meta', array( 'author', 'date' ) );
$blog_author   = get_theme_mod( 'blog_author' );
$single_author = get_theme_mod( 'single_author' );
$blog_comments = get_theme_mod( 'blog_comments' );

if ( 'hide' === $blog_author || 'hide' === $single_author ) {

	$article_meta = array_diff( $article_meta, array( 'author' ) );
	$article_meta = array_values( $article_meta );

	set_theme_mod( 'blog_sortable_meta', $article_meta );
	remove_theme_mod( 'blog_author' );
	remove_theme_mod( 'single_author' );

}

if ( 'show' === $blog_comments ) {

	$article_meta[] = 'comments';

	set_theme_mod( 'blog_sortable_meta', $article_meta );
	remove_theme_mod( 'blog_comments' );

}

/* Converted custom controls */

// Logo size.
$menu_logo_size_desktop = get_theme_mod( 'menu_logo_size_desktop' );
$menu_logo_size_tablet  = get_theme_mod( 'menu_logo_size_tablet' );
$menu_logo_size_mobile  = get_theme_mod( 'menu_logo_size_mobile' );

if ( $menu_logo_size_desktop || $menu_logo_size_tablet || $menu_logo_size_mobile ) {

	$theme_mod_array = array(
		'desktop' => $menu_logo_size_desktop,
		'tablet'  => $menu_logo_size_tablet,
		'mobile'  => $menu_logo_size_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	// set_theme_mod( 'menu_logo_size', $theme_mod_array );

	// remove_theme_mod( 'menu_logo_size_desktop' );
	// remove_theme_mod( 'menu_logo_size_tablet' );
	// remove_theme_mod( 'menu_logo_size_mobile' );

}

// Sub menu padding.
$sub_menu_padding_top    = get_theme_mod( 'sub_menu_padding_top' );
$sub_menu_padding_right  = get_theme_mod( 'sub_menu_padding_right' );
$sub_menu_padding_bottom = get_theme_mod( 'sub_menu_padding_bottom' );
$sub_menu_padding_left   = get_theme_mod( 'sub_menu_padding_left' );

if ( $sub_menu_padding_top || $sub_menu_padding_right || $sub_menu_padding_bottom || $sub_menu_padding_left ) {

	$theme_mod_array = array(
		'top'    => $sub_menu_padding_top,
		'right'  => $sub_menu_padding_right,
		'bottom' => $sub_menu_padding_bottom,
		'left'   => $sub_menu_padding_left,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	// set_theme_mod( 'sub_menu_padding', $theme_mod_array );

	// remove_theme_mod( 'sub_menu_padding_top' );
	// remove_theme_mod( 'sub_menu_padding_right' );
	// remove_theme_mod( 'sub_menu_padding_bottom' );
	// remove_theme_mod( 'sub_menu_padding_left' );

}

// Mobile menu padding.
$mobile_menu_padding_top    = get_theme_mod( 'mobile_menu_padding_top' );
$mobile_menu_padding_right  = get_theme_mod( 'mobile_menu_padding_right' );
$mobile_menu_padding_bottom = get_theme_mod( 'mobile_menu_padding_bottom' );
$mobile_menu_padding_left   = get_theme_mod( 'mobile_menu_padding_left' );

if ( $mobile_menu_padding_top || $mobile_menu_padding_right || $mobile_menu_padding_bottom || $mobile_menu_padding_left ) {

	$theme_mod_array = array(
		'top'    => $mobile_menu_padding_top,
		'right'  => $mobile_menu_padding_right,
		'bottom' => $mobile_menu_padding_bottom,
		'left'   => $mobile_menu_padding_left,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	// set_theme_mod( 'mobile_menu_padding', $theme_mod_array );

	// remove_theme_mod( 'mobile_menu_padding_top' );
	// remove_theme_mod( 'mobile_menu_padding_right' );
	// remove_theme_mod( 'mobile_menu_padding_bottom' );
	// remove_theme_mod( 'mobile_menu_padding_left' );

}

// WooCommerce products per row.
$woocommerce_loop_products_per_row_desktop = get_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
$woocommerce_loop_products_per_row_tablet  = get_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
$woocommerce_loop_products_per_row_mobile  = get_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

if ( $woocommerce_loop_products_per_row_desktop || $woocommerce_loop_products_per_row_tablet || $woocommerce_loop_products_per_row_mobile ) {

	$theme_mod_array = array(
		'desktop' => $woocommerce_loop_products_per_row_desktop,
		'tablet'  => $woocommerce_loop_products_per_row_tablet,
		'mobile'  => $woocommerce_loop_products_per_row_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	// set_theme_mod( 'woocommerce_loop_products_per_row', $theme_mod_array );

	// remove_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
	// remove_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
	// remove_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

}
