<?php
/**
 * Header builder customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

use Mapsteps\Wpbf\Customizer\Controls\Responsive\ResponsiveUtil;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Breakpoint variables brought from styles.php file.
 *
 * Because this header-builder-styles.php file is included in styles.php file,
 * we can use these variables directly.
 *
 * @var int $breakpoint_mobile_int The mobile breakpoint in integer format.
 * @var int $breakpoint_medium_int The medium breakpoint in integer format.
 * @var int $breakpoint_desktop_int The desktop breakpoint in integer format.
 *
 * @var string $breakpoint_mobile The mobile breakpoint with 'px' suffix.
 * @var string $breakpoint_medium The medium breakpoint with 'px' suffix.
 * @var string $breakpoint_desktop The desktop breakpoint with 'px' suffix.
 */

/**
 * ----------------------------------------------------------------------
 * Header Builder Mobile Menu Trigger Styles
 * ----------------------------------------------------------------------
 */

$menu_trigger_icon_size     = get_theme_mod( 'wpbf_header_builder_mobile_menu_trigger_icon_size' );
$menu_trigger_color         = get_theme_mod( 'wpbf_header_builder_mobile_menu_trigger_color' );
$menu_trigger_style         = get_theme_mod( 'wpbf_header_builder_mobile_menu_trigger_style', '' );
$menu_trigger_border_radius = get_theme_mod( 'wpbf_header_builder_mobile_menu_trigger_border_radius', get_theme_mod( 'mobile_menu_hamburger_border_radius', '0' ) );

// die($menu_trigger_border_radius);

if ( $menu_trigger_icon_size ) {
	echo '.wpbf-menu-toggle { font-size: ' . esc_attr( $menu_trigger_icon_size ) . 'px; }';
}

if ( $menu_trigger_color ) {
	echo '.wpbf-menu-toggle { color: ' . esc_attr( $menu_trigger_color ) . '; }';
	if ( 'outline' === $menu_trigger_style ) {
		echo '.wpbf-menu-toggle.outline { border-color: ' . esc_attr( $menu_trigger_color ) . '; }';
	}
}

/**
 * ----------------------------------------------------------------------
 * Header Rows Styles
 * ----------------------------------------------------------------------
 */

$saved_values   = wpbf_customize_array_value( 'wpbf_header_builder', array() );
$desktop_values = isset( $saved_values['desktop'] ) && is_array( $saved_values['desktop'] ) ? $saved_values['desktop'] : array();
$desktop_rows   = isset( $desktop_values['rows'] ) && is_array( $desktop_values['rows'] ) ? $desktop_values['rows'] : array();

$parsed_desktop_rows = array();

// Filter the saved rows.
if ( is_array( $desktop_rows ) && ! empty( $desktop_rows ) ) {
	foreach ( $desktop_rows as $row_key => $columns ) {
		if ( empty( $row_key ) || empty( $columns ) ) {
			continue;
		}

		foreach ( $columns as $column_key => $widget_keys ) {
			if ( empty( $column_key ) || empty( $widget_keys ) ) {
				continue;
			}

			if ( ! isset( $parsed_desktop_rows[ $row_key ] ) ) {
				$parsed_desktop_rows[ $row_key ] = array();
			}

			if ( ! isset( $parsed_desktop_rows[ $row_key ][ $column_key ] ) ) {
				$parsed_desktop_rows[ $row_key ][ $column_key ] = array();
			}

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				$parsed_desktop_rows[ $row_key ][ $column_key ][] = $widget_key;
			}
		}
	}
}

