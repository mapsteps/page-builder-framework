<?php
/**
 * Header customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Header */

// Logo container.
$menu_logo_container_width = wpbf_customize_str_value( 'menu_logo_container_width' );
$menu_logo_container_width = '25' === $menu_logo_container_width || '25px' === $menu_logo_container_width ? '' : $menu_logo_container_width;

if ( $menu_logo_container_width ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-navigation .wpbf-1-4',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( $menu_logo_container_width, '%' ) ),
			),
			array(
				'selector' => '.wpbf-navigation .wpbf-3-4',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( ( 100 - $menu_logo_container_width ), '%' ) ),
			),
		),
	) );

}

$mobile_menu_logo_container_width = wpbf_customize_str_value( 'mobile_menu_logo_container_width' );
$mobile_menu_logo_container_width = '66' === $mobile_menu_logo_container_width || '66%' === $mobile_menu_logo_container_width ? '' : $mobile_menu_logo_container_width;

if ( $mobile_menu_logo_container_width ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-navigation .wpbf-2-3',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( $mobile_menu_logo_container_width, '%' ) ),
			),
			array(
				'selector' => '.wpbf-navigation .wpbf-1-3',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( ( 100 - $mobile_menu_logo_container_width ), '%' ) ),
			),
		),
	) );

}

// Logo.
$custom_logo_id = wpbf_customize_absint_value( 'custom_logo' );
$menu_logo_size = wpbf_customize_array_value( 'menu_logo_size' );

if ( ! $custom_logo_id ) {

	$menu_logo_font_toggle  = wpbf_customize_bool_value( 'menu_logo_font_toggle' );
	$menu_logo_font_setting = wpbf_customize_array_value( 'menu_logo_font_family' );

	if ( $menu_logo_font_toggle && $menu_logo_font_setting ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'    => array(
				'font-family' => wpbf_typography_font_family( $menu_logo_font_setting ),
				'font-weight' => wpbf_typography_font_weight( $menu_logo_font_setting ),
				'font-style'  => wpbf_typography_font_style( $menu_logo_font_setting ),
				'color'       => ! empty( $menu_logo_font_setting['color'] ) ? $menu_logo_font_setting['color'] : null,
			),
		) );

	}

	$menu_logo_color = wpbf_customize_str_value( 'menu_logo_color' );

	if ( $menu_logo_color ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'    => array( 'color' => $menu_logo_color ),
		) );

	}

	$menu_logo_color_alt = wpbf_customize_str_value( 'menu_logo_color_alt' );

	if ( $menu_logo_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a:hover, .wpbf-mobile-logo a:hover',
			'props'    => array( 'color' => $menu_logo_color_alt ),
		) );

	}

	$menu_logo_font_size = wpbf_customize_array_value( 'menu_logo_font_size', true );

	$menu_logo_font_size_desktop = wpbf_get_theme_mod_value( $menu_logo_font_size, 'desktop', '22px' );

	if ( $menu_logo_font_size_desktop ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'    => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_font_size_desktop ),
			),
		) );

	}

	$menu_logo_font_size_tablet = wpbf_get_theme_mod_value( $menu_logo_font_size, 'tablet' );

	if ( $menu_logo_font_size_tablet ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ')',
			'selector'    => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'       => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_font_size_tablet ),
			),
		) );

	}

	$menu_logo_font_size_mobile = wpbf_get_theme_mod_value( $menu_logo_font_size, 'mobile' );

	if ( $menu_logo_font_size_mobile ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
			'selector'    => '.wpbf-logo a, .wpbf-mobile-logo a',
			'props'       => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_font_size_mobile ),
			),
		) );

	}
}

if ( $custom_logo_id ) {

	$menu_logo_size_desktop = wpbf_get_theme_mod_value( $menu_logo_size, 'desktop' );

	if ( $menu_logo_size_desktop ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-logo img, .wpbf-mobile-logo img',
			'props'    => array(
				'width' => wpbf_maybe_append_suffix( $menu_logo_size_desktop ),
			),
		) );

	}

	$menu_logo_size_tablet = wpbf_get_theme_mod_value( $menu_logo_size, 'tablet' );

	if ( $menu_logo_size_tablet ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
			'selector'    => '.wpbf-mobile-logo img',
			'props'       => array(
				'width' => wpbf_maybe_append_suffix( $menu_logo_size_tablet ),
			),
		) );

	}

	$menu_logo_size_mobile = wpbf_get_theme_mod_value( $menu_logo_size, 'mobile' );

	if ( $menu_logo_size_mobile ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
			'selector'    => '.wpbf-mobile-logo img',
			'props'       => array(
				'width' => wpbf_maybe_append_suffix( $menu_logo_size_mobile ),
			),
		) );

	}
}

