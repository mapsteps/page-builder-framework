<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Builder;

final class BuilderStore {

	/**
	 * Added builder control ids.
	 *
	 * @var string[]
	 */
	public static $added_control_ids = array();

	/**
	 * Get header builder available widgets.
	 *
	 * @return array
	 */
	public static function headerBuilderAvailableWidgets() {

		return array(
			array(
				'key'     => 'logo',
				'label'   => __( 'Logo', 'page-builder-framework' ),
				'section' => 'title_tagline',
			),
			array(
				'key'     => 'search',
				'label'   => __( 'Search', 'page-builder-framework' ),
				'section' => 'wpbf_header_builder_search_section',
			),
			array(
				'key'     => 'button_1',
				'label'   => __( 'Button 1', 'page-builder-framework' ),
				'section' => 'wpbf_header_builder_button_1_section',
			),
			array(
				'key'     => 'button_2',
				'label'   => __( 'Button 2', 'page-builder-framework' ),
				'section' => 'wpbf_header_builder_button_2_section',
			),
			array(
				'key'     => 'menu_1',
				'label'   => __( 'Menu 1', 'page-builder-framework' ),
				'section' => 'wpbf_header_builder_menu_1_section',
			),
			array(
				'key'     => 'menu_2',
				'label'   => __( 'Menu 2', 'page-builder-framework' ),
				'section' => 'wpbf_header_builder_menu_2_section',
			),
			array(
				'key'     => 'html_1',
				'label'   => __( 'HTML 1', 'page-builder-framework' ),
				'section' => 'wpbf_header_builder_html_1_section',
			),
			array(
				'key'     => 'html_2',
				'label'   => __( 'HTML 2', 'page-builder-framework' ),
				'section' => 'wpbf_header_builder_html_2_section',
			),
		);

	}

	/**
	 * Get header builder available rows.
	 *
	 * @return array
	 */
	public static function headerBuilderAvailableRows() {

		return array(
			array(
				'key'     => 'row_1',
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
				'key'     => 'row_2',
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
				'key'     => 'row_3',
				'label'   => __( 'Bottom Row', 'page-builder-framework' ),
				'columns' => array(
					array(
						'key'   => 'column_1',
						'label' => __( 'Column 1', 'page-builder-framework' ),
					),
					array(
						'key'   => 'column_2',
						'label' => __( 'Column 2', 'page-builder-framework' ),
					),
					array(
						'key'   => 'column_3',
						'label' => __( 'Column 3', 'page-builder-framework' ),
					),
				),
			),
		);

	}

}
