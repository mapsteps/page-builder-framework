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
use Mapsteps\Wpbf\Customizer\Controls\Custom\CustomField;
use Mapsteps\Wpbf\Customizer\Controls\Dimension\DimensionField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\GenericField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\ResponsiveGenericField;
use Mapsteps\Wpbf\Customizer\Controls\Headline\DividerField;
use Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineField;
use Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineToggleField;
use Mapsteps\Wpbf\Customizer\Controls\MarginPadding\MarginPaddingField;
use Mapsteps\Wpbf\Customizer\Controls\MarginPadding\ResponsiveMarginPaddingField;
use Mapsteps\Wpbf\Customizer\Controls\Media\ImageField;
use Mapsteps\Wpbf\Customizer\Controls\Media\UploadField;
use Mapsteps\Wpbf\Customizer\Controls\Radio\RadioButtonsetField;
use Mapsteps\Wpbf\Customizer\Controls\Radio\RadioField;
use Mapsteps\Wpbf\Customizer\Controls\Radio\RadioImageField;
use Mapsteps\Wpbf\Customizer\Controls\Select\SelectField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\InputSliderField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\ResponsiveInputSliderField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\SliderField;
use Mapsteps\Wpbf\Customizer\Controls\Sortable\SortableField;
use Mapsteps\Wpbf\Customizer\Controls\Tabs\SectionTabsField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use Mapsteps\Wpbf\Customizer\Sections\ExpandedSection;
use Mapsteps\Wpbf\Customizer\Sections\LinkSection;
use Mapsteps\Wpbf\Customizer\Sections\NestedSection;
use Mapsteps\Wpbf\Customizer\Sections\OuterSection;
use WP_Customize_Manager;
use WP_Customize_Section;

/**
 * Wpbf customizer's utility helper class.
 */
class CustomizerUtil {

	/**
	 * Available section tabs.
	 *
	 * @var string[]
	 */
	public $available_section_types = [ 'default', 'expanded', 'link', 'nested', 'outer' ];

	/**
	 * The available fields.
	 *
	 * Array of field/control types and their control class path.
	 *
	 * @var array $available_fields
	 */
	public $available_fields = array(
		'checkbox'                  => '\Mapsteps\Wpbf\Customizer\Controls\Checkbox\CheckboxControl',
		'toggle'                    => '\Mapsteps\Wpbf\Customizer\Controls\Checkbox\ToggleControl',
		'custom'                    => '\Mapsteps\Wpbf\Customizer\Controls\Custom\CustomControl',
		'color'                     => '\Mapsteps\Wpbf\Customizer\Controls\Color\ColorControl',
		'dimension'                 => '\Mapsteps\Wpbf\Customizer\Controls\Dimension\DimensionControl',
		'divider'                   => '\Mapsteps\Wpbf\Customizer\Controls\Headline\DividerControl',
		'headline'                  => '\Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineControl',
		'headline-toggle'           => '\Mapsteps\Wpbf\Customizer\Controls\Headline\HeadlineToggleControl',
		'generic'                   => '\Mapsteps\Wpbf\Customizer\Controls\Generic\GenericControl',
		'responsive-generic'        => '\Mapsteps\Wpbf\Customizer\Controls\Generic\ResponsiveGenericControl',
		'image'                     => '\Mapsteps\Wpbf\Customizer\Controls\Media\ImageControl',
		'margin-padding'            => '\Mapsteps\Wpbf\Customizer\Controls\MarginPadding\MarginPaddingControl',
		'responsive-margin-padding' => '\Mapsteps\Wpbf\Customizer\Controls\MarginPadding\ResponsiveMarginPaddingControl',
		'radio'                     => '\Mapsteps\Wpbf\Customizer\Controls\Radio\RadioControl',
		'radio-buttonset'           => '\Mapsteps\Wpbf\Customizer\Controls\Radio\RadioButtonsetControl',
		'radio-image'               => '\Mapsteps\Wpbf\Customizer\Controls\Radio\RadioImageControl',
		'select'                    => '\Mapsteps\Wpbf\Customizer\Controls\Select\SelectControl',
		'slider'                    => '\Mapsteps\Wpbf\Customizer\Controls\Slider\SliderControl',
		'input-slider'              => '\Mapsteps\Wpbf\Customizer\Controls\Slider\InputSliderControl',
		'responsive-input-slider'   => '\Mapsteps\Wpbf\Customizer\Controls\Slider\ResponsiveInputSliderControl',
		'section-tabs'              => '\Mapsteps\Wpbf\Customizer\Controls\Tabs\SectionTabsControl',
		'sortable'                  => '\Mapsteps\Wpbf\Customizer\Controls\Sortable\SortableControl',
		'typography'                => null,
		'upload'                    => '\Mapsteps\Wpbf\Customizer\Controls\Media\UploadControl',
	);

