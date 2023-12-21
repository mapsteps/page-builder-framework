<?php
/**
 * Aura customizer's setting entity.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer\Entities;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Entity object of an Aura customizer's settings.
 *
 * @see https://developer.wordpress.org/reference/classes/WP_Customize_Setting/__construct/
 */
class AuraSettingEntity {

	/**
	 * A specific ID of the setting.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Setting type. Accepts 'theme_mod' or 'option'.
	 *
	 * @var string
	 */
	public $type = 'theme_mod';

	/**
	 * Capability required for the setting. Default is 'edit_theme_options'.
	 *
	 * @var string
	 */
	public $capability = 'edit_theme_options';

	/**
	 * Default value for the setting. Default is empty string.
	 *
	 * @var string
	 */
	public $default = '';

	/**
	 * Options for rendering the live preview of changes in Customizer.
	 * Accepts 'refresh', 'selective_refresh' or 'postMessage'. Default is 'refresh'.
	 *
	 * Using 'refresh' makes the change visible by reloading the whole preview.
	 * Using 'postMessage' allows a custom JavaScript to handle live changes.
	 *
	 * @var string
	 */
	public $transport = 'refresh';

	/**
	 * Server-side validation callback for the setting's value.
	 *
	 * @var callable
	 */
	public $validate_callback = '';

	/**
	 * Callback to filter a Customize setting value in un-slashed form.
	 *
	 * @var string
	 */
	public $sanitize_callback = '';

	/**
	 * Callback to convert a Customize PHP setting value to a value that is JSON serializable.
	 *
	 * @var callable
	 */
	public $sanitize_js_callback = '';

}
