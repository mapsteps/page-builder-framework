<?php
/**
 * Dynamic Easy Digital Downloads CSS.
 *
 * Holds Customizer EDD CSS styles.
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

function wpbf_do_edd_customizer_css() {

	// Radio buttons.
	$page_accent_color = ( $val = get_theme_mod( 'page_accent_color' ) ) === '#3ba9d2' ? false : $val;

	if ( $page_accent_color ) {

		echo '.edd_download_purchase_form .edd_single_mode input[type="radio"]:checked + .edd_price_option_name::before {';
		echo sprintf( 'border-color: %s;', esc_attr( $page_accent_color ) );
		echo '}';

		echo '.edd_download_purchase_form .edd_single_mode input[type="radio"]:checked + .edd_price_option_name::after {';
		echo sprintf( 'background: %s;', esc_attr( $page_accent_color ) );
		echo '}';

	}

	// Theme buttons.
	$button_border_width             = get_theme_mod( 'button_border_width' );
	$button_border_color             = get_theme_mod( 'button_border_color' );
	$button_border_color_alt         = get_theme_mod( 'button_border_color_alt' );
	$button_primary_border_color     = get_theme_mod( 'button_primary_border_color' );
	$button_primary_border_color_alt = get_theme_mod( 'button_primary_border_color_alt' );
	$button_bg_color                 = get_theme_mod( 'button_bg_color' );
	$button_text_color               = get_theme_mod( 'button_text_color' );
	$button_border_radius            = get_theme_mod( 'button_border_radius' );
	$button_bg_color_alt             = get_theme_mod( 'button_bg_color_alt' );
	$button_text_color_alt           = get_theme_mod( 'button_text_color_alt' );
	$button_primary_bg_color         = get_theme_mod( 'button_primary_bg_color' );
	$button_primary_text_color       = get_theme_mod( 'button_primary_text_color' );
	$button_primary_bg_color_alt     = get_theme_mod( 'button_primary_bg_color_alt' );
	$button_primary_text_color_alt   = get_theme_mod( 'button_primary_text_color_alt' );

	if ( $button_border_width ) {

		echo '.edd-submit.button, .edd-submit.button.gray {';
		echo sprintf( 'border-width: %s;', esc_attr( $button_border_width ) . 'px' );
		echo 'border-style: solid;';

		if ( $button_border_color ) {
			echo sprintf( 'border-color: %s;', esc_attr( $button_border_color ) );
		}

		echo '}';

		if ( $button_border_color_alt ) {

			echo '.edd-submit.button:hover, .edd-submit.button.gray:hover {';
			echo sprintf( 'border-color: %s;', esc_attr( $button_border_color_alt ) );
			echo '}';

		}

		if ( $button_primary_border_color ) {

			echo '.edd-submit.button.blue {';
			echo sprintf( 'border-color: %s;', esc_attr( $button_primary_border_color ) );
			echo '}';

		}

		if ( $button_primary_border_color_alt ) {

			echo '.edd-submit.button.blue:hover {';
			echo sprintf( 'border-color: %s;', esc_attr( $button_primary_border_color_alt ) );
			echo '}';

		}

	}

	if ( $button_bg_color || $button_text_color || $button_border_radius ) {

		echo '.edd-submit.button, .edd-submit.button.gray {';

		if ( $button_border_radius ) {
			echo sprintf( 'border-radius: %s;', esc_attr( $button_border_radius ) . 'px' );
		}

		if ( $button_bg_color ) {
			echo sprintf( 'background: %s;', esc_attr( $button_bg_color ) );
		}

		if ( $button_text_color ) {
			echo sprintf( 'color: %s;', esc_attr( $button_text_color ) );
		}

		echo '}';

	}

	if ( $button_bg_color_alt || $button_text_color_alt ) {

		echo '.edd-submit.button:hover, .edd-submit.button.gray:hover {';

		if ( $button_bg_color_alt ) {
			echo sprintf( 'background: %s;', esc_attr( $button_bg_color_alt ) );
		}

		if ( $button_text_color_alt ) {
			echo sprintf( 'color: %s;', esc_attr( $button_text_color_alt ) );
		}

		echo '}';

	}

	if ( $button_primary_bg_color || $button_primary_text_color ) {

		echo '.edd-submit.button.blue {';

		if ( $button_primary_bg_color ) {
			echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color ) );
		}

		if ( $button_primary_text_color ) {
			echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color ) );
		}

		echo '}';

	}

	if ( $button_primary_bg_color_alt || $button_primary_text_color_alt ) {

		echo '.edd-submit.button.blue:hover {';

		if ( $button_primary_bg_color_alt ) {
			echo sprintf( 'background: %s;', esc_attr( $button_primary_bg_color_alt ) );
		}

		if ( $button_primary_text_color_alt ) {
			echo sprintf( 'color: %s;', esc_attr( $button_primary_text_color_alt ) );
		}

		echo '}';

	}

	// Menu item desktop.
	$edd_menu_item_desktop       = get_theme_mod( 'edd_menu_item_desktop' );
	$edd_menu_item_desktop_color = get_theme_mod( 'edd_menu_item_desktop_color' );
	$menu_font_color             = get_theme_mod( 'menu_font_color' );

	if ( 'hide' !== $edd_menu_item_desktop ) {

		if ( $edd_menu_item_desktop_color ) {

			echo '.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $edd_menu_item_desktop_color ) );
			echo '}';

			echo '.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $edd_menu_item_desktop_color ) );
			echo '}';

		} elseif ( $menu_font_color ) {

			echo '.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $menu_font_color ) );
			echo '}';

			echo '.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $menu_font_color ) );
			echo '}';

		} elseif ( $page_accent_color ) {

			echo '.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $page_accent_color ) );
			echo '}';

			echo '.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $page_accent_color ) );
			echo '}';

		}

	}

	// Menu item mobile.
	$edd_menu_item_mobile       = get_theme_mod( 'edd_menu_item_mobile' );
	$edd_menu_item_mobile_color = get_theme_mod( 'edd_menu_item_mobile_color' );
	$mobile_menu_font_color     = get_theme_mod( 'mobile_menu_font_color' );

	if ( 'hide' !== $edd_menu_item_mobile ) {

		if ( $edd_menu_item_mobile_color ) {

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $edd_menu_item_mobile_color ) );
			echo '}';

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $edd_menu_item_mobile_color ) );
			echo '}';

		} elseif ( $edd_menu_item_desktop_color ) {

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $edd_menu_item_desktop_color ) );
			echo '}';

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $edd_menu_item_desktop_color ) );
			echo '}';

		} elseif ( $mobile_menu_font_color ) {

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $mobile_menu_font_color ) );
			echo '}';

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $mobile_menu_font_color ) );
			echo '}';

		} elseif ( $menu_font_color ) {

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $menu_font_color ) );
			echo '}';

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $menu_font_color ) );
			echo '}';

		} elseif ( $page_accent_color ) {

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {';
			echo sprintf( 'background: %s;', esc_attr( $page_accent_color ) );
			echo '}';

			echo '.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {';
			echo sprintf( 'color: %s;', esc_attr( $page_accent_color ) );
			echo '}';

		}

	}

}
add_action( 'wpbf_after_customizer_css', 'wpbf_do_edd_customizer_css', 10 );
