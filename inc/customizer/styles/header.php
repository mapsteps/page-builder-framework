<?php
/**
 * Customizer CSS: Header (logo area, logo, tagline, navigation, sub menu, mobile navigation, mobile sub menu, pre
 * header).
 *
 * Plain PHP, included from styles.php with wpbf_css_area( 'header' ). How to write it: see styles/general.php.
 * Premium's header CSS (transparent and sticky header, call to action button, mega menu, off-canvas and full screen
 * menus, hover effects) is Premium's; the header markup it styles is unchanged.
 *
 * Kept from the old code, so visitors get what they got:
 * - 'when' => its own option where the old code skipped 0 / '0' (a plain `if ( $value )`).
 * - 'saved' where the old code printed whenever something was saved, even the default, and the stylesheet doesn't
 *   give the same result (menu font size, sub menu text alignment, hover backgrounds). With 'unless' where it compared
 *   to the default as text (`=== '20'`): the sliders save numbers, so a saved default printed too (menu padding,
 *   stacked menu margin, mobile logo area width) and colors compared with letter case.
 * - 'parts' for the logo and tagline sizes and the paddings: each device / side was compared on its own.
 * - The logo and tagline fonts are plain PHP (wpbf_css_font()), as in the typography area.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$wpbf_menu_position = wpbf_mod( 'menu_position' );
$wpbf_devices       = array(
	'desktop' => '',
	'tablet'  => 'max-medium',
	'mobile'  => 'max-mobile',
);

// Logo area width: desktop logo / menu columns; mobile logo / toggle columns (all screen sizes, as before).
wpbf_css( '.wpbf-navigation .wpbf-1-4', array( 'width' => '{menu_logo_container_width}%' ), array( 'when' => 'menu_logo_container_width' ) );
wpbf_css( '.wpbf-navigation .wpbf-3-4', array( 'width' => 'calc(100% - {menu_logo_container_width}%)' ), array( 'when' => 'menu_logo_container_width' ) );

// A saved 66 (a number) printed 66%, the stylesheet has 66.666%.
$wpbf_saved_66 = array(
	'saved'  => true,
	'unless' => '66',
	'when'   => 'mobile_menu_logo_container_width',
);

wpbf_css( '.wpbf-navigation .wpbf-2-3', array( 'width' => '{mobile_menu_logo_container_width}%' ), $wpbf_saved_66 );
wpbf_css( '.wpbf-navigation .wpbf-1-3', array( 'width' => 'calc(100% - {mobile_menu_logo_container_width}%)' ), $wpbf_saved_66 );

// Logo: text logo (font, colors, sizes) or image logo (widths).
$wpbf_custom_logo = get_theme_mod( 'custom_logo' );

if ( ! $wpbf_custom_logo ) {

	wpbf_css_font( '.wpbf-logo a, .wpbf-mobile-logo a', get_theme_mod( 'menu_logo_font_toggle' ) ? wpbf_css_saved_mod( 'menu_logo_font_family' ) : false, true );

	wpbf_css( '.wpbf-logo a, .wpbf-mobile-logo a', array( 'color' => '{menu_logo_color}' ), array( 'when' => 'menu_logo_color' ) );
	wpbf_css( '.wpbf-logo a:hover, .wpbf-mobile-logo a:hover', array( 'color' => '{menu_logo_color_alt}' ), array( 'when' => 'menu_logo_color_alt' ) );

	foreach ( $wpbf_devices as $wpbf_device => $wpbf_media ) {
		wpbf_css(
			'.wpbf-logo a, .wpbf-mobile-logo a',
			array( 'font-size' => '{menu_logo_font_size.' . $wpbf_device . '|px}' ),
			array(
				'media' => $wpbf_media,
				'when'  => 'menu_logo_font_size.' . $wpbf_device,
				'parts' => true,
			)
		);
	}
} else {

	$wpbf_logo_devices = array(
		'desktop' => array( '.wpbf-logo img, .wpbf-mobile-logo img', '' ),
		'tablet'  => array( '.wpbf-mobile-logo img', 'max-desktop' ),
		'mobile'  => array( '.wpbf-mobile-logo img', 'max-mobile' ),
	);

	foreach ( $wpbf_logo_devices as $wpbf_device => $wpbf_logo_device ) {
		wpbf_css(
			$wpbf_logo_device[0],
			array( 'width' => '{menu_logo_size.' . $wpbf_device . '|px}' ),
			array(
				'media' => $wpbf_logo_device[1],
				'when'  => 'menu_logo_size.' . $wpbf_device,
				'parts' => true,
			)
		);
	}
}

// Tagline (text logo only).
if ( ! $wpbf_custom_logo && get_theme_mod( 'menu_logo_description' ) ) {

	wpbf_css_font( '.wpbf-tagline', get_theme_mod( 'menu_logo_description_toggle' ) ? wpbf_css_saved_mod( 'menu_logo_description_font_family' ) : false );

	wpbf_css( '.wpbf-tagline', array( 'color' => '{menu_logo_description_color}' ), array( 'when' => 'menu_logo_description_color' ) );

	foreach ( $wpbf_devices as $wpbf_device => $wpbf_media ) {
		wpbf_css(
			'.wpbf-tagline',
			array( 'font-size' => '{menu_logo_description_font_size.' . $wpbf_device . '|px}' ),
			array(
				'media' => $wpbf_media,
				'when'  => 'menu_logo_description_font_size.' . $wpbf_device,
				'parts' => true,
			)
		);
	}
}

// Navigation. The height prints for a saved 0 too, as before.
wpbf_css( '.wpbf-nav-wrapper', array( 'max-width' => '{menu_width}' ), array( 'when' => 'menu_width' ) );

wpbf_css(
	'.wpbf-nav-wrapper',
	array(
		'padding-top'    => '{menu_height}px',
		'padding-bottom' => '{menu_height}px',
	)
);

// A saved 20 (a number) printed: the stacked menu's margin isn't in the stylesheet, and its menu item padding is
// 20px only for the theme's own menus (Premium's off-canvas and full screen menus have their own).
$wpbf_saved_20 = array(
	'saved'  => true,
	'unless' => '20',
);

if ( 'menu-stacked' === $wpbf_menu_position ) {
	wpbf_css( '.wpbf-menu-stacked nav', array( 'margin-top' => '{menu_height}px' ), $wpbf_saved_20 + array( 'when' => 'menu_height' ) );
}

wpbf_css(
	'.wpbf-navigation .wpbf-menu > .menu-item > a',
	array(
		'padding-left'  => '{menu_padding}px',
		'padding-right' => '{menu_padding}px',
	),
	$wpbf_saved_20 + array( 'when' => 'menu_padding' )
);

if ( 'menu-centered' === $wpbf_menu_position ) {
	wpbf_css( '.wpbf-menu-centered .logo-container', array( 'padding' => '0 {menu_padding}px' ), $wpbf_saved_20 + array( 'when' => 'menu_padding' ) );
}

wpbf_css( '.wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active)', array( 'background-color' => '{menu_bg_color}' ), array( 'when' => 'menu_bg_color' ) );
wpbf_css( '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close', array( 'color' => '{menu_font_color}' ), array( 'when' => 'menu_font_color' ) );
wpbf_css( '.wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover', array( 'color' => '{menu_font_color_alt}' ), array( 'when' => 'menu_font_color_alt' ) );
wpbf_css( '.wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a', array( 'color' => '{menu_font_color_alt}!important' ), array( 'when' => 'menu_font_color_alt' ) );

// Printed whenever saved (16px too, which sets the sub menu's and mobile menu's links as well).
wpbf_css(
	'.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a',
	array( 'font-size' => '{menu_font_size|px}' ),
	array(
		'saved' => true,
		'when'  => 'menu_font_size',
	)
);

// Sub menu. Text alignment and hover background print whenever saved (the stylesheet has neither).
$wpbf_sub_menu = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu)';

wpbf_css(
	'.wpbf-sub-menu .sub-menu',
	array( 'text-align' => '{sub_menu_text_alignment}' ),
	array(
		'saved' => true,
		'when'  => 'sub_menu_text_alignment',
	)
);

wpbf_css( $wpbf_sub_menu . ' .sub-menu li, .wpbf-sub-menu > .wpbf-mega-menu > .sub-menu', array( 'background-color' => '{sub_menu_bg_color}' ), array( 'when' => 'sub_menu_bg_color' ) );

wpbf_css(
	$wpbf_sub_menu . ' .sub-menu li:hover',
	array( 'background-color' => '{sub_menu_bg_color_alt}' ),
	array(
		'saved' => true,
		'when'  => 'sub_menu_bg_color_alt',
	)
);

if ( wpbf_mod( 'sub_menu_separator' ) ) {
	wpbf_css( $wpbf_sub_menu . ' li', array( 'border-bottom' => '1px solid #f5f5f7' ), array( 'always' => true ) );
	wpbf_css( $wpbf_sub_menu . ' li', array( 'border-bottom-color' => '{sub_menu_separator_color}' ), array( 'when' => 'sub_menu_separator_color' ) );
	wpbf_css( $wpbf_sub_menu . ' li:last-child', array( 'border-bottom' => 'none' ), array( 'always' => true ) );
}

wpbf_css( $wpbf_sub_menu . ' .sub-menu', array( 'width' => '{sub_menu_width}px' ), array( 'when' => 'sub_menu_width' ) );

foreach ( array( 'top', 'right', 'bottom', 'left' ) as $wpbf_side ) {
	wpbf_css(
		$wpbf_sub_menu . ' .sub-menu a',
		array( 'padding-' . $wpbf_side => '{sub_menu_padding.' . $wpbf_side . '}px' ),
		array(
			'when'  => 'sub_menu_padding.' . $wpbf_side,
			'parts' => true,
		)
	);
}

wpbf_css( '.wpbf-navigation .wpbf-menu .sub-menu a', array( 'color' => '{sub_menu_accent_color}' ), array( 'when' => 'sub_menu_accent_color' ) );
wpbf_css( '.wpbf-navigation .wpbf-menu .sub-menu a', array( 'font-size' => '{sub_menu_font_size|px}' ), array( 'when' => 'sub_menu_font_size' ) );
wpbf_css( '.wpbf-navigation .wpbf-menu .sub-menu a:hover', array( 'color' => '{sub_menu_accent_color_alt}' ), array( 'when' => 'sub_menu_accent_color_alt' ) );

// Mobile navigation. The height prints for a saved 0 too, as before.
wpbf_css(
	'.wpbf-mobile-nav-wrapper',
	array(
		'padding-top'    => '{mobile_menu_height}px',
		'padding-bottom' => '{mobile_menu_height}px',
	)
);

wpbf_css( '.wpbf-mobile-nav-wrapper', array( 'background' => '{mobile_menu_background_color}' ), array( 'when' => 'mobile_menu_background_color' ) );

foreach ( array( 'top', 'right', 'bottom', 'left' ) as $wpbf_side ) {
	wpbf_css(
		'.wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle',
		array( 'padding-' . $wpbf_side => '{mobile_menu_padding.' . $wpbf_side . '}px' ),
		array(
			'when'  => 'mobile_menu_padding.' . $wpbf_side,
			'parts' => true,
		)
	);
}

wpbf_css( '.wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close', array( 'color' => '{mobile_menu_font_color}' ), array( 'when' => 'mobile_menu_font_color' ) );
wpbf_css( '.wpbf-mobile-menu a:hover', array( 'color' => '{mobile_menu_font_color_alt}' ), array( 'when' => 'mobile_menu_font_color_alt' ) );
wpbf_css( '.wpbf-mobile-menu > .current-menu-item > a', array( 'color' => '{mobile_menu_font_color_alt}!important' ), array( 'when' => 'mobile_menu_font_color_alt' ) );

// Divider color: compared as text, as before (the stylesheet's divider is another color, var(--base-color)).
$wpbf_saved_border = array(
	'saved'  => true,
	'unless' => '#d9d9e0',
	'when'   => 'mobile_menu_border_color',
);

wpbf_css( '.wpbf-mobile-menu .menu-item', array( 'border-top-color' => '{mobile_menu_border_color}' ), $wpbf_saved_border );
wpbf_css( '.wpbf-mobile-menu > .menu-item:last-child', array( 'border-bottom-color' => '{mobile_menu_border_color}' ), $wpbf_saved_border );

if ( in_array( wpbf_mod( 'mobile_menu_options' ), array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ) ) ) { // phpcs:ignore WordPress.PHP.StrictInArray -- As before.

	wpbf_css( '.wpbf-mobile-nav-item', array( 'color' => '{mobile_menu_hamburger_color}' ), array( 'when' => 'mobile_menu_hamburger_color' ) );
	wpbf_css( '.wpbf-mobile-nav-item', array( 'font-size' => '{mobile_menu_hamburger_size|px}' ), array( 'when' => 'mobile_menu_hamburger_size' ) );
	wpbf_css( '.wpbf-mobile-nav-item a', array( 'color' => '{mobile_menu_hamburger_color}' ), array( 'when' => 'mobile_menu_hamburger_color' ) );

	// Filled hamburger (the radius only with a background).
	wpbf_css(
		'.wpbf-mobile-menu-toggle',
		array(
			'background'    => '{mobile_menu_hamburger_bg_color}',
			'color'         => '#ffffff !important',
			'padding'       => '10px',
			'line-height'   => '1',
			'border-radius' => '{mobile_menu_hamburger_border_radius}px',
		),
		array( 'when' => 'mobile_menu_hamburger_bg_color' )
	);

}

// Menu item backgrounds: compared as text, as before (the stylesheet gives the items none; the menu's own background
// is #fff, Premium's off-canvas one can differ). The hover background prints whenever saved.
wpbf_css(
	'.wpbf-mobile-menu > .menu-item a',
	array( 'background-color' => '{mobile_menu_bg_color}' ),
	array(
		'saved'  => true,
		'unless' => '#ffffff',
		'when'   => 'mobile_menu_bg_color',
	)
);

wpbf_css(
	'.wpbf-mobile-menu > .menu-item a:hover',
	array( 'background-color' => '{mobile_menu_bg_color_alt}' ),
	array(
		'saved' => true,
		'when'  => 'mobile_menu_bg_color_alt',
	)
);

wpbf_css( '.wpbf-mobile-menu .wpbf-submenu-toggle', array( 'color' => '{mobile_menu_submenu_arrow_color}' ), array( 'when' => 'mobile_menu_submenu_arrow_color' ) );
wpbf_css( '.wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle', array( 'font-size' => '{mobile_menu_font_size|px}' ), array( 'when' => 'mobile_menu_font_size' ) );

/*
 * Mobile sub menu. The indent is added to the mobile menu's left padding of old versions (mobile_menu_padding_left,
 * moved into the padding option by inc/backwards-compatibility.php; 20 when it's gone), as before.
 */
