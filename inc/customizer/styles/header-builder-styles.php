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
	 * We let the old pre_header settings to handle these settings:
	 * - vertical_padding.
	 * - width (because row_1 doesn't use "use_container")
	 * - bg_color
	 *
	 * And we don't use these settings in row_1:
	 * - use_container
	 * - min_height
	 */
	if ( 'row_1' !== $row_key ) {
		echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' {';

		$bg_color = get_theme_mod( $row_id_prefix . 'bg_color', '' );

		if ( $bg_color ) {
			echo sprintf( 'background-color: %s;', esc_attr( $bg_color ) );
		}

		$text_color = get_theme_mod( $row_id_prefix . 'text_color', '' );

		if ( $text_color ) {
			echo sprintf( 'color: %s;', esc_attr( $text_color ) );
		}

		echo '}';

		echo '.wpbf-header-row-' . esc_attr( $row_key ) . ' .wpbf-row-content {';

		$min_heights = get_theme_mod( $row_id_prefix . 'min_height', [] );
		$min_heights = ! is_array( $min_heights ) ? [] : $min_heights;

		// The top row doesn't have min-height setting.
		if ( $min_heights ) {
			if ( isset( $min_heights['desktop'] ) ) {
				echo sprintf( 'min-height: %s;', esc_attr( $min_heights['desktop'] ) );
			}

			if ( isset( $min_heights['tablet'] ) ) {
				echo '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ') {';
				echo sprintf( 'min-height: %s;', esc_attr( $min_heights['tablet'] ) );
				echo '}';
			}

			if ( isset( $min_heights['mobile'] ) ) {
				echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';
				echo sprintf( 'min-height: %s;', esc_attr( $min_heights['mobile'] ) );
				echo '}';
			}
		}

		$v_paddings = get_theme_mod( $row_id_prefix . 'vertical_padding', [] );
		$v_paddings = ! is_array( $v_paddings ) ? [] : $v_paddings;

		// Vertical padding for top row is handled differently.
		if ( $v_paddings ) {
			if ( isset( $v_paddings['desktop'] ) ) {
				echo sprintf( 'padding-top: %s;', esc_attr( $v_paddings['desktop'] ) );
				echo sprintf( 'padding-bottom: %s;', esc_attr( $v_paddings['desktop'] ) );
			}

			if ( isset( $v_paddings['tablet'] ) ) {
				echo '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ') {';
				echo sprintf( 'padding-top: %s;', esc_attr( $v_paddings['tablet'] ) );
				echo sprintf( 'padding-bottom: %s;', esc_attr( $v_paddings['tablet'] ) );
				echo '}';
			}

			if ( isset( $v_paddings['mobile'] ) ) {
				echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';
				echo sprintf( 'padding-top: %s;', esc_attr( $v_paddings['mobile'] ) );
				echo sprintf( 'padding-bottom: %s;', esc_attr( $v_paddings['mobile'] ) );
				echo '}';
			}
		}

		echo '}';
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
