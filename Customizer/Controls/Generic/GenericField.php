<?php
/**
 * Generic field.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Responsive\ResponsiveUtil;
use WP_Customize_Manager;

/**
 * The field of the generic types: text, number, number-unit, textarea, email, password, url, hidden, content, and
 * each of them with "responsive-" in front (one value per device).
 */
class GenericField extends BaseField {

	/**
	 * Whether the field is one of the responsive types.
	 *
	 * @return bool
	 */
	protected function isResponsive() {

		return 0 === strpos( $this->control->type, 'responsive-' );

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return string|int|float|array
	 */
	public function sanitizeCallback( $value ) {

		$props = $this->control->custom_properties;

		// For the responsive types, this is the full type ("responsive-number"), which isn't an allowed subtype:
		// their values are cleaned as text. Kept as it was; see the plan's notes for later steps.
		$subtype = $this->control->type;
		$subtype = ! in_array( $subtype, GenericControl::$allowed_subtypes, true ) ? 'text' : $subtype;

		$min = isset( $props['min'] ) && is_numeric( $props['min'] ) ? (float) $props['min'] : null;
		$max = isset( $props['max'] ) && is_numeric( $props['max'] ) ? (float) $props['max'] : null;

		if ( ! $this->isResponsive() ) {
			return ( new GenericSanitizer() )->sanitize( $subtype, $value, $min, $max );
		}

		$responsive_util = new ResponsiveUtil();

		$devices      = ! empty( $props['devices'] ) && is_array( $props['devices'] ) ? $props['devices'] : $responsive_util->default_devices;
		$save_as_json = ! empty( $props['save_as_json'] ) && is_bool( $props['save_as_json'] );
		$array_value  = $responsive_util->toArrayValue( $devices, $subtype, $value, $min, $max );

		return $save_as_json ? wp_json_encode( $array_value ) : $array_value;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		if ( $this->isResponsive() ) {
			$control_args['type']    = 'wpbf-responsive-generic';
			$control_args['subtype'] = str_ireplace( 'responsive-', '', $this->control->type );

			$props = $this->control->custom_properties;

			if ( ! empty( $props['save_as_json'] ) && is_bool( $props['save_as_json'] ) ) {
				$control_args['save_as_json'] = true;
			}

			if ( ! empty( $props['devices'] ) && is_array( $props['devices'] ) ) {
				$control_args['devices'] = $props['devices'];
			}
		} else {
			$control_args['type']    = 'wpbf-generic';
			$control_args['subtype'] = $this->control->type;
		}

		$wp_customize_manager->add_control( new GenericControl( $wp_customize_manager, $this->control->id, $control_args ) );

	}

}
