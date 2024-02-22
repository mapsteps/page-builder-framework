<?php
/**
 * Wpbf customizer's utility helper class.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Color\ColorField;
use Mapsteps\Wpbf\Customizer\Controls\Divider\DividerField;
use Mapsteps\Wpbf\Customizer\Controls\RadioImage\RadioImageField;
use Mapsteps\Wpbf\Customizer\Controls\Select\SelectField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\SliderField;
use Mapsteps\Wpbf\Customizer\Controls\Toggle\ToggleField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use WP_Customize_Manager;

/**
 * Wpbf customizer's utility helper class.
 */
class CustomizerUtil {

	/**
	 * The available control types.
	 *
	 * @var string[] $available_controls
	 */
	public $available_controls = array(
		'base'        => '\Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl',
		'color'       => '\Mapsteps\Wpbf\Customizer\Controls\Color\ColorControl',
		'divider'     => '\Mapsteps\Wpbf\Customizer\Controls\Divider\DividerControl',
		'radio-image' => '\Mapsteps\Wpbf\Customizer\Controls\RadioImage\RadioImageControl',
		'select'      => '\Mapsteps\Wpbf\Customizer\Controls\Select\SelectControl',
		'slider'      => '\Mapsteps\Wpbf\Customizer\Controls\Slider\SliderControl',
		'toggle'      => '\Mapsteps\Wpbf\Customizer\Controls\Toggle\ToggleControl',
	);

	/**
	 * Controls which utilize the content_template to render the control.
	 *
	 * @var string[] $basic_controls
	 */
	public $controls_with_content_template = array(
		'radio-image',
		'toggle',
	);

	/**
	 * Basic/primitive controls.
	 *
	 * @var string[] $basic_controls
	 */
	public $basic_controls = array(
		'text'
	);

	/**
	 * Filter the setting entity.
	 *
	 * @param CustomizerSettingEntity $setting The setting entity object.
	 *
	 * @return CustomizerSettingEntity
	 */
	public function filterSettingEntity( $setting ) {
		$control = null;

		foreach ( Customizer::$added_controls as $added_control ) {
			if ( $added_control->id === $setting->id ) {
				$control = $added_control;
				break;
			}
		}

		if ( is_null( $control ) ) {
			return $setting;
		}

		$field = $this->getFieldInstance( $control );

		if ( is_null( $field ) ) {
			return $setting;
		}

		if ( method_exists( $field, 'filterSettingEntity' ) ) {
			$setting = $field->filterSettingEntity( $setting );
		}

		return $setting;
	}

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

		$control_type = $control->type;
		$control_type = in_array( $control_type, $this->basic_controls, true ) ? 'base' : $control_type;

		if ( ! array_key_exists( $control_type, $this->available_controls ) ) {
			return null;
		}

		$field = null;

		switch ( $control_type ) {
			case 'base':
				$field = new BaseField( $control );
				break;
			case 'color':
				$field = new ColorField( $control );
				break;
			case 'divider':
				$field = new DividerField( $control );
				break;
			case 'radio-image':
				$field = new RadioImageField( $control );
				break;
			case 'select':
				$field = new SelectField( $control );
				break;
			case 'slider':
				$field = new SliderField( $control );
				break;
			case 'toggle':
				$field = new ToggleField( $control );
				break;
			default:
				break;
		}

		return $field;

	}

}
