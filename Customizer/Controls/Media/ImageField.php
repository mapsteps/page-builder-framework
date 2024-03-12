<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\ImageUtil;
use WP_Customize_Manager;

class ImageField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string
	 */
	public function sanitizeCallback( $value ) {

		$props      = $this->control->custom_properties;
		$save_as    = ImageControl::$default_save_as;
		$image_util = new ImageUtil();

		$image_src = $image_util->makeEmptySrcArray();

		if ( is_string( $value ) ) {
			$image_src = $image_util->urlToArray( $value );
		} elseif ( is_numeric( $value ) ) {
			$image_src = $image_util->idToArray( $value );
		} elseif ( is_array( $value ) ) {
			$image_src = $image_util->properlyFormatArray( $value );
		}

		if ( ! empty( $props['save_as'] ) && is_string( $props['save_as'] ) ) {
			if ( in_array( $props['save_as'], ImageControl::$allowed_save_as, true ) ) {
				$save_as = $props['save_as'];
			}
		}

		if ( 'array' === $save_as ) {
			return $image_src;
		}

		if ( 'id' === $save_as ) {
			return $image_src['id'];
		}

		return $image_src['url'];

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new ImageControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