// Now loop through the filtered/validated rows.
foreach ( $parsed_desktop_rows as $row_key => $columns ) {
	$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

	/**
	 * These fields are handled here for desktop_row_3 only
	 * because desktop_row_3 didn't exist before the new header builder added.
	 *
	 * Max width:
	 * - In desktop_row_1, the value is using the existing `pre_header_width` setting.
	 * - In desktop_row_2, the value is using the existing `menu_width` setting.
	 *
	 * Vertical padding:
	 * - In desktop_row_1, the value is using the existing `pre_header_height` setting.
	 * - In desktop_row_2, the value is using the existing `menu_height` setting.
	 *
	 * Font size:
	 * - In desktop_row_1, the value is using the existing `pre_header_font_size` setting.
	 * - In desktop_row_2, the value is using the existing `menu_font_size` setting.
	 *
	 * Background color:
	 * - In desktop_row_1, the value is using the existing `pre_header_bg_color` setting.
	 * - In desktop_row_2, the value is using the existing `menu_bg_color` setting.
	 *
	 * Text color:
	 * - In desktop_row_1, the value is using the existing `pre_header_font_color` setting.
	 * - In desktop_row_2, the value is using the existing `menu_font_colors` (multicolor) setting.
	 *
	 * Accent colors:
	 * - In desktop_row_1, the value is using the existing `pre_header_accent_colors` (multicolor) setting.
	 * - In desktop_row_2, there's no accent colors setting (we follow the old header section).
	 */
	if ( 'desktop_row_3' === $row_key ) {
		$max_width = wpbf_customize_str_value( $row_id_prefix . 'max_width' );
		$max_width = '' === $max_width || '1200' === $max_width || '1200px' === $max_width ? null : $max_width;

		if ( $max_width ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' .wpbf-container',
				'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $max_width ) ),
			) );
		}

		$v_padding = wpbf_customize_str_value( $row_id_prefix . 'vertical_padding' );
		$v_padding = '' === $v_padding || '15' === $v_padding ? '15px' : $v_padding;

		wpbf_write_css( array(
			'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' .wpbf-row-content',
			'props'    => array(
				'padding-top'    => wpbf_maybe_append_suffix( $v_padding ),
				'padding-bottom' => wpbf_maybe_append_suffix( $v_padding ),
			),
		) );

		$font_size = wpbf_customize_str_value( $row_id_prefix . 'font_size' );
		$font_size = '' === $font_size || '16' === $font_size ? '16px' : $font_size;

		if ( $font_size ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ),
				'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
			) );
		}

		$bg_color   = wpbf_customize_str_value( $row_id_prefix . 'bg_color' );
		$text_color = wpbf_customize_str_value( $row_id_prefix . 'text_color' );

		if ( $bg_color || $text_color ) {
			echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' {';

			if ( $bg_color ) {
				echo 'background-color: ' . esc_attr( $bg_color ) . ';';
			}

			if ( $text_color ) {
				echo 'color: ' . esc_attr( $text_color ) . ';';
			}

			echo '}';
		}

		$accent_colors = wpbf_customize_array_value( $row_id_prefix . 'accent_colors' );

		if ( ! empty( $accent_colors ) ) {
			$default_color = ! empty( $accent_colors['default'] ) ? $accent_colors['default'] : '';
			$hover_color   = ! empty( $accent_colors['hover'] ) ? $accent_colors['hover'] : '';

			if ( $default_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' a',
					'props'    => array( 'color' => $default_color ),
				) );
			}

			if ( $hover_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' a:hover, .wpbf-header-row-' . esc_attr( $row_key ) . ' a:focus',
					'props'    => array( 'color' => $hover_color ),
				) );
			}
		}
	}
}


$mobile_values = isset( $saved_values['mobile'] ) && is_array( $saved_values['mobile'] ) ? $saved_values['mobile'] : array();
$mobile_rows   = isset( $mobile_values['rows'] ) && is_array( $mobile_values['rows'] ) ? $mobile_values['rows'] : array();

$parsed_mobile_rows = array();

// Filter the saved rows.
if ( is_array( $mobile_rows ) && ! empty( $mobile_rows ) ) {
	foreach ( $mobile_rows as $row_key => $columns ) {
		if ( empty( $row_key ) || empty( $columns ) ) {
			continue;
		}

		foreach ( $columns as $column_key => $widget_keys ) {
			if ( empty( $column_key ) || empty( $widget_keys ) ) {
				continue;
			}

			if ( ! isset( $parsed_mobile_rows[ $row_key ] ) ) {
				$parsed_mobile_rows[ $row_key ] = array();
			}

			if ( ! isset( $parsed_mobile_rows[ $row_key ][ $column_key ] ) ) {
				$parsed_mobile_rows[ $row_key ][ $column_key ] = array();
			}

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				$parsed_mobile_rows[ $row_key ][ $column_key ][] = $widget_key;
			}
		}
	}
}

