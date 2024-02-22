<?php
/**
 * Wpbf customizer's utility helper class.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Controls\Color\ColorField;
use Mapsteps\Wpbf\Customizer\Controls\Divider\DividerField;
use Mapsteps\Wpbf\Customizer\Controls\Select\SelectField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\SliderField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use WP_Customize_Manager;

/**
 * Wpbf customizer's utility helper class.
 */
class CustomizerUtil {

	/**
	 * The available control types.
	 *
	 * @var string[] $available_control_types
	 */
	public $available_control_types = array(
		'color',
		'divider',
		'select',
		'slider',
	);

	/**
	 * Determine the sanitize callback.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 *
	 * @return callable|string
	 */
	public function determineSanitizeCallback( $control ) {

		$field = $this->getFieldInstance( $control );

		return ( null !== $field && method_exists( $field, 'sanitizeCallback' ) ? array(
			$field,
			'sanitizeCallback'
		) : '' );

	}

	/**
	 * Enqueue customize preview scripts.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function enqueueCustomizePreviewScripts( $control ) {

		$field = $this->getFieldInstance( $control );

		if ( null !== $field ) {
			$field->enqueueCustomizePreviewScripts();
		}

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager    $wp_customize_manager The customizer manager object.
	 * @param CustomizerControlEntity $control              The control entity object.
	 */
	public function addControl( $wp_customize_manager, $control ) {

		$field = $this->getFieldInstance( $control );

		if ( null !== $field ) {
			$field->addControl( $wp_customize_manager );
		}

	}

	/**
	 * Get the field instance.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 *
	 * @return ColorField|SelectField|SliderField|null
	 */
	private function getFieldInstance( $control ) {

		if ( ! in_array( $control->type, $this->available_control_types, true ) ) {
			return null;
		}

		$field = null;

		switch ( $control->type ) {
			case 'color':
				$field = new ColorField( $control );
				break;
			case 'divider':
				$field = new DividerField( $control );
				break;
			case 'select':
				$field = new SelectField( $control );
				break;
			case 'slider':
				$field = new SliderField( $control );
				break;
			default:
				break;
		}

		return $field;

	}

}
