<?php
/**
 * Footer Builder Rows Styles
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * ----------------------------------------------------------------------
 * Footer Builder Rows Styles
 * ----------------------------------------------------------------------
 */

$saved_values   = wpbf_customize_array_value( 'wpbf_footer_builder', array() );
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
	$row_id_prefix = 'wpbf_footer_builder_' . $row_key . '_';

	/**
	 * All desktop rows (Top, Main, Bottom) now have their own controls.
	 */
	if ( 'desktop_row_1' === $row_key || 'desktop_row_2' === $row_key || 'desktop_row_3' === $row_key ) {
		$max_width = wpbf_customize_str_value( $row_id_prefix . 'max_width' );
		$max_width = '' === $max_width || '1200' === $max_width || '1200px' === $max_width ? null : $max_width;

		if ( $max_width ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-container',
				'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $max_width ) ),
			) );
		}

		$v_padding = wpbf_customize_str_value( $row_id_prefix . 'vertical_padding' );
		$v_padding = '' === $v_padding || '15' === $v_padding ? '15px' : $v_padding;

		wpbf_write_css( array(
			'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-row-content',
			'props'    => array(
				'padding-top'    => wpbf_maybe_append_suffix( $v_padding ),
				'padding-bottom' => wpbf_maybe_append_suffix( $v_padding ),
			),
		) );

		$bg_color   = wpbf_customize_str_value( $row_id_prefix . 'bg_color' );
		$text_color = wpbf_customize_str_value( $row_id_prefix . 'text_color' );

		if ( $bg_color || $text_color ) {
			echo '.wpbf-footer-row-' . esc_attr( $row_key ) . ' {';

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
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' a',
					'props'    => array( 'color' => $default_color ),
				) );
			}

			if ( $hover_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' a:hover, .wpbf-footer-row-' . esc_attr( $row_key ) . ' a:focus',
					'props'    => array( 'color' => $hover_color ),
				) );
			}
		}

		$font_size = wpbf_customize_str_value( $row_id_prefix . 'font_size' );

		if ( $font_size && '16px' !== $font_size && '16' !== $font_size ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ),
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
	$row_id_prefix = 'wpbf_footer_builder_' . $row_key . '_';

	/**
	 * All mobile rows (Top, Main, Bottom) now have their own controls.
	 * Mobile rows don't have max_width control (following header builder pattern).
	 */
	if ( 'mobile_row_1' === $row_key || 'mobile_row_2' === $row_key || 'mobile_row_3' === $row_key ) {
		$v_padding = wpbf_customize_str_value( $row_id_prefix . 'vertical_padding' );
		$v_padding = '' === $v_padding || '15' === $v_padding ? '15px' : $v_padding;

		wpbf_write_css( array(
			'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-row-content',
			'props'    => array(
				'padding-top'    => wpbf_maybe_append_suffix( $v_padding ),
				'padding-bottom' => wpbf_maybe_append_suffix( $v_padding ),
			),
		) );

		$bg_color   = wpbf_customize_str_value( $row_id_prefix . 'bg_color' );
		$text_color = wpbf_customize_str_value( $row_id_prefix . 'text_color' );

		if ( $bg_color || $text_color ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ),
				'props'    => array( 'background-color' => $bg_color ),
			) );

			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ),
				'props'    => array( 'color' => $text_color ),
			) );
		}

		$accent_colors = wpbf_customize_array_value( $row_id_prefix . 'accent_colors' );

		if ( ! empty( $accent_colors ) ) {
			$default_color = ! empty( $accent_colors['default'] ) ? $accent_colors['default'] : '';
			$hover_color   = ! empty( $accent_colors['hover'] ) ? $accent_colors['hover'] : '';

			if ( $default_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' a',
					'props'    => array( 'color' => $default_color ),
				) );
			}

			if ( $hover_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' a:hover, .wpbf-footer-row-' . esc_attr( $row_key ) . ' a:focus',
					'props'    => array( 'color' => $hover_color ),
				) );
			}
		}

		$font_size = wpbf_customize_str_value( $row_id_prefix . 'font_size' );

		if ( $font_size && '16px' !== $font_size && '16' !== $font_size ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ),
				'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
			) );
		}
	}
}

/**
 * ----------------------------------------------------------------------
 * Footer Builder Logo Widget Styles
 * ----------------------------------------------------------------------
 */

// Desktop logo width.
$desktop_logo_width = wpbf_customize_str_value( 'wpbf_footer_builder_desktop_logo_width' );

if ( $desktop_logo_width ) {
	wpbf_write_css( array(
		'selector' => '.wpbf-footer-desktop .wpbf-footer-logo img',
		'props'    => array( 'width' => wpbf_maybe_append_suffix( $desktop_logo_width ) ),
	) );
}

