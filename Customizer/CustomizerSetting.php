<?php
/**
 * Wpbf customizer setting.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;

/**
 * Customizer setting class.
 */
class CustomizerSetting {

	/**
	 * The setting entity object.
	 *
	 * @var CustomizerSettingEntity
	 */
	private $setting;

	/**
	 * CustomizerSetting constructor.
	 */
	public function __construct() {

		$this->setting = new CustomizerSettingEntity();

	}

	/**
	 * Set the setting id.
	 *
	 * @param string $id Setting id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		$this->setting->id = $id;

		return $this;

	}

	/**
	 * Set the setting type.
	 *
	 * @param string $type Setting type. Accepts 'theme_mod' or 'option'.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		$this->setting->type = $type;

		return $this;

	}

	/**
	 * Set the capability required to use this setting.
	 *
	 * @param string $capability The capability required to use this setting.
	 *
	 * @return $this
	 */
	public function capability( $capability ) {

		$this->setting->capability = $capability;

		return $this;

	}

	/**
	 * Set the default value for this setting.
	 *
	 * @param string|array|bool|int|float $value The default value for this setting.
	 *
	 * @return $this
	 */
	public function defaultValue( $value ) {

		$this->setting->default = $value;

		return $this;

	}

	/**
	 * Set the transport for this setting.
	 *
	 * @param string $transport Options for rendering the live preview of changes in Customizer.
	 *
	 * @return $this
	 */
	public function transport( $transport ) {

		$this->setting->transport = $transport;

		return $this;

	}

	/**
	 * Set the server-side validation callback for the setting's value.
	 *
	 * @param callable $callback Server-side validation callback for the setting's value.
	 *
	 * @return $this
	 */
	public function validateCallback( $callback ) {

		$this->setting->validate_callback = $callback;

		return $this;

	}

	/**
	 * Set the callback to filter a Customize setting value in un-slashed form.
	 *
	 * @param callable $callback Callback to filter a Customize setting value in un-slashed form.
	 *
	 * @return $this
	 */
	public function sanitizeCallback( $callback ) {

		$this->setting->sanitize_callback = $callback;

		return $this;

	}

	/**
	 * Set the callback to convert a Customize PHP setting value to a value that is JSON serializable.
	 *
	 * @param callable $callback Callback to convert a Customize PHP setting value to a value that is JSON serializable.
	 *
	 * @return $this
	 */
	public function sanitizeJsCallback( $callback ) {

		$this->setting->sanitize_js_callback = $callback;

		return $this;

	}

	/**
	 * Add the setting to the Customizer singleton.
	 *
	 * @return CustomizerSettingEntity
	 */
	public function add() {

		Customizer::$added_settings[] = $this->setting;

		return $this->setting;

	}

}
