<?php

namespace Mapsteps\Wpbf\Customizer\HeaderBuilder;

final class HeaderBuilderConfig {

	/**
	 * Get header builder's available widgets.
	 *
	 * @return array
	 */
	public static function availableWidgets() {

		return array(
			'desktop' => array(
				array(
					'key'     => 'desktop_logo',
					'label'   => __( 'Logo', 'page-builder-framework' ),
					'section' => 'title_tagline',
				),
				array(
					'key'     => 'desktop_search',
					'label'   => __( 'Search', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_desktop_search_section',
				),
				array(
					'key'     => 'desktop_button_1',
					'label'   => __( 'Button 1', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_desktop_button_1_section',
				),
				array(
					'key'     => 'desktop_button_2',
					'label'   => __( 'Button 2', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_desktop_button_2_section',
				),
				array(
					'key'     => 'desktop_menu_1',
					'label'   => __( 'Menu 1', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_desktop_menu_1_section',
				),
				array(
					'key'     => 'desktop_menu_2',
					'label'   => __( 'Menu 2', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_desktop_menu_2_section',
				),
				array(
					'key'     => 'desktop_html_1',
					'label'   => __( 'HTML 1', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_desktop_html_1_section',
				),
				array(
					'key'     => 'desktop_html_2',
					'label'   => __( 'HTML 2', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_desktop_html_2_section',
				),
			),
			'mobile' => array(
				array(
					'key'     => 'mobile_logo',
					'label'   => __( 'Logo', 'page-builder-framework' ),
					'section' => 'title_tagline',
				),
				array(
					'key'     => 'mobile_search',
					'label'   => __( 'Search', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_search_section',
				),
				array(
					'key'     => 'mobile_button_1',
					'label'   => __( 'Button 1', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_button_1_section',
				),
				array(
					'key'     => 'mobile_button_2',
					'label'   => __( 'Button 2', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_button_2_section',
				),
				array(
					'key'     => 'mobile_menu_trigger',
					'label'   => __( 'Menu Trigger', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_menu_trigger_section',
				),
				array(
					'key'     => 'mobile_menu_1',
					'label'   => __( 'Menu 1', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_menu_1_section',
				),
				array(
					'key'     => 'mobile_menu_2',
					'label'   => __( 'Menu 2', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_menu_2_section',
				),
				array(
					'key'     => 'mobile_html_1',
					'label'   => __( 'HTML 1', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_html_1_section',
				),
				array(
					'key'     => 'mobile_html_2',
					'label'   => __( 'HTML 2', 'page-builder-framework' ),
					'section' => 'wpbf_header_builder_mobile_html_2_section',
				),
			),
		);

	}

	/**
	 * Get header builder's available slots.
	 *
	 * @return array
	 */
	public static function availableSlots() {

		return array(
			'desktop' => array(
				'rows' => array(
					array(
						'key'     => 'desktop_row_1',
						'label'   => __( 'Top Row', 'page-builder-framework' ),
						'columns' => array(
							array(
								'key'   => 'column_1_start',
								'label' => __( 'Column 1 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_1_end',
								'label' => __( 'Column 1 End', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_2',
								'label' => __( 'Column 2', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_start',
								'label' => __( 'Column 3 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_end',
								'label' => __( 'Column 3 End', 'page-builder-framework' ),
							),
						),
					),
					array(
						'key'     => 'desktop_row_2',
						'label'   => __( 'Main Row', 'page-builder-framework' ),
						'columns' => array(
							array(
								'key'   => 'column_1_start',
								'label' => __( 'Column 1 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_1_end',
								'label' => __( 'Column 1 End', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_2',
								'label' => __( 'Column 2', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_start',
								'label' => __( 'Column 3 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_end',
								'label' => __( 'Column 3 End', 'page-builder-framework' ),
							),
						),
					),
					array(
						'key'     => 'desktop_row_3',
						'label'   => __( 'Bottom Row', 'page-builder-framework' ),
						'columns' => array(
							array(
								'key'   => 'column_1_start',
								'label' => __( 'Column 1 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_1_end',
								'label' => __( 'Column 1 End', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_2',
								'label' => __( 'Column 2', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_start',
								'label' => __( 'Column 3 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_end',
								'label' => __( 'Column 3 End', 'page-builder-framework' ),
							),
						),
					),
				),
			),
			'mobile' => array(
				'sidebar' => array(
					'key'   => 'mobile_sidebar',
					'label' => __( 'Mobile Menu', 'page-builder-framework' ),
				),
				'rows' => array(
					array(
						'key'     => 'mobile_row_1',
						'label'   => __( 'Top Row', 'page-builder-framework' ),
						'columns' => array(
							array(
								'key'   => 'column_1_start',
								'label' => __( 'Column 1 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_1_end',
								'label' => __( 'Column 1 End', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_2',
								'label' => __( 'Column 2', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_start',
								'label' => __( 'Column 3 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_end',
								'label' => __( 'Column 3 End', 'page-builder-framework' ),
							),
						),
					),
					array(
						'key'     => 'mobile_row_2',
						'label'   => __( 'Main Row', 'page-builder-framework' ),
						'columns' => array(
							array(
								'key'   => 'column_1_start',
								'label' => __( 'Column 1 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_1_end',
								'label' => __( 'Column 1 End', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_2',
								'label' => __( 'Column 2', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_start',
								'label' => __( 'Column 3 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_end',
								'label' => __( 'Column 3 End', 'page-builder-framework' ),
							),
						),
					),
					array(
						'key'     => 'mobile_row_3',
						'label'   => __( 'Bottom Row', 'page-builder-framework' ),
						'columns' => array(
							array(
								'key'   => 'column_1_start',
								'label' => __( 'Column 1 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_1_end',
								'label' => __( 'Column 1 End', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_2',
								'label' => __( 'Column 2', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_start',
								'label' => __( 'Column 3 Start', 'page-builder-framework' ),
							),
							array(
								'key'   => 'column_3_end',
								'label' => __( 'Column 3 End', 'page-builder-framework' ),
							),
						),
					),
				),
			),
		);

	}

	/**
	 * SVG icon for menu trigger button.
	 *
	 * @param string $icon_variant The icon variant. Accepts 'variant-1', 'variant-2', 'variant-3', 'none', or empty string.
	 * @param string $button_style The icon style. Accepts 'simple', 'outline', or 'solid'.
	 *
	 * @return string The SVG icon.
	 */
	public static function menuTriggerButtonSvg( $icon_variant = 'variant-1', $button_style = 'simple' ) {

		$button_style = empty( $button_style ) ? 'simple' : $button_style;

		$menu_icon_variants = array(
			'variant-1' => array(
				'simple' => '<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg" data-variant="variant-1">
						<path d="M4 4h25v2H4zM4 12h25v2H4zM4 20h25v2H4z"/>
					</svg>',
				'outline' => '<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg" data-variant="variant-1">
						<rect x="4" y="4" width="25" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
						<rect x="4" y="12" width="25" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
						<rect x="4" y="20" width="25" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
					</svg>',
				'solid' => '<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg" 	data-variant="variant-1">
						<rect x="4" y="4" width="25" height="3" rx="1"/>
						<rect x="4" y="12" width="25" height="3" rx="1"/>
						<rect x="4" y="20" width="25" height="3" rx="1"/>
					</svg>',
			),
			'variant-2' => array(
				'simple' => '
					<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg" data-variant="variant-2">
						<path d="M4 4h17v2H4zM4 12h27v2H4zM4 20h21v2H4z"/>
					</svg>',
				'outline' => '
					<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg" data-variant="variant-2">
						<rect x="4" y="4" width="17" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
						<rect x="4" y="12" width="27" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
						<rect x="4" y="20" width="21" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
					</svg>',
				'solid' => '
					<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg" data-variant="variant-2">
						<rect x="4" y="4" width="17" height="3" rx="1"/>
						<rect x="4" y="12" width="27" height="3" rx="1"/>
						<rect x="4" y="20" width="21" height="3" rx="1"/>
					</svg>',
			),
			'variant-3' => array(
				'simple' => '
					<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg" data-variant="variant-3">
						<path d="M12 4h17v2H12zM4 12h25v2H4zM4 20h17v2H4z"/>
					</svg>',
				'outline' => '
					<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg" data-variant="variant-3">
						<rect x="12" y="4" width="17" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
						<rect x="4" y="12" width="25" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
						<rect x="4" y="20" width="17" height="3" rx="1" stroke="currentColor" stroke-width="1"/>
					</svg>',
				'solid' => '
					<svg class="menu-trigger-button-svg" width="1em" height="1em" viewBox="0 0 32 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg" data-variant="variant-3">
						<rect x="12" y="4" width="17" height="3" rx="1"/>
						<rect x="4" y="12" width="25" height="3" rx="1"/>
						<rect x="4" y="20" width="17" height="3" rx="1"/>
					</svg>',
			),
		);

		if ( ! isset( $menu_icon_variants[ $icon_variant ] ) || ! isset( $menu_icon_variants[ $icon_variant ][ $button_style ] ) ) {
			return '';
		}

		return $menu_icon_variants[ $icon_variant ][ $button_style ];

	}

}
