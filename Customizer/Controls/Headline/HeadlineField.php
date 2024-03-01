<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Headline;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class HeadlineField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string
	 */
	public function sanitizeCallback( $value ) {

		return '__return_null';

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new HeadlineControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}