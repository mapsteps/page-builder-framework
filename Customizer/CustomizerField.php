<?php
/**
 * Wpbf customizer field.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

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
	 * The setting's sanitize_callback.
	 *
	 * @var callable
	 */
	private $sanitize_callback = '';

	/**
	 * Construct the class.
	 */
	public function __construct() {

		$this->setting_instance = new CustomizerSetting();
		$this->control_instance = new CustomizerControl();

	}

	/**
	 * Set the control id.
	 *
	 * @param string $id Control id.
	 *
	 * @return   $this
	 */
	public function id( $id ) {

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
	 * @param string $settings Setting id.
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
	 * @param string $active_callback Control active_callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		$this->control_instance->activeCallback( $active_callback );

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
	 * @param string $sanitize_js_callback Control sanitize_js_callback.
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
	 * Add control to a section.
	 *
	 * @param string $section_id Section id.
	 *
	 * @return $this
	 */
	public function addToSection( $section_id ) {

		if ( empty( $this->sanitize_callback ) ) {
			$control_type = $this->control_instance->control->type;

			$this->sanitize_callback = ( new CustomizerUtil() )->determineSanitizeCallback( $control_type );

			if ( ! empty( $this->sanitize_callback ) ) {
				$this->sanitizeCallback( $this->sanitize_callback );
			}
		}

		$this->setting_instance->add();

		$this->control_instance->addToSection( $section_id );

		return $this;

	}

}
