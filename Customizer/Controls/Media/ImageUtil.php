<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

class ImageUtil {

	/**
	 * Allowed save_as value.
	 *
	 * @var string[]
	 */
	public $allowed_save_as = [ 'url', 'id', 'array' ];

	/**
	 * Default of the 'save_as' property.
	 *
	 * @var string
	 */
	public $default_save_as = 'url';

	/**
	 * Make sure the image source array is properly formatted.
	 *
	 * @param array $image_src The image source.
	 * @return array
	 */
	public function properlyFormatImageSrcArray( $image_src ) {

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
	public function imageUrlToSrcArray( $image_url ) {

		if ( ! is_string( $image_url ) ) {
			return $this->makeEmptyImageSrcArray();
		}

		$image_id = attachment_url_to_postid( $image_url );

		if ( ! $image_id ) {
			return $this->makeEmptyImageSrcArray();
		}

		return $this->imageIdToSrcArray( $image_id );

	}

	/**
	 * Convert image id to image source array.
	 *
	 * @param int|string $image_id ID of the image.
	 * @return array
	 */
	public function imageIdToSrcArray( $image_id ) {

		if ( ! is_numeric( $image_id ) ) {
			return $this->makeEmptyImageSrcArray();
		}

		$image_id  = absint( $image_id );
		$image_src = wp_get_attachment_image_src( $image_id, 'full' );

		if ( ! $image_src ) {
			return $this->makeEmptyImageSrcArray();
		}

		return [
			'id'     => $image_id,
			'url'    => isset( $image_src[0] ) ? esc_url_raw( $image_src[0] ) : '',
			'width'  => isset( $image_src[1] ) ? absint( $image_src[1] ) : 0,
			'height' => isset( $image_src[2] ) ? absint( $image_src[2] ) : 0,
		];

	}

	/**
	 * Convert an unknown-type value to image source array.
	 *
	 * @param mixed $value The value to convert.
	 * @return array
	 */
	public function unknownToImageSrcArray( $value ) {

		$image_src = $this->makeEmptyImageSrcArray();

		if ( is_string( $value ) ) {
			$image_src = $this->imageUrlToSrcArray( $value );
		} elseif ( is_numeric( $value ) ) {
			$image_src = $this->imageIdToSrcArray( $value );
		} elseif ( is_array( $value ) ) {
			$image_src = $this->properlyFormatImageSrcArray( $value );
		}

		return $image_src;

	}

	/**
	 * Make empty image source array.
	 */
	public function makeEmptyImageSrcArray() {

		return [
			'id'     => 0,
			'url'    => '',
			'width'  => 0,
			'height' => 0,
		];

	}

}
