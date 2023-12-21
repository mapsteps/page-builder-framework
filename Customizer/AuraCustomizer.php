<?php
/**
 * Aura customizer.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Singleton class for Aura customizer.
 */
class AuraCustomizer {

	/**
	 * Instance of the class.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Option type.
	 *
	 * @var string
	 */
	public static $option_type = 'theme_mod';

	/**
	 * Capability.
	 *
	 * @var string
	 */
	public static $capability = 'edit_theme_options';

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public static function init() {

		if ( ! self::$instance ) {
			self::$instance = new self();
			self::$instance->setup();
		}

	}

	/**
	 * Setup hooks.
	 */
	private function setup() {

		//

	}

}