// Tagline.
$menu_logo_description           = wpbf_customize_bool_value( 'menu_logo_description' );
$menu_logo_description_font_size = wpbf_customize_array_value( 'menu_logo_description_font_size' );

if ( ! $custom_logo_id && $menu_logo_description ) {

	$menu_logo_description_toggle       = wpbf_customize_bool_value( 'menu_logo_description_toggle' );
	$menu_logo_description_font_setting = wpbf_customize_array_value( 'menu_logo_description_font_family' );

	if ( $menu_logo_description_toggle && $menu_logo_description_font_setting ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-tagline',
			'props'    => array(
				'font-family' => wpbf_typography_font_family( $menu_logo_description_font_setting ),
				'font-weight' => wpbf_typography_font_weight( $menu_logo_description_font_setting ),
				'font-style'  => wpbf_typography_font_style( $menu_logo_description_font_setting ),
			),
		) );

	}

	$menu_logo_description_color = wpbf_customize_str_value( 'menu_logo_description_color' );

	if ( $menu_logo_description_color ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-tagline',
			'props'    => array(
				'color' => $menu_logo_description_color,
			),
		) );

	}

	$menu_logo_description_font_size_desktop = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'desktop' );

	if ( $menu_logo_description_font_size_desktop ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-tagline',
			'props'    => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_description_font_size_desktop ),
			),
		) );

	}

	$menu_logo_description_font_size_tablet = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'tablet' );

	if ( $menu_logo_description_font_size_tablet ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ')',
			'selector'    => '.wpbf-tagline',
			'props'       => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_description_font_size_tablet ),
			),
		) );

	}

	$menu_logo_description_font_size_mobile = wpbf_get_theme_mod_value( $menu_logo_description_font_size, 'mobile' );

	if ( $menu_logo_description_font_size_mobile ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
			'selector'    => '.wpbf-tagline',
			'props'       => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_logo_description_font_size_mobile ),
			),
		) );

	}
}

// Navigation.
$menu_width = wpbf_customize_str_value( 'menu_width' );
$menu_width = '1200' === $menu_width || '1200px' === $menu_width ? '' : $menu_width;

if ( wpbf_not_empty_allow_zero( $menu_width ) ) {

	wpbf_write_css( array(
		'selector' => $header_builder_enabled ? '.wpbf-header-row-desktop_row_2 .wpbf-container' : '.wpbf-nav-wrapper',
		'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $menu_width ) ),
	) );

}

$menu_position = wpbf_customize_str_value( 'menu_position' );

$menu_height = wpbf_customize_str_value( 'menu_height' );
$menu_height = ! $header_builder_enabled && ( '20' === $menu_height || '20px' === $menu_height ) ? '' : $menu_height;
$menu_height = $header_builder_enabled && '' === $menu_height ? '20px' : $menu_height;

if ( wpbf_not_empty_allow_zero( $menu_height ) ) {

	wpbf_write_css( array(
		'selector' => $header_builder_enabled ? '.wpbf-header-row-desktop_row_2' : '.wpbf-nav-wrapper',
		'props'    => array(
			'padding-top'    => wpbf_maybe_append_suffix( $menu_height ),
			'padding-bottom' => wpbf_maybe_append_suffix( $menu_height ),
		),
	) );

	if ( ! $header_builder_enabled && 'menu-stacked' === $menu_position ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-menu-stacked nav',
			'props'    => array(
				'margin-top' => wpbf_maybe_append_suffix( $menu_height ),
			),
		) );

	}

}

$menu_padding = wpbf_customize_str_value( 'menu_padding' );
$menu_padding = '20' === $menu_padding || '20px' === $menu_padding ? '' : $menu_padding;

if ( $menu_padding ) {

	wpbf_write_css( array(
		'selector' => $header_builder_enabled ? '.wpbf-menu.desktop_menu_1 > .menu-item > a' : '.wpbf-menu > .menu-item > a',
		'props'    => array(
			'padding-left'  => wpbf_maybe_append_suffix( $menu_padding ),
			'padding-right' => wpbf_maybe_append_suffix( $menu_padding ),
		),
	) );

	if ( ! $header_builder_enabled && 'menu-centered' === $menu_position ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-menu-centered .logo-container',
			'props'    => array( 'padding' => '0 ' . wpbf_maybe_append_suffix( $menu_padding ) ),
		) );

	}
}