// Now loop through the filtered/validated rows.
foreach ( $parsed_mobile_rows as $row_key => $columns ) {
	$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

	if ( 'mobile_row_1' === $row_key ) {

		$v_padding = wpbf_customize_str_value( $row_id_prefix . 'vertical_padding' );
		$v_padding = '' === $v_padding || '15' === $v_padding ? '15px' : $v_padding;

		wpbf_write_css( array(
			'selector' => '.wpbf-mobile-header-rows .wpbf-inner-pre-header',
			'props'    => array(
				'padding-top'    => wpbf_maybe_append_suffix( $v_padding ),
				'padding-bottom' => wpbf_maybe_append_suffix( $v_padding ),
			),
		) );

		$font_size = wpbf_customize_str_value( $row_id_prefix . 'font_size' );
		$font_size = '' === $font_size || '16' === $font_size ? '16px' : $font_size;

		if ( $font_size ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ),
				'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
			) );
		}

		$accent_colors = wpbf_customize_array_value( $row_id_prefix . 'accent_colors' );

		if ( ! empty( $accent_colors ) ) {
			$default_color = ! empty( $accent_colors['default'] ) ? $accent_colors['default'] : '';
			$hover_color   = ! empty( $accent_colors['hover'] ) ? $accent_colors['hover'] : '';

			if ( $default_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2)',
					'props'    => array( 'color' => $default_color ),
				) );
			}

			if ( $hover_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):hover, .wpbf-header-row-' . esc_attr( $row_key ) . ' a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):focus',
					'props'    => array( 'color' => $hover_color ),
				) );
			}
		}

		$bg_color   = wpbf_customize_str_value( $row_id_prefix . 'bg_color' );
		$text_color = wpbf_customize_str_value( $row_id_prefix . 'text_color' );

		if ( $bg_color || $text_color ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ),
				'props'    => array( 'background-color' => $bg_color ),
			) );

			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ':not(.wpbf-close)',
				'props'    => array( 'color' => $text_color ),
			) );

		}

	}

	if ( 'mobile_row_2' === $row_key ) {

		$v_padding = wpbf_customize_str_value( $row_id_prefix . 'vertical_padding' );
		$v_padding = '' === $v_padding || '15' === $v_padding ? '15px' : $v_padding;

		wpbf_write_css( array(
			'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' .wpbf-row-content',
			'props'    => array(
				'padding-top'    => wpbf_maybe_append_suffix( $v_padding ),
				'padding-bottom' => wpbf_maybe_append_suffix( $v_padding ),
			),
		) );

		$bg_color = wpbf_customize_str_value( $row_id_prefix . 'bg_color' );

		if ( $bg_color ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ),
				'props'    => array( 'background-color' => $bg_color ),
			) );

		}

	}

	if ( 'mobile_row_3' === $row_key ) {

		$v_padding = wpbf_customize_str_value( $row_id_prefix . 'vertical_padding' );
		$v_padding = '' === $v_padding || '15' === $v_padding ? '15px' : $v_padding;

		wpbf_write_css( array(
			'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' .wpbf-row-content',
			'props'    => array(
				'padding-top'    => wpbf_maybe_append_suffix( $v_padding ),
				'padding-bottom' => wpbf_maybe_append_suffix( $v_padding ),
			),
		) );

		$font_size = wpbf_customize_str_value( $row_id_prefix . 'font_size' );
		$font_size = '' === $font_size || '16' === $font_size ? '16px' : $font_size;

		if ( $font_size ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ),
				'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
			) );
		}

		$accent_colors = wpbf_customize_array_value( $row_id_prefix . 'accent_colors' );

		if ( ! empty( $accent_colors ) ) {
			$default_color = ! empty( $accent_colors['default'] ) ? $accent_colors['default'] : '';
			$hover_color   = ! empty( $accent_colors['hover'] ) ? $accent_colors['hover'] : '';

			if ( $default_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2)',
					'props'    => array( 'color' => $default_color ),
				) );
			}

			if ( $hover_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ' a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):hover, .wpbf-header-row-' . esc_attr( $row_key ) . ' a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):focus',
					'props'    => array( 'color' => $hover_color ),
				) );
			}
		}

		$bg_color   = wpbf_customize_str_value( $row_id_prefix . 'bg_color' );
		$text_color = wpbf_customize_str_value( $row_id_prefix . 'text_color' );

		if ( $bg_color || $text_color ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ),
				'props'    => array( 'background-color' => $bg_color ),
			) );

			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ':not(.wpbf-close)',
				'props'    => array( 'color' => $text_color ),
			) );

		}

	}
}

