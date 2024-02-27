<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class GenericField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string|int|float
	 */
	public function sanitizeCallback( $value ) {

		if ( $this->control->type === 'text' ) {
			return sanitize_text_field( $value );
		} elseif ( $this->control->type === 'textarea' ) {
			return sanitize_textarea_field( $value );
		} elseif ( $this->control->type === 'url' ) {
			return esc_url_raw( $value );
		} elseif ( $this->control->type === 'number' ) {
			return $this->sanitize_number( $value );
		} elseif ( $this->control->type === 'email' ) {
			return sanitize_email( $value );
		}

		return wp_kses_post( $value );

	}

	/**
	 * Sanitize number.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return int|float
	 */
	private function sanitize_number( $value ) {
		$value = filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$props = $this->control->custom_properties;

		if ( isset( $props['min'] ) && isset( $props['max'] ) ) {
			// Make sure min & max are all numeric.
			$min = filter_var( $props['min'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			$max = filter_var( $props['max'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

			if ( $value < $min ) {
				$value = $min;
			} elseif ( $value > $max ) {
				$value = $max;
			}
		} else {
			if ( isset( $props['min'] ) ) {
				$min = filter_var( $props['min'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

				if ( $value < $min ) {
					$value = $min;
				}
			} elseif ( isset( $props['max'] ) ) {
				$max = filter_var( $props['max'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

				if ( $value > $max ) {
					$value = $max;
				}
			}
		}

		return $value;
	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$generic_control = new GenericControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		);

		$generic_control->input_type = $this->control->type;

		$wp_customize_manager->add_control( $generic_control );

	}

}