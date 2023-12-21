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
	 * Get the instance of the class.
	 *
	 * @return self
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Initialize the class, setup hooks.
	 *
	 * @return void
	 */
	public function init() {

		//

	}

}
