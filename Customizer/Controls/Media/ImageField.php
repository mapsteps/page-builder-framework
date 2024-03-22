<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use WP_Customize_Manager;

class ImageField extends UploadField {

	/**
	 * Get utility instance.
	 *
	 * @return ImageUtil
	 */
	protected function getUtilInstance() {

		return new ImageUtil();

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
