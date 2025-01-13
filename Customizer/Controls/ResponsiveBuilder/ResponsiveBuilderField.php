<?php
/**
 * Responsive builder field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\ResponsiveBuilder;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\AssocArrayField;
use WP_Customize_Manager;

/**
 * Default settings for the builder field.
 */
class ResponsiveBuilderField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|array $value The setting value.
	 *
	 * @return string|int[]
	 */
	public function sanitizeCallback( $value ) {

		return AssocArrayField::sanitize( $value, 'block_' );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control( new ResponsiveBuilderControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

		ResponsiveBuilderStore::$added_control_ids[] = $this->control->id;

	}

}
