<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Custom;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class CustomField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return null
	 */
	public function sanitizeCallback( $value ) {

		return null;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control( new CustomControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}