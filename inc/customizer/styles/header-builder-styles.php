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
 * Header Rows Styles
 * ----------------------------------------------------------------------
 */

$header_builder_rows = wpbf_customize_array_value( 'wpbf_header_builder', array() );

$rows = array();

// Filter the saved rows.
if ( is_array( $header_builder_rows ) && ! empty( $header_builder_rows ) ) {
	foreach ( $header_builder_rows as $row_key => $columns ) {
		if ( empty( $row_key ) || empty( $columns ) ) {
			continue;
		}

		foreach ( $columns as $column_key => $widget_keys ) {
			if ( empty( $column_key ) || empty( $widget_keys ) ) {
				continue;
			}

			if ( ! isset( $rows[ $row_key ] ) ) {
				$rows[ $row_key ] = array();
			}

			if ( ! isset( $rows[ $row_key ][ $column_key ] ) ) {
				$rows[ $row_key ][ $column_key ] = array();
			}

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				$rows[ $row_key ][ $column_key ][] = $widget_key;
			}
		}
	}
}

// Now loop through the filtered/validated rows.
foreach ( $rows as $row_key => $columns ) {
	$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

	/**
	 * These fields are handled here for row_3 only
	 * because row_3 didn't exist before the new header builder added.
	 *
	 * Max width:
	 * - In row_1, the value is using the existing `pre_header_width` setting.
	 * - In row_2, the value is using the existing `menu_width` setting.
	 *
	 * Vertical padding:
	 * - In row_1, the value is using the existing `pre_header_height` setting.
	 * - In row_2, the value is using the existing `menu_height` setting.
	 *
	 * Font size:
	 * - In row_1, the value is using the existing `pre_header_font_size` setting.
	 * - In row_2, the value is using the existing `menu_font_size` setting.
	 *
	 * Background color:
	 * - In row_1, the value is using the existing `pre_header_bg_color` setting.
	 * - In row_2, the value is using the existing `menu_bg_color` setting.
	 *
	 * Text color:
	 * - In row_1, the value is using the existing `pre_header_font_color` setting.
	 * - In row_2, the value is using the existing `menu_font_colors` (multicolor) setting.
	 *
	 * Accent colors:
	 * - In row_1, the value is using the existing `pre_header_accent_colors` (multicolor) setting.
	 * - In row_2, there's no accent colors setting (we follow the old header section).
	 */
	if ( 'row_3' === $row_key ) {
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

$devices = ( new ResponsiveUtil() )->devices();

$header_builder_control_id_prefix = 'wpbf_header_builder_';

/**
 * ----------------------------------------------------------------------
 * Button Widget Styles
 * ----------------------------------------------------------------------
 */

$button_keys = array( 'button_1', 'button_2' );

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