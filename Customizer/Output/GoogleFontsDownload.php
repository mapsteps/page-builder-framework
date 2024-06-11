<?php

namespace Mapsteps\Wpbf\Customizer\Output;

use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsUtil;

class GoogleFontsDownload {

	/**
	 * The Google Fonts API URL.
	 *
	 * @var string
	 */
	private $api_url = 'https://fonts.googleapis.com/css2';

	/**
	 * The user-agent to download woff fonts.
	 *
	 * The default user-agent is the only one compatible with woff (not woff2)
	 * which also supports unicode ranges.
	 *
	 * @var string
	 */
	private $woff_user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8';

	/**
	 * The user-agent to download woff2 fonts.
	 *
	 * @var string
	 */
	private $woff2_user_agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0';

	/**
	 * Download Google Fonts and save it locally.
	 *
	 * @param array $font_families Associative array of font families with "font family" as the key and "array of variants" as the value.
	 */
	public function download( $font_families = [] ) {

		if ( empty( $font_families ) ) {
			return;
		}

		$stylesheet_url = $this->buildStylesheetUrl( $font_families );

		if ( empty( $stylesheet_url ) ) {
			return;
		}

		$css_content = $this->downloadStylesheet( $stylesheet_url );

		if ( empty( $css_content ) ) {
			return;
		}

		$fonts_to_download = $this->getFontUrlsFromCss( $css_content );

		$css_content = $this->localizeCssFontFilesPath( $css_content );

		if ( empty( $fonts_to_download ) || ! is_array( $fonts_to_download ) ) {
			return;
		}

		if ( ! function_exists( 'download_url' ) || ! function_exists( 'wp_mkdir_p' ) || ! function_exists( ( 'WP_Filesystem' ) ) ) {
			require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
		}

		$existing_downloaded_fonts = get_option( 'wpbf_downloaded_google_fonts', array() );
		$existing_downloaded_fonts = ! empty( $existing_downloaded_fonts ) && is_array( $existing_downloaded_fonts ) ? $existing_downloaded_fonts : [];

		$fonts_util = new FontsUtil();

		$existing_downloaded_css = $fonts_util->getDownloadedGoogleFontsCss();

		foreach ( $fonts_to_download as $font_family => $variant_and_url_array ) {
			$font_family_slug = $fonts_util->slugifyFontFamily( $font_family );
			$font_family_dir  = WP_CONTENT_DIR . '/fonts/' . $font_family_slug;

			// Check if the font-family directory exists.
			if ( ! file_exists( $font_family_dir ) ) {
				if ( ! wp_mkdir_p( $font_family_dir ) ) {
					continue;
				}
			}

			foreach ( $variant_and_url_array as $variant_and_url ) {
				$font_variant = $variant_and_url['variant'];
				$font_url     = $variant_and_url['url'];

				$local_file_path = $this->downloadFontFile( $font_family_dir, $font_url );

				if ( ! $local_file_path ) {
					continue;
				}

				if ( ! isset( $existing_downloaded_fonts[ $font_family ] ) ) {
					$existing_downloaded_fonts[ $font_family ] = [];
				}

				if ( ! in_array( $font_variant, $existing_downloaded_fonts[ $font_family ], true ) ) {
					$existing_downloaded_fonts[ $font_family ][] = $font_variant;
				}

				$font_face_declarations = $this->getFontFaceDeclarations( $css_content, $font_family, $font_variant );

				$sub_option_key = $font_family_slug . '_' . $font_variant;

				$existing_downloaded_css[ $sub_option_key ] = $font_face_declarations;
			}
		}

		update_option( 'wpbf_downloaded_google_fonts', $existing_downloaded_fonts );
		update_option( 'wpbf_downloaded_google_fonts_css', $existing_downloaded_css );

	}