$menu_bg_color = wpbf_customize_str_value( 'menu_bg_color' );
$menu_bg_color = '#f5f5f7' === $menu_bg_color ? '' : $menu_bg_color;

if ( $menu_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active)',
		'props'    => array( 'background-color' => $menu_bg_color ),
	) );

}

$menu_font_colors = wpbf_customize_array_value( 'menu_font_colors', array() );
$menu_font_colors = ! is_array( $menu_font_colors ) ? array() : $menu_font_colors;

if ( ! empty( $menu_font_colors ) ) {

	$menu_font_color_default = ! empty( $menu_font_colors['default'] ) && is_string( $menu_font_colors['default'] ) ? $menu_font_colors['default'] : null;
	$menu_font_color_hover   = ! empty( $menu_font_colors['hover'] ) && is_string( $menu_font_colors['hover'] ) ? $menu_font_colors['hover'] : null;

	if ( $menu_font_color_default ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close',
			'props'    => array( 'color' => $menu_font_color_default ),
		) );

	}

	if ( $menu_font_color_hover ) {

		wpbf_write_css( array(
			'blocks' => array(
				array(
					'selector' => '.wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover',
					'props'    => array( 'color' => $menu_font_color_hover ),
				),
				array(
					'selector' => '.wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a',
					'props'    => array( 'color' => $menu_font_color_hover . '!important' ),
				),
			),
		) );

	}

}

$menu_font_size = wpbf_customize_str_value( 'menu_font_size' );

if ( wpbf_not_empty_allow_zero( $menu_font_size ) ) {

	wpbf_write_css( array(
		'selector' => $header_builder_enabled ? '.wpbf-menu.desktop_menu_1 > .menu-item > a' : '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a',
		'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $menu_font_size ) ),
	) );

}

// Sub menu.
$sub_menu_text_alignment = wpbf_customize_str_value( 'sub_menu_text_alignment' );

$sub_menu_padding = wpbf_customize_array_value( 'sub_menu_padding' );

$sub_menu_padding_top      = wpbf_get_theme_mod_value( $sub_menu_padding, 'top', 10 );
$sub_menu_padding_right    = wpbf_get_theme_mod_value( $sub_menu_padding, 'right', 20 );
$sub_menu_padding_bottom   = wpbf_get_theme_mod_value( $sub_menu_padding, 'bottom', 10 );
$sub_menu_padding_left     = wpbf_get_theme_mod_value( $sub_menu_padding, 'left', 20 );
$sub_menu_accent_color     = wpbf_customize_str_value( 'sub_menu_accent_color' );
$sub_menu_font_size        = wpbf_customize_str_value( 'sub_menu_font_size' );
$sub_menu_accent_color_alt = wpbf_customize_str_value( 'sub_menu_accent_color_alt' );


if ( $sub_menu_text_alignment ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sub-menu .sub-menu',
		'props'    => array( 'text-align' => $sub_menu_text_alignment ),
	) );

}

$sub_menu_bg_color = wpbf_customize_str_value( 'sub_menu_bg_color' );
$sub_menu_bg_color = '#ffffff' === $sub_menu_bg_color ? '' : $sub_menu_bg_color;

if ( $sub_menu_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li, .wpbf-sub-menu > .wpbf-mega-menu > .sub-menu',
		'props'    => array( 'background-color' => $sub_menu_bg_color ),
	) );

}

$sub_menu_bg_color_alt = wpbf_customize_str_value( 'sub_menu_bg_color_alt' );

if ( $sub_menu_bg_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover',
		'props'    => array( 'background-color' => $sub_menu_bg_color_alt ),
	) );

}

$sub_menu_separator = wpbf_customize_bool_value( 'sub_menu_separator' );

$sub_menu_separator_color = wpbf_customize_str_value( 'sub_menu_separator_color' );
$sub_menu_separator_color = '#f5f5f7' === $sub_menu_separator_color ? '' : $sub_menu_separator_color;

if ( $sub_menu_separator ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li',
				'props'    => array(
					'border-bottom'       => '1px solid #f5f5f7',
					'border-bottom-color' => $sub_menu_separator_color ? $sub_menu_separator_color : null,
				),
			),
			array(
				'selector' => '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li:last-child',
				'props'    => array( 'border-bottom' => 'none' ),
			),
		),
	) );

}

