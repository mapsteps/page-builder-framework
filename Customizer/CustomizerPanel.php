<?php
/**
 * What wpbf_customizer_panel() returns: records every call, builds nothing until the Customizer registers.
 *
 * Keeps every method name and argument format (Premium and child themes rely on them). On customize_register the
 * recorded calls are replayed, in order, on a PanelRegistrar, which does the actual work (see Registry).
 *
 * @package Page Builder Framework
 */

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.Found -- The arguments are recorded with func_get_args(), so calls without optional ones replay the same.

use Mapsteps\Wpbf\Customizer\Registry\PanelRegistrar;
use Mapsteps\Wpbf\Customizer\Registry\Registry;

/**
 * Records a Customizer panel.
 */
final class CustomizerPanel {

	/**
	 * The recorded calls: [ method, arguments ].
	 *
	 * @var array[]
	 */
	private $calls = array();

	/**
	 * Set the panel id.
	 *
	 * @param string $id Panel id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the panel parent id.
	 *
	 * @param string $id Panel parent id.
	 *
	 * @return $this
	 */
	public function parentId( $id ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the panel type.
	 *
	 * @param string $type Panel type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the panel priority.
	 *
	 * @param int $priority Panel priority.
	 *
	 * @return $this
	 */
	public function priority( $priority ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the panel capability.
	 *
	 * @param string $capability Panel capability.
	 *
	 * @return $this
	 */
	public function capability( $capability ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the panel title.
	 *
	 * @param string $title Panel title.
	 *
	 * @return $this
	 */
	public function title( $title ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the panel description.
	 *
	 * @param string $description Panel description.
	 *
	 * @return $this
	 */
	public function description( $description ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Set the panel active callback.
	 *
	 * Callback will be called with one parameter which is the instance of WP_Customize_Panel.
	 * It should return boolean to indicate whether the section is active or not.
	 *
	 * @param callable $active_callback Panel active callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		return $this->record( __FUNCTION__, func_get_args() );

	}

	/**
	 * Add the panel to the singleton.
	 *
	 * Recorded like every other call; the panel is built when the Customizer registers.
	 *
	 * @return $this
	 */
	public function add() {

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
	 * Hand the recorded calls to the registry: replayed on a PanelRegistrar when the Customizer registers.
	 *
	 * @return $this
	 */
	private function submit() {

		$calls = $this->calls;

		Registry::add(
			function () use ( $calls ) {
				$registrar = new PanelRegistrar();

				foreach ( $calls as $call ) {
					call_user_func_array( array( $registrar, $call[0] ), $call[1] );
				}
			}
		);

		return $this;

	}

}
