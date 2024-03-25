<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Radio;

use WP_Customize_Manager;

class RadioImageField extends RadioField {

	/**
	 * Path of the control class for this field.
	 *
	 * @var string
	 */
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Radio\RadioImageControl';

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new RadioImageControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
