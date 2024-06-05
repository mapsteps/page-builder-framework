<?php

namespace Mapsteps\Wpbf\Customizer\Output;

use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsStore;
use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsUtil;
use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyStore;
use Mapsteps\Wpbf\Customizer\CustomizerStore;

class FontsOutput {

	/**
	 * Initialize the class, setup hooks.
	 */
	public function init() {

		add_action( 'wp_head', [ $this, 'inlineGoogleFontsCss' ], 5 );

	}

	/**
	 * Output the inline Google Fonts CSS.
	 */
	public function inlineGoogleFontsCss() {

		/**
		 * An associative array of Google fonts to use in frontend.
		 *
		 * The key will be the font-family name and value will be
		 * an associative array of variants to use and their CSS content.
		 *
		 * @var array
		 */
		$google_fonts_to_use = $this->googleFontsToUse();

		/**
		 * An associative array of Google fonts to download.
		 *
		 * The key will be the font-family name and value will be variants to download.
		 *
		 * @var array
		 */
		$google_fonts_to_download = [];

		foreach ( $google_fonts_to_use as $google_font_family => $google_font_variants ) {
			foreach ( $google_font_variants as $google_font_variant => $css_content ) {
				if ( empty( $css_content ) ) {
					$google_fonts_to_download[ $google_font_family ][] = $google_font_variant;
				}
			}
		}

		if ( ! empty( $google_fonts_to_download ) ) {
			( new GoogleFontsDownload() )->download( $google_fonts_to_download );

			foreach ( $google_fonts_to_use as $google_font_family => $google_font_variants ) {
				if ( ! isset( $google_fonts_to_download[ $google_font_family ] ) ) {
					continue;
				}

				$downloaded_variants = $google_fonts_to_download[ $google_font_family ];

				$google_font_family_slug = ( new FontsUtil() )->slugifyFontFamily( $google_font_family );

				foreach ( $google_font_variants as $google_font_variant => $css_content ) {
					if ( ! in_array( $google_font_variant, $downloaded_variants, true ) ) {
						continue;
					}

					$variant_name = '400' === $google_font_variant ? 'regular' : $google_font_variant;

					$font_face_declarations = get_option( 'wpbf_downloaded_google_fonts_css_' . $google_font_family_slug . '_' . $variant_name, '' );

					$google_fonts_to_use[ $google_font_family ][ $google_font_variant ] = $font_face_declarations;
				}
			}
		}

		$google_fonts_css_to_print = '';

		foreach ( $google_fonts_to_use as $google_font_family => $google_font_variants ) {
			foreach ( $google_font_variants as $google_font_variant => $css_content ) {
				if ( empty( $css_content ) ) {
					continue;
				}

				$google_fonts_css_to_print .= $css_content;
			}
		}

		if ( empty( $google_fonts_css_to_print ) ) {
			return;
		}
		?>

		<style class="wpbf-google-fonts">
			<?php echo wp_kses_post( $google_fonts_css_to_print ); ?>
		</style>

		<?php

	}

	/**
	 * Collect Google Fonts used by the theme that are not already downloaded.
	 *
	 * @return array Associative array of font-family as the key and associative array of variants to use and their CSS content.
	 */
	private function googleFontsToUse() {

		$control_ids    = TypographyStore::$added_control_ids;
		$control_values = [];

		foreach ( $control_ids as $control_id ) {
			$setting_entity = CustomizerStore::findSettingByControlId( $control_id );

			if ( ! $setting_entity ) {
				continue;
			}

			$value = 'theme_mod' === $setting_entity->type ? get_theme_mod( $setting_entity->id ) : get_option( $setting_entity->id );

			if ( ! $value ) {
				continue;
			}

			$control_values[ $setting_entity->id ] = $value;
		}

		/**
		 * An associative array of Google fonts to use in frontend.
		 *
		 * The key will be the font-family name and value will be
		 * an associative array of variants to use and their CSS content.
		 *
		 * @var array
		 */
		$google_fonts_to_use = [];

		foreach ( $control_values as $control_id => $value ) {
			if ( ! $value || ! is_array( $value ) ) {
				continue;
			}

			$google_font_family = ! empty( $value['font-family'] ) ? $value['font-family'] : null;

			if ( ! $google_font_family ) {
				continue;
			}

			if ( ! isset( FontsStore::$google_fonts[ $google_font_family ] ) ) {
				continue;
			}

			if ( ! isset( $google_fonts_to_use[ $google_font_family ] ) ) {
				$google_fonts_to_use[ $google_font_family ] = [];
			}

			$font_variant = isset( $value['variant'] ) ? (string) $value['variant'] : null;

			if ( ! $font_variant ) {
				continue;
			}

			if ( ! isset( FontsStore::$complete_font_variants[ $font_variant ] ) ) {
				continue;
			}

			if ( ! in_array( $font_variant, $google_fonts_to_use[ $google_font_family ], true ) ) {
				$google_fonts_to_use[ $google_font_family ][ $font_variant ] = '';
			}
		}

		foreach ( $google_fonts_to_use as $google_font_family => $google_font_variants ) {
			$google_font_family_slug = ( new FontsUtil() )->slugifyFontFamily( $google_font_family );

			foreach ( $google_font_variants as $google_font_variant => $empty_css_content ) {
				$variant_name = '400' === $google_font_variant ? 'regular' : $google_font_variant;
				$css_content  = get_option( 'wpbf_downloaded_google_fonts_css_' . $google_font_family_slug . '_' . $variant_name, '' );

				$google_fonts_to_use[ $google_font_family ][ $google_font_variant ] = $css_content;
			}
		}

		return $google_fonts_to_use;

	}

}
