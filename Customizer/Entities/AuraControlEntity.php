<?php
/**
 * Aura customizer's control entity.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer\Entities;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * The properties of an Aura customizer's control.
 */
class AuraControlEntity {

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Control setting.
	 *
	 * @var string
	 */
	public $setting;

	/**
	 * Control label.
	 *
	 * @var string
	 */
	public $label = '';

	/**
	 * Control description.
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Control transport. Accepts 'refresh', 'selective_refresh' or 'postMessage'.
	 *
	 * @var string
	 */
	public $transport = 'refresh';

	/**
	 * Control priority.
	 *
	 * @var int
	 */
	public $priority = 0;

	/**
	 * Control section id.
	 *
	 * @var string
	 */
	public $section_id;

	/**
	 * Control choices.
	 *
	 * @var array
	 */
	public $choices = array();

	/**
	 * Control input_attrs.
	 *
	 * @var array
	 */
	public $input_attrs = array();


	/**
	 * Control active_callback.
	 *
	 * @var string
	 */
	public $active_callback = '';

	/**
	 * Control sanitize_callback.
	 *
	 * @var string
	 */
	public $sanitize_callback = '';

	/**
	 * Control sanitize_js_callback.
	 *
	 * @var string
	 */
	public $sanitize_js_callback = '';

	/**
	 * Control json.
	 *
	 * @var string
	 */
	public $json = '';
}
