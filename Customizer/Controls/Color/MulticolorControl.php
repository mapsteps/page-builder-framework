<?php
/**
 * Multicolor control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Color;

/**
 * Class to add Wpbf customizer color control.
 */
class MulticolorControl extends ColorControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-multicolor';

	/**
	 * Set the value to JSON.
	 */
	protected function set_value_json() {

		$raw_values = empty( $this->value() ) || ! is_array( $this->value() ) ? [] : $this->value();

		$values = [];

		foreach ( $raw_values as $key => $raw_value ) {
			$val = 'hue' === $this->mode ? absint( $raw_value ) : $raw_value;
			$val = is_string( $val ) ? strtolower( $val ) : $val;

			$values[ $key ] = $val;
		}

		$this->json['value'] = $values;

	}

}
