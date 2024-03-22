<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Media\ImageUtil;
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

		$media_util = new ImageUtil();
		$props      = $this->control->custom_properties;
		$save_as    = $media_util->default_save_as;

		// The properties of $image_src here is already sanitized.
		$image_src = $media_util->unknownToImageSrcArray( $value );

		if ( ! empty( $props['save_as'] ) && is_string( $props['save_as'] ) ) {
			if ( in_array( $props['save_as'], $media_util->allowed_save_as, true ) ) {
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
