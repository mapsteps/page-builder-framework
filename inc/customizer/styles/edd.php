<?php
/**
 * Customizer CSS: Easy Digital Downloads (price option radios, theme buttons on EDD buttons, cart menu item count).
 *
 * Plain PHP, included with wpbf_css_area( 'edd' ) from wpbf_do_edd_customizer_css() (inc/integration/edd/edd-styles.php),
 * which runs on wpbf_after_customizer_css as before. How to write it: see styles/general.php.
 *
 * Each block has 'when' => its own option (the border colors: the border width): the old code skipped values like
 * 0 or '0' (no control saves them, an import can), so they stay skipped.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Price option radios.
wpbf_css( '.edd_download_purchase_form .edd_single_mode input[type="radio"]:checked + .edd_price_option_name::before', array( 'border-color' => '{page_accent_color}' ), array( 'when' => 'page_accent_color' ) );
wpbf_css( '.edd_download_purchase_form .edd_single_mode input[type="radio"]:checked + .edd_price_option_name::after', array( 'background' => '{page_accent_color}' ), array( 'when' => 'page_accent_color' ) );

// Theme buttons: border (only with a border width).
wpbf_css(
	'.edd-submit.button, .edd-submit.button.gray',
	array(
		'border-width' => '{button_border_width}px',
		'border-style' => 'solid',
		'border-color' => '{button_border_color}',
	),
	array( 'when' => 'button_border_width' )
);

wpbf_css( '.edd-submit.button:hover, .edd-submit.button.gray:hover', array( 'border-color' => '{button_border_color_alt}' ), array( 'when' => 'button_border_width' ) );
wpbf_css( '.edd-submit.button.blue', array( 'border-color' => '{button_primary_border_color}' ), array( 'when' => 'button_border_width' ) );
wpbf_css( '.edd-submit.button.blue:hover', array( 'border-color' => '{button_primary_border_color_alt}' ), array( 'when' => 'button_border_width' ) );

// Theme buttons: shape and colors.
wpbf_css( '.edd-submit.button, .edd-submit.button.gray', array( 'border-radius' => '{button_border_radius}px' ), array( 'when' => 'button_border_radius' ) );
wpbf_css( '.edd-submit.button, .edd-submit.button.gray', array( 'background' => '{button_bg_color}' ), array( 'when' => 'button_bg_color' ) );
wpbf_css( '.edd-submit.button, .edd-submit.button.gray', array( 'color' => '{button_text_color}' ), array( 'when' => 'button_text_color' ) );
wpbf_css( '.edd-submit.button:hover, .edd-submit.button.gray:hover', array( 'background' => '{button_bg_color_alt}' ), array( 'when' => 'button_bg_color_alt' ) );
wpbf_css( '.edd-submit.button:hover, .edd-submit.button.gray:hover', array( 'color' => '{button_text_color_alt}' ), array( 'when' => 'button_text_color_alt' ) );
wpbf_css( '.edd-submit.button.blue', array( 'background' => '{button_primary_bg_color}' ), array( 'when' => 'button_primary_bg_color' ) );
wpbf_css( '.edd-submit.button.blue', array( 'color' => '{button_primary_text_color}' ), array( 'when' => 'button_primary_text_color' ) );
wpbf_css( '.edd-submit.button.blue:hover', array( 'background' => '{button_primary_bg_color_alt}' ), array( 'when' => 'button_primary_bg_color_alt' ) );
wpbf_css( '.edd-submit.button.blue:hover', array( 'color' => '{button_primary_text_color_alt}' ), array( 'when' => 'button_primary_text_color_alt' ) );

/*
 * Cart menu item count: its own color, else the menu's font color, else the accent color. Written from the last
 * fallback to the first, so the first one that's set comes last and wins (the same result as if/elseif, but each
 * color previews instantly).
 */
$wpbf_edd_count_colors = array(
	'.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count'               => array(
		'show'   => 'edd_menu_item_desktop',
		'colors' => array( 'page_accent_color', 'menu_font_color', 'edd_menu_item_desktop_color' ),
	),
	'.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count' => array(
		'show'   => 'edd_menu_item_mobile',
		'colors' => array( 'page_accent_color', 'menu_font_color', 'mobile_menu_font_color', 'edd_menu_item_desktop_color', 'edd_menu_item_mobile_color' ),
	),
);

foreach ( $wpbf_edd_count_colors as $wpbf_selector => $wpbf_count ) {

	if ( 'hide' === wpbf_mod( $wpbf_count['show'] ) ) {
		continue;
	}

	foreach ( $wpbf_count['colors'] as $wpbf_option ) {
		wpbf_css( $wpbf_selector, array( 'background' => '{' . $wpbf_option . '}' ), array( 'when' => $wpbf_option ) );
	}
}
