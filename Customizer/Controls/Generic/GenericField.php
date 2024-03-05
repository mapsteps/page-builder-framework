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
			$props = $this->control->custom_properties;
			$min   = isset( $props['min'] ) && is_numeric( $props['min'] ) ? (float) $props['min'] : null;
			$max   = isset( $props['max'] ) && is_numeric( $props['max'] ) ? (float) $props['max'] : null;

			return ( new NumberUtil() )->sanitize_number( $value, $min, $max );
		} elseif ( $this->control->type === 'email' ) {
			return sanitize_email( $value );
		}

		return wp_kses_post( $value );

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

		$generic_control->subtype = $this->control->type;

		if ( 'number' === $this->control->type ) {
			$props = $this->control->custom_properties;

			if ( isset( $props['min'] ) && is_numeric( $props['min'] ) ) {
				$generic_control->min = (float) $props['min'];
			}

			if ( isset( $props['max'] ) && is_numeric( $props['max'] ) ) {
				$generic_control->max = (float) $props['max'];
			}
		}

		$wp_customize_manager->add_control( $generic_control );

	}

}