<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Builder;

final class BuilderStore {

	/**
	 * Added builder control ids.
	 *
	 * @var string[]
	 */
	public static $added_control_ids = array();

	public static function headerBuilderAvailableWidgets() {

		return array(
			array(
				'key'   => 'logo',
				'label' => __( 'Logo', 'page-builder-framework' ),
			),
			array(
				'key'   => 'search',
				'label' => __( 'Search', 'page-builder-framework' ),
			),
			array(
				'key'   => 'account',
				'label' => __( 'Account', 'page-builder-framework' ),
			),
			array(
				'key'   => 'block_1',
				'label' => __( 'Block 1', 'page-builder-framework' ),
			),
			array(
				'key'   => 'block_2',
				'label' => __( 'Block 2', 'page-builder-framework' ),
			),
			array(
				'key'   => 'block_3',
				'label' => __( 'Block 3', 'page-builder-framework' ),
			),
			array(
				'key'   => 'button_1',
				'label' => __( 'Button 1', 'page-builder-framework' ),
			),
			array(
				'key'   => 'button_2',
				'label' => __( 'Button 2', 'page-builder-framework' ),
			),
			array(
				'key'   => 'menu_1',
				'label' => __( 'Menu 1', 'page-builder-framework' ),
			),
			array(
				'key'   => 'menu_2',
				'label' => __( 'Menu 2', 'page-builder-framework' ),
			),
		);

	}

	public static function headerBuilderAvailableRows() {

		return array(
			array(
				'key'     => 'row_1',
				'label'   => __( 'Pre-Header', 'page-builder-framework' ),
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
			array(
				'key'     => 'row_2',
				'label'   => __( 'Main Row', 'page-builder-framework' ),
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
			array(
				'key'     => 'row_3',
				'label'   => __( 'Secondary Row', 'page-builder-framework' ),
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
