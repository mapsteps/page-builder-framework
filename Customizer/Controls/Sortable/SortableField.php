<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Sortable;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class SortableField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param array $value The value to sanitize.
	 *
	 * @return array
	 */
	public function sanitizeCallback( $value = [] ) {

		if ( ! is_array( $value ) ) {
			return [];
		}

		if ( empty( $value ) ) {
			return [];
		}

		$sanitized_value = [];

		foreach ( $value as $val ) {
			$sanitized_value[] = sanitize_text_field( $val );
		}

		return $sanitized_value;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new SortableControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