$sub_menu_width = wpbf_customize_str_value( 'sub_menu_width' );
$sub_menu_width = '220' === $sub_menu_width || '220px' === $sub_menu_width ? '' : $sub_menu_width;

if ( $sub_menu_width ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu',
		'props'    => array( 'width' => wpbf_maybe_append_suffix( $sub_menu_width ) ),
	) );

}

if ( $sub_menu_padding_top || $sub_menu_padding_right || $sub_menu_padding_bottom || $sub_menu_padding_left ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a',
		'props'    => array(
			'padding-top'    => $sub_menu_padding_top ? wpbf_maybe_append_suffix( $sub_menu_padding_top ) : null,
			'padding-right'  => $sub_menu_padding_right ? wpbf_maybe_append_suffix( $sub_menu_padding_right ) : null,
			'padding-bottom' => $sub_menu_padding_bottom ? wpbf_maybe_append_suffix( $sub_menu_padding_bottom ) : null,
			'padding-left'   => $sub_menu_padding_left ? wpbf_maybe_append_suffix( $sub_menu_padding_left ) : null,
		),
	) );

}

if ( $sub_menu_accent_color || $sub_menu_font_size ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-navigation .wpbf-menu .sub-menu a',
		'props'    => array(
			'color'     => $sub_menu_accent_color ? $sub_menu_accent_color : null,
			'font-size' => $sub_menu_font_size ? wpbf_maybe_append_suffix( $sub_menu_font_size ) : null,
		),
	) );

}

if ( $sub_menu_accent_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-navigation .wpbf-menu .sub-menu a:hover',
		'props'    => array( 'color' => $sub_menu_accent_color_alt ),
	) );

}

// Mobile navigation.
$mobile_menu_height = wpbf_customize_str_value( 'mobile_menu_height' );
$mobile_menu_height = '20' === $mobile_menu_height || '20px' === $mobile_menu_height ? '' : $mobile_menu_height;

if ( $mobile_menu_height ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-nav-wrapper',
		'props'    => array(
			'padding-top'    => wpbf_maybe_append_suffix( $mobile_menu_height ),
			'padding-bottom' => wpbf_maybe_append_suffix( $mobile_menu_height ),
		),
	) );

}

$mobile_menu_background_color = wpbf_customize_str_value( 'mobile_menu_background_color' );

if ( $mobile_menu_background_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-nav-wrapper',
		'props'    => array( 'background-color' => $mobile_menu_background_color ),
	) );

}

$mobile_menu_padding = wpbf_customize_array_value( 'mobile_menu_padding' );

$mobile_menu_padding_top    = wpbf_get_theme_mod_value( $mobile_menu_padding, 'top', 10 );
$mobile_menu_padding_right  = wpbf_get_theme_mod_value( $mobile_menu_padding, 'right', 20 );
$mobile_menu_padding_bottom = wpbf_get_theme_mod_value( $mobile_menu_padding, 'bottom', 10 );
$mobile_menu_padding_left   = wpbf_get_theme_mod_value( $mobile_menu_padding, 'left', 20 );

if ( $mobile_menu_padding_top || $mobile_menu_padding_right || $mobile_menu_padding_bottom || $mobile_menu_padding_left ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu.mobile_menu_1 a, .wpbf-mobile-menu.mobile_menu_1 .menu-item-has-children .wpbf-submenu-toggle',
		'props'    => array(
			'padding-top'    => $mobile_menu_padding_top ? wpbf_maybe_append_suffix( $mobile_menu_padding_top ) : null,
			'padding-right'  => $mobile_menu_padding_right ? wpbf_maybe_append_suffix( $mobile_menu_padding_right ) : null,
			'padding-bottom' => $mobile_menu_padding_bottom ? wpbf_maybe_append_suffix( $mobile_menu_padding_bottom ) : null,
			'padding-left'   => $mobile_menu_padding_left ? wpbf_maybe_append_suffix( $mobile_menu_padding_left ) : null,
		),
	) );

}

