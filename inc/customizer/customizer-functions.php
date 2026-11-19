<?php
/**
 * Customizer function.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Wpbf\Customizer\Customizer;
use Mapsteps\Wpbf\Customizer\CustomizerControl;
use Mapsteps\Wpbf\Customizer\CustomizerField;
use Mapsteps\Wpbf\Customizer\CustomizerPanel;
use Mapsteps\Wpbf\Customizer\CustomizerSection;
use Mapsteps\Wpbf\Customizer\CustomizerSetting;
use Mapsteps\Wpbf\Customizer\Output\CssRules;
use Mapsteps\Wpbf\Customizer\Output\CustomizerCss;
use Mapsteps\Wpbf\Customizer\Schema\OptionSchema;

/**
 * Initialize Wpbf customizer.
 */
function wpbf_customizer_init() {

	( new Customizer() )->init();

}

/**
 * Output the customizer.
 */
function wpbf_customizer_output() {

	( new Customizer() )->output();

}

/**
 * Initialize Wpbf customizer setting.
 *
 * @return CustomizerSetting
 */
function wpbf_customizer_setting() {

	return new CustomizerSetting();

}

/**
 * Initialize Wpbf customizer panel.
 *
 * @return CustomizerPanel
 */
function wpbf_customizer_panel() {

	return new CustomizerPanel();

}

/**
 * Initialize Wpbf customizer section.
 *
 * @return CustomizerSection
 */
function wpbf_customizer_section() {

	return new CustomizerSection();

}

/**
 * Initialize Wpbf customizer control.
 *
 * @return CustomizerControl
 */
function wpbf_customizer_control() {

	return new CustomizerControl();

}

/**
 * Initialize Wpbf customizer field.
 *
 * @return CustomizerField
 */
function wpbf_customizer_field() {

	return new CustomizerField();

}

/**
 * Read a Customizer option: the saved value, or its default if nothing is saved.
 *
 * The value comes back ready to use: options saved as JSON text as arrays, toggles as true/false,
 * sliders and numbers as int or float. Defaults come from the option schema (Customizer/Schema), or for
 * fields registered by Premium, child themes and plugins, from the default they declared. In the Customizer
 * preview it returns the previewed value, like get_theme_mod().
 *
 * @param string $id The option id.
 *
 * @return mixed The value. False for unknown options that aren't saved (like get_theme_mod()).
 */
function wpbf_mod( $id ) {

	static $not_saved = null;

	if ( null === $not_saved ) {
		$not_saved = new stdClass();
	}

	$entry = OptionSchema::find( $id );
	$value = isset( $entry['storage'] ) && 'option' === $entry['storage'] ? get_option( $id, $not_saved ) : get_theme_mod( $id, $not_saved );

	if ( null === $entry ) {
		return $not_saved === $value ? false : $value;
	}

	if ( $not_saved === $value ) {
		return OptionSchema::defaultValue( $entry );
	}

	return OptionSchema::typed( $entry, $value );

}

// Kirki safety net for Premium 2.9 and older and code written for Kirki (frozen, see the file).
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-compatibility.php';

if ( ! function_exists( 'wpbf_get_theme_mod_value' ) ) {

	/**
	 * Helper function to get theme_mod array values by key.
	 *
	 * @param array   $arr The decoded theme_mod array.
	 * @param string  $key The array key.
	 * @param boolean $default_value The default to check against.
	 * @param boolean $print_default Whether the default value should be returned.
	 *
	 * @return mixed The key value.
	 */
	function wpbf_get_theme_mod_value( $arr, $key, $default_value = false, $print_default = false ) {

		// Stop here if we have no array and we don't want to print a default.
		if ( ! $arr && ! $print_default ) {
			return false;
		}

		// Initialize value.
		$value = false;

		// If we want to return a default, let's adjust the value.
		if ( $default_value && $print_default ) {
			$value = $default_value;
		}

		// Get & set the value by key if we have one.
		$value = isset( $arr[ $key ] ) ? $arr[ $key ] : $value;

		// If we don't want to return a default and the saved
		// value matches default, we set value back to false.
		if ( $default_value && ! $print_default ) {
			$value = $default_value === $value ? false : $value;
		}

		return $value;

	}

}

/**
 * Adjust customizer preview.
 */
function wpbf_adjust_customizer_responsive_sizes() {

	$medium_breakpoint = function_exists( 'wpbf_breakpoint_medium' ) ? wpbf_breakpoint_medium() : 768;
	$mobile_breakpoint = function_exists( 'wpbf_breakpoint_mobile' ) ? wpbf_breakpoint_mobile() : 480;

	$tablet_margin_left = - $medium_breakpoint / 2 . 'px';
	$tablet_width       = $medium_breakpoint . 'px';

	$mobile_margin_left = - $mobile_breakpoint / 2 . 'px';
	$mobile_width       = $mobile_breakpoint . 'px';

	?>

	<style>
		.wp-customizer .preview-tablet .wp-full-overlay-main {
			margin-left: <?php echo esc_attr( $tablet_margin_left ); ?>;
			width: <?php echo esc_attr( $tablet_width ); ?>;
		}

		.wp-customizer .preview-mobile .wp-full-overlay-main {
			margin-left: <?php echo esc_attr( $mobile_margin_left ); ?>;
			width: <?php echo esc_attr( $mobile_width ); ?>;
			height: 680px;
		}
	</style>

	<?php
}
add_action( 'customize_controls_print_styles', 'wpbf_adjust_customizer_responsive_sizes' );

