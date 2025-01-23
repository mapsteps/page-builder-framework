<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class AssocArrayField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param array $value The value to sanitize.
	 *
	 * @return array
	 */
	public function sanitizeCallback( $value ) {

		return static::sanitize( $value );

	}

	/**
	 * Sanitize array recursively.
	 *
	 * @param array  $arr The array to sanitize.
	 * @param string $special_key Special key needle which value should be sanitized using `wp_kses_post`.
	 */
	public static function sanitize( $arr, $special_key = '' ) {

		$arr = empty( $arr ) || ! is_array( $arr ) ? [] : $arr;

		if ( empty( $arr ) ) {
			return $arr;
		}

		foreach ( $arr as $key => $item ) {
			if ( empty( $item ) ) {
				continue;
			}

			if ( is_array( $item ) ) {
				$arr[ $key ] = static::sanitize( $item );
				continue;
			}

			$item = ! empty( $special_key ) && false !== stripos( $key, $special_key ) ? wp_kses_post( $item ) : sanitize_text_field( $item );
			$item = is_numeric( $item ) ? absint( $item ) : $item;

			$arr[ $key ] = $item;
		}

		return $arr;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control( new AssocArrayControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
