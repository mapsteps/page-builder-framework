<?php
/**
 * Header Rows Styles
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

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

	// Text color and accent colors for desktop_row_2.
	if ( 'desktop_row_2' === $row_key ) {
		$text_color = wpbf_customize_str_value( $row_id_prefix . 'text_color' );

		if ( $text_color ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ) . ', .wpbf-header-row-' . esc_attr( $row_key ) . ' .widget_custom_html, .wpbf-header-row-' . esc_attr( $row_key ) . ' .textwidget',
				'props'    => array( 'color' => $text_color ),
			) );
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

	// Font size for desktop_row_2 and desktop_row_3.
	// Row 1 uses existing `pre_header_font_size` setting.
	if ( 'desktop_row_2' === $row_key || 'desktop_row_3' === $row_key ) {
		$font_size = wpbf_customize_str_value( $row_id_prefix . 'font_size' );

		if ( $font_size && '16px' !== $font_size && '16' !== $font_size ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-header-row-' . esc_attr( $row_key ),
				'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
			) );
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