// Mobile logo width.
$mobile_logo_width = wpbf_customize_str_value( 'wpbf_footer_builder_mobile_logo_width' );

if ( $mobile_logo_width ) {
	wpbf_write_css( array(
		'selector' => '.wpbf-footer-mobile .wpbf-footer-logo img',
		'props'    => array( 'width' => wpbf_maybe_append_suffix( $mobile_logo_width ) ),
	) );
}

/**
 * ----------------------------------------------------------------------
 * Footer Builder HTML Widget Styles
 * ----------------------------------------------------------------------
 */

// Reset margin-bottom on last element for proper vertical centering.
wpbf_write_css( array(
	'selector' => '.wpbf-footer-html-widget p:last-child, .wpbf-footer-html-widget > *:last-child',
	'props'    => array( 'margin-bottom' => '0' ),
) );

/**
 * ----------------------------------------------------------------------
 * Footer Builder Social Icons Widget Styles
 * ----------------------------------------------------------------------
 */

// Add spacing between social icons using flexbox gap.
wpbf_write_css( array(
	'selector' => '.wpbf-footer-social',
	'props'    => array(
		'display'   => 'flex',
		'flex-wrap' => 'wrap',
		'gap'       => '10px',
	),
) );

/**
 * ----------------------------------------------------------------------
 * Footer Builder Row Alignment
 * ----------------------------------------------------------------------
 *
 * Override the default vertical centering (align-items: center) for footer rows.
 * Footer content should be top-aligned, not vertically centered.
 * This is scoped to .wpbf-footer-builder to avoid affecting Header Builder.
 */

wpbf_write_css( array(
	'selector' => '.wpbf-footer-builder .wpbf-row-content',
	'props'    => array( 'align-items' => 'flex-start' ),
) );

/**
 * ----------------------------------------------------------------------
 * Footer Builder Menu Widget Styles
 * ----------------------------------------------------------------------
 *
 * Base styles for .wpbf-footer-menu to display as a vertical link list.
 * Uses isolated class to avoid affecting Header Builder's .wpbf-menu.
 */

wpbf_write_css( array(
	'selector' => '.wpbf-footer-menu',
	'props'    => array(
		'list-style' => 'none',
		'margin'     => '0',
		'padding'    => '0',
	),
) );

wpbf_write_css( array(
	'selector' => '.wpbf-footer-menu li',
	'props'    => array(
		'margin'  => '0',
		'padding' => '0',
	),
) );

wpbf_write_css( array(
	'selector' => '.wpbf-footer-menu a',
	'props'    => array(
		'display'         => 'block',
		'padding'         => '5px 0',
		'text-decoration' => 'none',
	),
) );

wpbf_write_css( array(
	'selector' => '.wpbf-footer-menu a:hover, .wpbf-footer-menu a:focus',
	'props'    => array( 'text-decoration' => 'underline' ),
) );

/**
 * ----------------------------------------------------------------------
 * Footer Builder Menu Widget Customizer Styles
 * ----------------------------------------------------------------------
 *
 * Dynamic styles from customizer settings for Menu 1 and Menu 2 widgets.
 */

// Desktop Menu 1 styles.
$menu_1_item_spacing = wpbf_customize_str_value( 'wpbf_footer_builder_desktop_menu_1_item_spacing' );

if ( $menu_1_item_spacing && '5' !== $menu_1_item_spacing ) {
	wpbf_write_css( array(
		'selector' => '.wpbf-footer-menu.desktop_menu_1 a',
		'props'    => array(
			'padding-top'    => wpbf_maybe_append_suffix( $menu_1_item_spacing ),
			'padding-bottom' => wpbf_maybe_append_suffix( $menu_1_item_spacing ),
		),
	) );
}

$menu_1_colors = wpbf_customize_array_value( 'wpbf_footer_builder_desktop_menu_1_link_colors' );

if ( ! empty( $menu_1_colors ) ) {
	$menu_1_default_color = ! empty( $menu_1_colors['default'] ) ? $menu_1_colors['default'] : '';
	$menu_1_hover_color   = ! empty( $menu_1_colors['hover'] ) ? $menu_1_colors['hover'] : '';

	if ( $menu_1_default_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.desktop_menu_1 a',
			'props'    => array( 'color' => $menu_1_default_color ),
		) );
	}

	if ( $menu_1_hover_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.desktop_menu_1 a:hover, .wpbf-footer-menu.desktop_menu_1 a:focus',
			'props'    => array( 'color' => $menu_1_hover_color ),
		) );
	}
}

