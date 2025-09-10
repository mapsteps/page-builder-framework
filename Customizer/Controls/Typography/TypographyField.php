<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
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
	 * The font properties.
	 *
	 * @var array
	 */
	protected $font_properties = [ 'font-family', 'variant', 'font-size', 'line-height', 'letter-spacing', 'color', 'text-alignment', 'text-transform' ];

	/**
	 * A `TypographyChoices` instance.
	 *
	 * @var TypographyChoices
	 */
	protected $typography_choices;

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

		$this->typography_choices = new TypographyChoices();

	}

	/**
	 * Enqueue styles & scripts on 'customize_controls_enqueue_scripts' action.
	 */
	public function enqueueControlScripts() {

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-typography-control', WPBF_THEME_URI . '/Customizer/Controls/Typography/dist/typography-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-typography-control', WPBF_THEME_URI . '/Customizer/Controls/Typography/dist/typography-control-min.js', array( 'customize-controls' ), WPBF_VERSION, false );

		// JS object inside this block will only be printed once.
		if ( ! TypographyStore::$control_vars_printed ) {
			wp_localize_script( 'wpbf-typography-control', 'wpbfFontVariantOptions', [
				'standard' => FontsStore::$standard_font_variant_options,
				'complete' => FontsStore::$complete_font_variant_options,
			] );

			wp_localize_script( 'wpbf-typography-control', 'wpbfFontProperties', $this->font_properties );
			wp_localize_script( 'wpbf-typography-control', 'wpbfGoogleFonts', ( new GoogleFontsUtil() )->getCollections() );
			wp_add_inline_script( 'wpbf-typography-control', 'const wpbfFieldsFontVariants = {};', 'before' );

			TypographyStore::$control_vars_printed = true;
		}

		$field_variant_key = str_ireplace( ']', '', $this->control->id );
		$field_variant_key = str_ireplace( '[', '_', $field_variant_key );

		$field_variant_values = $this->prepare_php_array_for_js(
			$this->typography_choices->makeCustomFontVariantOptions( $this->fonts_arg )
		);

		// JS object here will be printed for each field.
		wp_add_inline_script(
			'wpbf-typography-control',
			'wpbfFieldsFontVariants.' . $field_variant_key . ' = ' . wp_json_encode( $field_variant_values ) . ';',
			'before'
		);

	}

	/**
	 * Enqueue styles & scripts on 'customize_preview_init' action.
	 */
	public function enqueuePreviewScripts() {

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-typography-preview', WPBF_THEME_URI . '/Customizer/Controls/Typography/dist/typography-preview-min.js', array( 'customize-preview' ), WPBF_VERSION, false );

		// JS object inside this block will only be printed once.
		if ( ! TypographyStore::$preview_vars_printed ) {
			wp_localize_script( 'wpbf-typography-preview', 'wpbfGoogleFontNames', FontsStore::$google_font_names );

			TypographyStore::$preview_vars_printed = true;
		}

	}

	/**
	 * Prepare PHP array to be used as JS object.
	 *
	 * @see See https://developer.wordpress.org/reference/classes/wp_scripts/localize/
	 *
	 * @param array $values The data which can be either a single or multi-dimensional array.
	 * @return array
	 */
	private function prepare_php_array_for_js( $values ) {

		foreach ( $values as $key => $value ) {
			if ( ! is_scalar( $value ) ) {
				continue;
			}

			$values[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
		}

		return $values;

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

		if ( ! in_array( $this->control->id, TypographyStore::$added_control_ids, true ) ) {
			TypographyStore::$added_control_ids[] = $this->control->id;
		}

		$props = $this->control->custom_properties;

		$this->tab = ! empty( $props['tab'] ) && is_string( $props['tab'] ) ? $props['tab'] : '';

		$this->fonts_arg = ! empty( $props['fonts'] ) && is_array( $props['fonts'] ) ? $props['fonts'] : [];

		$this->addLabelAndDescription();

		if ( isset( $this->default_value['font-family'] ) ) {
			$this->addFontFamilyField();
			$this->addFontVariantField();
		}

	}

	/**
	 * Sanitize the value.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return array
	 */
	public function sanitizeCallback( $value ) {
		return ( new TypographySanitizer() )->sanitize( $value, $this->control->id );
	}

	/**
	 * Add the label and description using 'assoc-array' control.
	 */
	private function addLabelAndDescription() {

		wpbf_customizer_field()
			->id( $this->control->id )
			->type( 'assoc-array' )
			->tab( $this->tab )
			->label( $this->control->label )
			->description( $this->control->description )
			->defaultValue( $this->default_value )
			->capability( $this->control->capability )
			->priority( $this->control->priority )
			->transport( $this->transport )
			->activeCallback( $this->active_callback_args )
			->sanitizeCallback( [ $this, 'sanitizeCallback' ] )
			->partialRefresh( $this->partial_refresh_args )
			->tooltip( $this->control->tooltip )
			->properties( [
				'wrapper_attrs' => [
					'gap'   => 'small',
					'class' => '{default_class} wpbf-typography-label-description',
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

		$default_value = ! empty( $defaults['font-family'] ) && is_string( $defaults['font-family'] ) ? $defaults['font-family'] : '';

		wpbf_customizer_field()
			->id( $this->control->id . '[font-family]' )
			->type( 'select' )
			->label( __( 'Font Family', 'page-builder-framework' ) )
			->tab( $this->tab )
			->capability( $this->control->capability )
			->defaultValue( $default_value )
			->choices( $this->typography_choices->makeFontFamilyChoices( $this->fonts_arg ) )
			->priority( $this->control->priority )
			// The main control will do the real work.
			->transport( 'postMessage' )
			->inputAttrs( $this->control->input_attrs )
			->activeCallback( $this->active_callback_args )
			->properties( [
				'wrapper_attrs' => [
					'data-wpbf-typography-control' => $this->control->id,
					'data-wpbf-typography-type'    => 'font-family',
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

		wpbf_customizer_field()
			->id( $this->control->id . '[variant]' )
			->type( 'select' )
			->label( __( 'Font Variant', 'page-builder-framework' ) )
			->tab( $this->tab )
			->capability( $this->control->capability )
			->defaultValue( $font_variant )
			->choices( $this->typography_choices->makeFontVariantChoices( $this->fonts_arg ) )
			->priority( $this->control->priority )
			// The main control will do the real work.
			->transport( 'postMessage' )
			->inputAttrs( $this->control->input_attrs )
			->activeCallback( $this->active_callback_args )
			->properties( [
				'wrapper_attrs' => [
					'data-wpbf-typography-control' => $this->control->id,
					'data-wpbf-typography-type'    => 'variant',
				],
			] )
			->addToSection( $this->control->section_id );

	}

	/**
	 * Add the divider as the last field (currently not used).
	 */
	private function addDivider() {

		wpbf_customizer_field()
			->id( $this->control->id . '_separator' )
			->type( 'divider' )
			->tab( $this->tab )
			->capability( $this->control->capability )
			->priority( $this->control->priority )
			->activeCallback( $this->active_callback_args )
			->properties( [
				'wrapper_attrs' => [
					'gap' => 'small',
				],
			] )
			->addToSection( $this->control->section_id );

	}

}
