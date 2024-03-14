<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

class ImageUtil {

	/**
	 * Make sure the array is properly formatted.
	 *
	 * @param array $image_src The image source.
	 * @return array
	 */
	public function properlyFormatArray( $image_src ) {

		return [
			'id'     => isset( $image_src['id'] ) ? absint( $image_src ['id'] ) : 0,
			'url'    => isset( $image_src['url'] ) && is_string( $image_src['url'] ) ? esc_url_raw( $image_src ['url'] ) : '',
			'width'  => isset( $image_src['width'] ) && is_numeric( $image_src['width'] ) ? absint( $image_src['width'] ) : 0,
			'height' => isset( $image_src['height'] ) && is_numeric( $image_src['height'] ) ? absint( $image_src['height'] ) : 0,
		];

	}

	/**
	 * Convert image URL to image source array.
	 *
	 * @param string $image_url URL of the image.
	 * @return array
	 */
	public function urlToArray( $image_url ) {

		if ( ! is_string( $image_url ) ) {
			return $this->makeEmptySrcArray();
		}

		$image_id = attachment_url_to_postid( $image_url );

		if ( ! $image_id ) {
			return $this->makeEmptySrcArray();
		}

		return $this->idToArray( $image_id );

	}

	/**
	 * Convert image id to image source array.
	 *
	 * @param int|string $image_id ID of the image.
	 * @return array
	 */
	public function idToArray( $image_id ) {

		if ( ! is_numeric( $image_id ) ) {
			return $this->makeEmptySrcArray();
		}

		$image_src = wp_get_attachment_image_src( absint( $image_id ), 'full' );

		if ( ! $image_src ) {
			return $this->makeEmptySrcArray();
		}

		return [
			'id'     => $image_id,
			'url'    => isset( $image_src[0] ) ? $image_src[0] : '',
			'width'  => isset( $image_src[1] ) ? $image_src[1] : 0,
			'height' => isset( $image_src[2] ) ? $image_src[2] : 0,
		];

	}

	/**
	 * Convert an unknown-type value to image src.
	 *
	 * @param mixed $value The value to convert.
	 * @return array
	 */
	public function unknownToArray( $value ) {

		$image_src = $this->makeEmptySrcArray();

		if ( is_string( $value ) ) {
			$image_src = $this->urlToArray( $value );
		} elseif ( is_numeric( $value ) ) {
			$image_src = $this->idToArray( $value );
		} elseif ( is_array( $value ) ) {
			$image_src = $this->properlyFormatArray( $value );
		}

		return $image_src;

	}

	/**
	 * Make empty image source array.
	 */
	public function makeEmptySrcArray() {

		return [
			'id'     => 0,
			'url'    => '',
			'width'  => 0,
			'height' => 0,
		];

	}

}
