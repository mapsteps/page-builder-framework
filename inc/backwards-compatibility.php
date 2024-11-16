<?php
/**
 * Backwards compatibility.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$executed_backwards_compat = get_option( 'wpbf_backwards_compatibility', array() );
$executed_backwards_compat = ! empty( $executed_backwards_compat ) && is_array( $executed_backwards_compat ) ? $executed_backwards_compat : array();

if ( empty( $executed_backwards_compat['menu_mobile_logo_size'] ) ) {
	$menu_mobile_logo_size = get_theme_mod( 'menu_mobile_logo_size' );

	if ( $menu_mobile_logo_size ) {
		remove_theme_mod( 'menu_mobile_logo_size' );
	}

	$executed_backwards_compat['menu_mobile_logo_size'] = 1;
}

if ( empty( $executed_backwards_compat['sidebar_widget_padding_top'] ) ) {
	$sidebar_widget_padding_top = get_theme_mod( 'sidebar_widget_padding_top' );

	if ( $sidebar_widget_padding_top ) {
		remove_theme_mod( 'sidebar_widget_padding_top' );
	}

	$executed_backwards_compat['sidebar_widget_padding_top'] = 1;
}

if ( empty( $executed_backwards_compat['sidebar_widget_padding_right'] ) ) {
	$sidebar_widget_padding_right = get_theme_mod( 'sidebar_widget_padding_right' );

	if ( $sidebar_widget_padding_right ) {
		remove_theme_mod( 'sidebar_widget_padding_right' );
	}

	$executed_backwards_compat['sidebar_widget_padding_right'] = 1;
}

if ( empty( $executed_backwards_compat['sidebar_widget_padding_bottom'] ) ) {
	$sidebar_widget_padding_bottom = get_theme_mod( 'sidebar_widget_padding_bottom' );

	if ( $sidebar_widget_padding_bottom ) {
		remove_theme_mod( 'sidebar_widget_padding_bottom' );
	}

	$executed_backwards_compat['sidebar_widget_padding_bottom'] = 1;
}

if ( empty( $executed_backwards_compat['sidebar_widget_padding_left'] ) ) {
	$sidebar_widget_padding_left = get_theme_mod( 'sidebar_widget_padding_left' );

	if ( $sidebar_widget_padding_left ) {
		remove_theme_mod( 'sidebar_widget_padding_left' );
	}

	$executed_backwards_compat['sidebar_widget_padding_left'] = 1;
}

if ( empty( $executed_backwards_compat['blog_sortable_meta'] ) ) {
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
}

if ( empty( $executed_backwards_compat['menu_logo_size_data_type'] ) ) {
	/**
	 * This theme mod existed a long time ago and is now causing issues with the new JSON below.
	 * If it exists, we will have to update & convert it first, before checking for the new, responsive settings.
	 */
	$menu_logo_size = get_theme_mod( 'menu_logo_size' );

	if ( is_numeric( $menu_logo_size ) ) {

		$theme_mod_array = array(
			'desktop' => $menu_logo_size,
			'tablet'  => false,
			'mobile'  => false,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'menu_logo_size', $theme_mod_array );

	}

	$executed_backwards_compat['menu_logo_size'] = 1;
}

/**
 * Merge individual color setting keys to multicolor control.
 */

// Merge `pre_header_accent_color` and `pre_header_accent_color_alt` to `pre_header_accent_colors`.
if ( empty( $executed_backwards_compat['pre_header_accent_color'] ) ) {
	$pre_header_accent_color     = get_theme_mod( 'pre_header_accent_color' );
	$pre_header_accent_color_alt = get_theme_mod( 'pre_header_accent_color_alt' );

	// Delete the old theme mods regardless of their emptyness.
	remove_theme_mod( 'pre_header_accent_color' );
	remove_theme_mod( 'pre_header_accent_color_alt' );

	if ( $pre_header_accent_color || $pre_header_accent_color_alt ) {
		$pre_header_accent_colors = array();

		if ( $pre_header_accent_color ) {
			$pre_header_accent_colors['default'] = $pre_header_accent_color;
		}

		if ( $pre_header_accent_color_alt ) {
			$pre_header_accent_colors['hover'] = $pre_header_accent_color_alt;
		}

		set_theme_mod( 'pre_header_accent_colors', $pre_header_accent_colors );
	}

	$executed_backwards_compat['pre_header_accent_color'] = 1;
}

