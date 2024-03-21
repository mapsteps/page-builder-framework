<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Dimension;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class DimensionField extends BaseField {

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new DimensionControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
