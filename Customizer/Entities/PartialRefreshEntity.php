<?php
/**
 * Wpbf partial refresh entity.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Entities;

/**
 * Entity object of a Wpbf partial refresh.
 *
 * @see https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/
 * @see https://developer.wordpress.org/reference/classes/WP_Customize_Selective_Refresh/add_partial/
 */
class PartialRefreshEntity {

	/**
	 * ID of the partial refresh. This is not the control or setting's ID.
	 *
	 * @var string
	 */
	public $id = '';

	/**
	 * The control ID that the partial refresh is associated with.
	 *
	 * @var string
	 */
	public $control_id = '';

	/**
	 * Whether the container element is included in the partial, or if only the contents are rendered.
	 *
	 * @var bool
	 */
	public $container_inclusive = false;

	/**
	 * The jQuery selector for the container element.
	 *
	 * @var string
	 */
	public $selector = '';

	/**
	 * An array of settings IDs that will refresh the partial when they change.
	 *
	 * @var array
	 */
	public $settings = array();

	/**
	 * Function that returns the content that will get rendered in the partial.
	 *
	 * @var callable
	 */
	public $render_callback = '';

}
