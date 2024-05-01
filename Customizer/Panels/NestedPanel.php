<?php

namespace Mapsteps\Wpbf\Customizer\Panels;

use WP_Customize_Manager;
use WP_Customize_Panel;

class NestedPanel extends WP_Customize_Panel {

	/**
	 * Type of this panel.
	 *
	 * @var string
	 */
	public $type = 'wpbf-nested';

	/**
	 * Parent panel id.
	 *
	 * @var string
	 */
	public $parent_id = '';

	/**
	 * NestedPanel constructor.
	 *
	 * @param WP_Customize_Manager $manager The customizer manager object.
	 * @param string               $id      The panel ID.
	 * @param array                $args    Optional. Array of properties for the new Panel object. Default empty array.
	 */
	public function __construct( $manager, $id, $args = array() ) {

		parent::__construct( $manager, $id, $args );

		if ( ! empty( $args['parent_id'] ) && is_string( $args['parent_id'] ) ) {
			$this->parent_id = $args['parent_id'];
		}

	}

	/**
	 * Gather the parameters passed to client JavaScript via JSON.
	 *
	 * @since 4.1.0
	 *
	 * @return array The array to be exported to the client as JSON.
	 */
	public function json() {

		$arr = parent::json();

		$arr['parentId'] = $this->parent_id;

		return $arr;

	}

}
