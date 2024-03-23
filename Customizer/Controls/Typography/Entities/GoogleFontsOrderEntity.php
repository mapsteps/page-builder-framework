<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography\Entities;

final class GoogleFontsOrderEntity {

	/**
	 * List of font families based on alphabetical order.
	 *
	 * @var string[]
	 */
	public $alpha;

	/**
	 * List of font families based on popularity.
	 *
	 * @var string[]
	 */
	public $popularity;

	/**
	 * List of font families based on trending.
	 *
	 * @var string[]
	 */
	public $trending;

	/**
	 * Create a new instance of `GoogleFontsOrderEntity` from an array.
	 *
	 * @param array $arr The array to create the instance from.
	 * @return self
	 */
	public static function fromArray( $arr ) {

		$instance = new self();

		$instance->alpha      = isset( $arr['alpha'] ) ? $arr['alpha'] : [];
		$instance->popularity = isset( $arr['popularity'] ) ? $arr['popularity'] : [];
		$instance->trending   = isset( $arr['trending'] ) ? $arr['trending'] : [];

		return $instance;

	}

	/**
	 * Convert the instance to an array.
	 *
	 * @return array
	 */
	public function toArray() {

		return [
			'alpha'      => $this->alpha,
			'popularity' => $this->popularity,
			'trending'   => $this->trending,
		];

	}

}
