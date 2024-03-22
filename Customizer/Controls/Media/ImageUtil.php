<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

class ImageUtil extends UploadUtil {

	/**
	 * Make sure the image source array is properly formatted.
	 *
	 * @param array $src The image source data.
	 * @return array
	 */
	public function properlyFormatSrcArray( $src ) {

		return [
			'id'     => isset( $src['id'] ) ? absint( $src ['id'] ) : 0,
			'url'    => isset( $src['url'] ) && is_string( $src['url'] ) ? esc_url_raw( $src ['url'] ) : '',
			'width'  => isset( $src['width'] ) && is_numeric( $src['width'] ) ? absint( $src['width'] ) : 0,
			'height' => isset( $src['height'] ) && is_numeric( $src['height'] ) ? absint( $src['height'] ) : 0,
		];

	}

	/**
	 * Convert image id to source array.
	 *
	 * @param int|string  $id ID of the image.
	 * @param string|null $url URL of the image.
	 *
	 * @return array
	 */
	public function idToSrcArray( $id, $url = null ) {

		if ( ! is_numeric( $id ) ) {
			return $this->makeEmptySrcArray();
		}

		$id  = absint( $id );
		$src = wp_get_attachment_image_src( $id, 'full' );

		if ( ! $src ) {
			return $this->makeEmptySrcArray();
		}

		return [
			'id'     => $id,
			'url'    => isset( $src[0] ) ? esc_url_raw( $src[0] ) : '',
			'width'  => isset( $src[1] ) ? absint( $src[1] ) : 0,
			'height' => isset( $src[2] ) ? absint( $src[2] ) : 0,
		];

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
