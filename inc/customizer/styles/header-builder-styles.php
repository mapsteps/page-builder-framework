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

$header_builder_rows = get_theme_mod( 'wpbf_header_builder', array() );

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
		$max_width = trim( strval( get_theme_mod( $row_id_prefix . 'max_width', '' ) ) );
		$max_width = '' === $max_width || '1200' === $max_width || '1200px' === $max_width ? null : strval( $max_width );

		if ( ! is_null( $max_width ) ) {
			echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' .wpbf-container {
				max-width: ' . esc_attr( wpbf_suffix_css_value( $max_width ) ) . ';
			}';
		}

		$v_padding = trim( strval( get_theme_mod( $row_id_prefix . 'vertical_padding' ) ) );
		$v_padding = '' === $v_padding || '15' === $v_padding || '15px' === $v_padding ? '15px' : $v_padding;
		$v_padding = wpbf_suffix_css_value( $v_padding );

		echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' .wpbf-row-content {
			padding-top: ' . esc_attr( $v_padding ) . 'px;
			padding-bottom: ' . esc_attr( $v_padding ) . 'px;
		}';

		$font_size = trim( strval( get_theme_mod( $row_id_prefix . 'font_size' ) ) );
		$font_size = '' === $font_size || '16' === $font_size || '16px' === $font_size ? '16px' : $font_size;

		if ( $font_size ) {
			echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' {
				font-size: ' . esc_attr( wpbf_suffix_css_value( $font_size ) ) . '
			}';
		}

		$bg_color   = get_theme_mod( $row_id_prefix . 'bg_color', '' );
		$text_color = get_theme_mod( $row_id_prefix . 'text_color', '' );

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

		$accent_colors = get_theme_mod( $row_id_prefix . 'accent_colors', [] );
		$accent_colors = ! is_array( $accent_colors ) ? [] : $accent_colors;

		if ( ! empty( $accent_colors ) ) {
			$default_color = isset( $accent_colors['default'] ) && '' !== $accent_colors['default'] ? $accent_colors['default'] : null;
			$hover_color   = isset( $accent_colors['hover'] ) && '' !== $accent_colors['hover'] ? $accent_colors['hover'] : null;

			if ( ! is_null( $default_color ) ) {
				echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' a {
					color: ' . esc_attr( $default_color ) . ';
				}';
			}

			if ( ! is_null( $hover_color ) ) {
				echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' a:hover, .wpbf-header-row-' . esc_attr( $row_key ) . ' a:focus {
					color: ' . esc_attr( $hover_color ) . ';
				}';
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

	$responsive_border_radius = get_theme_mod( $header_builder_control_id_prefix . $button_key . '_border_radius', [] );
	$responsive_border_radius = ! is_array( $responsive_border_radius ) ? [] : $responsive_border_radius;

	$responsive_border_width = get_theme_mod( $header_builder_control_id_prefix . $button_key . '_border_width', [] );
	$responsive_border_width = ! is_array( $responsive_border_width ) ? [] : $responsive_border_width;

	$button_border_style = get_theme_mod( $header_builder_control_id_prefix . $button_key . '_border_style', '' );
	$button_border_style = ! empty( $button_border_style ) ? $button_border_style : 'none';

	$button_border_colors = get_theme_mod( $header_builder_control_id_prefix . $button_key . '_border_color', [] );
	$button_border_colors = ! is_array( $button_border_colors ) ? [] : $button_border_colors;

	$button_bg_colors = get_theme_mod( $header_builder_control_id_prefix . $button_key . '_bg_color', [] );
	$button_bg_colors = ! is_array( $button_bg_colors ) ? [] : $button_bg_colors;

	$button_text_colors = get_theme_mod( $header_builder_control_id_prefix . $button_key . '_text_color', [] );
	$button_text_colors = ! is_array( $button_text_colors ) ? [] : $button_text_colors;

	echo esc_attr( $selector ) . ' {';

	if ( isset( $responsive_border_radius['desktop'] ) ) {
		$desktop_border_radius_value = $responsive_border_radius['desktop'];
		$desktop_border_radius_value = is_numeric( $desktop_border_radius_value ) ? $desktop_border_radius_value . 'px' : $desktop_border_radius_value;

		echo sprintf( 'border-radius: %s;', esc_attr( $desktop_border_radius_value ) );
	}

	if ( isset( $responsive_border_width['desktop'] ) ) {
		$desktop_border_width_value = $responsive_border_width['desktop'];
		$desktop_border_width_value = is_numeric( $desktop_border_width_value ) ? $desktop_border_width_value . 'px' : $desktop_border_width_value;

		echo sprintf( 'border-width: %s;', esc_attr( $desktop_border_width_value ) );
	}

	if ( 'none' !== $button_border_style ) {
		echo sprintf( 'border-style: %s;', esc_attr( $button_border_style ) );
	}

	if ( isset( $button_border_colors['default'] ) ) {
		$button_default_border_color_value = $button_border_colors['default'];

		if ( $button_default_border_color_value ) {
			echo sprintf( 'border-color: %s;', esc_attr( $button_default_border_color_value ) );
		}
	}

	if ( isset( $button_bg_colors['default'] ) ) {
		$button_default_bg_color_value = $button_bg_colors['default'];

		if ( $button_default_bg_color_value ) {
			echo sprintf( 'background-color: %s;', esc_attr( $button_default_bg_color_value ) );
		}
	}

	if ( isset( $button_text_colors['default'] ) ) {
		$button_default_text_color_value = $button_text_colors['default'];

		if ( $button_default_text_color_value ) {
			echo sprintf( 'color: %s;', esc_attr( $button_default_text_color_value ) );
		}
	}

	echo '}';

	echo esc_attr( $selector ) . ':hover {';

	if ( isset( $button_border_colors['hover'] ) ) {
		$button_hover_border_color_value = $button_border_colors['hover'];

		if ( $button_hover_border_color_value ) {
			echo sprintf( 'border-color: %s;', esc_attr( $button_hover_border_color_value ) );
		}
	}

	if ( isset( $button_bg_colors['hover'] ) ) {
		$button_hover_bg_color_value = $button_bg_colors['hover'];

		if ( $button_hover_bg_color_value ) {
			echo sprintf( 'background-color: %s;', esc_attr( $button_hover_bg_color_value ) );
		}
	}

	if ( isset( $button_text_colors['hover'] ) ) {
		$button_hover_text_color_value = $button_text_colors['hover'];

		if ( $button_hover_text_color_value ) {
			echo sprintf( 'color: %s;', esc_attr( $button_hover_text_color_value ) );
		}
	}

	echo '}';

	foreach ( $devices as $device ) {
		if ( 'desktop' === $device ) {
			continue;
		}

		if ( 'tablet' === $device || 'mobile' === $device ) {
			$breakpoint_width = 'tablet' === $device ? $breakpoint_medium : $breakpoint_mobile;

			echo sprintf( '@media screen and (max-width: %s) {', esc_attr( $breakpoint_width ) );
			echo esc_attr( $selector ) . ' {';

			if ( isset( $responsive_border_radius[ $device ] ) ) {
				$border_radius_value = $responsive_border_radius[ $device ];
				$border_radius_value = is_numeric( $border_radius_value ) ? $border_radius_value . 'px' : $border_radius_value;

				echo sprintf( 'border-radius: %s;', esc_attr( $border_radius_value ) );
			}

			if ( isset( $responsive_border_width[ $device ] ) ) {
				$border_width_value = $responsive_border_width[ $device ];
				$border_width_value = is_numeric( $border_width_value ) ? $border_width_value . 'px' : $border_width_value;

				echo sprintf( 'border-width: %s;', esc_attr( $border_width_value ) );
			}

			echo '}';
			echo '}';
		}
	}

}
