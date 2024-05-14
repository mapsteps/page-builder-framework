<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

class UploadUtil {

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
	 * Make sure the file source array is properly formatted.
	 *
	 * @param array $src The file source data.
	 * @return array
	 */
	public function properlyFormatSrcArray( $src ) {

		return [
			'id'       => isset( $src['id'] ) ? absint( $src ['id'] ) : 0,
			'url'      => isset( $src['url'] ) && is_string( $src['url'] ) ? esc_url_raw( $src ['url'] ) : '',
			'filename' => isset( $src['filename'] ) && is_string( $src['filename'] ) ? sanitize_file_name( $src['filename'] ) : '',
		];

	}

	/**
	 * Convert file/image URL to source array.
	 *
	 * @param string $url URL of the file/image.
	 * @return array
	 */
	public function urlToSrcArray( $url ) {

		if ( ! is_string( $url ) ) {
			return $this->makeEmptySrcArray();
		}

		$id = attachment_url_to_postid( $url );

		if ( ! $id ) {
			return $this->makeEmptySrcArray();
		}

		return $this->idToSrcArray( $id, $url );

	}

	/**
	 * Convert file id to source array.
	 *
	 * @param int|string  $id ID of the file.
	 * @param string|null $url URL of the file.
	 *
	 * @return array
	 */
	public function idToSrcArray( $id, $url = null ) {

		if ( ! is_numeric( $id ) ) {
			return $this->makeEmptySrcArray();
		}

		$id       = absint( $id );
		$filepath = get_attached_file( $id );

		if ( ! $filepath ) {
			return $this->makeEmptySrcArray();
		}

		$url = is_null( $url ) ? wp_get_attachment_url( $id ) : $url;
		$url = $url ?: '';

		return [
			'id'       => $id,
			'url'      => esc_url_raw( $url ),
			'filename' => sanitize_file_name( basename( $filepath ) ),
		];

	}

	/**
	 * Convert an unknown-type value to file/image source array.
	 *
	 * @param mixed $value The value to convert.
	 * @return array
	 */
	public function unknownToSrcArray( $value ) {

		$src = $this->makeEmptySrcArray();

		if ( is_numeric( $value ) ) {
			$src = $this->idToSrcArray( $value );
		} elseif ( is_string( $value ) && ! is_numeric( $value ) ) {
			$src = $this->urlToSrcArray( $value );
		} elseif ( is_array( $value ) ) {
			$src = $this->properlyFormatSrcArray( $value );
		}

		return $src;

	}

	/**
	 * Make empty file source array.
	 */
	public function makeEmptySrcArray() {

		return [
			'id'       => 0,
			'url'      => '',
			'filename' => '',
		];

	}

}