	/**
	 * Controls which utilize the content_template to render the control.
	 *
	 * @var string[] $basic_controls
	 */
	public $controls_with_content_template = array(
		'checkbox',
		'toggle',
		'custom',
		'headline-toggle',
		'dimension',
		'image',
		'radio',
		'radio-buttonset',
		'radio-image',
		'section-tabs',
		'sortable',
		'upload',
	);

	/**
	 * Controls which are grouped into a single control.
	 *
	 * @var array $grouped_controls
	 */
	public $grouped_controls = [
		'generic' => [
			'email',
			'number',
			'number-unit',
			'text',
			'textarea',
			'url',
			'content',
		],
		'responsive-generic' => [
			'responsive-email',
			'responsive-number',
			'responsive-number-unit',
			'responsive-text',
			'responsive-textarea',
			'responsive-url',
			'responsive-content',
		],
		'margin-padding' => [
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
	 * Get the section instance.
	 *
	 * @param string               $section_type Type of the section.
	 * @param WP_Customize_Manager $wp_customer_manager The customizer manager object.
	 * @param string               $id The section id.
	 * @param array                $args The section arguments.
	 *
	 * @return WP_Customize_Section|ExpandedSection|LinkSection|NestedSection|OuterSection
	 */
	public function getSectionInstance( $section_type, $wp_customer_manager, $id, $args ) {

		if ( empty( $section_type ) || ! in_array( $section_type, $this->available_section_types, true ) ) {
			$section_type = 'default';
		}

		switch ( $section_type ) {
			case 'expanded':
				return new ExpandedSection( $wp_customer_manager, $id, $args );
			case 'link':
				return new LinkSection( $wp_customer_manager, $id, $args );
			case 'nested':
				return new NestedSection( $wp_customer_manager, $id, $args );
			case 'outer':
				return new OuterSection( $wp_customer_manager, $id, $args );
			default:
				return new WP_Customize_Section( $wp_customer_manager, $id, $args );
		}

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

		if ( ! array_key_exists( $control_type, $this->available_fields ) ) {
			return null;
		}

		$field = null;

		switch ( $control_type ) {
			case 'checkbox':
				$field = new CheckboxField( $control );
				break;
			case 'toggle':
				$field = new ToggleField( $control );
				break;
			case 'custom':
				$field = new CustomField( $control );
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
			case 'generic':
				$field = new GenericField( $control );
				break;
			case 'responsive-generic':
				$field = new ResponsiveGenericField( $control );
				break;
			case 'headline':
				$field = new HeadlineField( $control );
				break;
			case 'headline-toggle':
				$field = new HeadlineToggleField( $control );
				break;
			case 'image':
				$field = new ImageField( $control );
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
			case 'radio-buttonset':
				$field = new RadioButtonsetField( $control );
				break;
			case 'radio-image':
				$field = new RadioImageField( $control );
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
			case 'responsive-input-slider':
				$field = new ResponsiveInputSliderField( $control );
				break;
			case 'section-tabs':
				$field = new SectionTabsField( $control );
				break;
			case 'sortable':
				$field = new SortableField( $control );
				break;
			case 'upload':
				$field = new UploadField( $control );
				break;
		}

		return $field;

	}

}
