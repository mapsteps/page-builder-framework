<?php
/**
 * Aura customizer control.
 *
 * @package Aura
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;

/**
 * Class to add Aura customizer control.
 */
final class CustomizerControl {

	/**
	 * Set the control's type.
	 *
	 * @param string $type Control type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		return $this;

	}

	/**
	 * Set the control's setting.
	 *
	 * @param string $setting Setting id.
	 *
	 * @return $this
	 */
	public function setting( $setting ) {

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

		return $this;

	}

	/**
	 * Set the control's transport.
	 *
	 * @param string $transport Control transport.
	 *
	 * @return $this
	 */
	public function transport( $transport ) {

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

		return $this;

	}

	/**
	 * Set the control's sanitize_callback.
	 *
	 * @param string $sanitize_callback Control sanitize_callback.
	 *
	 * @return $this
	 */
	public function sanitizeCallback( $sanitize_callback ) {

		return $this;

	}

	/**
	 * Set the control's sanitize_js_callback.
	 *
	 * @param string $sanitize_js_callback Control sanitize_js_callback.
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

		return new CustomizerControlEntity();

	}

}
