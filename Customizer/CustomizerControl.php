<?php
/**
 * Wpbf customizer control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;

/**
 * Class to add Wpbf customizer control.
 */
final class CustomizerControl {

	/**
	 * The control entity object.
	 *
	 * @var CustomizerControlEntity
	 */
	public $control;

	/**
	 * Construct the class.
	 */
	public function __construct() {

		$this->control = new CustomizerControlEntity();

	}

	/**
	 * Set the control id.
	 *
	 * @param string $id Control id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		$this->control->id = $id;

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

		$this->control->type = $type;

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

		$this->control->capability = $capability;

		return $this;

	}

	/**
	 * Set settings tied to the control.
	 *
	 * @param string $settings Setting id.
	 *
	 * @return $this
	 */
	public function settings( $settings ) {

		$this->control->settings = $settings;

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

		$this->control->setting = $setting;

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

		$this->control->label = $label;

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

		$this->control->description = $description;

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

		$this->control->priority = $priority;

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

		$this->control->choices = $choices;

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

		$this->control->input_attrs = $input_attrs;

		return $this;

	}

	/**
	 * Set the control's active_callback.
	 *
	 * Callback will be called with one parameter which is the instance of WP_Customize_Control.
	 * It should return boolean to indicate whether the control is active or not.
	 *
	 * @param callable $active_callback Control's active_callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		$this->control->active_callback = $active_callback;

		return $this;

	}

	/**
	 * Set the control's sanitize_callback.
	 *
	 * @param callable $sanitize_callback Control sanitize_callback.
	 *
	 * @return $this
	 */
	public function sanitizeCallback( $sanitize_callback ) {

		return $this;

	}

	/**
	 * Set the control's sanitize_js_callback.
	 *
	 * @param callable $sanitize_js_callback Control sanitize_js_callback.
	 *
	 * @return $this
	 */
	public function sanitizeJsCallback( $sanitize_js_callback ) {

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

		$this->control->json = $json;

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

		$this->control->tooltip = $tooltip;

		return $this;

	}

	/**
	 * Set the control's custom_properties.
	 *
	 * @param array $properties Custom properties which are not provided by WP_Customize_Control by default.
	 *
	 * @return $this
	 */
	public function customProperties( $properties = array() ) {

		$this->control->custom_properties = $properties;

		return $this;

	}

	/**
	 * Add control to a section.
	 *
	 * @param string $section_id Section id.
	 *
	 * @return CustomizerControlEntity
	 */
	public function addToSection( $section_id ) {

		$this->control->section_id = $section_id;

		CustomizerStore::$added_controls[] = $this->control;

		return $this->control;

	}

}
