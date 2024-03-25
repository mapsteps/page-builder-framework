<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyUtil;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;

class TypographyField extends BaseField {

	/**
	 * Whether the field is a wrapper that will render other fields.
	 *
	 * @var bool
	 */
	public $is_wrapper_field = true;

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
	 * Raw active callback arguments.
	 *
	 * The array format is the same as when calling `activeCallback` method in `wpbf_customizer_field`.
	 *
	 * @var array
	 */
	protected $active_callback_args = [];

	/**
	 * Raw partial refresh arguments.
	 *
	 * The array format is the same as when calling `partialRefresh` method in `wpbf_customizer_field`.
	 *
	 * @var array
	 */
	protected $partial_refresh_args = [];

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

	}

	/**
	 * Enqueue styles & scripts on 'customize_controls_enqueue_scripts' action.
	 */
	public function enqueueControlScripts() {

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-typography-control', WPBF_THEME_URI . '/Customizer/Controls/Typography/dist/typography-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-typography-control', WPBF_THEME_URI . '/Customizer/Controls/Typography/dist/typography-control-min.js', array( 'customize-controls' ), WPBF_VERSION, false );

	}

	/**
	 * Add sub fields when the `$is_wrapper_field` is set to `true`.
	 *
	 * @param CustomizerSettingEntity $setting_entity The setting entity object.
	 * @param callable|array          $active_callback_args Raw active callback arguments.
	 * @param array                   $partial_refresh_args Raw partial refresh arguments.
	 */
	public function addSubFields( $setting_entity, $active_callback_args, $partial_refresh_args ) {

		if ( ! FontsStore::initialized() ) {
			FontsStore::init();
		}

		$this->setting_entity       = $setting_entity;
		$this->active_callback_args = $active_callback_args;
		$this->partial_refresh_args = $partial_refresh_args;

		$this->transport = $setting_entity->transport;
		$this->transport = 'auto' === $this->transport ? 'postMessage' : $this->transport;

		$this->default_value = $setting_entity->default;
		$this->default_value = is_array( $this->default_value ) ? $this->default_value : [];

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueueControlScripts' ) );

		$props = $this->control->custom_properties;

		$this->tab = ! empty( $props['tab'] ) && is_string( $props['tab'] ) ? $props['tab'] : '';

		$this->fonts_arg = ! empty( $props['fonts'] ) && is_array( $props['fonts'] ) ? $props['fonts'] : [];

		$this->addLabelAndDescription();

		if ( isset( $this->default_value['font-family'] ) ) {
			$this->addFontFamilyField();
			$this->addFontVariantField();
		}

		$this->addDivider();

	}

	/**
	 * Add the label and description using 'custom' control.
	 */
	private function addLabelAndDescription() {

		wpbf_customizer_field()
			->id( $this->control->id )
			->type( 'custom' )
			->tab( $this->tab )
			->label( $this->control->label )
			->description( $this->control->description )
			->capability( $this->control->capability )
			->priority( $this->control->priority )
			->activeCallback( $this->active_callback_args )
			->tooltip( $this->control->tooltip )
			->properties( [
				'wrapper_attrs' => [
					'gap'   => 'small',
					'class' => 'wpbf-typography-label-description',
				],
			] )
			->addToSection( $this->control->section_id );

	}

	/**
	 * Add the font family field.
	 */
	private function addFontFamilyField() {

		if ( is_null( $this->setting_entity ) ) {
			return;
		}

		$defaults = $this->default_value;

		$font_family = ! empty( $defaults['font-family'] ) && is_string( $defaults['font-family'] ) ? $defaults['font-family'] : '';

		wpbf_customizer_field()
			->id( $this->control->id . '[font-family]' )
			->type( 'select' )
			->label( __( 'Font Family', 'page-builder-framework' ) )
			->tab( $this->tab )
			->capability( $this->control->capability )
			->defaultValue( $font_family )
			->choices( $this->typography_util->makeFontFamilyChoices( $font_family, $this->fonts_arg ) )
			->priority( $this->control->priority )
			->transport( $this->transport )
			->inputAttrs( $this->control->input_attrs )
			->sanitizeCallback( $this->setting_entity->sanitize_callback )
			->activeCallback( $this->active_callback_args )
			->partialRefresh( $this->partial_refresh_args )
			->properties( [
				'wrapper_attrs' => [
					'data-wpbf-typography-type' => 'font-family',
				],
			] )
			->addToSection( $this->control->section_id );

	}

	/**
	 * Add the font variant field.
	 */
	private function addFontVariantField() {

		if ( is_null( $this->setting_entity ) ) {
			return;
		}

		$defaults = $this->default_value;

		$font_variant = ! empty( $defaults['variant'] ) && is_string( $defaults['variant'] ) ? $defaults['variant'] : '';
		$font_weight  = ! empty( $defaults['font-weight'] ) && ( is_string( $defaults['font-weight'] ) || is_numeric( $defaults['font-weight'] ) ) ? $defaults['font-weight'] : '';
		$font_weight  = is_numeric( $font_weight ) ? (string) $font_weight : $font_weight;

		if ( ! empty( $font_weight ) ) {
			$font_variant = '400' === $font_weight ? 'regular' : $font_variant;
		}

		$control_id = $this->control->id . '[variant]';

		wpbf_customizer_field()
			->id( $control_id )
			->type( 'select' )
			->label( __( 'Font Variant', 'page-builder-framework' ) )
			->tab( $this->tab )
			->capability( $this->control->capability )
			->defaultValue( $font_variant )
			->choices( $this->typography_util->makeFontVariantChoices( $this->fonts_arg ) )
			->priority( $this->control->priority )
			->transport( $this->transport )
			->inputAttrs( $this->control->input_attrs )
			->sanitizeCallback( $this->setting_entity->sanitize_callback )
			->activeCallback( $this->active_callback_args )
			->partialRefresh( $this->partial_refresh_args )
			->properties( [
				'wrapper_attrs' => [
					'data-wpbf-typography-type' => 'variant',
				],
			] )
			->addToSection( $this->control->section_id );

	}

	/**
	 * Add the divider as the last field.
	 */
	private function addDivider() {

		wpbf_customizer_field()
			->id( 'meta_excerpt_separator' )
			->type( 'divider' )
			->priority( 1 )
			->properties( [
				'wrapper_attrs' => [
					'gap' => 'small',
				],
			] )
			->addToSection( 'wpbf_blog_settings' );

	}

}
