<?php
/**
 * Wpbf customizer's utility helper class.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Checkbox\CheckboxField;
use Mapsteps\Wpbf\Customizer\Controls\Checkbox\ToggleField;
use Mapsteps\Wpbf\Customizer\Controls\Code\CodeField;
use Mapsteps\Wpbf\Customizer\Controls\Color\ColorField;
use Mapsteps\Wpbf\Customizer\Controls\Custom\CustomField;
use Mapsteps\Wpbf\Customizer\Controls\Dimension\DimensionField;
use Mapsteps\Wpbf\Customizer\Controls\Editor\EditorField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\AssocArrayField;
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
use Mapsteps\Wpbf\Customizer\Controls\Repeater\RepeaterField;
use Mapsteps\Wpbf\Customizer\Controls\Select\SelectField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\InputSliderField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\ResponsiveInputSliderField;
use Mapsteps\Wpbf\Customizer\Controls\Slider\SliderField;
use Mapsteps\Wpbf\Customizer\Controls\Sortable\SortableField;
use Mapsteps\Wpbf\Customizer\Controls\Tabs\SectionTabsField;
use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Panels\NestedPanel;
use Mapsteps\Wpbf\Customizer\Sections\ExpandedSection;
use Mapsteps\Wpbf\Customizer\Sections\LinkSection;
use Mapsteps\Wpbf\Customizer\Sections\NestedSection;
use Mapsteps\Wpbf\Customizer\Sections\OuterSection;
use WP_Customize_Manager;
use WP_Customize_Panel;
use WP_Customize_Section;

/**
 * Wpbf customizer's utility helper class.
 */
class CustomizerUtil {

	/**
	 * Available panel types.
	 *
	 * @var string[]
	 */
	public $available_panel_types = [ 'default', 'nested' ];

	/**
	 * Available section types.
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
		'checkbox',
		'toggle',
		'custom',
		'code',
		'color',
		'dimension',
		'divider',
		'headline',
		'headline-toggle',
		'editor',
		'generic',
		'responsive-generic',
		'assoc-array',
		'image',
		'margin-padding',
		'responsive-margin-padding',
		'radio',
		'radio-buttonset',
		'radio-image',
		'select',
		'slider',
		'input-slider',
		'repeater',
		'responsive-input-slider',
		'section-tabs',
		'sortable',
		'typography',
		'upload',
	);

	/**
	 * Controls which are grouped into a single control.
	 *
	 * @var array $grouped_controls
	 */
	private $grouped_controls = [
		'generic' => [
			'email',
			'password',
			'number',
			'number-unit',
			'text',
			'textarea',
			'url',
			'hidden',
			'content',
		],
		'responsive-generic' => [
			'responsive-email',
			'responsive-password',
			'responsive-number',
			'responsive-number-unit',
			'responsive-text',
			'responsive-textarea',
			'responsive-url',
			'responsive-hidden',
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
	 * Get panel instance by type.
	 *
	 * @param string               $panel_type Type of the panel.
	 * @param WP_Customize_Manager $wp_customer_manager The customizer manager object.
	 * @param string               $id The panel id.
	 * @param array                $args The panel arguments.
	 *
	 * @return WP_Customize_Section|ExpandedSection|LinkSection|NestedSection|OuterSection
	 */
	public function getPanelInstance( $panel_type, $wp_customer_manager, $id, $args ) {

		if ( empty( $panel_type ) || ! in_array( $panel_type, $this->available_section_types, true ) ) {
			$panel_type = 'default';
		}

		if ( ! empty( $args['parent_id'] ) ) {
			$panel_type = 'nested';
		}

		switch ( $panel_type ) {
			case 'nested':
				return new NestedPanel( $wp_customer_manager, $id, $args );
			default:
				return new WP_Customize_Panel( $wp_customer_manager, $id, $args );
		}

	}

	/**
	 * Get section instance by type.
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

		if ( ! empty( $args['parent_id'] ) ) {
			$section_type = 'nested';
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
	public function enqueuePreviewScripts( $control ) {

		$field = $this->getField( $control );

		if ( null !== $field ) {
			$field->enqueuePreviewScripts();
		}

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager    $wp_customize_manager The customizer manager object.
	 * @param CustomizerControlEntity $control              The control entity object.
	 */
	public function addControl( $wp_customize_manager, $control ) {

		$field = $this->getField( $control );

		if ( null !== $field ) {
			$field->addControl( $wp_customize_manager );
		}

	}

	/**
	 * Get the field instance.
	 *
	 * @param CustomizerControlEntity $control_entity The control entity object.
	 *
	 * @return BaseField|null
	 */
	public function getField( $control_entity ) {

		$control_type = $control_entity->type;

		foreach ( $this->grouped_controls as $control_name => $grouped_controls ) {
			if ( in_array( $control_type, $grouped_controls, true ) ) {
				$control_type = $control_name;
				break;
			}
		}

		if ( ! in_array( $control_type, $this->available_fields, true ) ) {
			return null;
		}

		$field = null;

		switch ( $control_type ) {
			case 'checkbox':
				$field = new CheckboxField( $control_entity );
				break;
			case 'toggle':
				$field = new ToggleField( $control_entity );
				break;
			case 'custom':
				$field = new CustomField( $control_entity );
				break;
			case 'code':
				$field = new CodeField( $control_entity );
				break;
			case 'color':
				$field = new ColorField( $control_entity );
				break;
			case 'divider':
				$field = new DividerField( $control_entity );
				break;
			case 'dimension':
				$field = new DimensionField( $control_entity );
				break;
			case 'editor':
				$field = new EditorField( $control_entity );
				break;
			case 'generic':
				$field = new GenericField( $control_entity );
				break;
			case 'responsive-generic':
				$field = new ResponsiveGenericField( $control_entity );
				break;
			case 'assoc-array':
				$field = new AssocArrayField( $control_entity );
				break;
			case 'headline':
				$field = new HeadlineField( $control_entity );
				break;
			case 'headline-toggle':
				$field = new HeadlineToggleField( $control_entity );
				break;
			case 'image':
				$field = new ImageField( $control_entity );
				break;
			case 'margin-padding':
				$field = new MarginPaddingField( $control_entity );
				break;
			case 'responsive-margin-padding':
				$field = new ResponsiveMarginPaddingField( $control_entity );
				break;
			case 'radio':
				$field = new RadioField( $control_entity );
				break;
			case 'radio-buttonset':
				$field = new RadioButtonsetField( $control_entity );
				break;
			case 'radio-image':
				$field = new RadioImageField( $control_entity );
				break;
			case 'radio-image':
				$field = new RadioImageField( $control_entity );
				break;
			case 'select':
				$field = new SelectField( $control_entity );
				break;
			case 'slider':
				$field = new SliderField( $control_entity );
				break;
			case 'input-slider':
				$field = new InputSliderField( $control_entity );
				break;
			case 'repeater':
				$field = new RepeaterField( $control_entity );
				break;
			case 'responsive-input-slider':
				$field = new ResponsiveInputSliderField( $control_entity );
				break;
			case 'section-tabs':
				$field = new SectionTabsField( $control_entity );
				break;
			case 'sortable':
				$field = new SortableField( $control_entity );
				break;
			case 'typography':
				$field = new TypographyField( $control_entity );
				break;
			case 'upload':
				$field = new UploadField( $control_entity );
				break;
		}

		return $field;

	}

}