$devices = ( new ResponsiveUtil() )->devices();

$header_builder_control_id_prefix = 'wpbf_header_builder_';

/**
 * ----------------------------------------------------------------------
 * Button Widget Styles
 * ----------------------------------------------------------------------
 */

$button_keys = array( 'desktop_button_1', 'desktop_button_2', 'mobile_button_1', 'mobile_button_2' );

foreach ( $button_keys as $button_key ) {

	$selector = '.wpbf-button.' . $header_builder_control_id_prefix . $button_key;

	$responsive_border_radius = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_border_radius' );
	$responsive_border_width  = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_border_width' );
	$button_border_style      = wpbf_customize_str_value( $header_builder_control_id_prefix . $button_key . '_border_style' );
	$button_border_style      = ! empty( $button_border_style ) ? $button_border_style : 'none';
	$button_border_colors     = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_border_color' );
	$button_bg_colors         = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_bg_color' );
	$button_text_colors       = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_text_color' );

	wpbf_write_css( array(
		'selector' => $selector,
		'props'    => array(
			'border-radius'    => isset( $responsive_border_radius['desktop'] ) && '' !== $responsive_border_radius['desktop'] ? wpbf_maybe_append_suffix( $responsive_border_radius['desktop'] ) : null,
			'border-width'     => isset( $responsive_border_width['desktop'] ) && '' !== $responsive_border_width['desktop'] ? wpbf_maybe_append_suffix( $responsive_border_width['desktop'] ) : null,
			'border-style'     => 'none' !== $button_border_style ? $button_border_style : null,
			'border-color'     => isset( $button_border_colors['default'] ) && '' !== $button_border_colors['default'] ? $button_border_colors['default'] : null,
			'background-color' => isset( $button_bg_colors['default'] ) && '' !== $button_bg_colors['default'] ? $button_bg_colors['default'] : null,
			'color'            => isset( $button_text_colors['default'] ) && '' !== $button_text_colors['default'] ? $button_text_colors['default'] : null,
		),
	) );

	wpbf_write_css( array(
		'selector' => $selector . ':hover',
		'props'    => array(
			'border-color'     => isset( $button_border_colors['hover'] ) && '' !== $button_border_colors['hover'] ? $button_border_colors['hover'] : null,
			'background-color' => isset( $button_bg_colors['hover'] ) && '' !== $button_bg_colors['hover'] ? $button_bg_colors['hover'] : null,
			'color'            => isset( $button_text_colors['hover'] ) && '' !== $button_text_colors['hover'] ? $button_text_colors['hover'] : null,
		),
	) );

	foreach ( $devices as $device ) {
		if ( 'tablet' !== $device && 'mobile' !== $device ) {
			continue;
		}

		$breakpoint_width = 'tablet' === $device ? $breakpoint_medium : $breakpoint_mobile;

		$device_border_radius = isset( $responsive_border_radius[ $device ] ) && '' !== $responsive_border_radius[ $device ] ? $responsive_border_radius[ $device ] : null;
		$device_border_width  = isset( $responsive_border_width[ $device ] ) && '' !== $responsive_border_width[ $device ] ? $responsive_border_width[ $device ] : null;

		if ( is_null( $device_border_radius ) && is_null( $device_border_width ) ) {
			continue;
		}

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . $breakpoint_width . ')',
			'selector'    => $selector,
			'props'       => array(
				'border-radius' => $device_border_radius ? wpbf_maybe_append_suffix( $device_border_radius ) : null,
				'border-width'  => $device_border_width ? wpbf_maybe_append_suffix( $device_border_width ) : null,
			),
		) );
	}

}

