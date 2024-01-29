<?php
/**
 * Wpbf customizer's utility helper class.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

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
	);

	/**
	 * Determine the sanitize callback.
	 *
	 * @param string $type The control type.
	 *
	 * @return callable|string
	 */
	public function determineSanitizeCallback( $type ) {

		if ( ! in_array( $type, $this->available_controls, true ) ) {
			return '';
		}

		if ( 'slider' === $type ) {
			if ( class_exists( 'Wpbf\Customizer\Controls\Slider\SliderSetting' ) ) {
				if ( method_exists( 'Wpbf\Customizer\Controls\Slider\SliderSetting', 'sanitizeCallback' ) ) {
					return array( 'Wpbf\Customizer\Controls\Slider\SliderSetting', 'sanitizeCallback' );
				}
			}

			return '';
		}

		return '';

	}

}
