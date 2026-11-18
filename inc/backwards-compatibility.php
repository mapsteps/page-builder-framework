<?php
/**
 * Backwards compatibility: the settings migrations from 2019–2021 and the clean-up of old options.
 *
 * They used to run on every request (about 110 setting reads, ~3 ms). Now they run once and record it in the option
 * `wpbf_migrations_done`: a fingerprint of the theme version, the active (child) theme and the archive list they ran
 * for. They run again when one of those changes, and when settings are saved that they act on (an old setting name, a
 * number in `menu_logo_size`, e.g. from importing an old export) or one of the old options reappears. What they do is
 * unchanged (wpbf_run_settings_migrations()).
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Raise this when a migration is added or changed, so every site runs them again once.
 */
const WPBF_SETTINGS_MIGRATIONS_FORMAT = 1;

/**
 * The fingerprint the migrations ran for.
 *
 * @return string
 */
function wpbf_settings_migrations_key() {

	return md5( wp_json_encode( array( WPBF_SETTINGS_MIGRATIONS_FORMAT, WPBF_VERSION, get_stylesheet(), apply_filters( 'wpbf_archives', array( 'archive' ) ) ) ) );

}

/**
 * Run the migrations unless they already ran for this fingerprint.
 */
function wpbf_maybe_run_settings_migrations() {

	$key = wpbf_settings_migrations_key();

	if ( get_option( 'wpbf_migrations_done' ) === $key ) {
		return;
	}

	wpbf_run_settings_migrations();

	update_option( 'wpbf_migrations_done', $key, true );

}

/**
 * Whether a setting is one the migrations act on.
 *
 * @param string $name The setting name (theme mod).
 * @param mixed  $value Its value.
 *
 * @return bool
 */
function wpbf_is_old_setting( $name, $value ) {

	if ( 'menu_logo_size' === $name ) {
		return is_numeric( $value );
	}

	return (bool) preg_match( '/^(?:menu_mobile_logo_size|blog_author|single_author|blog_comments|(?:menu_logo|menu_logo_font|menu_logo_description_font)_size_(?:desktop|tablet|mobile)|woocommerce_loop_products_per_row_(?:desktop|tablet|mobile)|(?:sub_menu|mobile_menu)_padding_(?:top|right|bottom|left)|sidebar_widget_padding_(?:top|right|bottom|left)(?:_(?:desktop|tablet|mobile))?|(?:.+_boxed|page)_padding_(?:top|right|bottom|left)_(?:desktop|tablet|mobile))$/', $name );

}

/**
 * Let the migrations run again when an option they act on is written: theme mods with an old setting added or changed,
 * or one of the old options they delete.
 *
 * @param string $option The option name.
 * @param mixed  $old_value The previous value (null when the option was added).
 * @param mixed  $value The new value.
 */
function wpbf_settings_migrations_check_option( $option, $old_value, $value ) {

	if ( 0 === strpos( $option, 'theme_mods_' ) ) {
		if ( ! is_array( $value ) ) {
			return;
		}

		$old_value = is_array( $old_value ) ? $old_value : array();

		foreach ( $value as $name => $setting ) {
			if ( ( ! array_key_exists( $name, $old_value ) || $old_value[ $name ] !== $setting ) && wpbf_is_old_setting( (string) $name, $setting ) ) {
				delete_option( 'wpbf_migrations_done' );
				return;
			}
		}

		return;
	}

	if ( in_array( $option, array( 'wpbf_bfcm_notice_dismissed', 'wpbf_bfcm_notice_dismissed_2022', 'wpbf_bfcm_notice_dismissed_2023', 'wpbf_bfcm_notice_dismissed_2024', 'wpbf_kirki_remote_url_contents_deleted' ), true ) ) {
		delete_option( 'wpbf_migrations_done' );
	}

}

add_action( 'updated_option', 'wpbf_settings_migrations_check_option', 10, 3 );
add_action(
	'added_option',
	function ( $option, $value ) {
		wpbf_settings_migrations_check_option( $option, null, $value );
	},
	10,
	2
);

/**
 * The migrations (unchanged, they used to run at the top level of this file on every request).
 */
