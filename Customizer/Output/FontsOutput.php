<?php

namespace Mapsteps\Wpbf\Customizer\Output;

use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsStore;
use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsUtil;
use Mapsteps\Wpbf\Customizer\Schema\OptionSchema;

class FontsOutput {

	/**
	 * FontsUtil instance.
	 *
	 * @var FontsUtil
	 */
	private $fonts_util;

	/**
	 * Minimum required fonts system version.
	 *
	 * If the saved option value is lower than this, we will force clear the font cache.
	 * This fonts system version is not tied to the theme version.
	 *
	 * @var string
	 */
	private $min_fonts_system_version = '2.11.0.8';

	/**
	 * The option listing fonts whose download failed, with the time of their next try.
	 *
	 * @var string
	 */
	const FAILED_OPTION = 'wpbf_google_fonts_failed';

	/**
	 * The font variants a typography option can hold (the keys of FontsStore's complete variants).
	 *
	 * @var string[]
	 */
	const FONT_VARIANTS = array( 'regular', 'italic', '100', '100italic', '200', '200italic', '300', '300italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic' );

	/**
	 * Whether font families are Google fonts, by family.
	 *
	 * @var bool[]
	 */
	private $is_google_font = array();

	/**
	 * `FontsOutput` constructor.
	 */
	public function __construct() {

		$this->fonts_util = new FontsUtil();

	}

	/**
	 * Initialize the class, setup hooks.
	 */
	public function init() {

		add_action( 'init', [ $this, 'maybeClearFontCache' ] );
		add_action( 'wp_head', [ $this, 'inlineGoogleFontsCss' ], 5 );

	}

	/**
	 * Clear the font cache if fonts system version is lower than the minimum required version.
	 */
	public function maybeClearFontCache() {

		$fonts_system_version = get_option( 'wpbf_fonts_system_version' );

		if ( empty( $fonts_system_version ) ) {
			$this->fonts_util->clearDownloadedGoogleFonts();
			update_option( 'wpbf_fonts_system_version', $this->min_fonts_system_version );
			return;
		}

		if ( version_compare( $fonts_system_version, $this->min_fonts_system_version, '<' ) ) {
			$this->fonts_util->clearDownloadedGoogleFonts();
			update_option( 'wpbf_fonts_system_version', $this->min_fonts_system_version );
		}

	}

