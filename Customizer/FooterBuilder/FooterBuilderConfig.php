<?php

namespace Mapsteps\Wpbf\Customizer\FooterBuilder;

final class FooterBuilderConfig {

	/**
	 * Get footer builder's available widgets.
	 *
	 * @return array
	 */
	public static function availableWidgets() {

		return array(
			'desktop' => array(
				array(
					'key'     => 'desktop_logo',
					'label'   => __( 'Logo', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_logo_section',
				),
				array(
					'key'     => 'desktop_menu_1',
					'label'   => __( 'Menu 1', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_menu_1_section',
				),
				array(
					'key'     => 'desktop_menu_2',
					'label'   => __( 'Menu 2', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_menu_2_section',
				),
				array(
					'key'     => 'desktop_html_1',
					'label'   => __( 'HTML 1', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_html_1_section',
				),
				array(
					'key'     => 'desktop_html_2',
					'label'   => __( 'HTML 2', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_html_2_section',
				),
				array(
					'key'     => 'desktop_social',
					'label'   => __( 'Social Icons', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_social_section',
				),
				array(
					'key'     => 'desktop_copyright',
					'label'   => __( 'Copyright', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_copyright_section',
				),
				array(
					'key'     => 'desktop_button_1',
					'label'   => __( 'Button 1', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_button_1_section',
				),
				array(
					'key'     => 'desktop_button_2',
					'label'   => __( 'Button 2', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_desktop_button_2_section',
				),
			),
			'mobile' => array(
				array(
					'key'     => 'mobile_logo',
					'label'   => __( 'Logo', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_logo_section',
				),
				array(
					'key'     => 'mobile_menu_1',
					'label'   => __( 'Menu 1', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_menu_1_section',
				),
				array(
					'key'     => 'mobile_menu_2',
					'label'   => __( 'Menu 2', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_menu_2_section',
				),
				array(
					'key'     => 'mobile_html_1',
					'label'   => __( 'HTML 1', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_html_1_section',
				),
				array(
					'key'     => 'mobile_html_2',
					'label'   => __( 'HTML 2', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_html_2_section',
				),
				array(
					'key'     => 'mobile_social',
					'label'   => __( 'Social Icons', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_social_section',
				),
				array(
					'key'     => 'mobile_copyright',
					'label'   => __( 'Copyright', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_copyright_section',
				),
				array(
					'key'     => 'mobile_button_1',
					'label'   => __( 'Button 1', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_button_1_section',
				),
				array(
					'key'     => 'mobile_button_2',
					'label'   => __( 'Button 2', 'page-builder-framework' ),
					'section' => 'wpbf_footer_builder_mobile_button_2_section',
				),
			),
		);

	}

	/**
	 * Get footer builder's available slots.
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