/**
 * ----------------------------------------------------------------------
 * Mobile Header Builder: Search Icon Styles.
 * ----------------------------------------------------------------------
 */

$control_id_prefix = $header_builder_control_id_prefix . 'mobile_search_';
$icon_size         = wpbf_customize_array_value( $control_id_prefix . 'icon_size' );
$icon_size         = '' === $icon_size || '16' === $icon_size ? '16px' : $icon_size;

foreach ( $devices as $device ) {
	if ( 'tablet' !== $device && 'mobile' !== $device ) {
		continue;
	}

	$breakpoint_width = 'tablet' === $device ? $breakpoint_medium : $breakpoint_mobile;

	$device_icon_size = isset( $icon_size[ $device ] ) && '' !== $icon_size[ $device ] ? $icon_size[ $device ] : null;

	if ( is_null( $device_icon_size ) ) {
		continue;
	}

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . $breakpoint_width . ')',
		'selector'    => '.wpbff-search',
		'props'       => array(
			'font-size' => $device_icon_size ? wpbf_maybe_append_suffix( $device_icon_size ) : null,
		),
	) );
}

/**
 * ----------------------------------------------------------------------
 * Mobile Header Builder: Search Icon color.
 * ----------------------------------------------------------------------
 */
$icon_color = wpbf_customize_array_value( $control_id_prefix . 'icon_color' );

if ( ! empty( $icon_color ) ) {
	$default_color = ! empty( $icon_color['default'] ) ? $icon_color['default'] : '';
	$hover_color   = ! empty( $icon_color['hover'] ) ? $icon_color['hover'] : '';

	if ( $default_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbff-search',
			'props'    => array( 'color' => $default_color ),
		) );
	}

	if ( $hover_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbff-search:hover, .wpbff-search:focus',
			'props'    => array( 'color' => $hover_color ),
		) );
	}
}

// $header_builder_devices = [ 'desktop', 'mobile' ];
$header_builder_devices = [ 'desktop', 'mobile' ];

