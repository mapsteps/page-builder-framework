<?php
/**
 * Customizer function.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyChoices;
use Mapsteps\Wpbf\Customizer\Customizer;
use Mapsteps\Wpbf\Customizer\CustomizerControl;
use Mapsteps\Wpbf\Customizer\CustomizerField;
use Mapsteps\Wpbf\Customizer\CustomizerPanel;
use Mapsteps\Wpbf\Customizer\CustomizerSection;
use Mapsteps\Wpbf\Customizer\CustomizerSetting;
use Mapsteps\Wpbf\Customizer\HeaderBuilder\HeaderBuilderConfig;
use Mapsteps\Wpbf\Customizer\HeaderBuilder\HeaderBuilderOutput;

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

require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-compatibility.php';
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-panel-section-compatibility.php';
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-control-base-compatibility.php';
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-fields-compatibility.php';
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-unsupported-fields-compatibility.php';
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-pro-fields-compatibility.php';
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/kirki-class-aliases.php';
require_once WPBF_THEME_DIR . '/Customizer/Compatibility/wpbf-old-controls-compatibility.php';

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
 * Generate customizer CSS.
 *
 * @param bool $run_once Whether to run the function only once.
 * @return string The generated CSS.
 */
function wpbf_generate_css( $run_once = false ) {

	ob_start();

	if ( $run_once ) {
		require_once WPBF_THEME_DIR . '/inc/customizer/styles.php';
	} else {
		include WPBF_THEME_DIR . '/inc/customizer/styles.php';
	}

	return wpbf_minify_css( ob_get_clean() );

}

/**
 * Create wpbf-customizer-styles.css file.
 */
function wpbf_create_customizer_css_file() {

	if ( 'file' !== apply_filters( 'wpbf_css_output', 'inline' ) ) {
		return;
	}

	global $wp_filesystem;

	if ( ! $wp_filesystem ) {
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
	}

	WP_Filesystem();

	$upload_dir = wp_upload_dir();
	$pbf_dir    = trailingslashit( $upload_dir['basedir'] ) . 'page-builder-framework/';
	$css        = wpbf_generate_css();

	// Create page-builder-framework folder if it doesn't exist.
	if ( ! file_exists( $pbf_dir ) ) {
		$wp_filesystem->mkdir( $pbf_dir );
	}

	// Create wpbf-customizer-styles.css file if it doesn't exist, otherwise attempt to update it.
	if ( ! file_exists( $pbf_dir . 'page-builder-framework/wpbf-customizer-styles.css' ) ) {
		$wp_filesystem->put_contents( $pbf_dir . 'wpbf-customizer-styles.css', $css, 0644 );
	} elseif ( $css !== $wp_filesystem->get_contents( $pbf_dir . 'wpbf-customizer-styles.css' ) ) {
		// Override the file only if changes were made in the customizer.
		$wp_filesystem->put_contents( $pbf_dir . 'wpbf-customizer-styles.css', $css, 0644 );
	}

}
add_action( 'wp_loaded', 'wpbf_create_customizer_css_file' );

/**
 * Enqueue customizer CSS.
 */
