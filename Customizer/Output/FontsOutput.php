<?php

namespace Mapsteps\Wpbf\Customizer\Output;

use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsStore;
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

		$google_fonts_to_download = $this->googleFontsToDownload();

		if ( ! empty( $google_fonts_to_download ) ) {
			( new GoogleFontsDownload() )->download( $google_fonts_to_download );
		}

		$downloaded_google_fonts_css = get_option( 'wpbf_downloaded_google_fonts_stylesheet', '' );

		if ( empty( $downloaded_google_fonts_css ) ) {
			return;
		}

		?>

		<style class="wpbf-google-fonts">
			<?php echo wp_kses_post( $downloaded_google_fonts_css ); ?>
		</style>

		<?php

	}

	/**
	 * Collect Google Fonts used by the theme that are not already downloaded.
	 *
	 * @return array Associative array of font-family as the key and array of variants as the value.
	 */
	private function googleFontsToDownload() {

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

		$google_fonts_to_download = [];

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

			if ( ! isset( $google_fonts_to_download[ $google_font_family ] ) ) {
				$google_fonts_to_download[ $google_font_family ] = [];
			}

			$font_variant = isset( $value['variant'] ) ? (string) $value['variant'] : null;

			if ( ! $font_variant ) {
				continue;
			}

			if ( ! isset( FontsStore::$complete_font_variants[ $font_variant ] ) ) {
				continue;
			}

			if ( ! in_array( $font_variant, $google_fonts_to_download[ $google_font_family ], true ) ) {
				$google_fonts_to_download[ $google_font_family ][] = (string) $font_variant;
			}
		}

		$downloaded_fonts = get_option( 'wpbf_downloaded_google_fonts', [] );

		if ( empty( $downloaded_fonts ) ) {
			return $google_fonts_to_download;
		}

		foreach ( $google_fonts_to_download as $google_font_family => $google_font_variants ) {
			if ( isset( $downloaded_fonts[ $google_font_family ] ) ) {
				$downloaded_variants = $downloaded_fonts[ $google_font_family ];

				if ( in_array( $font_variant, $downloaded_variants, true ) ) {
					$google_fonts_to_download[ $google_font_family ] = array_diff( $google_fonts_to_download[ $google_font_family ], [ $font_variant ] );
				}
			}

			if ( empty( $google_fonts_to_download[ $google_font_family ] ) ) {
				unset( $google_fonts_to_download[ $google_font_family ] );
			}
		}

		return $google_fonts_to_download;

	}

}
