<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography\Entities;

final class GoogleFontsData {

	/**
	 * List of `GoogleFontItemEntity` instances.
	 *
	 * @var GoogleFontEntity[]
	 */
	public $items;

	/**
	 * Instance of `GoogleFontsOrderEntity`.
	 *
	 * @var GoogleFontsOrderEntity
	 */
	public $order;

	/**
	 * Create a new instance of `GoogleFontsData` from an array.
	 *
	 * @param array $arr The array to create the instance from.
	 * @return self
	 */
	public static function fromArray( $arr ) {

		$items = [];

		foreach ( $arr['items'] as $item ) {
			if ( ! is_array( $item ) || empty( $item ) ) {
				continue;
			}

			$items[] = GoogleFontEntity::fromArray( $item );
		}

		$order = isset( $arr['order'] ) && is_array( $arr['order'] ) ? $arr['order'] : [];

		$instance = new self();

		$instance->items = $items;
		$instance->order = GoogleFontsOrderEntity::fromArray( $order );

		return $instance;

	}

	/**
	 * Convert the instance to an array.
	 *
	 * @return array
	 */
	public function toArray() {

		$items = [];

		foreach ( $this->items as $item ) {
			$items[] = $item->toArray();
		}

		return [
			'items' => $items,
			'order' => $this->order->toArray(),
		];

	}

}
