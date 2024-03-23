<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsStore;
use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyUtil;
use Mapsteps\Wpbf\Customizer\CustomizerStore;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use WP_Customize_Manager;

class TypographyField extends BaseField {

	/**
	 * A `TypographyUtil` instance.
	 *
	 * @var TypographyUtil
	 */
	protected $typography_util;

	/**
	 * The setting entity.
	 *
	 * @var CustomizerSettingEntity|null
	 */
	protected $setting_entity = null;

	/**
	 * The tab.
	 *
	 * @var string
	 */
	protected $tab = '';

	/**
	 * The default value.
	 *
	 * @var array
	 */
	protected $default_value = [];

	/**
	 * The transport type.
	 *
	 * @var string
	 */
	protected $transport = '';

	/**
	 * The raw partial refresh array (as when adding it via `wpbf_customizer_field`).
	 *
	 * @var array
	 */
	protected $partial_refresh = [];

	/**
	 * The fonts argument.
	 *
	 * @var array
	 */
	protected $fonts_arg = [];

	/**
	 * Construct the class.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function __construct( $control ) {

		parent::__construct( $control );

		$this->typography_util = new TypographyUtil();
		$this->setting_entity  = CustomizerStore::findSettingByControlId( $this->control->id );

		if ( ! $this->setting_entity ) {
			return;
		}

		$this->transport = $this->setting_entity->transport;
		$this->transport = 'auto' === $this->transport ? 'postMessage' : $this->transport;

		$this->default_value = $this->setting_entity->default;
		$this->default_value = is_array( $this->default_value ) ? $this->default_value : [];

		$partial_refresh_entities = CustomizerStore::findPartialRefreshesByControlId( $this->control->id );

		foreach ( $partial_refresh_entities as $partial_refresh_entity ) {
			$partial_refresh_id = $partial_refresh_entity->id;

			$this->partial_refresh[ $partial_refresh_id ] = [
				'container_inclusive' => $partial_refresh_entity->container_inclusive,
				'selector'            => $partial_refresh_entity->selector,
				'render_callback'     => $partial_refresh_entity->render_callback,
			];
		}

	}

	/**
	 * Add sub controls based on the control arguments.
	 *
	 * @param array $args The arguments for the control.
	 */
	private function addSubControls( $args ) {

		$this->tab = ! empty( $args['tab'] ) && is_string( $args['tab'] ) ? $args['tab'] : '';

		$this->fonts_arg = ! empty( $args['fonts'] ) && is_array( $args['fonts'] ) ? $args['fonts'] : [];

		$this->addLabelAndDescription();

		if ( isset( $this->default_value['font-family'] ) ) {
			$this->addFontFamilyControl();
		}

	}

	/**
	 * Add the label and description using 'custom' control.
	 */
	private function addLabelAndDescription() {

		wpbf_customizer_field()
			->id( $this->control->id . '_label' )
			->type( 'custom' )
			->tab( $this->tab )
			->label( $this->control->label )
			->description( $this->control->description )
			->capability( $this->control->capability )
			->priority( $this->control->priority )
			->activeCallback( $this->control->active_callback )
			->tooltip( $this->control->tooltip )
			->properties( [
				'wrapper_attrs' => [
					'gap' => 'small',
				],
			] )
			->addToSection( $this->control->section_id );

	}

	/**
	 * Add the font family control.
	 */
	private function addFontFamilyControl() {

		if ( is_null( $this->setting_entity ) ) {
			return;
		}

		wpbf_customizer_field()
			->id( $this->control->id . '[font-family]' )
			->type( 'select' )
			->label( __( 'Font Family', 'page-builder-framework' ) )
			->settings( $this->control->settings )
			->setting( $this->control->setting )
			->tab( $this->tab )
			->capability( $this->control->capability )
			->choices( $this->typography_util->makeFontFamilyChoices( $this->fonts_arg ) )
			->priority( $this->control->priority )
			->transport( $this->transport )
			->inputAttrs( $this->control->input_attrs )
			->sanitizeCallback( $this->setting_entity->sanitize_callback )
			->activeCallback( $this->control->active_callback )
			->partialRefresh( $this->partial_refresh )
			->addToSection( $this->control->section_id );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		if ( ! $this->setting_entity ) {
			return;
		}

		if ( ! FontsStore::initialized() ) {
			FontsStore::init();
		}

		$control_args = $this->parseControlArgs();

		$this->addSubControls( $control_args );

	}

}