/**
 * Minify CSS.
 *
 * @param string $css The css.
 *
 * @return string The minified CSS.
 */
function wpbf_minify_css( $css ) {

	// Remove Comments.
	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
	// Remove space after colons.
	$css = str_replace( ': ', ':', $css );
	$css = str_replace( ' {', '{', $css );
	$css = str_replace( ', ', ',', $css );
	// Remove whitespace.
	$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );

	return $css;

}

/**
 * Write one Customizer CSS block from option values (see inc/customizer/styles/general.php for how to use it).
 *
 * Prints the block when its options are set and differ from their defaults. In the Customizer preview, changes to
 * these options show instantly.
 *
 * @param string $selector     The CSS selector.
 * @param array  $declarations Property => value. Values hold option values as {option_id} or {option_id.key}.
 * @param array  $args         'media' (breakpoint name like 'max-desktop', or a media query), 'always' (print even at
 *                             the defaults), 'when' (an option that must be on), 'saved' (print whenever saved, even
 *                             as the default) with 'unless' (not when saved exactly as this text), 'parts' (compare
 *                             each part of a JSON option on its own). See inc/customizer/styles/general.php.
 */
function wpbf_css( $selector, $declarations, $args = array() ) {

	CssRules::rule( $selector, $declarations, $args );

}

/**
 * Print an area's Customizer CSS (inc/customizer/styles/<area>.php).
 *
 * @param string $area The area name.
 */
function wpbf_css_area( $area ) {

	CssRules::area( $area );

}

/**
 * A theme mod's saved value for Customizer CSS written in plain PHP, false when nothing is saved.
 *
 * Visitors get get_theme_mod() without a default: false when nothing is saved. In the Customizer preview
 * get_theme_mod() hands over the registered default for an option nobody saved or changed; that counts as not saved
 * too, so the preview prints what visitors get.
 *
 * @param string $id The option id.
 *
 * @return mixed The saved value, false for none.
 */
function wpbf_css_saved_mod( $id ) {

	$value = get_theme_mod( $id );

	return $value && ! CssRules::hasPreviewValue( $id ) ? false : $value;

}

/**
 * Print a font block for Customizer CSS: the family, weight and style from a typography value (saved value only,
 * see wpbf_css_saved_mod()), as the theme always printed them.
 *
 * '700italic' becomes 700 / italic, 'regular' 400 / normal; saved font-weight / font-style parts aren't used. A value
 * saved as anything but a list of parts prints an empty block, as before.
 *
 * @param string $selector   The selector.
 * @param mixed  $value      The typography value (nothing prints when it's empty).
 * @param bool   $with_color Also print its color part (the logo font has one).
 */
function wpbf_css_font( $selector, $value, $with_color = false ) {

	if ( ! $value ) {
		return;
	}

	echo $selector . ' {'; // phpcs:ignore WordPress.Security.EscapeOutput -- Fixed selectors.

	if ( ! empty( $value['font-family'] ) ) {
		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $value['font-family'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- Escaped by wpbf_parse_font_family().
	}

	if ( ! empty( $value['variant'] ) ) {
		$weight = str_replace( 'italic', '', $value['variant'] );
		$weight = in_array( $weight, array( '', 'regular' ) ) ? '400' : $weight; // phpcs:ignore WordPress.PHP.StrictInArray -- As before (a variant saved as the number 400).
		$style  = false !== strpos( $value['variant'], 'italic' ) ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $style ) );
	}

	if ( $with_color && ! empty( $value['color'] ) ) {
		echo sprintf( 'color: %s;', esc_attr( $value['color'] ) );
	}

	echo '}';

}

/**
 * Generate customizer CSS.
 */
function wpbf_generate_css() {

	ob_start();

	include get_template_directory() . '/inc/customizer/styles.php';

	return wpbf_minify_css( ob_get_clean() );

}

/**
 * Write the wpbf-customizer-styles.css file ("file" CSS mode) with the current CSS.
 *
 * Not hooked any more: the file is written when the CSS changes (see Customizer/Output/CustomizerCss.php).
 * Kept for code that calls it.
 */
function wpbf_create_customizer_css_file() {

	if ( 'file' !== apply_filters( 'wpbf_css_output', 'inline' ) ) {
		return;
	}

	// Never write unsaved Customizer changes into the file every visitor gets.
	if ( is_customize_preview() ) {
		return;
	}

	CustomizerCss::writeFile( CustomizerCss::current()['css'] );

}

/**
 * Enqueue customizer CSS.
 *
 * The CSS comes from the cache (built when settings change). The Customizer preview prints its live CSS itself
 * (wpbf_customizer_preview_css()), so it's left out here.
 */