// Mobile Menu 2 Padding (Header Builder).
if ( $header_builder_enabled ) {
	$mobile_menu_2_padding = wpbf_customize_array_value( 'wpbf_header_builder_mobile_menu_2_menu_padding', array(
		'top'    => 10,
		'right'  => 20,
		'bottom' => 10,
		'left'   => 20,
	) );

	$mobile_menu_2_padding_top    = wpbf_get_theme_mod_value( $mobile_menu_2_padding, 'top', 10 );
	$mobile_menu_2_padding_right  = wpbf_get_theme_mod_value( $mobile_menu_2_padding, 'right', 20 );
	$mobile_menu_2_padding_bottom = wpbf_get_theme_mod_value( $mobile_menu_2_padding, 'bottom', 10 );
	$mobile_menu_2_padding_left   = wpbf_get_theme_mod_value( $mobile_menu_2_padding, 'left', 20 );

	if ( $mobile_menu_2_padding_top || $mobile_menu_2_padding_right || $mobile_menu_2_padding_bottom || $mobile_menu_2_padding_left ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-mobile-menu.mobile_menu_2 a, .wpbf-mobile-menu.mobile_menu_2 .menu-item-has-children .wpbf-submenu-toggle',
			'props'    => array(
				'padding-top'    => $mobile_menu_2_padding_top ? wpbf_maybe_append_suffix( $mobile_menu_2_padding_top ) : null,
				'padding-right'  => $mobile_menu_2_padding_right ? wpbf_maybe_append_suffix( $mobile_menu_2_padding_right ) : null,
				'padding-bottom' => $mobile_menu_2_padding_bottom ? wpbf_maybe_append_suffix( $mobile_menu_2_padding_bottom ) : null,
				'padding-left'   => $mobile_menu_2_padding_left ? wpbf_maybe_append_suffix( $mobile_menu_2_padding_left ) : null,
			),
		) );

	}
}

$mobile_menu_font_colors = wpbf_customize_array_value( 'mobile_menu_font_colors', array() );
$mobile_menu_font_colors = ! is_array( $mobile_menu_font_colors ) ? array() : $mobile_menu_font_colors;

if ( ! empty( $mobile_menu_font_colors ) ) {

	$mobile_menu_font_color_default = ! empty( $mobile_menu_font_colors['default'] ) && is_string( $mobile_menu_font_colors['default'] ) ? $mobile_menu_font_colors['default'] : null;
	$mobile_menu_font_color_hover   = ! empty( $mobile_menu_font_colors['hover'] ) && is_string( $mobile_menu_font_colors['hover'] ) ? $mobile_menu_font_colors['hover'] : null;

	if ( $mobile_menu_font_color_default ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close',
			'props'    => array( 'color' => $mobile_menu_font_color_default ),
		) );

	}

	if ( $mobile_menu_font_color_hover ) {

		wpbf_write_css( array(
			'blocks' => array(
				array(
					'selector' => '.wpbf-mobile-menu a:hover',
					'props'    => array( 'color' => $mobile_menu_font_color_hover ),
				),
				array(
					'selector' => '.wpbf-mobile-menu > .current-menu-item > a',
					'props'    => array( 'color' => $mobile_menu_font_color_hover . '!important' ),
				),
			),
		) );

	}

}

$mobile_menu_border_color = wpbf_customize_str_value( 'mobile_menu_border_color' );
$mobile_menu_border_color = '#d9d9e0' === $mobile_menu_border_color ? '' : $mobile_menu_border_color;

if ( $mobile_menu_border_color ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-mobile-menu .menu-item',
				'props'    => array( 'border-top-color' => $mobile_menu_border_color ),
			),
			array(
				'selector' => '.wpbf-mobile-menu > .menu-item:last-child',
				'props'    => array( 'border-bottom-color' => $mobile_menu_border_color ),
			),
		),
	) );

}

$mobile_menu_options = wpbf_customize_str_value( 'mobile_menu_options', 'menu-mobile-hamburger' );

