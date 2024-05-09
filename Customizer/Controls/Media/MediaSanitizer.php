<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

class MediaSanitizer {

	/**
	 * Sanitize the media value.
	 *
	 * @param string               $value The value to sanitize.
	 * @param UploadUtil|ImageUtil $util The utility instance.
	 * @param string               $save_as The save as property.
	 *
	 * @return string|int|float|array
	 */
	public function sanitize( $value, $util, $save_as = 'url' ) {

		// The properties of $src here are already sanitized.
		$src = $util->unknownToSrcArray( $value );

		if ( ! empty( $save_as ) && is_string( $save_as ) ) {
			if ( in_array( $save_as, $util->allowed_save_as, true ) ) {
				$save_as = $save_as;
			}
		}

		if ( 'array' === $save_as ) {
			return $src;
		}

		if ( 'id' === $save_as ) {
			return $src['id'];
		}

		return $src['url'];

	}

}