function wpbf_customizer_frontend_scripts() {

	if ( is_customize_preview() ) {
		return;
	}

	$css_output = apply_filters( 'wpbf_css_output', 'inline' );

	if ( 'inline' === $css_output ) {

		wp_add_inline_style( apply_filters( 'wpbf_add_inline_style', 'wpbf-style' ), CustomizerCss::current()['css'] );

	} elseif ( 'file' === $css_output ) {

		// Makes sure the file holds the current CSS (written only when it changed).
		CustomizerCss::current();

		if ( file_exists( CustomizerCss::filePath() ) ) {
			wp_enqueue_style( 'wpbf-customizer', CustomizerCss::fileUrl(), '', filemtime( CustomizerCss::filePath() ) );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'wpbf_customizer_frontend_scripts', 11 );

/**
 * Customizer CSS live preview.
 */
function wpbf_customizer_preview_css() {

	if ( ! is_customize_preview() ) {
		return;
	}

	// Areas written with wpbf_css() get their own style tag, redrawn by preview-css.js.
	CssRules::startSplit();
	require WPBF_THEME_DIR . '/inc/customizer/styles.php';
	$segments = CssRules::endSplit();

	$plain = 0;
	$areas = array();

	foreach ( $segments as $segment ) {
		if ( is_array( $segment ) ) {
			echo '<style id="wpbf-css-' . esc_attr( $segment['area'] ) . '">' . $segment['css'] . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput -- CSS, values escaped when written.

			$areas[ $segment['area'] ] = array_diff_key( $segment, array_flip( array( 'area', 'css' ) ) );
			continue;
		}

		echo '<style id="wpbf-customize-saved-styles' . ( $plain ? '-' . ( $plain + 1 ) : '' ) . '">' . $segment . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput -- CSS.
		++$plain;
	}

	wp_add_inline_script( 'wpbf-preview-css', 'window.wpbfCssAreas = ' . wp_json_encode( $areas, JSON_HEX_TAG ) . ';', 'before' );

}
add_action( 'wp_head', 'wpbf_customizer_preview_css', 999 );

/**
 * Selective refresh partials for the areas written with wpbf_css(): the preview asks PHP for an area's CSS again
 * when an option it reads outside wpbf_css() changes (see inc/customizer/js/preview-css.js).
 *
 * @param WP_Customize_Manager $wp_customize The Customizer.
 */
function wpbf_customizer_css_partials( $wp_customize ) {

	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	foreach ( CssRules::AREAS as $area ) {
		$wp_customize->selective_refresh->add_partial(
			'wpbf_css_' . $area,
			array(
				'type'                => 'wpbf_css',
				'selector'            => '#wpbf-css-' . $area,
				'settings'            => array(),
				'capability'          => 'edit_theme_options',
				'container_inclusive' => false,
				'render_callback'     => function () use ( $area ) {
					$data = CssRules::record( $area );
					unset( $data['css'] );

					return $data;
				},
			)
		);
	}

}
add_action( 'customize_register', 'wpbf_customizer_css_partials' );

/**
 * Post message.
 */
function wpbf_customizer_preview_js() {

	wp_enqueue_script(
		'wpbf-postmessage',
		get_template_directory_uri() . '/inc/customizer/js/postmessage.js',
		array(
			'jquery',
			'customize-preview',
		),
		WPBF_VERSION,
		true
	);

	wp_enqueue_script(
		'wpbf-preview-css',
		get_template_directory_uri() . '/inc/customizer/js/preview-css.js',
		array(
			'customize-preview',
			'customize-selective-refresh',
		),
		WPBF_VERSION,
		true
	);

}
add_action( 'customize_preview_init', 'wpbf_customizer_preview_js' );

/**
 * Enqueue customizer scripts & styles.
 */
function wpbf_customizer_scripts_styles() {

	wp_enqueue_style( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/css/customizer.css', '', WPBF_VERSION );
	wp_enqueue_script( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/js/customizer.js', array( 'jquery' ), WPBF_VERSION, true );

}
add_action( 'customize_controls_print_styles', 'wpbf_customizer_scripts_styles' );

// Stop here if WP_Customize_Control doesn't exist.
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Custom default fonts.
 *
 * @param array $standard_fonts The standard fonts.
 *
 * @return array The updated standard fonts.
 */
function wpbf_custom_default_fonts( $standard_fonts ) {

	$standard_fonts = array();

	$standard_fonts['helvetica_neue'] = array(
		'label'    => 'Helvetica Neue',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack'    => '"Helvetica Neue", Helvetica, Arial, sans-serif',
	);

	$standard_fonts['helvetica'] = array(
		'label'    => 'Helvetica',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack'    => 'Helvetica, Arial, sans-serif',
	);

	$standard_fonts['arial'] = array(
		'label'    => 'Arial',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack'    => 'Arial, Helvetica, sans-serif',
	);

	return $standard_fonts;

}
add_filter( 'wpbf_fonts_standard_fonts', 'wpbf_custom_default_fonts', 0 );