	/**
	 * Generate Google Fonts CSS.
	 *
	 * Fonts that aren't downloaded yet are downloaded only when $download is true (cache refresh on cron, Customizer
	 * preview). Otherwise a refresh is scheduled for them. Fonts whose download failed are retried after a pause that
	 * grows with each failure (see FAILED_OPTION).
	 *
	 * @param bool $download Whether missing fonts may be downloaded now.
	 *
	 * @return string
	 */
	public function generateGoogleFontsCss( $download = true ) {

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

		$existing_downloaded_css = $this->fonts_util->getDownloadedGoogleFontsCss();

		$google_fonts_to_download = $this->withoutPausedFonts( $google_fonts_to_download );

		if ( ! empty( $google_fonts_to_download ) && ! $download ) {
			CustomizerCss::scheduleRefresh();
			$google_fonts_to_download = [];
		}

		if ( ! empty( $google_fonts_to_download ) ) {
			( new GoogleFontsDownload() )->download( $google_fonts_to_download );
			$this->recordFailures( $google_fonts_to_download );

			// Get the updated downloaded CSS.
			$existing_downloaded_css = $this->fonts_util->getDownloadedGoogleFontsCss();

			foreach ( $google_fonts_to_use as $google_font_family => $google_font_variants ) {
				if ( ! isset( $google_fonts_to_download[ $google_font_family ] ) ) {
					continue;
				}

				$downloaded_variants = $google_fonts_to_download[ $google_font_family ];

				$google_font_family_slug = $this->fonts_util->slugifyFontFamily( $google_font_family );

				foreach ( $google_font_variants as $google_font_variant => $css_content ) {
					if ( ! in_array( $google_font_variant, $downloaded_variants, true ) ) {
						continue;
					}

					$variant_name   = '400' === $google_font_variant ? 'regular' : $google_font_variant;
					$sub_option_key = $google_font_family_slug . '_' . $variant_name;

					$font_face_declarations = isset( $existing_downloaded_css[ $sub_option_key ] ) ? $existing_downloaded_css[ $sub_option_key ] : '';

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

		return $this->schemeRelativeFontUrls( $google_fonts_css_to_print );

	}

	/**
	 * Make the local font file URLs scheme-relative (//example.com/wp-content/fonts/...).
	 *
	 * The stored @font-face rules carry the scheme of the request that downloaded them. Since downloads run on cron, that
	 * can be http on an https site (a server cron), and browsers refuse to load http fonts on https pages.
	 *
	 * @param string $css The Google Fonts CSS.
	 *
	 * @return string
	 */
	private function schemeRelativeFontUrls( $css ) {

		$fonts_url = content_url( '/fonts' );

		return str_replace(
			array( set_url_scheme( $fonts_url, 'https' ), set_url_scheme( $fonts_url, 'http' ) ),
			preg_replace( '#^https?:#i', '', $fonts_url ),
			$css
		);

	}

	/**
	 * Output the generated Google Fonts CSS as inline CSS.
	 */
	public function inlineGoogleFontsCss() {

		// The preview shows unsaved choices: built live. Page views use the cache.
		$css = CustomizerCss::enabled() ? CustomizerCss::current()['fonts'] : wpbf_minify_css( $this->generateGoogleFontsCss() );

		if ( '' === $css ) {
			return;
		}

		?>
		<style class="wpbf-google-fonts"><?php echo $css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Font-face rules built from Google's stylesheet. ?></style>
		<?php

	}

	/**
	 * Leave out fonts whose download failed recently.
	 *
	 * @param array $font_families Font family => variants to download.
	 *
	 * @return array The fonts that may be downloaded now.
	 */
	private function withoutPausedFonts( $font_families ) {

		$failed = $this->failedFonts();

		foreach ( $font_families as $font_family => $variants ) {
			foreach ( $variants as $i => $variant ) {
				$key = $this->fontKey( $font_family, $variant );

				if ( isset( $failed[ $key ]['next'] ) && $failed[ $key ]['next'] > time() ) {
					unset( $font_families[ $font_family ][ $i ] );
				}
			}

			if ( empty( $font_families[ $font_family ] ) ) {
				unset( $font_families[ $font_family ] );
			} else {
				$font_families[ $font_family ] = array_values( $font_families[ $font_family ] );
			}
		}

		return $font_families;

	}

	/**
	 * After a download, remember which fonts failed and when to try them again (1 hour, then 4 times longer each time,
	 * at most a week), and schedule that retry. Fonts that arrived are forgotten.
	 *
	 * @param array $font_families Font family => variants that were downloaded.
	 */
	private function recordFailures( $font_families ) {

		$downloaded = $this->fonts_util->getDownloadedGoogleFontsCss();
		$failed     = $this->failedFonts();
		$before     = $failed;

		foreach ( $font_families as $font_family => $variants ) {
			$slug = $this->fonts_util->slugifyFontFamily( $font_family );

			foreach ( $variants as $variant ) {
				$key          = $this->fontKey( $font_family, $variant );
				$variant_name = '400' === $variant ? 'regular' : $variant;

				if ( ! empty( $downloaded[ $slug . '_' . $variant_name ] ) ) {
					unset( $failed[ $key ] );
					continue;
				}

				$tries          = isset( $failed[ $key ]['tries'] ) ? (int) $failed[ $key ]['tries'] + 1 : 1;
				$failed[ $key ] = array(
					'tries' => $tries,
					'next'  => time() + min( WEEK_IN_SECONDS, HOUR_IN_SECONDS * pow( 4, min( $tries, 6 ) - 1 ) ),
				);
			}
		}

		if ( $failed !== $before ) {
			update_option( self::FAILED_OPTION, $failed, false );
		}

		if ( ! empty( $failed ) ) {
			CustomizerCss::scheduleRefresh( max( 0, min( wp_list_pluck( $failed, 'next' ) ) - time() ) );
		}

	}

	/**
	 * Fonts whose download failed: key => [ 'tries' => count, 'next' => timestamp of the next try ].
	 *
	 * @return array
	 */
	private function failedFonts() {

		$failed = get_option( self::FAILED_OPTION, array() );

		return is_array( $failed ) ? $failed : array();

	}

	/**
	 * The key of a font variant in the failure list.
	 *
	 * @param string $font_family The font family.
	 * @param string $variant The variant.
	 *
	 * @return string
	 */
	private function fontKey( $font_family, $variant ) {

		return $this->fonts_util->slugifyFontFamily( $font_family ) . '_' . ( '400' === $variant ? 'regular' : $variant );

	}

	/**
	 * Collect Google Fonts used by the theme that are not already downloaded.
	 *
	 * @return array Associative array of font-family as the key and associative array of variants to use and their CSS content.
	 */
	private function googleFontsToUse() {

		// Typography options: the theme's from the schema, others' (child themes, plugins) as their fields declared them.
		$control_values = [];

		foreach ( OptionSchema::ofType( 'typography' ) as $option_id => $entry ) {
			$value = isset( $entry['storage'] ) && 'option' === $entry['storage'] ? get_option( $option_id ) : get_theme_mod( $option_id );

			if ( ! $value ) {
				continue;
			}

			$control_values[ $option_id ] = $value;
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

			if ( ! $this->isGoogleFont( $google_font_family ) ) {
				continue;
			}

			if ( ! isset( $google_fonts_to_use[ $google_font_family ] ) ) {
				$google_fonts_to_use[ $google_font_family ] = [];
			}

			$font_variant = isset( $value['variant'] ) ? (string) $value['variant'] : null;

			if ( ! $font_variant ) {
				continue;
			}

			if ( ! in_array( $font_variant, self::FONT_VARIANTS, true ) ) {
				continue;
			}

			if ( ! in_array( $font_variant, $google_fonts_to_use[ $google_font_family ], true ) ) {
				$google_fonts_to_use[ $google_font_family ][ $font_variant ] = '';
			}
		}

		$existing_downloaded_css = $this->fonts_util->getDownloadedGoogleFontsCss();

		foreach ( $google_fonts_to_use as $google_font_family => $google_font_variants ) {
			$google_font_family_slug = $this->fonts_util->slugifyFontFamily( $google_font_family );

			foreach ( $google_font_variants as $google_font_variant => $empty_css_content ) {
				$variant_name   = '400' === $google_font_variant ? 'regular' : $google_font_variant;
				$sub_option_key = $google_font_family_slug . '_' . $variant_name;
				$css_content    = isset( $existing_downloaded_css[ $sub_option_key ] ) ? $existing_downloaded_css[ $sub_option_key ] : '';

				$google_fonts_to_use[ $google_font_family ][ $google_font_variant ] = $css_content;
			}
		}

		return $google_fonts_to_use;

	}

	/**
	 * Whether a font family is a Google font.
	 *
	 * Avoids loading the Google font list (1,800 fonts) on page views: a family with downloaded CSS is one, a font stack
	 * (it has a comma) is not. Only other families (custom fonts, Google fonts not downloaded yet) need the list.
	 *
	 * @param string $font_family The font family.
	 *
	 * @return bool
	 */
	private function isGoogleFont( $font_family ) {

		if ( isset( $this->is_google_font[ $font_family ] ) ) {
			return $this->is_google_font[ $font_family ];
		}

		$prefix = $this->fonts_util->slugifyFontFamily( $font_family ) . '_';

		foreach ( array_keys( $this->fonts_util->getDownloadedGoogleFontsCss() ) as $key ) {
			if ( 0 === strpos( $key, $prefix ) ) {
				$this->is_google_font[ $font_family ] = true;

				return true;
			}
		}

		if ( false !== strpos( $font_family, ',' ) ) {
			$this->is_google_font[ $font_family ] = false;

			return false;
		}

		if ( ! FontsStore::initialized() ) {
			FontsStore::init();
		}

		$this->is_google_font[ $font_family ] = isset( FontsStore::$google_fonts[ $font_family ] );

		return $this->is_google_font[ $font_family ];

	}

}
