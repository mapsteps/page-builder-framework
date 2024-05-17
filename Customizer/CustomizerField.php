<?php
/**
 * Wpbf customizer field.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Entities\PartialRefreshEntity;

/**
 * Class to add Wpbf customizer control & setting.
 */
final class CustomizerField {

	/**
	 * WPBF customizer setting object.
	 *
	 * @var CustomizerSetting
	 */
	private $setting_instance;

	/**
	 * WPBF customizer control object.
	 *
	 * @var CustomizerControl
	 */
	private $control_instance;

	/**
	 * The setting's id.
	 *
	 * @var string
	 */
	private $setting_id = '';

	/**
	 * The setting's sanitize_callback.
	 *
	 * @var callable
	 */
	private $sanitize_callback = '';

	/**
	 * Field's dependencies.
	 *
	 * @var array
	 */
	private $field_dependencies = [];

	/**
	 * Field's raw partial refresh arguments.
	 *
	 * @var array
	 */
	private $partial_refresh_args = array();

	/**
	 * Custom properties for the control.
	 *
	 * @var array
	 */
	private $custom_properties = array();

	/**
	 * Construct the class.
	 */
	public function __construct() {

		$this->setting_instance = new CustomizerSetting();
		$this->control_instance = new CustomizerControl();

	}

	/**
	 * Set the setting id.
	 *
	 * @param string $id Setting id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		$this->setting_id = $id;
		$this->setting_instance->id( $id );
		$this->control_instance->id( $id );

		return $this;

	}

	/**
	 * Set the control's type.
	 *
	 * @param string $type Control type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		$this->control_instance->type( $type );

		return $this;

	}

	/**
	 * Set the setting's option type.
	 *
	 * @param string $option_type Setting's option type. Accepts 'theme_mod' or 'option'.
	 *
	 * @return $this
	 */
	public function optionType( $option_type ) {

		// Tollerate developer's typo mistake.
		$option_type = 'options' === $option_type ? 'option' : $option_type;

		$this->setting_instance->type( $option_type );

		return $this;

	}

	/**
	 * Set the capability required to use this control.
	 *
	 * @param string $capability The capability required to use this control.
	 *
	 * @return $this
	 */
	public function capability( $capability ) {

		$this->setting_instance->capability( $capability );
		$this->control_instance->capability( $capability );

		return $this;

	}

	/**
	 * Set settings tied to the control.
	 *
	 * @param array|string $settings Setting id.
	 *
	 * @return $this
	 */
	public function settings( $settings ) {

		$this->control_instance->settings( $settings );

		return $this;

	}

	/**
	 * Set the primary setting for the control (if there is one).
	 *
	 * @param string $setting Setting id.
	 *
	 * @return $this
	 */
	public function setting( $setting ) {

		$this->control_instance->setting( $setting );

		return $this;

	}

	/**
	 * Set the control's label.
	 *
	 * @param string $label Control label.
	 *
	 * @return $this
	 */
	public function label( $label ) {

		$this->control_instance->label( $label );

		return $this;

	}

	/**
	 * Set the control's description.
	 *
	 * @param string $description Control description.
	 *
	 * @return $this
	 */
	public function description( $description ) {

		$this->control_instance->description( $description );

		return $this;

	}

	/**
	 * Set the setting's transport.
	 *
	 * @param string $transport Options for rendering the live preview of changes in Customizer.
	 *
	 * @return $this
	 */
	public function transport( $transport ) {

		$this->setting_instance->transport( $transport );

		return $this;

	}

	/**
	 * Set the control's priority.
	 *
	 * @param int $priority Control priority.
	 *
	 * @return $this
	 */
	public function priority( $priority ) {

		$this->control_instance->priority( $priority );

		return $this;

	}

	/**
	 * Set the setting's default value.
	 *
	 * @param string|array|bool|int|float $value The default value of the setting.
	 *
	 * @return $this
	 */
	public function defaultValue( $value ) {

		$this->setting_instance->defaultValue( $value );

		return $this;

	}

	/**
	 * Set the control's choices.
	 *
	 * @param array $choices Control choices.
	 *
	 * @return $this
	 */
	public function choices( $choices ) {

		$this->control_instance->choices( $choices );

		return $this;

	}

	/**
	 * Set the control's input_attrs.
	 *
	 * @param array $input_attrs Control input_attrs.
	 *
	 * @return $this
	 */
	public function inputAttrs( $input_attrs ) {

		$this->control_instance->inputAttrs( $input_attrs );

		return $this;

	}

	/**
	 * Set the control's active_callback.
	 *
	 * @param callable|array $active_callback Control's active callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		if ( is_callable( $active_callback ) ) {
			$this->control_instance->activeCallback( $active_callback );
			return $this;
		}

		if ( ! is_array( $active_callback ) ) {
			return $this;
		}

		$this->field_dependencies = $active_callback;

		return $this;

	}

	/**
	 * Set the setting's sanitize_callback.
	 *
	 * @param callable $sanitize_callback Control sanitize_callback.
	 *
	 * @return $this
	 */
	public function sanitizeCallback( $sanitize_callback ) {

		$this->sanitize_callback = $sanitize_callback;
		$this->setting_instance->sanitizeCallback( $sanitize_callback );

		return $this;

	}

	/**
	 * Set the setting's sanitize_js_callback.
	 *
	 * @param callable $sanitize_js_callback Control sanitize_js_callback.
	 *
	 * @return $this
	 */
	public function sanitizeJsCallback( $sanitize_js_callback ) {

		$this->setting_instance->sanitizeJsCallback( $sanitize_js_callback );

		return $this;

	}

	/**
	 * Set the control's json.
	 *
	 * @param string $json Control json.
	 *
	 * @return $this
	 */
	public function json( $json ) {

		$this->control_instance->json( $json );

		return $this;

	}

