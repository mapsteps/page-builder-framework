<?php
/**
 * Customizer registry: builds the Customizer only when the Customizer runs.
 *
 * Calls to wpbf_customizer_field() / section() / panel() (the theme's, Premium's on after_setup_theme, child themes',
 * the Kirki layer's) only record what they declare and hand themselves to add(). On every other request nothing
 * more happens: no setting/control/section objects, no font list. When WordPress fires `customize_register`, build()
 * turns everything into the registry (CustomizerStore) in the order it was declared, so the Customizer is exactly
 * what it was when every call built it on the spot. From then on new calls are built right away.
 *
 * Code that loads its settings files only for the Customizer adds a job that requires them, at the moment it used
 * to load them, which keeps the order.
 *
 * @package Page Builder Framework
 */

namespace Mapsteps\Wpbf\Customizer\Registry;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Registry.
 */
final class Registry {

	/**
	 * Jobs waiting for the Customizer, in the order they were added.
	 *
	 * @var callable[]
	 */
	private static $jobs = array();

	/**
	 * Whether build() has started. From then on jobs run right away.
	 *
	 * @var bool
	 */
	private static $built = false;

	/**
	 * Add a job: run it when the Customizer registers, or right away if it already does.
	 *
	 * @param callable $job The job.
	 */
	public static function add( $job ) {

		if ( self::$built ) {
			call_user_func( $job );
			return;
		}

		self::$jobs[] = $job;

	}

	/**
	 * Run every waiting job, in order. Hooked to `customize_register` (priority 1).
	 */
	public static function build() {

		if ( self::$built ) {
			return;
		}

		self::$built = true;

		$jobs       = self::$jobs;
		self::$jobs = array();

		foreach ( $jobs as $job ) {
			call_user_func( $job );
		}

	}

}