	/**
	 * Build the URL for the Google Fonts stylesheet.
	 *
	 * @param array $font_families Associative array of font families with "font-family" as the key and "array of variants" as the value.
	 *
	 * @return string
	 */
	private function buildStylesheetUrl( $font_families = [] ) {

		if ( empty( $font_families ) ) {
			return '';
		}

		$stylesheet_url = '';

		$loop_index = 0;

		foreach ( $font_families as $font_family => $font_variants ) {
			if ( empty( $font_variants ) || ! is_array( $font_variants ) ) {
				continue;
			}

			$has_any_italic_style = false;

			foreach ( $font_variants as $font_variant ) {
				if ( false !== strpos( $font_variant, 'italic' ) ) {
					$has_any_italic_style = true;
					break;
				}
			}

			$stylesheet_url .= 0 !== $loop_index ? '&' : '';
			$stylesheet_url .= 'family=' . rawurlencode( $font_family );
			$stylesheet_url .= $has_any_italic_style ? ':ital,wght@' : ':wght@';

			$regular_font_weights = [];
			$italic_font_weights  = [];

			foreach ( $font_variants as $font_variant ) {
				if ( 'regular' === $font_variant ) {
					$regular_font_weights[] = '400';
					continue;
				}

				if ( 'italic' === $font_variant ) {
					$italic_font_weights[] = '400';
					continue;
				}

				if ( false !== strpos( $font_variant, 'italic' ) ) {
					$italic_font_weights[] = str_ireplace( 'italic', '', $font_variant );
					continue;
				}

				$regular_font_weights[] = $font_variant;
			}

			sort( $regular_font_weights );
			sort( $italic_font_weights );

			foreach ( $regular_font_weights as $font_variant ) {
				$stylesheet_url .= $has_any_italic_style ? "0,$font_variant;" : "$font_variant;";
			}

			foreach ( $italic_font_weights as $font_variant ) {
				$stylesheet_url .= "1,$font_variant;";
			}

			$stylesheet_url = rtrim( $stylesheet_url, ';' );

			++$loop_index;
		}

		if ( empty( $stylesheet_url ) ) {
			return '';
		}

		return $this->api_url . '?' . $stylesheet_url . '&display=swap';

	}

	/**
	 * Download the stylesheet.
	 *
	 * @param string $stylesheet_url The stylesheet URL.
	 * @return string The CSS content.
	 */
	private function downloadStylesheet( $stylesheet_url = '' ) {

		// Use wp_remote_get to get the stylesheet.
		$response = wp_remote_get( $stylesheet_url, array( 'user-agent' => $this->woff2_user_agent ) );

		// Early exit if there was an error.
		if ( is_wp_error( $response ) ) {
			return '';
		}

		// Get the CSS from our response.
		$css = wp_remote_retrieve_body( $response );

		// Early exit if there was an error.
		if ( is_wp_error( $css ) ) {
			return '';
		}

		return $css;

	}

	/**
	 * Parse the CSS to get the font URLs per font-family.
	 *
	 * @param string $css The CSS we want to parse.
	 * @return array      Associative array. The key is font-family name. And the value is associative array with 2 keys: 'variant' and 'url'.
	 */
	private function getFontUrlsFromCss( $css = '' ) {

		if ( empty( $css ) ) {
			return [];
		}

		/**
		 * Associative array. The key is font-family name. And the value is associative array with 2 keys: 'variant' and 'url'.
		 *
		 * @var array $fonts
		 */
		$fonts = [];

		// Loop through all our font-face declarations.
		preg_match_all( '/@font-face.*?\{.*?\}/is', $css, $font_face_match );

		// Loop through all our matches.
		foreach ( $font_face_match[0] as $font_face_block ) {
			if ( empty( $font_face_block ) ) {
				continue;
			}

			// Get an array of our font-families.
			preg_match_all( '/font-family.*?\;/i', $font_face_block, $matched_font_families );

			$font_family = '';

			// Get the font-family name.
			if ( isset( $matched_font_families[0] ) && isset( $matched_font_families[0][0] ) ) {
				$font_family = rtrim( ltrim( $matched_font_families[0][0], 'font-family:' ), ';' );
				$font_family = trim( str_replace( array( "'", '"', ';' ), '', $font_family ) );
			}

			if ( empty( $font_family ) ) {
				continue;
			}

			// Make sure the font-family is set in our array.
			if ( ! isset( $fonts[ $font_family ] ) ) {
				$fonts[ $font_family ] = [];
			}

			$font_url = '';

			// Match the font-url.
			preg_match_all( '/url\(.*?\)/i', $font_face_block, $font_url_match );

			// Get files for this font-family and add them to the array.
			foreach ( $font_url_match[0] as $font_url_declaration ) {
				if ( empty( $font_url_declaration ) ) {
					continue;
				}

				$font_url = rtrim( ltrim( $font_url_declaration, 'url(' ), ')' );

				if ( ! empty( $font_url ) ) {
					break;
				}
			}

			$font_weight = '';

			// Match the font-weight.
			preg_match_all( '/font-weight.*?\;/i', $font_face_block, $font_weight_match );

			// Get font-weight for this font-family and add it to the array.
			foreach ( $font_weight_match[0] as $font_weight_declaration ) {
				if ( empty( $font_weight_declaration ) ) {
					continue;
				}

				$font_weight = rtrim( ltrim( $font_weight_declaration, 'font-weight:' ), ';' );
				$font_weight = trim( str_replace( array( "'", '"', ';' ), '', $font_weight ) );

				if ( ! empty( $font_weight ) ) {
					break;
				}
			}

			$font_style = '';

			// Match the font-style.
			preg_match_all( '/font-style.*?\;/i', $font_face_block, $font_style_match );

			// Get font-style for this font-family and add it to the array.
			foreach ( $font_style_match[0] as $font_style_declaration ) {
				if ( empty( $font_style_declaration ) ) {
					continue;
				}

				$font_style = rtrim( ltrim( $font_style_declaration, 'font-style:' ), ';' );
				$font_style = trim( str_replace( array( "'", '"', ';' ), '', $font_style ) );

				if ( ! empty( $font_style ) ) {
					break;
				}
			}

			$font_variant = '';

			if ( ! empty( $font_weight ) && ! empty( $font_style ) ) {
				$font_variant = 'normal' === $font_style ? $font_weight : $font_weight . $font_style;
				$font_variant = '400' === $font_variant ? 'regular' : $font_variant;
				$font_variant = '400italic' === $font_variant ? 'italic' : $font_variant;
			}

			if ( empty( $font_url ) || empty( $font_variant ) ) {
				unset( $fonts[ $font_family ] );
				continue;
			}

			$fonts[ $font_family ][] = [
				'variant' => $font_variant,
				'url'     => $font_url,
			];
		}

		return $fonts;

	}

