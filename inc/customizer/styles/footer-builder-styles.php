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
		if ( 'desktop_row_2' === $row_key ) {
			$max_width = wpbf_customize_str_value( 'footer_width' );
			$max_width = '' === $max_width || '1200' === $max_width || '1200px' === $max_width ? null : $max_width;
	
			if ( $max_width ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-container',
					'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $max_width ) ),
				) );
			}
	
			$v_padding = wpbf_customize_str_value( 'footer_height' );
			$v_padding = '' === $v_padding || '15' === $v_padding ? '15px' : $v_padding;
	
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-row-content',
				'props'    => array(
					'padding-top'    => wpbf_maybe_append_suffix( $v_padding ),
					'padding-bottom' => wpbf_maybe_append_suffix( $v_padding ),
				),
			) );
	
			$bg_color   = wpbf_customize_str_value( 'footer_bg_color' );
			$text_color = wpbf_customize_str_value( 'footer_font_color' );
	
			if ( $bg_color || $text_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ),
					'props'    => array(
						'background-color' => $bg_color ? $bg_color : null,
						'color'            => $text_color ? $text_color : null,
					),
				) );
			}
	
			$accent_colors = array(
				'default' => wpbf_customize_str_value( 'footer_accent_color' ),
				'hover'   => wpbf_customize_str_value( 'footer_accent_color_alt' ),
			);
	
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
	
			$font_size = wpbf_customize_str_value( 'footer_font_size' );
	
			if ( $font_size && '16px' !== $font_size && '16' !== $font_size ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ),
					'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
				) );
			}
	
			// Border Top.
			$border_top_width = wpbf_customize_str_value( $row_id_prefix . 'border_top_width' );
			$border_top_style = wpbf_customize_str_value( $row_id_prefix . 'border_top_style' );
			$border_top_color = wpbf_customize_str_value( $row_id_prefix . 'border_top_color' );
			$border_top_scope = wpbf_customize_str_value( $row_id_prefix . 'border_top_scope' );
		} else {
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
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ),
				'props'    => array(
					'background-color' => $bg_color ? $bg_color : null,
					'color'            => $text_color ? $text_color : null,
				),
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

			// Border Top.
			$border_top_width = wpbf_customize_str_value( $row_id_prefix . 'border_top_width' );
			$border_top_style = wpbf_customize_str_value( $row_id_prefix . 'border_top_style' );
			$border_top_color = wpbf_customize_str_value( $row_id_prefix . 'border_top_color' );
			$border_top_scope = wpbf_customize_str_value( $row_id_prefix . 'border_top_scope' );
		}

		// Column Gap.
		$column_gap = wpbf_customize_str_value( $row_id_prefix . 'column_gap' );
		$column_gap = '' === $column_gap || '20' === $column_gap || '20px' === $column_gap ? '20px' : $column_gap;

		if ( $column_gap ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-row-content, .wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-builder-zone',
				'props'    => array(
					'gap' => wpbf_maybe_append_suffix( $column_gap ),
				),
			) );
		}

		// Column Alignment (per-column).
		$column_keys = array( 'column_1_start', 'column_1_end', 'column_2', 'column_3_start', 'column_3_end' );
		foreach ( $column_keys as $col_key ) {
			$col_align = wpbf_customize_str_value( $row_id_prefix . $col_key . '_align' );
			if ( $col_align && 'default' !== $col_align ) {
				$justify    = 'flex-start';
				$text_align = 'left';

				if ( 'center' === $col_align ) {
					$justify    = 'center';
					$text_align = 'center';
				} elseif ( 'end' === $col_align || 'right' === $col_align ) {
					$justify    = 'flex-end';
					$text_align = 'right';
				} elseif ( 'space-between' === $col_align ) {
					$justify    = 'space-between';
					$text_align = 'inherit';
				}

				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-builder-column-' . esc_attr( $col_key ),
					'props'    => array(
						'justify-content' => $justify,
						'text-align'      => $text_align,
					),
				) );
			}
		}

		// Only output border if style is not 'none' and width is set.
		if ( $border_top_style && 'none' !== $border_top_style && $border_top_width ) {
			$border_selector = 'fullwidth' === $border_top_scope
				? '.wpbf-footer-row-' . esc_attr( $row_key )
				: '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-container';

			wpbf_write_css( array(
				'selector' => $border_selector,
				'props'    => array(
					'border-top-width' => wpbf_maybe_append_suffix( $border_top_width ),
					'border-top-style' => $border_top_style,
					'border-top-color' => $border_top_color ? $border_top_color : 'currentColor',
				),
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
				'props'    => array(
					'background-color' => $bg_color ? $bg_color : null,
					'color'            => $text_color ? $text_color : null,
				),
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

		// Border Top.
		$border_top_width = wpbf_customize_str_value( $row_id_prefix . 'border_top_width' );
		$border_top_style = wpbf_customize_str_value( $row_id_prefix . 'border_top_style' );
		$border_top_color = wpbf_customize_str_value( $row_id_prefix . 'border_top_color' );
		$border_top_scope = wpbf_customize_str_value( $row_id_prefix . 'border_top_scope' );

		// Column Gap.
		$column_gap = wpbf_customize_str_value( $row_id_prefix . 'column_gap' );
		$column_gap = '' === $column_gap || '20' === $column_gap || '20px' === $column_gap ? '20px' : $column_gap;

		if ( $column_gap ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-row-content, .wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-builder-zone',
				'props'    => array(
					'gap' => wpbf_maybe_append_suffix( $column_gap ),
				),
			) );
		}

		// Column Alignment (per-column).
		$column_keys = array( 'column_1_start', 'column_1_end', 'column_2', 'column_3_start', 'column_3_end' );
		foreach ( $column_keys as $col_key ) {
			$col_align = wpbf_customize_str_value( $row_id_prefix . $col_key . '_align' );
			if ( $col_align && 'default' !== $col_align ) {
				$justify    = 'flex-start';
				$text_align = 'left';

				if ( 'center' === $col_align ) {
					$justify    = 'center';
					$text_align = 'center';
				} elseif ( 'end' === $col_align || 'right' === $col_align ) {
					$justify    = 'flex-end';
					$text_align = 'right';
				} elseif ( 'space-between' === $col_align ) {
					$justify    = 'space-between';
					$text_align = 'inherit';
				}

				wpbf_write_css( array(
					'selector' => '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-builder-column-' . esc_attr( $col_key ),
					'props'    => array(
						'justify-content' => $justify,
						'text-align'      => $text_align,
					),
				) );
			}
		}

		// Only output border if style is not 'none' and width is set.
		if ( $border_top_style && 'none' !== $border_top_style && $border_top_width ) {
			$border_selector = 'fullwidth' === $border_top_scope
				? '.wpbf-footer-row-' . esc_attr( $row_key )
				: '.wpbf-footer-row-' . esc_attr( $row_key ) . ' .wpbf-container';

			wpbf_write_css( array(
				'selector' => $border_selector,
				'props'    => array(
					'border-top-width' => wpbf_maybe_append_suffix( $border_top_width ),
					'border-top-style' => $border_top_style,
					'border-top-color' => $border_top_color ? $border_top_color : 'currentColor',
				),
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
 * Footer Builder Widget Title Styles
 * ----------------------------------------------------------------------
 *
 * Base styles for widget titles displayed above Menu and HTML widgets.
 */

wpbf_write_css( array(
	'selector' => '.wpbf-footer-widget-title',
	'props'    => array(
		'margin'      => '0 0 15px 0',
		'font-size'   => '16px',
		'font-weight' => '600',
		'color'       => 'inherit',
	),
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
	'selector' => '.wpbf-footer-builder .wpbf-row-content, .wpbf-footer-builder .wpbf-builder-zone',
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

/**
 * ----------------------------------------------------------------------
 * Footer Builder Widget Responsive Padding Styles
 * ----------------------------------------------------------------------
 */
if ( ! function_exists( 'wpbf_generate_footer_widget_padding_css' ) ) {
	/**
	 * Helper function to generate responsive padding CSS for footer widgets.
	 *
	 * @param string $setting_id The setting ID.
	 * @param string $selector   The CSS selector.
	 */
	function wpbf_generate_footer_widget_padding_css( $setting_id, $selector ) {
		$padding = wpbf_customize_array_value( $setting_id );

		if ( empty( $padding ) || ! is_array( $padding ) ) {
			return;
		}

		$breakpoint_mobile_int  = function_exists( 'wpbf_breakpoint_mobile' ) ? wpbf_breakpoint_mobile() : 480;
		$breakpoint_desktop_int = function_exists( 'wpbf_breakpoint_desktop' ) ? wpbf_breakpoint_desktop() : 1024;
		$breakpoint_mobile      = $breakpoint_mobile_int . 'px';
		$breakpoint_desktop     = $breakpoint_desktop_int . 'px';

		$desktop_top    = wpbf_get_theme_mod_value( $padding, 'desktop_top' );
		$desktop_right  = wpbf_get_theme_mod_value( $padding, 'desktop_right' );
		$desktop_bottom = wpbf_get_theme_mod_value( $padding, 'desktop_bottom' );
		$desktop_left   = wpbf_get_theme_mod_value( $padding, 'desktop_left' );

		if ( is_numeric( $desktop_top ) || is_numeric( $desktop_right ) || is_numeric( $desktop_bottom ) || is_numeric( $desktop_left ) ) {
			wpbf_write_css( array(
				'selector' => $selector,
				'props'    => array(
					'padding-top'    => is_numeric( $desktop_top ) ? wpbf_maybe_append_suffix( $desktop_top ) : null,
					'padding-right'  => is_numeric( $desktop_right ) ? wpbf_maybe_append_suffix( $desktop_right ) : null,
					'padding-bottom' => is_numeric( $desktop_bottom ) ? wpbf_maybe_append_suffix( $desktop_bottom ) : null,
					'padding-left'   => is_numeric( $desktop_left ) ? wpbf_maybe_append_suffix( $desktop_left ) : null,
				),
			) );
		}

		$tablet_top    = wpbf_get_theme_mod_value( $padding, 'tablet_top' );
		$tablet_right  = wpbf_get_theme_mod_value( $padding, 'tablet_right' );
		$tablet_bottom = wpbf_get_theme_mod_value( $padding, 'tablet_bottom' );
		$tablet_left   = wpbf_get_theme_mod_value( $padding, 'tablet_left' );

		if ( is_numeric( $tablet_top ) || is_numeric( $tablet_right ) || is_numeric( $tablet_bottom ) || is_numeric( $tablet_left ) ) {
			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
				'selector'    => $selector,
				'props'       => array(
					'padding-top'    => is_numeric( $tablet_top ) ? wpbf_maybe_append_suffix( $tablet_top ) : null,
					'padding-right'  => is_numeric( $tablet_right ) ? wpbf_maybe_append_suffix( $tablet_right ) : null,
					'padding-bottom' => is_numeric( $tablet_bottom ) ? wpbf_maybe_append_suffix( $tablet_bottom ) : null,
					'padding-left'   => is_numeric( $tablet_left ) ? wpbf_maybe_append_suffix( $tablet_left ) : null,
				),
			) );
		}

		$mobile_top    = wpbf_get_theme_mod_value( $padding, 'mobile_top' );
		$mobile_right  = wpbf_get_theme_mod_value( $padding, 'mobile_right' );
		$mobile_bottom = wpbf_get_theme_mod_value( $padding, 'mobile_bottom' );
		$mobile_left   = wpbf_get_theme_mod_value( $padding, 'mobile_left' );

		if ( is_numeric( $mobile_top ) || is_numeric( $mobile_right ) || is_numeric( $mobile_bottom ) || is_numeric( $mobile_left ) ) {
			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
				'selector'    => $selector,
				'props'       => array(
					'padding-top'    => is_numeric( $mobile_top ) ? wpbf_maybe_append_suffix( $mobile_top ) : null,
					'padding-right'  => is_numeric( $mobile_right ) ? wpbf_maybe_append_suffix( $mobile_right ) : null,
					'padding-bottom' => is_numeric( $mobile_bottom ) ? wpbf_maybe_append_suffix( $mobile_bottom ) : null,
					'padding-left'   => is_numeric( $mobile_left ) ? wpbf_maybe_append_suffix( $mobile_left ) : null,
				),
			) );
		}
	}
}

// Menu widget padding.
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_desktop_menu_1_padding', '.wpbf-footer-menu-widget-desktop_menu_1' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_desktop_menu_2_padding', '.wpbf-footer-menu-widget-desktop_menu_2' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_mobile_menu_1_padding', '.wpbf-footer-menu-widget-mobile_menu_1' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_mobile_menu_2_padding', '.wpbf-footer-menu-widget-mobile_menu_2' );

// HTML widget padding.
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_desktop_html_1_padding', '.wpbf-footer-html-widget-wrapper-desktop_html_1' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_desktop_html_2_padding', '.wpbf-footer-html-widget-wrapper-desktop_html_2' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_mobile_html_1_padding', '.wpbf-footer-html-widget-wrapper-mobile_html_1' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_mobile_html_2_padding', '.wpbf-footer-html-widget-wrapper-mobile_html_2' );

// Social icons padding.
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_desktop_social_padding', '.wpbf-footer-social.wpbf_footer_builder_desktop_social' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_mobile_social_padding', '.wpbf-footer-social.wpbf_footer_builder_mobile_social' );

// Copyright padding.
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_desktop_copyright_padding', '.wpbf-footer-copyright.wpbf_footer_builder_desktop_copyright' );
wpbf_generate_footer_widget_padding_css( 'wpbf_footer_builder_mobile_copyright_padding', '.wpbf-footer-copyright.wpbf_footer_builder_mobile_copyright' );

// Footer Button Styles.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/footer-builder-button-styles.php';