$wpbf_indent_base = (float) get_theme_mod( 'mobile_menu_padding_left', '20' );

wpbf_css( '.wpbf-mobile-menu .sub-menu a', array( 'padding-left' => 'calc({mobile_sub_menu_indent}px + ' . $wpbf_indent_base . 'px)' ), array( 'when' => 'mobile_sub_menu_indent' ) );
wpbf_css( '.wpbf-mobile-menu .sub-menu a', array( 'background-color' => '{mobile_sub_menu_bg_color}' ), array( 'when' => 'mobile_sub_menu_bg_color' ) );
wpbf_css( '.wpbf-mobile-menu .sub-menu a:hover', array( 'background-color' => '{mobile_sub_menu_bg_color_alt}' ), array( 'when' => 'mobile_sub_menu_bg_color_alt' ) );
wpbf_css( '.wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle', array( 'color' => '{mobile_sub_menu_arrow_color}' ), array( 'when' => 'mobile_sub_menu_arrow_color' ) );
wpbf_css( '.wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle', array( 'font-size' => '{mobile_sub_menu_font_size|px}' ), array( 'when' => 'mobile_sub_menu_font_size' ) );
wpbf_css( '.wpbf-mobile-menu .sub-menu a', array( 'color' => '{mobile_sub_menu_font_color}' ), array( 'when' => 'mobile_sub_menu_font_color' ) );
wpbf_css( '.wpbf-mobile-menu .sub-menu a:hover', array( 'color' => '{mobile_sub_menu_font_color_alt}' ), array( 'when' => 'mobile_sub_menu_font_color_alt' ) );
wpbf_css( '.wpbf-mobile-menu .sub-menu > .current-menu-item > a', array( 'color' => '{mobile_sub_menu_font_color_alt}!important' ), array( 'when' => 'mobile_sub_menu_font_color_alt' ) );