foreach ( $header_builder_devices as $header_builder_device ) {
	/**
	 * ----------------------------------------------------------------------
	 * Triggered Menu Reveal.
	 * ----------------------------------------------------------------------
	 */
	$menu_options = wpbf_customize_str_value(
		'wpbf_header_builder_' . $header_builder_device . '_offcanvas_reveal_as',
		'mobile' === $header_builder_device ? 'dropdown' : 'off-canvas'
	);

	if ( in_array( $menu_options, array( 'off-canvas', 'dropdown' ), true ) ) {

		$menu_width    = wpbf_customize_str_value( 'mobile_menu_width' );
		$menu_width    = '320' === $menu_width || '320px' === $menu_width ? '' : $menu_width;
		$menu_bg_color = wpbf_customize_str_value( 'mobile_menu_bg_color' );

		if ( $menu_width || $menu_bg_color ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-mobile-menu-off-canvas .wpbf-mobile-menu-container',
				'props'    => array(
					'width'            => $menu_width ? wpbf_maybe_append_suffix( $menu_width ) : null,
					'right'            => $menu_width ? '-' . wpbf_maybe_append_suffix( $menu_width ) : null,
					'background-color' => $menu_bg_color ? $menu_bg_color : null,
				),
			) );
		}

		$menu_overlay = wpbf_customize_bool_value( 'mobile_menu_overlay' );

		$menu_overlay_color = wpbf_customize_str_value( 'mobile_menu_overlay_color' );
		$menu_overlay_color = 'rgba(0,0,0,0.5)' === $menu_overlay_color || 'rgba(0, 0, 0, 0.5)' === $menu_overlay_color ? '' : $menu_overlay_color;

		if ( $menu_overlay && $menu_overlay_color ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-mobile-menu-overlay',
				'props'    => array(
					'background-color' => $menu_overlay_color ? $menu_overlay_color : null,
				),
			) );
		}
	}

	/**
	 * ----------------------------------------------------------------------
	 * Trigger Button Style.
	 * ----------------------------------------------------------------------
	 */
	$menu_trigger_style = wpbf_customize_str_value( 'wpbf_header_builder_' . $header_builder_device . '_menu_trigger_style' );
	$menu_trigger_style = '' === $menu_trigger_style ? 'simple' : $menu_trigger_style;

	if ( ! empty( $menu_trigger_style ) ) {

		if ( 'outline' === $menu_trigger_style ) {

			$menu_trigger_border_key = 'mobile' === $header_builder_device ? 'mobile_menu_hamburger_color' : 'wpbf_header_builder_' . $header_builder_device . '_menu_trigger_icon_color';

			wpbf_write_css( array(
				'selector' => 'mobile' === $header_builder_device ? '#wpbf-mobile-menu-toggle' : '#wpbf-menu-toggle',
				'props'    => array(
					'background-color' => 'unset',
					'border'           => '2px solid ' . wpbf_customize_str_value( $menu_trigger_border_key ),
					'border-radius'    => $menu_trigger_border_radius ? wpbf_maybe_append_suffix( $menu_trigger_border_radius ) : null,
				),
			) );

		}

		if ( 'solid' === $menu_trigger_style ) {

			$menu_trigger_bg_key = 'mobile' === $header_builder_device ? 'mobile_menu_hamburger_bg_color' : 'wpbf_header_builder_' . $header_builder_device . '_menu_trigger_bg_color';

			wpbf_write_css( array(
				'selector' => 'mobile' === $header_builder_device ? '#wpbf-mobile-menu-toggle' : '#wpbf-menu-toggle',
				'props'    => array(
					'background-color' => wpbf_customize_str_value( $menu_trigger_bg_key ),
					'border'           => 'unset',
				),
			) );

		}

		/**
		 * ----------------------------------------------------------------------
		 * Trigger Button Padding.
		 * ----------------------------------------------------------------------
		 */

		$button_padding = wpbf_customize_array_value( 'wpbf_header_builder_' . $header_builder_device . '_menu_trigger_padding', [
			'top'    => 10,
			'right'  => 10,
			'bottom' => 10,
			'left'   => 10,
		] );

		$button_top_padding    = wpbf_get_theme_mod_value( $button_padding, 'top' );
		$button_right_padding  = wpbf_get_theme_mod_value( $button_padding, 'right' );
		$button_bottom_padding = wpbf_get_theme_mod_value( $button_padding, 'bottom' );
		$button_left_padding   = wpbf_get_theme_mod_value( $button_padding, 'left' );

		if ( $button_top_padding || $button_right_padding || $button_bottom_padding || $button_left_padding ) {

			wpbf_write_css( array(
				'selector' => 'mobile' === $header_builder_device ? '#wpbf-mobile-menu-toggle' : '#wpbf-menu-toggle',
				'props'    => array(
					'padding-top'    => $button_top_padding ? wpbf_maybe_append_suffix( $button_top_padding ) : null,
					'padding-right'  => $button_right_padding ? wpbf_maybe_append_suffix( $button_right_padding ) : null,
					'padding-bottom' => $button_bottom_padding ? wpbf_maybe_append_suffix( $button_bottom_padding ) : null,
					'padding-left'   => $button_left_padding ? wpbf_maybe_append_suffix( $button_left_padding ) : null,
				),
			) );

		}

		/**
		 * ----------------------------------------------------------------------
		 * Trigger Button Border Radius.
		 *
		 * Desktop only, because the mobile version already handled in "styles.php"
		 * in "mobile_menu_hamburger_border_radius" control.
		 * ----------------------------------------------------------------------
		 */
		if ( 'desktop' === $header_builder_device ) {
			$button_border_radius = wpbf_customize_str_value( 'wpbf_header_builder_' . $header_builder_device . '_menu_trigger_border_radius' );

			if ( $button_border_radius ) {
				wpbf_write_css( array(
					'selector' => '#wpbf-menu-toggle',
					'props'    => array(
						'border-radius' => $button_border_radius ? wpbf_maybe_append_suffix( $button_border_radius ) : null,
					),
				) );
			}
		}

	} else {

		wpbf_write_css( array(
			'selector' => 'mobile' === $header_builder_device ? '#wpbf-mobile-menu-toggle' : '#wpbf-menu-toggle',
			'props'    => array(
				'background-color' => 'unset',
				'border'           => 'unset',
			),
		) );

	}
}
