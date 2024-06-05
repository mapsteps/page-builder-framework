<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography\Entities;

final class GoogleFontEntity {

	/**
	 * The font family.
	 *
	 * @var string
	 */
	public $family;

	/**
	 * The font category.
	 *
	 * @var string
	 */
	public $category;

	/**
	 * List of variant variants (they keys, not the labels).
	 *
	 * @var string[]
	 */
	public $variants;

	/**
	 * Create a new instance of `GoogleFontEntity` from an array.
	 *
	 * @param array $arr The array to create the instance from.
	 * @return self
	 */
	public static function fromArray( $arr ) {

		$instance = new self();

		$instance->family   = isset( $arr['family'] ) ? $arr['family'] : '';
		$instance->category = isset( $arr['category'] ) ? $arr['category'] : '';
		$instance->variants = isset( $arr['variants'] ) ? $arr['variants'] : [];

		return $instance;

	}

	/**
	 * Convert the instance to an array.
	 *
	 * @return array
	 */
	public function toArray() {

		return [
			'family'   => $this->family,
			'category' => $this->category,
			'variants' => $this->variants,
		];

	}

}
