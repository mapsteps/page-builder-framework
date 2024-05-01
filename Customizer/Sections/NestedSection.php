<?php

namespace Mapsteps\Wpbf\Customizer\Sections;

use WP_Customize_Manager;
use WP_Customize_Section;

class NestedSection extends WP_Customize_Section {

	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = 'wpbf-nested';

	/**
	 * Parent section id.
	 *
	 * @var string
	 */
	public $parent_id = '';

	/**
	 * NestedSection constructor.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Array of properties for the new Control object. Default empty array.
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