// Merge `menu_font_color` and `menu_font_color_alt` to `menu_font_colors`.
if ( empty( $executed_backwards_compat['menu_font_colors'] ) ) {
	$menu_font_color     = get_theme_mod( 'menu_font_color' );
	$menu_font_color_alt = get_theme_mod( 'menu_font_color_alt' );

	// Delete the old theme mods regardless of their emptyness.
	remove_theme_mod( 'menu_font_color' );
	remove_theme_mod( 'menu_font_color_alt' );

	if ( $menu_font_color || $menu_font_color_alt ) {
		$menu_font_colors = array();

		if ( $menu_font_color ) {
			$menu_font_colors['default'] = $menu_font_color;
		}

		if ( $menu_font_color_alt ) {
			$menu_font_colors['hover'] = $menu_font_color_alt;
		}

		set_theme_mod( 'menu_font_colors', $menu_font_colors );
	}

	$executed_backwards_compat['menu_font_colors'] = 1;
}

/**
 * Convert individual responsive controls.
 *
 * From here downwards we convert previous individual responsive setting keys to be saved in a single key.
 * This and the entire backwards compatibility might be removed after 1 year.
 */

// Logo size.
if ( empty( $executed_backwards_compat['responsive_menu_logo_size'] ) ) {
	$menu_logo_size_desktop = get_theme_mod( 'menu_logo_size_desktop' );
	$menu_logo_size_tablet  = get_theme_mod( 'menu_logo_size_tablet' );
	$menu_logo_size_mobile  = get_theme_mod( 'menu_logo_size_mobile' );

	if ( $menu_logo_size_desktop || $menu_logo_size_tablet || $menu_logo_size_mobile ) {

		$theme_mod_array = array(
			'desktop' => $menu_logo_size_desktop,
			'tablet'  => $menu_logo_size_tablet,
			'mobile'  => $menu_logo_size_mobile,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'menu_logo_size', $theme_mod_array );

		remove_theme_mod( 'menu_logo_size_desktop' );
		remove_theme_mod( 'menu_logo_size_tablet' );
		remove_theme_mod( 'menu_logo_size_mobile' );

	}

	$executed_backwards_compat['responsive_menu_logo_size'] = 1;
}

// Logo font size.
if ( empty( $executed_backwards_compat['responsive_menu_logo_font_size'] ) ) {
	$menu_logo_font_size_desktop = get_theme_mod( 'menu_logo_font_size_desktop' );
	$menu_logo_font_size_tablet  = get_theme_mod( 'menu_logo_font_size_tablet' );
	$menu_logo_font_size_mobile  = get_theme_mod( 'menu_logo_font_size_mobile' );

	if ( $menu_logo_font_size_desktop || $menu_logo_font_size_tablet || $menu_logo_font_size_mobile ) {

		$theme_mod_array = array(
			'desktop' => $menu_logo_font_size_desktop,
			'tablet'  => $menu_logo_font_size_tablet,
			'mobile'  => $menu_logo_font_size_mobile,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'menu_logo_font_size', $theme_mod_array );

		remove_theme_mod( 'menu_logo_font_size_desktop' );
		remove_theme_mod( 'menu_logo_font_size_tablet' );
		remove_theme_mod( 'menu_logo_font_size_mobile' );

	}

	$executed_backwards_compat['responsive_menu_logo_font_size'] = 1;
}

// Tagline font size.
if ( empty( $executed_backwards_compat['responsive_menu_logo_description_font_size'] ) ) {
	$menu_logo_description_font_size_desktop = get_theme_mod( 'menu_logo_description_font_size_desktop' );
	$menu_logo_description_font_size_tablet  = get_theme_mod( 'menu_logo_description_font_size_tablet' );
	$menu_logo_description_font_size_mobile  = get_theme_mod( 'menu_logo_description_font_size_mobile' );

	if ( $menu_logo_description_font_size_desktop || $menu_logo_description_font_size_tablet || $menu_logo_description_font_size_mobile ) {

		$theme_mod_array = array(
			'desktop' => $menu_logo_description_font_size_desktop,
			'tablet'  => $menu_logo_description_font_size_tablet,
			'mobile'  => $menu_logo_description_font_size_mobile,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'menu_logo_description_font_size', $theme_mod_array );

		remove_theme_mod( 'menu_logo_description_font_size_desktop' );
		remove_theme_mod( 'menu_logo_description_font_size_tablet' );
		remove_theme_mod( 'menu_logo_description_font_size_mobile' );

	}

	$executed_backwards_compat['responsive_menu_logo_description_font_size'] = 1;
}