	/**
	 * Set the control's partial_refresh.
	 *
	 * @param array $args The partial refresh arguments.
	 *
	 * @return $this
	 */
	public function partialRefresh( $args = array() ) {

		if ( empty( $args ) || ! is_array( $args ) ) {
			return $this;
		}

		$this->partial_refresh_args = $args;

		return $this;

	}

	/**
	 * Set the control's tooltip.
	 *
	 * @param string $tooltip Control's tooltip content.
	 *
	 * @return $this
	 */
	public function tooltip( $tooltip = '' ) {

		$this->control_instance->tooltip( $tooltip );

		return $this;

	}

	/**
	 * The section tab where the control belongs to.
	 *
	 * @param string $tab_key The section tab key.
	 */
	public function tab( $tab_key ) {

		if ( empty( $tab_key ) ) {
			return $this;
		}

		$this->custom_properties['tab'] = $tab_key;

		return $this;

	}

	/**
	 * Set the control's custom properties.
	 *
	 * @param array $custom_properties Control's custom properties.
	 *
	 * @return $this
	 */
	public function properties( $custom_properties ) {

		if ( empty( $custom_properties ) ) {
			return $this;
		}

		$control_custom_props    = wp_parse_args( $custom_properties, $this->custom_properties );
		$this->custom_properties = $control_custom_props;

		return $this;
	}

	/**
	 * Add control to a section.
	 *
	 * @param string $section_id Section id.
	 *
	 * @return $this
	 */
	public function addToSection( $section_id ) {

		$field = ( new CustomizerUtil() )->getField( $this->control_instance->control );

		if ( is_null( $field ) ) {
			return;
		}

		if ( $field->use_content_template ) {
			$control_type = $this->control_instance->control->type;

			if ( ! isset( CustomizerStore::$controls_using_content_template[ $control_type ] ) ) {
				CustomizerStore::$controls_using_content_template[ $control_type ] = $field->control_class_path;
			}
		}

		if ( empty( $this->setting_id ) ) {
			$this->setting_id = uniqid( 'wpbf_control_' );

			$this->id( $this->setting_id );
		}

		$control_id       = $this->control_instance->control->id;
		$control_settings = $this->control_instance->control->settings;

		if ( empty( $control_settings ) ) {
			if ( ! empty( $control_id ) ) {
				$this->control_instance->settings( $control_id );
			}
		} elseif ( empty( $control_id ) ) {
			if ( is_string( $control_settings ) ) {
				$this->control_instance->id( $control_settings );
			}
		}

		// Update the `$control_id` var.
		$control_id = $this->control_instance->control->id;

		if ( empty( $this->sanitize_callback ) ) {
			$this->sanitizeCallback( [ $field, 'sanitizeCallback' ] );
		}

		if ( ! empty( $this->partial_refresh_args ) ) {
			$this->setting_instance->transport( 'postMessage' );
		}

		$this->setting_instance->setting = $field->filterSettingEntity( $this->setting_instance->setting );

		if ( ! empty( $this->custom_properties ) ) {
			$this->control_instance->customProperties( $this->custom_properties );
		}

		if ( $field->is_wrapper_field ) {
			$this->control_instance->control->section_id = $section_id;

			// Update `$field` variable to have the updated setting entity.
			$field = ( new CustomizerUtil() )->getField( $this->control_instance->control );

			if ( is_null( $field ) ) {
				return;
			}

			$callable_active_callback  = $this->control_instance->control->active_callback;
			$subfields_active_callback = ! empty( $callable_active_callback ) && is_callable( $callable_active_callback ) ? $callable_active_callback : $this->field_dependencies;

			$field->addSubFields( $this->setting_instance->setting, $subfields_active_callback, $this->partial_refresh_args );

			// Stop here if this field is a wrapper that will render other fields.
			return;
		}

		$this->setting_instance->control_type( $this->control_instance->control->type );

		$this->setting_instance->add();

		if ( ! empty( $this->field_dependencies ) ) {
			CustomizerStore::$added_control_dependencies[ $control_id ] = $this->field_dependencies;
		}

		$this->parsePartialRefreshArgs();

		$this->control_instance->addToSection( $section_id );

	}

	/**
	 * Parse the raw partial refresh arguments.
	 */
	private function parsePartialRefreshArgs() {

		if ( empty( $this->partial_refresh_args ) || ! is_array( $this->partial_refresh_args ) ) {
			return;
		}

		$control_settings = $this->control_instance->control->settings;

		$partial_refresh_settings = array();

		if ( is_array( $control_settings ) ) {
			$partial_refresh_settings = $control_settings;
		} elseif ( is_string( $control_settings ) ) {
			$partial_refresh_settings = array( $control_settings );
		}

		foreach ( $this->partial_refresh_args as $partial_refresh_key => $partial_refresh_arg ) {
			$partial_refresh_entity = new PartialRefreshEntity();

			$partial_refresh_entity->id         = $partial_refresh_key;
			$partial_refresh_entity->control_id = $this->control_instance->control->id;
			$partial_refresh_entity->settings   = $partial_refresh_settings;

			if ( isset( $partial_refresh_arg['container_inclusive'] ) ) {
				$partial_refresh_entity->container_inclusive = $partial_refresh_arg['container_inclusive'];
			}

			if ( isset( $partial_refresh_arg['selector'] ) ) {
				$partial_refresh_entity->selector = $partial_refresh_arg['selector'];
			}

			if ( isset( $partial_refresh_arg['render_callback'] ) ) {
				$partial_refresh_entity->render_callback = $partial_refresh_arg['render_callback'];
			}

			CustomizerStore::$added_partial_refreshes[] = $partial_refresh_entity;
		}

	}

}
