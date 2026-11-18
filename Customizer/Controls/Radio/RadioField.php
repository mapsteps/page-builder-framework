<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Radio;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\CustomizerStore;
use WP_Customize_Manager;

/**
 * The field of the radio types: radio, radio-buttonset and radio-image (the form renders with React, see RadioForm.tsx).
 */
class RadioField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string
	 */
	public function sanitizeCallback( $value ) {

		if ( ! is_scalar( $value ) || ! isset( $this->control->choices[ $value ] ) ) {
			$setting_entity = CustomizerStore::findSettingByControlId( $this->control->id );

			return $setting_entity ? $setting_entity->default : '';
		}

		return $value;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args         = $this->parseControlArgs();
		$control_args['type'] = 'wpbf-' . $this->control->type;

		$wp_customize_manager->add_control(
			new RadioControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