// Sub menu padding.
if ( empty( $executed_backwards_compat['responsive_sub_menu_padding'] ) ) {
	$sub_menu_padding_top    = get_theme_mod( 'sub_menu_padding_top' );
	$sub_menu_padding_right  = get_theme_mod( 'sub_menu_padding_right' );
	$sub_menu_padding_bottom = get_theme_mod( 'sub_menu_padding_bottom' );
	$sub_menu_padding_left   = get_theme_mod( 'sub_menu_padding_left' );

	if ( $sub_menu_padding_top || $sub_menu_padding_right || $sub_menu_padding_bottom || $sub_menu_padding_left ) {

		$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
			'top'    => $sub_menu_padding_top,
			'right'  => $sub_menu_padding_right,
			'bottom' => $sub_menu_padding_bottom,
			'left'   => $sub_menu_padding_left,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'sub_menu_padding', $theme_mod_array );

		remove_theme_mod( 'sub_menu_padding_top' );
		remove_theme_mod( 'sub_menu_padding_right' );
		remove_theme_mod( 'sub_menu_padding_bottom' );
		remove_theme_mod( 'sub_menu_padding_left' );

	}

	$executed_backwards_compat['responsive_sub_menu_padding'] = 1;
}

// Mobile menu padding.
if ( empty( $executed_backwards_compat['responsive_mobile_menu_padding'] ) ) {
	$mobile_menu_padding_top    = get_theme_mod( 'mobile_menu_padding_top' );
	$mobile_menu_padding_right  = get_theme_mod( 'mobile_menu_padding_right' );
	$mobile_menu_padding_bottom = get_theme_mod( 'mobile_menu_padding_bottom' );
	$mobile_menu_padding_left   = get_theme_mod( 'mobile_menu_padding_left' );

	if ( $mobile_menu_padding_top || $mobile_menu_padding_right || $mobile_menu_padding_bottom || $mobile_menu_padding_left ) {

		$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
			'top'    => $mobile_menu_padding_top,
			'right'  => $mobile_menu_padding_right,
			'bottom' => $mobile_menu_padding_bottom,
			'left'   => $mobile_menu_padding_left,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'mobile_menu_padding', $theme_mod_array );

		remove_theme_mod( 'mobile_menu_padding_top' );
		remove_theme_mod( 'mobile_menu_padding_right' );
		remove_theme_mod( 'mobile_menu_padding_bottom' );
		remove_theme_mod( 'mobile_menu_padding_left' );

	}

	$executed_backwards_compat['responsive_mobile_menu_padding'] = 1;
}

// WooCommerce products per row.
if ( empty( $executed_backwards_compat['responsive_woocommerce_loop_products_per_row'] ) ) {
	$woocommerce_loop_products_per_row_desktop = get_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
	$woocommerce_loop_products_per_row_tablet  = get_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
	$woocommerce_loop_products_per_row_mobile  = get_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

	if ( $woocommerce_loop_products_per_row_desktop || $woocommerce_loop_products_per_row_tablet || $woocommerce_loop_products_per_row_mobile ) {

		$theme_mod_array = array(
			'desktop' => $woocommerce_loop_products_per_row_desktop ? $woocommerce_loop_products_per_row_desktop : '4',
			'tablet'  => $woocommerce_loop_products_per_row_tablet ? $woocommerce_loop_products_per_row_tablet : '2',
			'mobile'  => $woocommerce_loop_products_per_row_mobile ? $woocommerce_loop_products_per_row_mobile : '1',
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'woocommerce_loop_products_per_row', $theme_mod_array );

		remove_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
		remove_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
		remove_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

	}

	$executed_backwards_compat['responsive_woocommerce_loop_products_per_row'] = 1;
}

