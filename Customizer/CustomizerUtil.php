<?php
/**
 * Wpbf customizer's utility helper class.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Controls\Checkbox\CheckboxField;
use Mapsteps\Wpbf\Customizer\Controls\Checkbox\ToggleField;
use Mapsteps\Wpbf\Customizer\Controls\Color\ColorField;
use Mapsteps\Wpbf\Customizer\Controls\Dimension\DimensionField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\GenericField;
use Mapsteps\Wpbf\Customizer\Controls\Headline\DividerField;
use Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineField;
use Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineToggleField;
use Mapsteps\Wpbf\Customizer\Controls\MarginPadding\MarginPaddingField;
use Mapsteps\Wpbf\Customizer\Controls\MarginPadding\ResponsiveMarginPaddingField;
use Mapsteps\Wpbf\Customizer\Controls\Radio\RadioField;
use Mapsteps\Wpbf\Customizer\Controls\Radio\RadioImageField;
use Mapsteps\Wpbf\Customizer\Controls\Select\SelectField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\InputSliderField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\SliderField;
use Mapsteps\Wpbf\Customizer\Controls\Sortable\SortableField;
use Mapsteps\Wpbf\Customizer\Controls\Tabs\SectionTabsField;
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
		'checkbox'                  => '\Mapsteps\Wpbf\Customizer\Controls\Checkbox\CheckboxControl',
		'toggle'                    => '\Mapsteps\Wpbf\Customizer\Controls\Checkbox\ToggleControl',
		'color'                     => '\Mapsteps\Wpbf\Customizer\Controls\Color\ColorControl',
		'dimension'                 => '\Mapsteps\Wpbf\Customizer\Controls\Dimension\DimensionControl',
		'divider'                   => '\Mapsteps\Wpbf\Customizer\Controls\Headline\DividerControl',
		'headline'                  => '\Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineControl',
		'headline-toggle'           => '\Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineToggleControl',
		'generic'                   => '\Mapsteps\Wpbf\Customizer\Controls\Generic\GenericControl',
		'margin-padding'            => '\Mapsteps\Wpbf\Customizer\Controls\MarginPadding\MarginPaddingControl',
		'responsive-margin-padding' => '\Mapsteps\Wpbf\Customizer\Controls\MarginPadding\ResponsiveMarginPaddingControl',
		'radio'                     => '\Mapsteps\Wpbf\Customizer\Controls\Radio\RadioControl',
		'radio-image'               => '\Mapsteps\Wpbf\Customizer\Controls\Radio\RadioImageControl',
		'select'                    => '\Mapsteps\Wpbf\Customizer\Controls\Select\SelectControl',
		'slider'                    => '\Mapsteps\Wpbf\Customizer\Controls\Slider\SliderControl',
		'input-slider'              => '\Mapsteps\Wpbf\Customizer\Controls\InputSlider\InputSliderControl',
		'section-tabs'              => '\Mapsteps\Wpbf\Customizer\Controls\Tabs\SectionTabsControl',
		'sortable'                  => '\Mapsteps\Wpbf\Customizer\Controls\Sortable\SortableControl',
	);

	/**
	 * Controls which utilize the content_template to render the control.
	 *
	 * @var string[] $basic_controls
	 */
	public $controls_with_content_template = array(
		'checkbox',
		'toggle',
		'headline-toggle',
		'dimension',
		'generic',
		'radio',
		'radio-image',
		'section-tabs',
		'sortable',
	);

	/**
	 * Controls which are grouped into a single control.
	 *
	 * @var array $grouped_controls
	 */
	public $grouped_controls = [
		'generic'                   => [
			'email',
			'number',
			'text',
			'textarea',
			'url',
		],
		'margin-padding'            => [
			'margin',
			'padding',
		],
		'responsive-margin-padding' => [
			'responsive-margin',
			'responsive-padding',
		],
	];

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
			'sanitizeCallback',
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

		foreach ( $this->grouped_controls as $control_name => $grouped_controls ) {
			if ( in_array( $control->type, $grouped_controls, true ) ) {
				$control_type = $control_name;
				break;
			}
		}

		if ( ! array_key_exists( $control_type, $this->available_controls ) ) {
			return null;
		}

		$field = null;

		switch ( $control_type ) {
			case 'generic':
				$field = new GenericField( $control );
				break;
			case 'checkbox':
				$field = new CheckboxField( $control );
				break;
			case 'toggle':
				$field = new ToggleField( $control );
				break;
			case 'color':
				$field = new ColorField( $control );
				break;
			case 'divider':
				$field = new DividerField( $control );
				break;
			case 'dimension':
				$field = new DimensionField( $control );
				break;
			case 'headline':
				$field = new HeadlineField( $control );
				break;
			case 'headline-toggle':
				$field = new HeadlineToggleField( $control );
				break;
			case 'margin-padding':
				$field = new MarginPaddingField( $control );
				break;
			case 'responsive-margin-padding':
				$field = new ResponsiveMarginPaddingField( $control );
				break;
			case 'radio':
				$field = new RadioField( $control );
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
			case 'input-slider':
				$field = new InputSliderField( $control );
				break;
			case 'section-tabs':
				$field = new SectionTabsField( $control );
				break;
			case 'sortable':
				$field = new SortableField( $control );
				break;
		}

		return $field;

	}

}