function wpbf_customizer_frontend_scripts() {

	$css_output = apply_filters( 'wpbf_css_output', 'inline' );

	if ( 'inline' === $css_output ) {

		$inline_styles = wpbf_generate_css();
		wp_add_inline_style( apply_filters( 'wpbf_add_inline_style', 'wpbf-style' ), $inline_styles );

	} elseif ( 'file' === $css_output ) {

		$upload_dir = wp_upload_dir();
		$file_path  = $upload_dir['basedir'] . '/page-builder-framework/wpbf-customizer-styles.css';
		$file_url   = $upload_dir['baseurl'] . '/page-builder-framework/wpbf-customizer-styles.css';

		if ( file_exists( $file_path ) ) {
			wp_enqueue_style( 'wpbf-customizer', $file_url, '', filemtime( $file_path ) );
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

	echo '<style id="wpbf-customize-saved-styles">';
	echo wpbf_generate_css( true );
	echo '</style>';

}
add_action( 'wp_head', 'wpbf_customizer_preview_css', 999 );

/**
 * Post message.
 */
function wpbf_customizer_preview_js() {

	wp_enqueue_script(
		'wpbf-postmessage',
		WPBF_THEME_URI . '/js/min/postmessage-min.js',
		array(
			'jquery',
			'customize-preview',
			'wpbf-site',
		),
		WPBF_VERSION,
		true
	);

	wp_add_inline_script(
		'wpbf-postmessage',
		'window.wpbfMenuTriggerButtonSvg = ' . wp_json_encode( array(
			'none'      => HeaderBuilderConfig::menuTriggerButtonSvg(),
			'variant-1' => HeaderBuilderConfig::menuTriggerButtonSvg( 'variant-1' ),
			'variant-2' => HeaderBuilderConfig::menuTriggerButtonSvg( 'variant-2' ),
			'variant-3' => HeaderBuilderConfig::menuTriggerButtonSvg( 'variant-3' ),
		) ),
		'before'
	);

}
add_action( 'customize_preview_init', 'wpbf_customizer_preview_js' );

/**
 * Enqueue customizer scripts & styles.
 */
function wpbf_customizer_scripts_styles() {

	wp_enqueue_style( 'wpbf-customizer', WPBF_THEME_URI . '/inc/customizer/css/customizer.css', '', WPBF_VERSION );
	wp_enqueue_script( 'wpbf-customizer', WPBF_THEME_URI . '/js/min/customizer-min.js', array( 'jquery' ), WPBF_VERSION, true );

	wp_enqueue_style( 'responsive-controls', WPBF_THEME_URI . '/inc/customizer/css/responsive-controls.css', '', WPBF_VERSION );
	wp_enqueue_script( 'responsive-controls', WPBF_THEME_URI . '/inc/customizer/js/responsive-controls.js', array( 'jquery' ), WPBF_VERSION, true );

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

/**
 * Global Typography Fonts.
 */
function wpbf_global_typography_js_vars() {

	$font_choices = wpbf_default_font_choices();

	$fonts_arg = ! empty( $font_choices ) && is_array( $font_choices ) ? $font_choices : array();
	$fonts_arg = ! empty( $fonts_arg['fonts'] ) && is_array( $fonts_arg['fonts'] ) ? $fonts_arg['fonts'] : array();

	wp_localize_script(
		'wpbf-select-control',
		'wpbfGoogleFontFamilies',
		( new TypographyChoices() )->makeFontFamilyChoices( $fonts_arg )
	);

	wp_localize_script(
		'wpbf-select-control',
		'wpbfGoogleFontVariants',
		( new TypographyChoices() )->makeFontVariantChoices( $fonts_arg )
	);

}
add_action( 'customize_controls_enqueue_scripts', 'wpbf_global_typography_js_vars' );

/**
 * ----------------------------------------------------------------------
 * Common Builder Functions
 *
 * These functions are used by both header builder and footer builder.
 * ----------------------------------------------------------------------
 */

if ( ! function_exists( 'wpbf_header_builder_enabled' ) ) {
	/**
	 * ----------------------------------------------------------------------
	 * Header Builder Functions
	 * ----------------------------------------------------------------------
	 */
	function wpbf_header_builder_enabled() {

		return wpbf_customize_bool_value( 'wpbf_enable_header_builder' );

	}
}

/**
 * Setup hooks when header builder is enabled.
 *
 * This function will be called directly in `template-parts/header.php` file.
 *
 * @see page-builder-framework/inc/template-parts/header.php
 */
function wpbf_header_builder_hooks() {

	if ( ! wpbf_header_builder_enabled() ) {
		return;
	}

	( new HeaderBuilderOutput() )->setup_hooks();

}
