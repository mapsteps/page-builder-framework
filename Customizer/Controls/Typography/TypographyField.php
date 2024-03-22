<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyStore;
use WP_Customize_Manager;

class TypographyField extends BaseField {

	/**
	 * Add fields based on the control arguments.
	 *
	 * @param array $args The arguments for the control.
	 */
	private function addFields( $args ) {

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		if ( ! TypographyStore::initialized() ) {
			TypographyStore::init();
		}

		$control_args = $this->parseControlArgs();

		$this->addFields( $control_args );

	}

}
