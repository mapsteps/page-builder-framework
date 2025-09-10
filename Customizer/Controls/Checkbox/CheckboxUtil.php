<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use WP_Customize_Manager;

class CheckboxUtil {

	/**
	 * Positive values which will be treated as `true`.
	 *
	 * @var array $positive_values
	 */
	private $positive_values = [ true, 'true', 1, '1', 'on' ];

	/**
	 * Setting's sanitize callback.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return bool
	 */
	public function sanitize( $value ) {

		if ( ! $value ) {
			return false;
		}

		if ( is_string( $value ) ) {
			$value = strtolower( $value );
		}

		return in_array( $value, $this->positive_values, true );

	}

}
