<?php
/**
 * What wpbf_customizer_field() returns: records every call, builds nothing until the Customizer registers.
 *
 * Keeps every method name and argument format (Premium and child themes rely on them). On customize_register the
 * recorded calls are replayed, in order, on a FieldRegistrar, which does the actual work (see Registry).
 *
 * @package Page Builder Framework
 */

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.Found -- The arguments are recorded with func_get_args(), so calls without optional ones replay the same.

use Mapsteps\Wpbf\Customizer\Registry\FieldRegistrar;
use Mapsteps\Wpbf\Customizer\Registry\Registry;
use Mapsteps\Wpbf\Customizer\Schema\OptionSchema;

/**
 * Records a Customizer field.
 */
final class CustomizerField {

	/**
	 * The recorded calls: [ method, arguments ].
	 *
	 * @var array[]
	 */
	private $calls = array();

	/**
	 * Set the setting id.
	 *
	 * @param string $id Setting id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's type.
	 *
	 * @param string $type Control type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the setting's option type.
	 *
	 * @param string $option_type Setting's option type. Accepts 'theme_mod' or 'option'.
	 *
	 * @return $this
	 */
	public function optionType( $option_type ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the capability required to use this control.
	 *
	 * @param string $capability The capability required to use this control.
	 *
	 * @return $this
	 */
	public function capability( $capability ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set settings tied to the control.
	 *
	 * @param array|string $settings Setting id.
	 *
	 * @return $this
	 */
	public function settings( $settings ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the primary setting for the control (if there is one).
	 *
	 * @param string $setting Setting id.
	 *
	 * @return $this
	 */
	public function setting( $setting ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's label.
	 *
	 * @param string $label Control label.
	 *
	 * @return $this
	 */
	public function label( $label ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's description.
	 *
	 * @param string $description Control description.
	 *
	 * @return $this
	 */
	public function description( $description ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the setting's transport.
	 *
	 * @param string $transport Options for rendering the live preview of changes in Customizer.
	 *
	 * @return $this
	 */
	public function transport( $transport ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's priority.
	 *
	 * @param int $priority Control priority.
	 *
	 * @return $this
	 */
	public function priority( $priority ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the setting's default value.
	 *
	 * @param string|array|bool|int|float $value The default value of the setting.
	 *
	 * @return $this
	 */
	public function defaultValue( $value ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's choices.
	 *
	 * @param array $choices Control choices.
	 *
	 * @return $this
	 */
	public function choices( $choices ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's input_attrs.
	 *
	 * @param array $input_attrs Control input_attrs.
	 *
	 * @return $this
	 */
	public function inputAttrs( $input_attrs ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's active_callback.
	 *
	 * @param callable|array $active_callback Control's active callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the setting's sanitize_callback.
	 *
	 * @param callable $sanitize_callback Control sanitize_callback.
	 *
	 * @return $this
	 */
	public function sanitizeCallback( $sanitize_callback ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the setting's sanitize_js_callback.
	 *
	 * @param callable $sanitize_js_callback Control sanitize_js_callback.
	 *
	 * @return $this
	 */
	public function sanitizeJsCallback( $sanitize_js_callback ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's json.
	 *
	 * @param string $json Control json.
	 *
	 * @return $this
	 */
	public function json( $json ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's partial_refresh.
	 *
	 * @param array $args The partial refresh arguments.
	 *
	 * @return $this
	 */
	public function partialRefresh( $args = array() ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's tooltip.
	 *
	 * @param string $tooltip Control's tooltip content.
	 *
	 * @return $this
	 */
	public function tooltip( $tooltip = '' ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * The section tab where the control belongs to.
	 *
	 * @param string $tab_key The section tab key.
	 *
	 * @return $this
	 */
	public function tab( $tab_key ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's custom properties.
	 *
	 * @param array $custom_properties Control's custom properties.
	 *
	 * @return $this
	 */
	public function properties( $custom_properties ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Add control to a section.
	 *
	 * Recorded like every other call; the field is built when the Customizer registers.
	 *
	 * @param string $section_id Section id.
	 *
	 * @return $this
	 */
	public function addToSection( $section_id ) {

		$this->record( __FUNCTION__, func_get_args() );

		return $this->submit();

	}

	/**
	 * Record a call.
	 *
	 * @param string $method The method.
	 * @param array  $args The arguments.
	 *
	 * @return $this
	 */
	private function record( $method, $args ) {

		$this->calls[] = array( $method, $args );

		return $this;

	}

	/**
	 * Hand the recorded calls to the registry: replayed on a FieldRegistrar when the Customizer registers.
	 *
	 * @return $this
	 */
	private function submit() {

		$this->declareOption();

		$calls = $this->calls;

		Registry::add(
			function () use ( $calls ) {
				$registrar = new FieldRegistrar();

				foreach ( $calls as $call ) {
					call_user_func_array( array( $registrar, $call[0] ), $call[1] );
				}
			}
		);

		return $this;

	}

	/**
	 * Tell the option schema what this field declares (id, type, default, stored format), so wpbf_mod() can read
	 * options the schema doesn't list (Premium, child themes, plugins) on any request.
	 */
	private function declareOption() {

		$id         = '';
		$type       = '';
		$default    = '';
		$properties = array();
		$storage    = 'theme_mod';

		foreach ( $this->calls as $call ) {
			list( $method, $args ) = $call;

			if ( 'id' === $method && isset( $args[0] ) ) {
				$id = $args[0];
			} elseif ( 'type' === $method && isset( $args[0] ) ) {
				$type = $args[0];
			} elseif ( 'defaultValue' === $method && array_key_exists( 0, $args ) ) {
				$default = $args[0];
			} elseif ( 'properties' === $method && ! empty( $args[0] ) && is_array( $args[0] ) ) {
				$properties = array_merge( $properties, $args[0] );
			} elseif ( 'optionType' === $method && isset( $args[0] ) && in_array( $args[0], array( 'option', 'options' ), true ) ) {
				$storage = 'option';
			}
		}

		if ( is_string( $id ) && '' !== $id ) {
			OptionSchema::record( $id, $type, $default, ! empty( $properties['save_as_json'] ) && is_bool( $properties['save_as_json'] ), $storage );
		}

	}

}
