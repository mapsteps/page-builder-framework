<?php

namespace Kirki\Pro\Field;

if ( class_exists( '\Kirki' ) ) {
	return;
}

class Headline {

	/**
	 * Headline field constructor.
	 *
	 * @param array $field_args The field arguments.
	 */
	public function __construct( $field_args = [] ) {

		$field_args['type'] = 'headline';

	}

}