if ( empty( $executed_backwards_compat['responsive_archives_boxed_padding'] ) ) {
	$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

	foreach ( $archives as $archive ) {

		// Archive boxed padding.
		$boxed_padding_top_desktop    = get_theme_mod( $archive . '_boxed_padding_top_desktop' );
		$boxed_padding_right_desktop  = get_theme_mod( $archive . '_boxed_padding_right_desktop' );
		$boxed_padding_bottom_desktop = get_theme_mod( $archive . '_boxed_padding_bottom_desktop' );
		$boxed_padding_left_desktop   = get_theme_mod( $archive . '_boxed_padding_left_desktop' );

		$boxed_padding_top_tablet    = get_theme_mod( $archive . '_boxed_padding_top_tablet' );
		$boxed_padding_right_tablet  = get_theme_mod( $archive . '_boxed_padding_right_tablet' );
		$boxed_padding_bottom_tablet = get_theme_mod( $archive . '_boxed_padding_bottom_tablet' );
		$boxed_padding_left_tablet   = get_theme_mod( $archive . '_boxed_padding_left_tablet' );

		$boxed_padding_top_mobile    = get_theme_mod( $archive . '_boxed_padding_top_mobile' );
		$boxed_padding_right_mobile  = get_theme_mod( $archive . '_boxed_padding_right_mobile' );
		$boxed_padding_bottom_mobile = get_theme_mod( $archive . '_boxed_padding_bottom_mobile' );
		$boxed_padding_left_mobile   = get_theme_mod( $archive . '_boxed_padding_left_mobile' );

		if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet || $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

			$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
				'desktop_top'    => $boxed_padding_top_desktop,
				'desktop_right'  => $boxed_padding_right_desktop,
				'desktop_bottom' => $boxed_padding_bottom_desktop,
				'desktop_left'   => $boxed_padding_left_desktop,
				'tablet_top'     => $boxed_padding_top_tablet,
				'tablet_right'   => $boxed_padding_right_tablet,
				'tablet_bottom'  => $boxed_padding_bottom_tablet,
				'tablet_left'    => $boxed_padding_left_tablet,
				'mobile_top'     => $boxed_padding_top_mobile,
				'mobile_right'   => $boxed_padding_right_mobile,
				'mobile_bottom'  => $boxed_padding_bottom_mobile,
				'mobile_left'    => $boxed_padding_left_mobile,
			);

			$theme_mod_array = wp_json_encode( $theme_mod_array, true );

			set_theme_mod( $archive . '_boxed_padding', $theme_mod_array );

			remove_theme_mod( $archive . '_boxed_padding_top_desktop' );
			remove_theme_mod( $archive . '_boxed_padding_right_desktop' );
			remove_theme_mod( $archive . '_boxed_padding_bottom_desktop' );
			remove_theme_mod( $archive . '_boxed_padding_left_desktop' );

			remove_theme_mod( $archive . '_boxed_padding_top_tablet' );
			remove_theme_mod( $archive . '_boxed_padding_right_tablet' );
			remove_theme_mod( $archive . '_boxed_padding_bottom_tablet' );
			remove_theme_mod( $archive . '_boxed_padding_left_tablet' );

			remove_theme_mod( $archive . '_boxed_padding_top_mobile' );
			remove_theme_mod( $archive . '_boxed_padding_right_mobile' );
			remove_theme_mod( $archive . '_boxed_padding_bottom_mobile' );
			remove_theme_mod( $archive . '_boxed_padding_left_mobile' );

		}

	}

	$executed_backwards_compat['responsive_archives_boxed_padding'] = 1;
}

