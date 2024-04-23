<?php

if ( class_exists( '\Kirki' ) ) {
	return;
}

namespace Kirki\Pro\Field;

class Headline {

	public function __construct( $field_args = [] ) {

		$field_args['type'] = 'headline';

	}

}