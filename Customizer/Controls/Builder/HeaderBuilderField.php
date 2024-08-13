<?php
/**
 * Builder field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Builder;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

/**
 * Default settings for the header builder field.
 */
class HeaderBuilderField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|array $value The setting value.
	 *
	 * @return string|int[]
	 */
	public function sanitizeCallback( $value ) {

		return $value;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control( new HeaderBuilderControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
