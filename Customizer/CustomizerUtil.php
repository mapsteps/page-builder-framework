<?php
/**
 * Wpbf customizer's utility helper class.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Controls\Select\SelectField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\SliderField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use WP_Customize_Manager;

/**
 * Wpbf customizer's utility helper class.
 */
class CustomizerUtil {

	/**
	 * The available controls.
	 *
	 * @var string[] $available_controls
	 */
	public $available_controls = array(
		'slider',
		'select',
	);

	/**
	 * Determine the sanitize callback.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 *
	 * @return callable|string
	 */
	public function determineSanitizeCallback( $control ) {

		$control_type = $control->type;

		if ( ! in_array( $control_type, $this->available_controls, true ) ) {
			return '';
		}

		if ( 'slider' === $control_type ) {
			$slider_field = new SliderField( $control );

			if ( method_exists( $slider_field, 'sanitizeCallback' ) ) {
				return array( $slider_field, 'sanitizeCallback' );
			}

			return '';
		}

		if ( 'select' === $control_type ) {
			$select_field = new SelectField( $control );

			if ( method_exists( $select_field, 'sanitizeCallback' ) ) {
				return array( $select_field, 'sanitizeCallback' );
			}

			return '';
		}

		return '';

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager    $wp_customize_manager The customizer manager object.
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function addControl( $wp_customize_manager, $control ) {

		$control_type = $control->type;

		if ( ! in_array( $control_type, $this->available_controls, true ) ) {
			return;
		}

		if ( 'slider' === $control_type ) {
			$slider_field = new SliderField( $control );

			if ( method_exists( $slider_field, 'addControl' ) ) {
				$slider_field->addControl( $wp_customize_manager );
			}

			return;
		}

		if ( 'select' === $control_type ) {
			$select_field = new SelectField( $control );

			if ( method_exists( $select_field, 'addControl' ) ) {
				$select_field->addControl( $wp_customize_manager );
			}

			return;
		}

	}

}
