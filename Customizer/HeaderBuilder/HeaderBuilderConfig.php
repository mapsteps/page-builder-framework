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

}