if ( in_array( $mobile_menu_options, array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ), true ) ) {

	$mobile_menu_hamburger_color = wpbf_customize_str_value( 'mobile_menu_hamburger_color' );
	$mobile_menu_hamburger_size  = wpbf_customize_str_value( 'mobile_menu_hamburger_size' );
	$mobile_menu_hamburger_size  = '16' === $mobile_menu_hamburger_size || '16px' === $mobile_menu_hamburger_size ? '' : $mobile_menu_hamburger_size;

	if ( $mobile_menu_hamburger_color || $mobile_menu_hamburger_size ) {
		$hamburger_props = array();

		if ( $mobile_menu_hamburger_color ) {
			$hamburger_props['color'] = $mobile_menu_hamburger_color;
		}

		if ( $mobile_menu_hamburger_size ) {
			$hamburger_props['font-size'] = wpbf_maybe_append_suffix( $mobile_menu_hamburger_size );
		}

		wpbf_write_css( array(
			'selector' => '.wpbf-mobile-menu-toggle',
			'props'    => $hamburger_props,
		) );
	}

	$mobile_menu_hamburger_bg_color = wpbf_customize_str_value( 'mobile_menu_hamburger_bg_color' );

	if ( $mobile_menu_hamburger_bg_color ) {

		$mobile_menu_hamburger_border_radius = wpbf_customize_str_value( 'mobile_menu_hamburger_border_radius' );

		wpbf_write_css( array(
			'selector' => '.wpbf-mobile-menu-toggle',
			'props'    => array(
				'background-color' => $mobile_menu_hamburger_bg_color,
				'font-size'        => $mobile_menu_hamburger_size ? wpbf_maybe_append_suffix( $mobile_menu_hamburger_size ) : null,
				'color'            => '#ffffff !important',
				'padding'          => '10px',
				'line-height'      => '1',
				'border-radius'    => $mobile_menu_hamburger_border_radius ? wpbf_maybe_append_suffix( $mobile_menu_hamburger_border_radius ) : null,
			),
		) );

	}
}

$mobile_menu_bg_color = wpbf_customize_str_value( 'mobile_menu_bg_color' );
$mobile_menu_bg_color = '#ffffff' === $mobile_menu_bg_color ? '' : $mobile_menu_bg_color;

if ( $mobile_menu_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu > .menu-item a',
		'props'    => array( 'background-color' => $mobile_menu_bg_color ),
	) );

}

$mobile_menu_bg_color_alt = wpbf_customize_str_value( 'mobile_menu_bg_color_alt' );

if ( $mobile_menu_bg_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu > .menu-item a:hover',
		'props'    => array( 'background-color' => $mobile_menu_bg_color_alt ),
	) );

}

$mobile_menu_submenu_arrow_color = wpbf_customize_str_value( 'mobile_menu_submenu_arrow_color' );

if ( $mobile_menu_submenu_arrow_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .wpbf-submenu-toggle',
		'props'    => array( 'color' => $mobile_menu_submenu_arrow_color ),
	) );

}

$mobile_menu_font_size = wpbf_customize_str_value( 'mobile_menu_font_size' );
$mobile_menu_font_size = '16' === $mobile_menu_font_size || '16px' === $mobile_menu_font_size ? '' : $mobile_menu_font_size;

if ( $mobile_menu_font_size ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle',
		'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $mobile_menu_font_size ) ),
	) );

}

// Mobile sub menu.
$mobile_sub_menu_indent = wpbf_customize_absint_value( 'mobile_sub_menu_indent' );

if ( $mobile_sub_menu_indent ) {

	// ? Why do we use 'mobile_menu_padding_left' here?
	// ? Because in backwards-compatibility, this option is deleted and replaced with 'mobile_menu_padding' (which is an array).
	$default_legacy_padding_left = wpbf_customize_absint_value( 'mobile_menu_padding_left', 20 );
	$mobile_sub_menu_indent      = $mobile_sub_menu_indent + $default_legacy_padding_left;

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .sub-menu a',
		'props'    => array( 'padding-left' => wpbf_maybe_append_suffix( $mobile_sub_menu_indent ) ),
	) );

}

$mobile_sub_menu_bg_color = wpbf_customize_str_value( 'mobile_sub_menu_bg_color' );

if ( $mobile_sub_menu_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .sub-menu a',
		'props'    => array( 'background-color' => $mobile_sub_menu_bg_color ),
	) );

}

$mobile_sub_menu_bg_color_alt = wpbf_customize_str_value( 'mobile_sub_menu_bg_color_alt' );

if ( $mobile_sub_menu_bg_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .sub-menu a:hover',
		'props'    => array( 'background-color' => $mobile_sub_menu_bg_color_alt ),
	) );

}

$mobile_sub_menu_arrow_color = wpbf_customize_str_value( 'mobile_sub_menu_arrow_color' );

if ( $mobile_sub_menu_arrow_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle',
		'props'    => array( 'color' => $mobile_sub_menu_arrow_color ),
	) );

}

$mobile_sub_menu_font_size = wpbf_customize_str_value( 'mobile_sub_menu_font_size' );