// Desktop Menu 2 styles.
$menu_2_item_spacing = wpbf_customize_str_value( 'wpbf_footer_builder_desktop_menu_2_item_spacing' );

if ( $menu_2_item_spacing && '5' !== $menu_2_item_spacing ) {
	wpbf_write_css( array(
		'selector' => '.wpbf-footer-menu.desktop_menu_2 a',
		'props'    => array(
			'padding-top'    => wpbf_maybe_append_suffix( $menu_2_item_spacing ),
			'padding-bottom' => wpbf_maybe_append_suffix( $menu_2_item_spacing ),
		),
	) );
}

$menu_2_colors = wpbf_customize_array_value( 'wpbf_footer_builder_desktop_menu_2_link_colors' );

if ( ! empty( $menu_2_colors ) ) {
	$menu_2_default_color = ! empty( $menu_2_colors['default'] ) ? $menu_2_colors['default'] : '';
	$menu_2_hover_color   = ! empty( $menu_2_colors['hover'] ) ? $menu_2_colors['hover'] : '';

	if ( $menu_2_default_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.desktop_menu_2 a',
			'props'    => array( 'color' => $menu_2_default_color ),
		) );
	}

	if ( $menu_2_hover_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.desktop_menu_2 a:hover, .wpbf-footer-menu.desktop_menu_2 a:focus',
			'props'    => array( 'color' => $menu_2_hover_color ),
		) );
	}
}

// Mobile Menu 1 styles.
$mobile_menu_1_item_spacing = wpbf_customize_str_value( 'wpbf_footer_builder_mobile_menu_1_item_spacing' );

if ( $mobile_menu_1_item_spacing && '5' !== $mobile_menu_1_item_spacing ) {
	wpbf_write_css( array(
		'selector' => '.wpbf-footer-menu.mobile_menu_1 a',
		'props'    => array(
			'padding-top'    => wpbf_maybe_append_suffix( $mobile_menu_1_item_spacing ),
			'padding-bottom' => wpbf_maybe_append_suffix( $mobile_menu_1_item_spacing ),
		),
	) );
}

$mobile_menu_1_colors = wpbf_customize_array_value( 'wpbf_footer_builder_mobile_menu_1_link_colors' );

if ( ! empty( $mobile_menu_1_colors ) ) {
	$mobile_menu_1_default_color = ! empty( $mobile_menu_1_colors['default'] ) ? $mobile_menu_1_colors['default'] : '';
	$mobile_menu_1_hover_color   = ! empty( $mobile_menu_1_colors['hover'] ) ? $mobile_menu_1_colors['hover'] : '';

	if ( $mobile_menu_1_default_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.mobile_menu_1 a',
			'props'    => array( 'color' => $mobile_menu_1_default_color ),
		) );
	}

	if ( $mobile_menu_1_hover_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.mobile_menu_1 a:hover, .wpbf-footer-menu.mobile_menu_1 a:focus',
			'props'    => array( 'color' => $mobile_menu_1_hover_color ),
		) );
	}
}

// Mobile Menu 2 styles.
$mobile_menu_2_item_spacing = wpbf_customize_str_value( 'wpbf_footer_builder_mobile_menu_2_item_spacing' );

if ( $mobile_menu_2_item_spacing && '5' !== $mobile_menu_2_item_spacing ) {
	wpbf_write_css( array(
		'selector' => '.wpbf-footer-menu.mobile_menu_2 a',
		'props'    => array(
			'padding-top'    => wpbf_maybe_append_suffix( $mobile_menu_2_item_spacing ),
			'padding-bottom' => wpbf_maybe_append_suffix( $mobile_menu_2_item_spacing ),
		),
	) );
}

$mobile_menu_2_colors = wpbf_customize_array_value( 'wpbf_footer_builder_mobile_menu_2_link_colors' );

if ( ! empty( $mobile_menu_2_colors ) ) {
	$mobile_menu_2_default_color = ! empty( $mobile_menu_2_colors['default'] ) ? $mobile_menu_2_colors['default'] : '';
	$mobile_menu_2_hover_color   = ! empty( $mobile_menu_2_colors['hover'] ) ? $mobile_menu_2_colors['hover'] : '';

	if ( $mobile_menu_2_default_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.mobile_menu_2 a',
			'props'    => array( 'color' => $mobile_menu_2_default_color ),
		) );
	}

	if ( $mobile_menu_2_hover_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-footer-menu.mobile_menu_2 a:hover, .wpbf-footer-menu.mobile_menu_2 a:focus',
			'props'    => array( 'color' => $mobile_menu_2_hover_color ),
		) );
	}
}
