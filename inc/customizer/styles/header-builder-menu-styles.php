<?php
/**
 * Header Builder Menu Styles
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$header_builder_devices = [ 'desktop', 'mobile' ];

foreach ( $header_builder_devices as $header_builder_device ) {
	/**
	 * ----------------------------------------------------------------------
	 * Triggered Menu.
	 * ----------------------------------------------------------------------
	 */

	$menu_options = wpbf_customize_str_value(
		'wpbf_header_builder_' . $header_builder_device . '_offcanvas_reveal_as',
		'mobile' === $header_builder_device ? 'default' : 'off-canvas'
	);

	if ( in_array( $menu_options, array( 'default', 'dropdown' ), true ) ) {

		$menu_bg_color = wpbf_customize_str_value( 'mobile_menu_bg_color' );

		// For dropdown type (including default/empty), apply background color to the container.
		if ( $menu_bg_color ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-mobile-menu-dropdown .wpbf-mobile-menu-container',
				'props'    => array(
					'background-color' => $menu_bg_color,
				),
			) );
		}
	}

	/**
	 * Action to output off-canvas specific styles.
	 * Premium Add-On hooks here to output off-canvas menu styles.
	 *
	 * @param string $menu_options The menu options value.
	 * @param string $header_builder_device The device type ('desktop' or 'mobile').
	 */
	do_action( 'wpbf_header_builder_mobile_menu_styles', $menu_options, $header_builder_device );

	/**
	 * ----------------------------------------------------------------------
	 * Menu Trigger Button.
	 * ----------------------------------------------------------------------
	 */

	$menu_trigger_props = array();
	$menu_trigger_style = wpbf_customize_str_value( 'wpbf_header_builder_' . $header_builder_device . '_menu_trigger_style' );
	$menu_trigger_style = '' === $menu_trigger_style ? 'simple' : $menu_trigger_style;

	/**
	 * Some controls are defined only for the desktop version,
	 * because the mobile equivalents already existed before header builder feature was introduced.
	 *
	 * The following mobile controls are already handled elsewhere:
	 * - Menu trigger icon color → handled by "mobile_menu_hamburger_color".
	 * - Menu trigger button border radius → handled by "mobile_menu_hamburger_border_radius".
	 * - Menu trigger button background/border color → handled by "mobile_menu_hamburger_bg_color".
	 * - Menu trigger button icon size → handled by "mobile_menu_hamburger_size".
	 */

	$menu_trigger_icon_color = wpbf_customize_str_value(
		'mobile' === $header_builder_device ? 'mobile_menu_hamburger_color' : 'wpbf_header_builder_desktop_menu_trigger_icon_color'
	);

	$menu_trigger_button_border_radius = wpbf_customize_str_value(
		'mobile' === $header_builder_device ? 'mobile_menu_hamburger_border_radius' : 'wpbf_header_builder_desktop_menu_trigger_border_radius'
	);

	$menu_trigger_button_color = wpbf_customize_str_value(
		'mobile' === $header_builder_device ? 'mobile_menu_hamburger_bg_color' : 'wpbf_header_builder_desktop_menu_trigger_bg_color'
	);

	$menu_trigger_icon_size = wpbf_customize_str_value(
		'mobile' === $header_builder_device ? 'mobile_menu_hamburger_size' : 'wpbf_header_builder_desktop_menu_trigger_icon_size', '16px'
	);

	$menu_trigger_props['font-size'] = wpbf_maybe_append_suffix( $menu_trigger_icon_size );

	// Icon color (mobile uses mobile_menu_hamburger_color). Make sure we emit it.
	// For solid style with background color, default to white if no custom color is set.
	if ( $menu_trigger_icon_color ) {
		$menu_trigger_props['color'] = $menu_trigger_icon_color . '!important';
	} elseif ( 'solid' === $menu_trigger_style && $menu_trigger_button_color ) {
		// Default to white for solid style when user hasn't set a custom icon color.
		$menu_trigger_props['color'] = '#ffffff !important';
	}

	// If the menu trigger style is either 'outlined' or 'solid'.
	if ( ! empty( $menu_trigger_style ) ) {
		if ( $menu_trigger_button_border_radius ) {
			$menu_trigger_props['border-radius'] = wpbf_maybe_append_suffix( $menu_trigger_button_border_radius );
		}

		if ( 'outline' === $menu_trigger_style ) {
			if ( $menu_trigger_button_color ) {
				$menu_trigger_props['background-color'] = 'unset';
				$menu_trigger_props['border']           = '2px solid ' . $menu_trigger_button_color;
			}
		} elseif ( 'solid' === $menu_trigger_style ) {
			if ( $menu_trigger_button_color ) {
				$menu_trigger_props['background-color'] = $menu_trigger_button_color;
				$menu_trigger_props['border']           = 'unset';
			}
		} elseif ( wpbf_header_builder_enabled() ) {
			// Only reset styles for "simple" style when header builder is enabled.
			// When header builder is disabled, the legacy controls (mobile_menu_hamburger_bg_color, etc.)
			// in header-styles.php should handle the styling without being overridden.
			$menu_trigger_props['background-color'] = 'unset';
			$menu_trigger_props['border']           = 'unset';
		}

		$button_padding = wpbf_customize_array_value( 'wpbf_header_builder_' . $header_builder_device . '_menu_trigger_padding', [
			'top'    => 10,
			'right'  => 10,
			'bottom' => 10,
			'left'   => 10,
		] );

		$button_top_padding = wpbf_get_theme_mod_value( $button_padding, 'top' );

		if ( $button_top_padding ) {
			$menu_trigger_props['padding-top'] = wpbf_maybe_append_suffix( $button_top_padding );
		}

		$button_right_padding = wpbf_get_theme_mod_value( $button_padding, 'right' );

		if ( $button_right_padding ) {
			$menu_trigger_props['padding-right'] = wpbf_maybe_append_suffix( $button_right_padding );
		}

		$button_bottom_padding = wpbf_get_theme_mod_value( $button_padding, 'bottom' );

		if ( $button_bottom_padding ) {
			$menu_trigger_props['padding-bottom'] = wpbf_maybe_append_suffix( $button_bottom_padding );
		}

		$button_left_padding = wpbf_get_theme_mod_value( $button_padding, 'left' );

		if ( $button_left_padding ) {
			$menu_trigger_props['padding-left'] = wpbf_maybe_append_suffix( $button_left_padding );
		}

	} else {

		$menu_trigger_props['background-color'] = 'unset !important';
		$menu_trigger_props['border']           = 'unset !important';

	}

	wpbf_write_css( array(
		'selector' => 'mobile' === $header_builder_device ? '.wpbf-mobile-menu-toggle' : '.wpbf-menu-toggle',
		'props'    => $menu_trigger_props,
	) );

	/**
	 * ----------------------------------------------------------------------
	 * Menu 1 & Menu 2.
	 *
	 * The following controls are already handled elsewhere in styles.php:
	 * - Menu 1 (desktop) padding → handled by "menu_padding".
	 * - Menu 1 (mobile) padding → handled by "mobile_menu_padding".
	 * ----------------------------------------------------------------------
	 */

	if ( 'desktop' === $header_builder_device ) {
		$menu_2_padding = wpbf_customize_str_value( 'wpbf_header_builder_' . $header_builder_device . '_menu_2_menu_padding' );
		$menu_2_padding = '20' === $menu_2_padding || '' === $menu_2_padding ? '20px' : $menu_2_padding;

		wpbf_write_css( array(
			'selector' => '.wpbf-menu.desktop_menu_2 > .menu-item > a',
			'props'    => array(
				'padding-left'  => wpbf_maybe_append_suffix( $menu_2_padding ),
				'padding-right' => wpbf_maybe_append_suffix( $menu_2_padding ),
			),
		) );

		/**
		 * Always output Menu 2 font size (default 16px) to prevent inheriting row's font size.
		 *
		 * @see header-styles.php for detailed explanation of this architectural issue.
		 */
		$menu_2_font_size = wpbf_customize_str_value( 'wpbf_header_builder_' . $header_builder_device . '_menu_2_menu_font_size' );
		$menu_2_font_size = wpbf_not_empty_allow_zero( $menu_2_font_size ) ? $menu_2_font_size : '16px';

		wpbf_write_css( array(
			'selector' => '.wpbf-menu.desktop_menu_2 > .menu-item > a',
			'props'    => array(
				'font-size' => wpbf_maybe_append_suffix( $menu_2_font_size ),
			),
		) );
	}

	// Mobile menu 2 padding is now handled in styles.php to be consistent with mobile menu 1 pattern.

	/**
	 * ----------------------------------------------------------------------
	 * Desktop Off Canvas Section.
	 * ----------------------------------------------------------------------
	 */

	if ( 'desktop' === $header_builder_device ) {
		// Get the reveal_as setting for desktop off-canvas.
		$desktop_reveal_as = wpbf_customize_str_value(
			'wpbf_header_builder_desktop_offcanvas_reveal_as',
			'off-canvas'
		);

		// Apply styles for both 'off-canvas' (right) and 'off-canvas-left' (left).
		if ( 'off-canvas' === $desktop_reveal_as || 'off-canvas-left' === $desktop_reveal_as ) {
			// Off canvas width.
			$menu_off_canvas_width = wpbf_customize_str_value( 'menu_off_canvas_width' );
			$menu_off_canvas_width = '400' === $menu_off_canvas_width || '400px' === $menu_off_canvas_width ? '' : $menu_off_canvas_width;

			if ( $menu_off_canvas_width ) {
				if ( 'off-canvas-left' === $desktop_reveal_as ) {
					// Left position - menu slides in from left, push content to right.
					wpbf_write_css( array(
						'blocks' => array(
							array(
								'selector' => '.wpbf-menu-off-canvas-left',
								'props'    => array(
									'width' => wpbf_maybe_append_suffix( $menu_off_canvas_width ),
									'left'  => '-' . wpbf_maybe_append_suffix( $menu_off_canvas_width ),
								),
							),
							array(
								'selector' => '.wpbf-push-menu-left.active',
								'props'    => array(
									'left' => wpbf_maybe_append_suffix( $menu_off_canvas_width ),
								),
							),
							array(
								'selector' => '.wpbf-push-menu-left.active .wpbf-navigation-active',
								'props'    => array(
									'left' => wpbf_maybe_append_suffix( $menu_off_canvas_width ) . ' !important',
								),
							),
						),
					) );
				} elseif ( 'off-canvas' === $desktop_reveal_as ) {
					// Right position (default) - menu slides in from right, push content to left.
					wpbf_write_css( array(
						'blocks' => array(
							array(
								'selector' => '.wpbf-menu-off-canvas-right',
								'props'    => array(
									'width' => wpbf_maybe_append_suffix( $menu_off_canvas_width ),
									'right' => '-' . wpbf_maybe_append_suffix( $menu_off_canvas_width ),
								),
							),
							array(
								'selector' => '.wpbf-push-menu-right.active',
								'props'    => array(
									'left' => '-' . wpbf_maybe_append_suffix( $menu_off_canvas_width ),
								),
							),
							array(
								'selector' => '.wpbf-push-menu-right.active .wpbf-navigation-active',
								'props'    => array(
									'left' => '-' . wpbf_maybe_append_suffix( $menu_off_canvas_width ) . ' !important',
								),
							),
						),
					) );
				}
			}

			// Off canvas background color.
			$menu_off_canvas_bg_color = wpbf_customize_str_value( 'menu_off_canvas_bg_color' );
			$menu_off_canvas_bg_color = '#ffffff' === $menu_off_canvas_bg_color ? '' : $menu_off_canvas_bg_color;

			if ( $menu_off_canvas_bg_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-menu-off-canvas, .wpbf-menu-full-screen',
					'props'    => array(
						'background-color' => $menu_off_canvas_bg_color,
					),
				) );
			}

			// Off canvas submenu arrow color.
			$menu_off_canvas_submenu_arrow_color = wpbf_customize_str_value( 'menu_off_canvas_submenu_arrow_color' );

			if ( $menu_off_canvas_submenu_arrow_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-menu-off-canvas .wpbf-submenu-toggle',
					'props'    => array(
						'color' => $menu_off_canvas_submenu_arrow_color,
					),
				) );
			}

			// Off canvas overlay color.
			$menu_overlay       = wpbf_customize_bool_value( 'menu_overlay' );
			$menu_overlay_color = wpbf_customize_str_value( 'menu_overlay_color' );
			$menu_overlay_color = 'rgba(0,0,0,.5)' === $menu_overlay_color || 'rgba(0, 0, 0,.5)' === $menu_overlay_color ? '' : $menu_overlay_color;

			if ( $menu_overlay && $menu_overlay_color ) {
				wpbf_write_css( array(
					'selector' => '.wpbf-menu-overlay',
					'props'    => array(
						'background-color' => $menu_overlay_color,
					),
				) );
			}
		}
	}
}