if ( $mobile_sub_menu_font_size ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle',
		'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $mobile_sub_menu_font_size ) ),
	) );

}

$mobile_sub_menu_font_color = wpbf_customize_str_value( 'mobile_sub_menu_font_color' );

if ( $mobile_sub_menu_font_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .sub-menu a',
		'props'    => array( 'color' => $mobile_sub_menu_font_color ),
	) );

}

$mobile_sub_menu_font_color_alt = wpbf_customize_str_value( 'mobile_sub_menu_font_color_alt' );

if ( $mobile_sub_menu_font_color_alt ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-mobile-menu .sub-menu a:hover',
				'props'    => array( 'color' => $mobile_sub_menu_font_color_alt ),
			),
			array(
				'selector' => '.wpbf-mobile-menu .sub-menu > .current-menu-item > a',
				'props'    => array( 'color' => $mobile_sub_menu_font_color_alt . '!important' ),
			),
		),
	) );

}

$mobile_sub_menu_border_color = wpbf_customize_str_value( 'mobile_sub_menu_border_color' );

if ( $mobile_sub_menu_border_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-mobile-menu .sub-menu .menu-item',
		'props'    => array( 'border-top-color' => $mobile_sub_menu_border_color ),
	) );

}

// Pre header.
$pre_header_layout       = wpbf_customize_str_value( 'pre_header_layout' );
$render_pre_header_style = $header_builder_enabled || 'none' !== $pre_header_layout ? true : false;

$pre_header_width = wpbf_customize_str_value( 'pre_header_width' );
$pre_header_width = '1200' === $pre_header_width || '1200px' === $pre_header_width ? '' : $pre_header_width;

$pre_header_height = wpbf_customize_str_value( 'pre_header_height' );
$pre_header_height = '10' === $pre_header_height || '10px' === $pre_header_height ? '' : $pre_header_height;

if ( $render_pre_header_style && ( wpbf_not_empty_allow_zero( $pre_header_width ) || wpbf_not_empty_allow_zero( $pre_header_height ) ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-inner-pre-header',
		'props'    => array(
			'padding-top'    => wpbf_not_empty_allow_zero( $pre_header_height ) ? wpbf_maybe_append_suffix( $pre_header_height ) : null,
			'padding-bottom' => wpbf_not_empty_allow_zero( $pre_header_height ) ? wpbf_maybe_append_suffix( $pre_header_height ) : null,
			'max-width'      => wpbf_not_empty_allow_zero( $pre_header_width ) ? wpbf_maybe_append_suffix( $pre_header_width ) : null,
		),
	) );

}

$pre_header_bg_color   = wpbf_customize_str_value( 'pre_header_bg_color' );
$pre_header_bg_color   = '#ffffff' === $pre_header_bg_color ? '' : $pre_header_bg_color;
$pre_header_font_color = wpbf_customize_str_value( 'pre_header_font_color' );

if ( $render_pre_header_style && ( $pre_header_bg_color || $pre_header_font_color ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-pre-header',
		'props'    => array(
			'background-color' => $pre_header_bg_color ? $pre_header_bg_color : null,
			'color'            => $pre_header_font_color ? $pre_header_font_color : null,
		),
	) );

}

$pre_header_accent_colors = wpbf_customize_array_value( 'pre_header_accent_colors' );

if ( $render_pre_header_style && ! empty( $pre_header_accent_colors['default'] ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-pre-header a',
		'props'    => array( 'color' => $pre_header_accent_colors['default'] ),
	) );

}

if ( $render_pre_header_style && ! empty( $pre_header_accent_colors['hover'] ) ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-pre-header a:hover',
				'props'    => array( 'color' => $pre_header_accent_colors['hover'] ),
			),
			array(
				'selector' => '.wpbf-pre-header .wpbf-menu > .current-menu-item > a',
				'props'    => array( 'color' => $pre_header_accent_colors['hover'] . '!important' ),
			),
		),
	) );

}

$pre_header_font_size = wpbf_customize_str_value( 'pre_header_font_size' );
$pre_header_font_size = '14' === $pre_header_font_size || '14px' === $pre_header_font_size ? '' : $pre_header_font_size;

if ( $render_pre_header_style && wpbf_not_empty_allow_zero( $pre_header_font_size ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-pre-header, .wpbf-pre-header .wpbf-menu, .wpbf-pre-header .wpbf-menu .sub-menu a',
		'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $pre_header_font_size ) ),
	) );

}