	/**
	 * Download the font files.
	 *
	 * @param string $dir Directory to download the font file.
	 * @param string $font_url The font-file url.
	 *
	 * @return string The local path of the downloaded font file.
	 */
	private function downloadFontFile( $dir, $font_url ) {

		if ( empty( $dir ) || empty( $font_url ) ) {
			return '';
		}

		$tmp_path = download_url( $font_url );

		if ( is_wp_error( $tmp_path ) ) {
			return '';
		}

		$font_file_name = basename( wp_parse_url( $font_url, PHP_URL_PATH ) );
		$font_file_path = $dir . '/' . $font_file_name;

		$success = $this->getFilesystem()->move( $tmp_path, $font_file_path, true );

		if ( ! $success ) {
			return '';
		}

		return $font_file_path;

	}

	/**
	 * Localize the Google Font urls in the CSS to the local path.
	 *
	 * @param string $css_content The CSS content.
	 *
	 * @return string CSS content with localized font urls.
	 */
	private function localizeCssFontFilesPath( $css_content ) {

		$base_local_fonts_dir_url = content_url( '/fonts' );

		// We need to parse per @font-face declaration.
		$css_content = preg_replace_callback(
			'/@font-face.*?\{.*?\}/is',
			function ( $matches ) use ( $base_local_fonts_dir_url ) {
				$content = $matches[0];

				// Get the font-family name.
				preg_match_all( '/font-family\s*:\s*([\'"])(.*?)\1/i', $content, $font_family_matches );

				$font_family = '';

				if ( isset( $font_family_matches[2] ) && isset( $font_family_matches[2][0] ) ) {
					$font_family = trim( $font_family_matches[2][0] );
				}

				if ( empty( $font_family ) ) {
					return $content;
				}

				$font_family_slug = ( new FontsUtil() )->slugifyFontFamily( $font_family );

				// Get the font-file url inside of current @font-face declaration by detecting src: url(...) inside of it.
				preg_match_all( '/url\(.*?\)/i', $content, $font_file_url_matches );

				$font_file_url_declaration = $font_file_url_matches[0][0];

				$font_file_url = str_replace( 'url(', '', $font_file_url_declaration );
				$font_file_url = str_replace( ')', '', $font_file_url );

				$local_file_path = $base_local_fonts_dir_url . '/' . $font_family_slug . '/' . basename( $font_file_url );

				return str_replace( $font_file_url, $local_file_path, $content );
			},
			$css_content
		);

		return $css_content;

	}

	/**
	 * Get WP_Filesystem instance.
	 *
	 * @return WP_Filesystem
	 */
	private function getFilesystem() {

		global $wp_filesystem;

		if ( ! $wp_filesystem ) {
			WP_Filesystem();
		}

		return $wp_filesystem;

	}

	/**
	 * Get font-face declarations for a specific font-family and font-variant.
	 *
	 * @param string $css_content The localized CSS content.
	 * @param string $font_family The font-family name.
	 * @param string $font_variant The font-variant name.
	 *
	 * @return string
	 */
	private function getFontFaceDeclarations( $css_content, $font_family, $font_variant ) {

		$font_face_declarations = '';

		$font_weight = $font_variant;

		if ( 'italic' === $font_variant ) {
			$font_weight = '400';
		} elseif ( 'regular' === $font_variant ) {
			$font_weight = '400';
		}

		$pattern = "/@font-face\s*{[^}]*font-family:\s*['\"]?" . $font_family . "['\"]?[^}]*font-weight:\s*" . $font_weight . '[^}]*}/is';

		// Find all matches from the CSS content.
		preg_match_all( $pattern, $css_content, $matches );

		if ( empty( $matches[0] ) ) {
			return $font_face_declarations;
		}

		foreach ( $matches[0] as $font_face_declaration ) {
			$font_face_declarations .= $font_face_declaration . "\n";
		}

		return $font_face_declarations;

	}

}
