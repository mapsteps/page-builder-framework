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

		return $this->schemeRelativeFontUrls( $this->mergeVariableFontWeights( $google_fonts_css_to_print ) );

	}

	/**
	 * Remove downloaded Google Fonts nothing uses any more (a font switched off or replaced): their stored CSS and their
	 * files. Runs before a cache refresh (CustomizerCss::refreshWithFonts()); a font picked again is downloaded again.
	 *
	 * Only files the theme downloaded go (the ones its stored CSS points to), so other fonts in wp-content/fonts (the
	 * WordPress Font Library's) stay. Not on multisite: the sites share that folder but each has its own font list.
	 */
	public function removeUnusedFonts() {

		if ( is_multisite() ) {
			return;
		}

		$stored = $this->fonts_util->getDownloadedGoogleFontsCss();

		if ( empty( $stored ) ) {
			return;
		}

		$in_use = array();

		foreach ( $this->googleFontsToUse() as $font_family => $variants ) {
			$slug = $this->fonts_util->slugifyFontFamily( $font_family );

			foreach ( array_keys( $variants ) as $variant ) {
				$in_use[ $slug . '_' . ( '400' === (string) $variant ? 'regular' : $variant ) ] = true;
			}
		}

		$kept    = array_intersect_key( $stored, $in_use );
		$removed = array_diff_key( $stored, $in_use );

		if ( empty( $removed ) ) {
			return;
		}

		// Files the kept fonts still use (a variable font shares one file across weights).
		$kept_files = array();

		foreach ( $kept as $css ) {
			foreach ( $this->fontFiles( $css ) as $file ) {
				$kept_files[ $file ] = true;
			}
		}

		$fonts_dir = wp_normalize_path( WP_CONTENT_DIR . '/fonts' );
		$dirs      = array();

		foreach ( $removed as $css ) {
			foreach ( $this->fontFiles( $css ) as $file ) {
				if ( isset( $kept_files[ $file ] ) ) {
					continue;
				}

				$path = wp_normalize_path( $fonts_dir . '/' . $file );

				// Only files inside wp-content/fonts/<family>/.
				if ( 0 !== strpos( $path, $fonts_dir . '/' ) || false !== strpos( $file, '..' ) ) {
					continue;
				}

				if ( is_file( $path ) ) {
					wp_delete_file( $path );
				}

				$dirs[ dirname( $path ) ] = true;
			}
		}

		// Family folders left empty.
		foreach ( array_keys( $dirs ) as $dir ) {
			if ( is_dir( $dir ) && ! ( new \FilesystemIterator( $dir ) )->valid() ) {
				rmdir( $dir ); // phpcs:ignore WordPress.WP.AlternativeFunctions -- An empty folder we created.
			}
		}

		update_option( 'wpbf_downloaded_google_fonts_css', $kept );

		// The list of downloaded families and variants, without the removed ones.
		$list = get_option( 'wpbf_downloaded_google_fonts', array() );

		if ( is_array( $list ) ) {
			foreach ( $list as $font_family => $variants ) {
				$slug                 = $this->fonts_util->slugifyFontFamily( $font_family );
				$list[ $font_family ] = array_values(
					array_filter(
						(array) $variants,
						function ( $variant ) use ( $slug, $kept ) {
							return isset( $kept[ $slug . '_' . $variant ] );
						}
					)
				);

				if ( empty( $list[ $font_family ] ) ) {
					unset( $list[ $font_family ] );
				}
			}

			update_option( 'wpbf_downloaded_google_fonts', $list );
		}

	}

	/**
	 * The font files a stored @font-face CSS points to, as "<family folder>/<file>" below wp-content/fonts.
	 *
	 * @param string $css The stored CSS of one font variant.
	 *
	 * @return string[]
	 */
	private function fontFiles( $css ) {

		preg_match_all( '#/fonts/([^/\s\'")]+/[^/\s\'")]+\.(?:woff2?|ttf|otf))#i', (string) $css, $matches );

		return array_unique( $matches[1] );

	}

	/**
	 * One @font-face rule per font file: variable fonts (Inter, Roboto, Open Sans ...) serve every weight from the same
	 * file, so Google's CSS repeats the rule per weight with only the weight changed. Rules that differ in nothing but
	 * the weight become one rule with a weight range ("font-weight: 400 700"). Static fonts have a file per weight and
	 * stay as they are.
	 *
	 * @param string $css The Google Fonts CSS (@font-face rules only).
	 *
	 * @return string
	 */
	private function mergeVariableFontWeights( $css ) {

		if ( ! preg_match_all( '/@font-face\s*\{[^}]*\}/i', $css, $matches ) ) {
			return $css;
		}

		$weight_pattern = '/font-weight\s*:\s*(\d+)\s*;/i';
		$groups         = array();
		$order          = array();

		foreach ( $matches[0] as $block ) {
			if ( ! preg_match( $weight_pattern, $block, $weight ) ) {
				$order[] = array( 'block' => $block );
				continue;
			}

			// Everything but the weight: family, style, file and character range.
			$key = preg_replace( $weight_pattern, '', $block );

			if ( ! isset( $groups[ $key ] ) ) {
				$groups[ $key ] = array(
					'block'   => $block,
					'weights' => array(),
				);
				$order[]        = array( 'key' => $key );
			}

			$groups[ $key ]['weights'][] = (int) $weight[1];
		}

		$merged = '';

		foreach ( $order as $item ) {
			if ( isset( $item['block'] ) ) {
				$merged .= $item['block'] . "\n";
				continue;
			}

			$group   = $groups[ $item['key'] ];
			$weights = array_unique( $group['weights'] );
			$block   = $group['block'];

			if ( count( $weights ) > 1 ) {
				$block = preg_replace( $weight_pattern, 'font-weight: ' . min( $weights ) . ' ' . max( $weights ) . ';', $block, 1 );
			}

			$merged .= $block . "\n";
		}

		return $merged;

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

		$preload = $this->textFontFile( $css );

		if ( $preload ) {
			// The text font's Latin file, so body text shows in it sooner.
			echo '<link rel="preload" href="' . esc_url( $preload ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
		}

		?>
		<style class="wpbf-google-fonts"><?php echo $css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Font-face rules built from Google's stylesheet. ?></style>
		<?php

	}

	/**
	 * The Latin woff2 file of the text font (Typography -> Text, when its Font Settings switch is on) at its chosen weight
	 * and style, from the printed Google Fonts CSS. Empty when the text font isn't a downloaded Google font.
	 *
	 * @param string $css The printed Google Fonts CSS.
	 *
	 * @return string The file URL, or ''.
	 */
	private function textFontFile( $css ) {

		$font = get_theme_mod( 'page_font_toggle' ) ? get_theme_mod( 'page_font_family' ) : false;

		if ( ! is_array( $font ) || empty( $font['font-family'] ) ) {
			return '';
		}

		$variant = isset( $font['variant'] ) ? (string) $font['variant'] : 'regular';
		$style   = false !== strpos( $variant, 'italic' ) ? 'italic' : 'normal';
		$weight  = (int) str_replace( array( 'regular', 'italic' ), '', $variant );
		$weight  = $weight ? $weight : 400;

		preg_match_all( '/@font-face\s*\{[^}]*\}/i', $css, $blocks );

		foreach ( $blocks[0] as $block ) {
			$is_family = preg_match( "/font-family\s*:\s*['\"]?" . preg_quote( $font['font-family'], '/' ) . "['\"]?\s*;/i", $block );
			$is_style  = preg_match( '/font-style\s*:\s*' . $style . '\s*;/i', $block );
			$is_latin  = preg_match( '/unicode-range\s*:\s*U\+0000-00FF/i', $block );

			if ( ! $is_family || ! $is_style || ! $is_latin ) {
				continue;
			}

			// A single weight or a range ("400 700").
			if ( ! preg_match( '/font-weight\s*:\s*(\d+)(?:\s+(\d+))?\s*;/i', $block, $w ) ) {
				continue;
			}

			$min = (int) $w[1];
			$max = isset( $w[2] ) ? (int) $w[2] : $min;

			if ( $weight < $min || $weight > $max ) {
				continue;
			}

			if ( preg_match( '/url\(\s*[\'"]?([^\'")]+\.woff2)[\'"]?\s*\)/i', $block, $url ) ) {
				return $url[1];
			}
		}

		return '';

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
	 * Whether a typography option's font is used at all: its "Font Settings" switch is on (the CSS only prints it then,
	 * see inc/customizer/styles/typography.php and header.php), and for the logo / tagline fonts there's a text logo.
	 * Options without a known switch (child themes, plugins) always count.
	 *
	 * @param string $option_id The typography option.
	 *
	 * @return bool
	 */
	private function isFontInUse( $option_id ) {

		$toggles = array(
			'page_font_family'                  => 'page_font_toggle',
			'menu_logo_font_family'             => 'menu_logo_font_toggle',
			'menu_logo_description_font_family' => 'menu_logo_description_toggle',
			'menu_font_family'                  => 'menu_font_family_toggle',
			'sub_menu_font_family'              => 'sub_menu_font_family_toggle',
			'page_h1_font_family'               => 'page_h1_toggle',
			'page_h2_font_family'               => 'page_h2_toggle',
			'page_h3_font_family'               => 'page_h3_toggle',
			'page_h4_font_family'               => 'page_h4_toggle',
			'page_h5_font_family'               => 'page_h5_toggle',
			'page_h6_font_family'               => 'page_h6_toggle',
			'footer_font_family'                => 'footer_font_toggle',
		);

		if ( ! isset( $toggles[ $option_id ] ) ) {
			return true;
		}

		if ( ! get_theme_mod( $toggles[ $option_id ] ) ) {
			return false;
		}

		$logo_fonts = array( 'menu_logo_font_family', 'menu_logo_description_font_family' );

		return ! ( in_array( $option_id, $logo_fonts, true ) && get_theme_mod( 'custom_logo' ) );

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
			if ( ! $this->isFontInUse( $option_id ) ) {
				continue;
			}

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

		$google_fonts_to_use = $this->withMoreWeights( $google_fonts_to_use );

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
	 * More weights than the one picked, so bold and italic text (and other weights a page uses) show in the real font
	 * instead of one the browser fakes:
	 * - every font: regular, bold (700), italic and bold italic, where the font has them;
	 * - variable fonts: every weight. One file holds them all, so they cost no extra download. A font counts as variable
	 *   once two of its downloaded weights share a file (see variableStyles()); until then it has the four above.
	 * Browsers only download the files a page actually uses.
	 *
	 * @param array $fonts Font family => [ variant => CSS ].
	 *
	 * @return array The same, with the added variants (CSS '' until downloaded).
	 */
	private function withMoreWeights( $fonts ) {

		if ( empty( $fonts ) ) {
			return $fonts;
		}

		if ( ! FontsStore::initialized() ) {
			FontsStore::init();
		}

		$stored = $this->fonts_util->getDownloadedGoogleFontsCss();

		foreach ( $fonts as $font_family => $variants ) {
			$entry     = isset( FontsStore::$google_fonts[ $font_family ] ) ? FontsStore::$google_fonts[ $font_family ] : null;
			$available = $entry && is_array( $entry->variants ) ? $entry->variants : array();

			if ( empty( $available ) ) {
				continue;
			}

			$wanted = array( 'regular', '700', 'italic', '700italic' );

			foreach ( $this->variableStyles( $font_family, $stored ) as $style ) {
				foreach ( $available as $variant ) {
					if ( ( 'italic' === $style ) === ( false !== strpos( $variant, 'italic' ) ) ) {
						$wanted[] = $variant;
					}
				}
			}

			foreach ( array_unique( $wanted ) as $variant ) {
				if ( ! isset( $fonts[ $font_family ][ $variant ] ) && in_array( $variant, $available, true ) && in_array( $variant, self::FONT_VARIANTS, true ) ) {
					$fonts[ $font_family ][ $variant ] = '';
				}
			}
		}

		return $fonts;

	}

	/**
	 * The styles ('normal', 'italic') in which a downloaded font is variable: two of its weights in that style use the
	 * same file for the same characters.
	 *
	 * @param string $font_family The font family.
	 * @param array  $stored The downloaded fonts' CSS (FontsUtil::getDownloadedGoogleFontsCss()).
	 *
	 * @return string[]
	 */
	private function variableStyles( $font_family, $stored ) {

		$prefix = $this->fonts_util->slugifyFontFamily( $font_family ) . '_';
		$seen   = array();
		$styles = array();

		foreach ( $stored as $key => $css ) {
			if ( 0 !== strpos( $key, $prefix ) || ! preg_match_all( '/@font-face\s*\{[^}]*\}/i', (string) $css, $blocks ) ) {
				continue;
			}

			foreach ( $blocks[0] as $block ) {
				if ( ! preg_match( '/font-style\s*:\s*(\w+)/i', $block, $style ) || ! preg_match( '/font-weight\s*:\s*(\d+)/i', $block, $weight ) || ! preg_match( '/url\(\s*[\'"]?([^\'")]+)/i', $block, $url ) ) {
					continue;
				}

				$file = $style[1] . '|' . basename( $url[1] );

				if ( isset( $seen[ $file ] ) && $seen[ $file ] !== $weight[1] ) {
					$styles[ strtolower( $style[1] ) ] = true;
				}

				$seen[ $file ] = $weight[1];
			}
		}

		return array_keys( $styles );

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
