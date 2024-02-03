<?php
/**
 * Slider field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use WP_Customize_Manager;

/**
 * Default settings for the slider field.
 */
class SliderField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return float
	 */
	public function sanitizeCallback( $value ) {

		return filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager    $wp_customize_manager The customizer manager object.
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function addControl( $wp_customize_manager, $control ) {

		$control_args = $this->parseControlArgs( $control );

		$wp_customize_manager->add_control(
			new SliderControl(
				$wp_customize_manager,
				$control->id,
				$control_args
			)
		);

	}

}
