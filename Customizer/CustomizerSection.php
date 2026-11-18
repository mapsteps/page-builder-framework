<?php
/**
 * What wpbf_customizer_section() returns: records every call, builds nothing until the Customizer registers.
 *
 * Keeps every method name and argument format (Premium and child themes rely on them). On customize_register the
 * recorded calls are replayed, in order, on a SectionRegistrar, which does the actual work (see Registry).
 *
 * @package Page Builder Framework
 */

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.Found -- The arguments are recorded with func_get_args(), so calls without optional ones replay the same.

use Mapsteps\Wpbf\Customizer\Registry\SectionRegistrar;
use Mapsteps\Wpbf\Customizer\Registry\Registry;

/**
 * Records a Customizer section.
 */
final class CustomizerSection {

	/**
	 * The recorded calls: [ method, arguments ].
	 *
	 * @var array[]
	 */
	private $calls = array();

	/**
	 * Set the section id.
	 *
	 * @param string $id Section id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the section parent id.
	 *
	 * @param string $id Section parent id.
	 *
	 * @return $this
	 */
	public function parentId( $id ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the section priority.
	 *
	 * @param int $priority Section priority.
	 *
	 * @return $this
	 */
	public function priority( $priority ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the section capability.
	 *
	 * @param string $capability Section capability.
	 *
	 * @return $this
	 */
	public function capability( $capability ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the section type.
	 *
	 * @param string $type Section type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the section title.
	 *
	 * @param string $title Section title.
	 *
	 * @return $this
	 */
	public function title( $title ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the section description.
	 *
	 * @param string $description Section description.
	 *
	 * @return $this
	 */
	public function description( $description ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the section active callback.
	 *
	 * Callback will be called with one parameter which is the instance of WP_Customize_Section.
	 * It should return boolean to indicate whether the section is active or not.
	 *
	 * @param callable $active_callback Section active callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Define tabs for the section.
	 *
	 * @param array $tabs Tabs for the section.
	 *
	 * @return $this
	 */
	public function tabs( $tabs ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the control's custom_properties.
	 *
	 * @param array $properties Custom properties which are not provided by WP_Customize_Control by default.
	 *
	 * @return $this
	 */
	public function customProperties( $properties = array() ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Add the section without a panel.
	 *
	 * Recorded like every other call; the section is built when the Customizer registers.
	 *
	 * @return $this
	 */
	public function add() {

		$this->record( __FUNCTION__, func_get_args() );

		return $this->submit();

	}

	/**
	 * Add the section to a panel.
	 *
	 * Recorded like every other call; the section is built when the Customizer registers.
	 *
	 * @param string $panel_id Panel id.
	 *
	 * @return $this
	 */
	public function addToPanel( $panel_id ) {

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
	 * Hand the recorded calls to the registry: replayed on a SectionRegistrar when the Customizer registers.
	 *
	 * @return $this
	 */
	private function submit() {

		$calls = $this->calls;

		Registry::add(
			function () use ( $calls ) {
				$registrar = new SectionRegistrar();

				foreach ( $calls as $call ) {
					call_user_func_array( array( $registrar, $call[0] ), $call[1] );
				}
			}
		);

		return $this;

	}

}
