<?php

namespace Mapsteps\Wpbf\Customizer\Controls\RadioImage;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Customizer;
use WP_Customize_Manager;

class RadioImageField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string
	 */
	public function sanitizeCallback( $value ) {

		if ( ! isset( $this->control->choices[ $value ] ) ) {
			$setting_entity = null;

			foreach ( Customizer::$added_settings as $added_setting ) {
				if ( $added_setting->id === $this->control->id ) {
					$setting_entity = $added_setting;
					break;
				}
			}

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

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new RadioImageControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}