// Single boxed padding.
if ( empty( $executed_backwards_compat['responsive_single_boxed_padding'] ) ) {
	$boxed_padding_top_desktop    = get_theme_mod( 'single_boxed_padding_top_desktop' );
	$boxed_padding_right_desktop  = get_theme_mod( 'single_boxed_padding_right_desktop' );
	$boxed_padding_bottom_desktop = get_theme_mod( 'single_boxed_padding_bottom_desktop' );
	$boxed_padding_left_desktop   = get_theme_mod( 'single_boxed_padding_left_desktop' );

	$boxed_padding_top_tablet    = get_theme_mod( 'single_boxed_padding_top_tablet' );
	$boxed_padding_right_tablet  = get_theme_mod( 'single_boxed_padding_right_tablet' );
	$boxed_padding_bottom_tablet = get_theme_mod( 'single_boxed_padding_bottom_tablet' );
	$boxed_padding_left_tablet   = get_theme_mod( 'single_boxed_padding_left_tablet' );

	$boxed_padding_top_mobile    = get_theme_mod( 'single_boxed_padding_top_mobile' );
	$boxed_padding_right_mobile  = get_theme_mod( 'single_boxed_padding_right_mobile' );
	$boxed_padding_bottom_mobile = get_theme_mod( 'single_boxed_padding_bottom_mobile' );
	$boxed_padding_left_mobile   = get_theme_mod( 'single_boxed_padding_left_mobile' );

	if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet || $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

		$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
			'desktop_top'    => $boxed_padding_top_desktop,
			'desktop_right'  => $boxed_padding_right_desktop,
			'desktop_bottom' => $boxed_padding_bottom_desktop,
			'desktop_left'   => $boxed_padding_left_desktop,
			'tablet_top'     => $boxed_padding_top_tablet,
			'tablet_right'   => $boxed_padding_right_tablet,
			'tablet_bottom'  => $boxed_padding_bottom_tablet,
			'tablet_left'    => $boxed_padding_left_tablet,
			'mobile_top'     => $boxed_padding_top_mobile,
			'mobile_right'   => $boxed_padding_right_mobile,
			'mobile_bottom'  => $boxed_padding_bottom_mobile,
			'mobile_left'    => $boxed_padding_left_mobile,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'single_boxed_padding', $theme_mod_array );

		remove_theme_mod( 'single_boxed_padding_top_desktop' );
		remove_theme_mod( 'single_boxed_padding_right_desktop' );
		remove_theme_mod( 'single_boxed_padding_bottom_desktop' );
		remove_theme_mod( 'single_boxed_padding_left_desktop' );

		remove_theme_mod( 'single_boxed_padding_top_tablet' );
		remove_theme_mod( 'single_boxed_padding_right_tablet' );
		remove_theme_mod( 'single_boxed_padding_bottom_tablet' );
		remove_theme_mod( 'single_boxed_padding_left_tablet' );

		remove_theme_mod( 'single_boxed_padding_top_mobile' );
		remove_theme_mod( 'single_boxed_padding_right_mobile' );
		remove_theme_mod( 'single_boxed_padding_bottom_mobile' );
		remove_theme_mod( 'single_boxed_padding_left_mobile' );

	}

	$executed_backwards_compat['responsive_single_boxed_padding'] = 1;
}

