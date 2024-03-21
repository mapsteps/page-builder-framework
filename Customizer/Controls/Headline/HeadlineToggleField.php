<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Headline;

use Mapsteps\Wpbf\Customizer\Controls\Checkbox\ToggleField;
use WP_Customize_Manager;

class HeadlineToggleField extends ToggleField {

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new HeadlineToggleControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