function wpbf_run_settings_migrations() {

	$menu_mobile_logo_size = get_theme_mod( 'menu_mobile_logo_size' );

	if ( $menu_mobile_logo_size ) {
		remove_theme_mod( 'menu_mobile_logo_size' );
	}

	$sidebar_widget_padding_top    = get_theme_mod( 'sidebar_widget_padding_top' );
	$sidebar_widget_padding_right  = get_theme_mod( 'sidebar_widget_padding_right' );
	$sidebar_widget_padding_bottom = get_theme_mod( 'sidebar_widget_padding_bottom' );
	$sidebar_widget_padding_left   = get_theme_mod( 'sidebar_widget_padding_left' );

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

	/**
	 * Convert custom controls.
	 *
	 * From here downwards we convert previous custom/responsive customizer controls to be saved in a single theme_mod.
	 * This and the entire backwards compatibility might be removed after 1 year.
	 */

	// This theme mod existed a long time ago and is now causing issues with the new JSON below.
	// If it exists, we will have to update & convert it first, before checking for the new, responsive settings.
	$menu_logo_size = get_theme_mod( 'menu_logo_size' );

	if ( is_numeric( $menu_logo_size ) ) {

		$theme_mod_array = array(
			'desktop' => $menu_logo_size,
			'tablet'  => false,
			'mobile'  => false,
		);

		$theme_mod_array = json_encode( $theme_mod_array, true );

		set_theme_mod( 'menu_logo_size', $theme_mod_array );

	}

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

		set_theme_mod( 'menu_logo_size', $theme_mod_array );

		remove_theme_mod( 'menu_logo_size_desktop' );
		remove_theme_mod( 'menu_logo_size_tablet' );
		remove_theme_mod( 'menu_logo_size_mobile' );

	}

	// Logo font size.
	$menu_logo_font_size_desktop = get_theme_mod( 'menu_logo_font_size_desktop' );
	$menu_logo_font_size_tablet  = get_theme_mod( 'menu_logo_font_size_tablet' );
	$menu_logo_font_size_mobile  = get_theme_mod( 'menu_logo_font_size_mobile' );

	if ( $menu_logo_font_size_desktop || $menu_logo_font_size_tablet || $menu_logo_font_size_mobile ) {

		$theme_mod_array = array(
			'desktop' => $menu_logo_font_size_desktop,
			'tablet'  => $menu_logo_font_size_tablet,
			'mobile'  => $menu_logo_font_size_mobile,
		);

		$theme_mod_array = json_encode( $theme_mod_array, true );

		set_theme_mod( 'menu_logo_font_size', $theme_mod_array );

		remove_theme_mod( 'menu_logo_font_size_desktop' );
		remove_theme_mod( 'menu_logo_font_size_tablet' );
		remove_theme_mod( 'menu_logo_font_size_mobile' );

	}

	// Tagline font size.
	$menu_logo_description_font_size_desktop = get_theme_mod( 'menu_logo_description_font_size_desktop' );
	$menu_logo_description_font_size_tablet  = get_theme_mod( 'menu_logo_description_font_size_tablet' );
	$menu_logo_description_font_size_mobile  = get_theme_mod( 'menu_logo_description_font_size_mobile' );

	if ( $menu_logo_description_font_size_desktop || $menu_logo_description_font_size_tablet || $menu_logo_description_font_size_mobile ) {

		$theme_mod_array = array(
			'desktop' => $menu_logo_description_font_size_desktop,
			'tablet'  => $menu_logo_description_font_size_tablet,
			'mobile'  => $menu_logo_description_font_size_mobile,
		);

		$theme_mod_array = json_encode( $theme_mod_array, true );

		set_theme_mod( 'menu_logo_description_font_size', $theme_mod_array );

		remove_theme_mod( 'menu_logo_description_font_size_desktop' );
		remove_theme_mod( 'menu_logo_description_font_size_tablet' );
		remove_theme_mod( 'menu_logo_description_font_size_mobile' );

	}

	// Sub menu padding.
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

		$theme_mod_array = json_encode( $theme_mod_array, true );

		set_theme_mod( 'sub_menu_padding', $theme_mod_array );

		remove_theme_mod( 'sub_menu_padding_top' );
		remove_theme_mod( 'sub_menu_padding_right' );
		remove_theme_mod( 'sub_menu_padding_bottom' );
		remove_theme_mod( 'sub_menu_padding_left' );

	}

	// Mobile menu padding.
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

		$theme_mod_array = json_encode( $theme_mod_array, true );

		set_theme_mod( 'mobile_menu_padding', $theme_mod_array );

		remove_theme_mod( 'mobile_menu_padding_top' );
		remove_theme_mod( 'mobile_menu_padding_right' );
		remove_theme_mod( 'mobile_menu_padding_bottom' );
		remove_theme_mod( 'mobile_menu_padding_left' );

	}

	// WooCommerce products per row.
	$woocommerce_loop_products_per_row_desktop = get_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
	$woocommerce_loop_products_per_row_tablet  = get_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
	$woocommerce_loop_products_per_row_mobile  = get_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

	if ( $woocommerce_loop_products_per_row_desktop || $woocommerce_loop_products_per_row_tablet || $woocommerce_loop_products_per_row_mobile ) {

		$theme_mod_array = array(
			'desktop' => $woocommerce_loop_products_per_row_desktop ? $woocommerce_loop_products_per_row_desktop : '4',
			'tablet'  => $woocommerce_loop_products_per_row_tablet ? $woocommerce_loop_products_per_row_tablet : '2',
			'mobile'  => $woocommerce_loop_products_per_row_mobile ? $woocommerce_loop_products_per_row_mobile : '1',
		);

		$theme_mod_array = json_encode( $theme_mod_array, true );

		set_theme_mod( 'woocommerce_loop_products_per_row', $theme_mod_array );

		remove_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
		remove_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
		remove_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

	}

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

			$theme_mod_array = json_encode( $theme_mod_array, true );

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

	// Single boxed padding.
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

		$theme_mod_array = json_encode( $theme_mod_array, true );

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

	// Page padding.
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

		$theme_mod_array = json_encode( $theme_mod_array, true );

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

	// Sidebar widget padding.
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

		$theme_mod_array = json_encode( $theme_mod_array, true );

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

	// Page boxed padding.
	// This conversion is wrong as we need only one field per breakpoint (we are only working with left & right padding, not all around).
	// It remains here for the future.

	// $page_boxed_padding = get_theme_mod( 'page_boxed_padding' );

	// if ( is_numeric( $page_boxed_padding ) ) {

	// $theme_mod_array = array(
	// 'desktop_top'    => $page_boxed_padding,
	// 'desktop_right'  => $page_boxed_padding,
	// 'desktop_bottom' => $page_boxed_padding,
	// 'desktop_left'   => $page_boxed_padding,
	// 'tablet_top'     => false,
	// 'tablet_right'   => false,
	// 'tablet_bottom'  => false,
	// 'tablet_left'    => false,
	// 'mobile_top'     => false,
	// 'mobile_right'   => false,
	// 'mobile_bottom'  => false,
	// 'mobile_left'    => false,
	// );

	// $theme_mod_array = json_encode( $theme_mod_array, true );

	// set_theme_mod( 'page_boxed_padding', $theme_mod_array );

	// }

	// Clean up previous BFCM admin notice dismissals.
	$bfcm2021 = get_option( 'wpbf_bfcm_notice_dismissed' );
	$bfcm2022 = get_option( 'wpbf_bfcm_notice_dismissed_2022' );
	$bfcm2023 = get_option( 'wpbf_bfcm_notice_dismissed_2023' );
	$bfcm2024 = get_option( 'wpbf_bfcm_notice_dismissed_2024' );

	if ( $bfcm2021 ) {
		delete_option( 'wpbf_bfcm_notice_dismissed' );
	}

	if ( $bfcm2022 ) {
		delete_option( 'wpbf_bfcm_notice_dismissed_2022' );
	}

	if ( $bfcm2023 ) {
		delete_option( 'wpbf_bfcm_notice_dismissed_2023' );
	}

	if ( $bfcm2024 ) {
		delete_option( 'wpbf_bfcm_notice_dismissed_2024' );
	}

	/**
	 * Remove previously saved option that fixed an issue with fonts not being downloaded by Kirki.
	 * Since we no longer use Kirki, this is safe to be deleted.
	 */
	if ( get_option( 'wpbf_kirki_remote_url_contents_deleted' ) ) {
		delete_option( 'wpbf_kirki_remote_url_contents_deleted' );
	}

}

wpbf_maybe_run_settings_migrations();