// Page padding.
if ( empty( $executed_backwards_compat['responsive_page_padding'] ) ) {
	$page_padding_top_desktop    = get_theme_mod( 'page_padding_top_desktop' );
	$page_padding_right_desktop  = get_theme_mod( 'page_padding_right_desktop' );
	$page_padding_bottom_desktop = get_theme_mod( 'page_padding_bottom_desktop' );
	$page_padding_left_desktop   = get_theme_mod( 'page_padding_left_desktop' );

	$page_padding_top_tablet    = get_theme_mod( 'page_padding_top_tablet' );
	$page_padding_right_tablet  = get_theme_mod( 'page_padding_right_tablet' );
	$page_padding_bottom_tablet = get_theme_mod( 'page_padding_bottom_tablet' );
	$page_padding_left_tablet   = get_theme_mod( 'page_padding_left_tablet' );

	$page_padding_top_mobile    = get_theme_mod( 'page_padding_top_mobile' );
	$page_padding_right_mobile  = get_theme_mod( 'page_padding_right_mobile' );
	$page_padding_bottom_mobile = get_theme_mod( 'page_padding_bottom_mobile' );
	$page_padding_left_mobile   = get_theme_mod( 'page_padding_left_mobile' );

	if ( $page_padding_top_desktop || $page_padding_right_desktop || $page_padding_bottom_desktop || $page_padding_left_desktop || $page_padding_top_tablet || $page_padding_right_tablet || $page_padding_bottom_tablet || $page_padding_left_tablet || $page_padding_top_desktop || $page_padding_right_desktop || $page_padding_bottom_desktop || $page_padding_left_desktop || $page_padding_top_mobile || $page_padding_right_mobile || $page_padding_bottom_mobile || $page_padding_left_mobile ) {

		$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
			'desktop_top'    => $page_padding_top_desktop,
			'desktop_right'  => $page_padding_right_desktop,
			'desktop_bottom' => $page_padding_bottom_desktop,
			'desktop_left'   => $page_padding_left_desktop,
			'tablet_top'     => $page_padding_top_tablet,
			'tablet_right'   => $page_padding_right_tablet,
			'tablet_bottom'  => $page_padding_bottom_tablet,
			'tablet_left'    => $page_padding_left_tablet,
			'mobile_top'     => $page_padding_top_mobile,
			'mobile_right'   => $page_padding_right_mobile,
			'mobile_bottom'  => $page_padding_bottom_mobile,
			'mobile_left'    => $page_padding_left_mobile,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'page_padding', $theme_mod_array );

		remove_theme_mod( 'page_padding_top_desktop' );
		remove_theme_mod( 'page_padding_right_desktop' );
		remove_theme_mod( 'page_padding_bottom_desktop' );
		remove_theme_mod( 'page_padding_left_desktop' );

		remove_theme_mod( 'page_padding_top_tablet' );
		remove_theme_mod( 'page_padding_right_tablet' );
		remove_theme_mod( 'page_padding_bottom_tablet' );
		remove_theme_mod( 'page_padding_left_tablet' );

		remove_theme_mod( 'page_padding_top_mobile' );
		remove_theme_mod( 'page_padding_right_mobile' );
		remove_theme_mod( 'page_padding_bottom_mobile' );
		remove_theme_mod( 'page_padding_left_mobile' );

	}

	$executed_backwards_compat['responsive_page_padding'] = 1;
}

// Sidebar widget padding.
if ( empty( $executed_backwards_compat['responsive_sidebar_widget_padding'] ) ) {

	$sidebar_widget_padding_top_desktop    = get_theme_mod( 'sidebar_widget_padding_top_desktop' );
	$sidebar_widget_padding_right_desktop  = get_theme_mod( 'sidebar_widget_padding_right_desktop' );
	$sidebar_widget_padding_bottom_desktop = get_theme_mod( 'sidebar_widget_padding_bottom_desktop' );
	$sidebar_widget_padding_left_desktop   = get_theme_mod( 'sidebar_widget_padding_left_desktop' );

	$sidebar_widget_padding_top_tablet    = get_theme_mod( 'sidebar_widget_padding_top_tablet' );
	$sidebar_widget_padding_right_tablet  = get_theme_mod( 'sidebar_widget_padding_right_tablet' );
	$sidebar_widget_padding_bottom_tablet = get_theme_mod( 'sidebar_widget_padding_bottom_tablet' );
	$sidebar_widget_padding_left_tablet   = get_theme_mod( 'sidebar_widget_padding_left_tablet' );

	$sidebar_widget_padding_top_mobile    = get_theme_mod( 'sidebar_widget_padding_top_mobile' );
	$sidebar_widget_padding_right_mobile  = get_theme_mod( 'sidebar_widget_padding_right_mobile' );
	$sidebar_widget_padding_bottom_mobile = get_theme_mod( 'sidebar_widget_padding_bottom_mobile' );
	$sidebar_widget_padding_left_mobile   = get_theme_mod( 'sidebar_widget_padding_left_mobile' );

	if ( $sidebar_widget_padding_top_desktop || $sidebar_widget_padding_right_desktop || $sidebar_widget_padding_bottom_desktop || $sidebar_widget_padding_left_desktop || $sidebar_widget_padding_top_tablet || $sidebar_widget_padding_right_tablet || $sidebar_widget_padding_bottom_tablet || $sidebar_widget_padding_left_tablet || $sidebar_widget_padding_top_desktop || $sidebar_widget_padding_right_desktop || $sidebar_widget_padding_bottom_desktop || $sidebar_widget_padding_left_desktop || $sidebar_widget_padding_top_mobile || $sidebar_widget_padding_right_mobile || $sidebar_widget_padding_bottom_mobile || $sidebar_widget_padding_left_mobile ) {

		$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
			'desktop_top'    => $sidebar_widget_padding_top_desktop,
			'desktop_right'  => $sidebar_widget_padding_right_desktop,
			'desktop_bottom' => $sidebar_widget_padding_bottom_desktop,
			'desktop_left'   => $sidebar_widget_padding_left_desktop,
			'tablet_top'     => $sidebar_widget_padding_top_tablet,
			'tablet_right'   => $sidebar_widget_padding_right_tablet,
			'tablet_bottom'  => $sidebar_widget_padding_bottom_tablet,
			'tablet_left'    => $sidebar_widget_padding_left_tablet,
			'mobile_top'     => $sidebar_widget_padding_top_mobile,
			'mobile_right'   => $sidebar_widget_padding_right_mobile,
			'mobile_bottom'  => $sidebar_widget_padding_bottom_mobile,
			'mobile_left'    => $sidebar_widget_padding_left_mobile,
		);

		$theme_mod_array = wp_json_encode( $theme_mod_array, true );

		set_theme_mod( 'sidebar_widget_padding', $theme_mod_array );

		remove_theme_mod( 'sidebar_widget_padding_top_desktop' );
		remove_theme_mod( 'sidebar_widget_padding_right_desktop' );
		remove_theme_mod( 'sidebar_widget_padding_bottom_desktop' );
		remove_theme_mod( 'sidebar_widget_padding_left_desktop' );

		remove_theme_mod( 'sidebar_widget_padding_top_tablet' );
		remove_theme_mod( 'sidebar_widget_padding_right_tablet' );
		remove_theme_mod( 'sidebar_widget_padding_bottom_tablet' );
		remove_theme_mod( 'sidebar_widget_padding_left_tablet' );

		remove_theme_mod( 'sidebar_widget_padding_top_mobile' );
		remove_theme_mod( 'sidebar_widget_padding_right_mobile' );
		remove_theme_mod( 'sidebar_widget_padding_bottom_mobile' );
		remove_theme_mod( 'sidebar_widget_padding_left_mobile' );

	}

	$executed_backwards_compat['responsive_sidebar_widget_padding'] = 1;
}

