<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Radio;

use WP_Customize_Manager;

class RadioButtonsetField extends RadioField {

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new RadioButtonsetControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