// Divider color (backwards compatibility: an option from old versions, no longer in the Customizer).
$wpbf_mobile_sub_menu_border_color = get_theme_mod( 'mobile_sub_menu_border_color' );

if ( $wpbf_mobile_sub_menu_border_color ) {
	echo '.wpbf-mobile-menu .sub-menu .menu-item {border-top-color: ' . esc_attr( $wpbf_mobile_sub_menu_border_color ) . ';}'; // phpcs:ignore WordPress.Security.EscapeOutput -- Escaped.
}

// Pre header (only with one).
if ( 'none' !== wpbf_mod( 'pre_header_layout' ) ) {

	wpbf_css(
		'.wpbf-inner-pre-header',
		array(
			'padding-top'    => '{pre_header_height}px',
			'padding-bottom' => '{pre_header_height}px',
		),
		array( 'when' => 'pre_header_height' )
	);

	wpbf_css( '.wpbf-inner-pre-header', array( 'max-width' => '{pre_header_width}' ), array( 'when' => 'pre_header_width' ) );
	wpbf_css( '.wpbf-pre-header', array( 'background-color' => '{pre_header_bg_color}' ), array( 'when' => 'pre_header_bg_color' ) );
	wpbf_css( '.wpbf-pre-header', array( 'color' => '{pre_header_font_color}' ), array( 'when' => 'pre_header_font_color' ) );
	wpbf_css( '.wpbf-pre-header a', array( 'color' => '{pre_header_accent_color}' ), array( 'when' => 'pre_header_accent_color' ) );
	wpbf_css( '.wpbf-pre-header a:hover', array( 'color' => '{pre_header_accent_color_alt}' ), array( 'when' => 'pre_header_accent_color_alt' ) );
	wpbf_css( '.wpbf-pre-header .wpbf-menu > .current-menu-item > a', array( 'color' => '{pre_header_accent_color_alt}!important' ), array( 'when' => 'pre_header_accent_color_alt' ) );
	wpbf_css( '.wpbf-pre-header, .wpbf-pre-header .wpbf-menu, .wpbf-pre-header .wpbf-menu .sub-menu a', array( 'font-size' => '{pre_header_font_size|px}' ), array( 'when' => 'pre_header_font_size' ) );

}