// End of individual responsive setting keys backwards compatibility.

update_option( 'wpbf_backwards_compatibility', $executed_backwards_compat );

/**
 * Page boxed padding.
 * This conversion is wrong as we need only one field per breakpoint (we are only working with left & right padding, not all around).
 * It remains here for the future.
 */

/**
$page_boxed_padding = get_theme_mod( 'page_boxed_padding' );

if ( is_numeric( $page_boxed_padding ) ) {

	$theme_mod_array = array(
		'desktop_top'    => $page_boxed_padding,
		'desktop_right'  => $page_boxed_padding,
		'desktop_bottom' => $page_boxed_padding,
		'desktop_left'   => $page_boxed_padding,
		'tablet_top'     => false,
		'tablet_right'   => false,
		'tablet_bottom'  => false,
		'tablet_left'    => false,
		'mobile_top'     => false,
		'mobile_right'   => false,
		'mobile_bottom'  => false,
		'mobile_left'    => false,
	);

	$theme_mod_array = wp_json_encode( $theme_mod_array, true );

	set_theme_mod( 'page_boxed_padding', $theme_mod_array );

}
*/

$previous_bfcm_dismissal_option_keys = [
	'wpbf_bfcm_notice_dismissed',
	'wpbf_bfcm_notice_dismissed_2022',
	'wpbf_bfcm_notice_dismissed_2023',
];

// Clean up previous BFCM admin notice dismissal options.
foreach ( $previous_bfcm_dismissal_option_keys as $dismissal_option_key ) {
	$dismissal_option = get_option( $dismissal_option_key );

	if ( $dismissal_option ) {
		delete_option( $dismissal_option_key );
	}
}

/**
 * Remove previously saved option that fixed an issue with fonts not being downloaded by Kirki.
 * Since we no longer use Kirki, this is safe to be deleted.
 */
if ( get_option( 'wpbf_kirki_remote_url_contents_deleted' ) ) {
	delete_option( 'wpbf_kirki_remote_url_contents_deleted' );
}
