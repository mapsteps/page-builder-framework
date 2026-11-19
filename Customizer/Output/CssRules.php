<?php
/**
 * Customizer CSS written with wpbf_css(), and its instant preview.
 *
 * An area's CSS lives in plain PHP (inc/customizer/styles/<area>.php), included with wpbf_css_area() from styles.php
 * (EDD, WooCommerce: from their wpbf_after_customizer_css callbacks).
 * Simple lines are written with wpbf_css( $selector, $declarations, $args ); everything else is plain echo.
 *
 * Front end: wpbf_css() prints the block right away. A declaration prints when the options it uses are set and at
 * least one of them differs from its default (or the block is marked 'always'); fixed declarations print with them.
 *
 * Customizer preview: the area is rendered into a template where each wpbf_css() block is a placeholder, plus the
 * list of blocks and the options the area read outside wpbf_css() (in an if, a calculation, an echo).
 * inc/customizer/js/preview-css.js redraws the blocks in the browser when an option they use changes (instant), and
 * asks PHP for the whole area again (selective refresh partial "wpbf_css_<area>") when one of the other options
 * changes. The browser code follows exactly the same rules as this class: keep both in step.
 *
 * @package Page Builder Framework
 */

namespace Mapsteps\Wpbf\Customizer\Output;

use Mapsteps\Wpbf\Customizer\Schema\OptionSchema;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Customizer CSS rules.
 */
final class CssRules {

	/**
	 * Areas that are written with wpbf_css() (one file each in inc/customizer/styles/).
	 */
	const AREAS = array( 'typography', 'general', 'footer', 'edd', 'blog', 'woocommerce', 'header' );

	/**
	 * Placeholder of an option value in a declaration: {option_id} or {option_id.key} for a part of a JSON option;
	 * {option_id|px} adds the unit when the value is a plain number ('14' → 14px, '1em' stays).
	 */
	const REF = '/\{([A-Za-z0-9_\-]+)(?:\.([A-Za-z0-9_\-]+))?(?:\|([a-z%]+))?\}/';

	/**
	 * Placeholder of a block in a preview template.
	 */
	const TOKEN = '/\/\*wpbf-css:(\d+)\*\//';

	/**
	 * A hex color.
	 */
	const HEX = '/^#[0-9a-fA-F]{3,8}$/';

	/**
	 * The area being recorded for the preview (blocks, reads, options), or null.
	 *
	 * @var array|null
	 */
	private static $recording = null;

	/**
	 * Whether wpbf_css() is reading an option (those reads don't count as reads of the area).
	 *
	 * @var bool
	 */
	private static $in_rule = false;

	/**
	 * Preview output split into plain CSS and areas, or null when not splitting.
	 *
	 * @var array|null
	 */
	private static $segments = null;

	/**
	 * Whether option reads are watched (Customizer preview only).
	 *
	 * @var bool
	 */
	private static $watching = false;

	/**
	 * Option values read while an area is printed (they can't change meanwhile), or null outside an area.
	 *
	 * @var array|null
	 */
	private static $values = null;

	/**
	 * Parsed placeholders per declaration value.
	 *
	 * @var array
	 */
	private static $parsed = array();

	/**
	 * Print an area's CSS (called from styles.php).
	 *
	 * @param string $area The area name.
	 */
	public static function area( $area ) {

		if ( null === self::$segments ) {
			self::includeArea( $area );
			return;
		}

		self::$segments[] = ob_get_clean();
		self::$segments[] = array( 'area' => $area ) + self::record( $area );
		ob_start();

	}

	/**
	 * Start splitting the CSS printed from now on into plain parts and areas (Customizer preview).
	 */
	public static function startSplit() {

		self::$segments = array();
		ob_start();

	}

	/**
	 * Stop splitting.
	 *
	 * @return array The parts: strings for plain CSS, arrays (see record()) for areas.
	 */
	public static function endSplit() {

		self::$segments[] = ob_get_clean();

		$segments       = self::$segments;
		self::$segments = null;

		return $segments;

	}

	/**
	 * Render an area for the preview.
	 *
	 * @param string $area The area name.
	 *
	 * @return array css (the CSS), template (the CSS with a placeholder per block), blocks, reads (options read
	 *               outside wpbf_css()) and options (default and type of the options the blocks use).
	 */
	public static function record( $area ) {

		self::watchReads();

		$outer           = self::$recording;
		self::$recording = array(
			'blocks'  => array(),
			'reads'   => array(),
			'options' => array(),
		);

		ob_start();
		self::includeArea( $area );
		$template = ob_get_clean();

		$recorded        = self::$recording;
		self::$recording = $outer;

		$blocks = $recorded['blocks'];

		return array(
			'css'      => preg_replace_callback(
				self::TOKEN,
				function ( $found ) use ( $blocks ) {
					return isset( $blocks[ $found[1] ] ) ? self::render( $blocks[ $found[1] ] ) : '';
				},
				$template
			),
			'template' => $template,
			'blocks'   => $blocks,
			'reads'    => array_keys( $recorded['reads'] ),
			'options'  => (object) $recorded['options'],
		);

	}

	/**
	 * Write one CSS block (wpbf_css()).
	 *
	 * @param string $selector     The selector.
	 * @param array  $declarations Property => value. Values may hold {option_id} or {option_id.key}.
	 * @param array  $args         media: a breakpoint name (see media()) or a media query; always: print the block
	 *                             even when its options are at their defaults; when: an option that must be on
	 *                             ('option_id.key': one part of a JSON option); saved: print a declaration whenever
	 *                             its options are saved, even as their defaults, and nothing while they aren't
	 *                             (theme mods; for old checks without a default); unless: with saved, not when the
	 *                             option is saved exactly as this text (the old `=== '20'` checks); parts: compare
	 *                             each part of a JSON option with the default's part on its own, exactly (the old
	 *                             per-device / per-side checks).
	 */
	public static function rule( $selector, $declarations, $args = array() ) {

		$block = array(
			'selector' => (string) $selector,
			'media'    => self::media( isset( $args['media'] ) ? $args['media'] : '' ),
			'always'   => ! empty( $args['always'] ),
			'when'     => isset( $args['when'] ) ? (string) $args['when'] : '',
			'saved'    => ! empty( $args['saved'] ),
			'unless'   => isset( $args['unless'] ) ? (string) $args['unless'] : null,
			'parts'    => ! empty( $args['parts'] ),
			'lines'    => array(),
		);

		foreach ( (array) $declarations as $property => $value ) {
			$block['lines'][] = array( (string) $property, (string) $value );
		}

		if ( null === self::$recording ) {
			echo self::render( $block ); // phpcs:ignore WordPress.Security.EscapeOutput -- Values are escaped in render().
			return;
		}

		$ids = '' === $block['when'] ? array() : array( self::whenId( $block['when'] ) );

		foreach ( $block['lines'] as $line ) {
			foreach ( self::refs( $line[1] ) as $ref ) {
				$ids[] = $ref[0];
			}
		}

		foreach ( $ids as $id ) {
			$entry = OptionSchema::find( $id );

			self::$recording['options'][ $id ] = array(
				'default' => null === $entry ? null : OptionSchema::defaultValue( $entry ),
				'type'    => isset( $entry['type'] ) ? $entry['type'] : '',
				'json'    => ! empty( $entry['json'] ),
				'saved'   => self::isSaved( $id ),
			);
		}

		self::$recording['blocks'][] = $block;

		echo '/*wpbf-css:' . ( count( self::$recording['blocks'] ) - 1 ) . '*/';

	}

	/**
	 * A breakpoint (Premium's custom breakpoints when set).
	 *
	 * @param string $name desktop, medium or mobile.
	 *
	 * @return int The breakpoint in px.
	 */
	public static function breakpoint( $name ) {

		// Premium's functions, each checked by name (bin/check-premium-deps.php looks for these checks).
		switch ( $name ) {
			case 'desktop':
				return function_exists( 'wpbf_breakpoint_desktop' ) ? (int) wpbf_breakpoint_desktop() : 1024;
			case 'medium':
				return function_exists( 'wpbf_breakpoint_medium' ) ? (int) wpbf_breakpoint_medium() : 768;
			case 'mobile':
				return function_exists( 'wpbf_breakpoint_mobile' ) ? (int) wpbf_breakpoint_mobile() : 480;
		}

		return 0;

	}

	/**
	 * Media query for a breakpoint name.
	 *
	 * Names: max-desktop, max-medium, max-mobile are up to and including the breakpoint ("screen and (max-width:
	 * 1024px)"); min-desktop, min-medium, min-mobile are above it ("(min-width: 1025px)").
	 * Anything else is used as it is.
	 *
	 * @param string $media The breakpoint name or media query.
	 *
	 * @return string The media query, '' for none.
	 */
	public static function media( $media ) {

		if ( preg_match( '/^(max|min)-(desktop|medium|mobile)$/', (string) $media, $match ) ) {
			$breakpoint = self::breakpoint( $match[2] );

			return 'max' === $match[1] ? 'screen and (max-width: ' . $breakpoint . 'px)' : '(min-width: ' . ( $breakpoint + 1 ) . 'px)';
		}

		return (string) $media;

	}

	/**
	 * Render a block.
	 *
	 * @param array $block The block (see rule()).
	 *
	 * @return string The CSS, '' when nothing prints.
	 */
	private static function render( $block ) {

		if ( '' !== $block['when'] && ! self::isOn( $block['when'] ) ) {
			return '';
		}

		$printed = array();

		foreach ( $block['lines'] as $index => $line ) {
			$refs = self::refs( $line[1] );

			if ( ! $refs ) {
				continue;
			}

			$parts   = array();
			$changed = false;

			foreach ( $refs as $placeholder => $ref ) {
				if ( $block['saved'] && ! self::isSaved( $ref[0] ) ) {
					continue 2;
				}

				$value = $block['saved'] ? self::mod( $ref[0] ) : self::value( $ref[0] );
				$part  = '' === $ref[1] ? $value : ( is_array( $value ) && isset( $value[ $ref[1] ] ) ? $value[ $ref[1] ] : null );

				if ( self::isEmpty( $part ) || is_array( $part ) ) {
					continue 2;
				}

				$parts[ $placeholder ] = esc_attr( self::text( $part ) . ( '' !== $ref[2] && is_numeric( $part ) ? $ref[2] : '' ) );
				$changed               = $changed || self::differs( $block, $ref, $value, $part );
			}

			if ( $changed || $block['always'] ) {
				$printed[ $index ] = strtr( $line[1], $parts );
			}
		}

		if ( ! $printed && ! $block['always'] ) {
			return '';
		}

		$css = '';

		foreach ( $block['lines'] as $index => $line ) {
			if ( isset( $printed[ $index ] ) ) {
				$css .= $line[0] . ':' . $printed[ $index ] . ';';
			} elseif ( ! self::refs( $line[1] ) ) {
				$css .= $line[0] . ':' . $line[1] . ';';
			}
		}

		if ( '' === $css ) {
			return '';
		}

		$css = $block['selector'] . '{' . $css . '}';

		return '' === $block['media'] ? $css : '@media ' . $block['media'] . '{' . $css . '}';

	}

	/**
	 * Whether a block's 'when' option is on: 'option_id', or 'option_id.key' for one part of a JSON option (a padding
	 * side). On means PHP truthiness, as the old `if ( $value )` checks.
	 *
	 * @param string $when The option id, or id.key.
	 *
	 * @return bool
	 */
	private static function isOn( $when ) {

		$parts = explode( '.', $when, 2 );
		$value = self::mod( $parts[0] );

		if ( isset( $parts[1] ) ) {
			$value = is_array( $value ) && isset( $value[ $parts[1] ] ) ? $value[ $parts[1] ] : null;
		}

		return (bool) $value;

	}

	/**
	 * The option id of a block's 'when' ('option_id' or 'option_id.key').
	 *
	 * @param string $when The option id, or id.key.
	 *
	 * @return string The option id.
	 */
	private static function whenId( $when ) {

		$parts = explode( '.', $when, 2 );

		return $parts[0];

	}

	/**
	 * Whether one placeholder of a declaration makes it print: its value differs from the default (as a whole for
	 * JSON options); 'parts': this part differs from the default's part, exactly; 'saved': always (it's saved), unless
	 * it's saved exactly as the 'unless' text.
	 *
	 * @param array  $block The block (see rule()).
	 * @param array  $ref   The placeholder (see refs()).
	 * @param mixed  $value The option's value.
	 * @param string $part  The value or part that prints.
	 *
	 * @return bool
	 */
	private static function differs( $block, $ref, $value, $part ) {

		if ( $block['saved'] ) {
			return null === $block['unless'] || self::raw( $ref[0] ) !== $block['unless']; // phpcs:ignore WordPress.PHP.YodaConditions -- Two values.
		}

		if ( $block['parts'] && '' !== $ref[1] ) {
			$default_value = self::defaultOf( $ref[0] );

			return ! is_array( $default_value ) || ! array_key_exists( $ref[1], $default_value ) || $part !== $default_value[ $ref[1] ];
		}

		return ! self::same( $value, self::defaultOf( $ref[0] ) );

	}

	/**
	 * Whether a theme mod is saved: get_theme_mod() has a value for it, as the old `if ( get_theme_mod( … ) )` checks
	 * saw it. In the Customizer preview get_theme_mod() hands over the registered default for an option nobody saved
	 * or changed, so there it also has to be saved or changed (see hasPreviewValue()).
	 *
	 * @param string $id The option id.
	 *
	 * @return bool
	 */
	public static function isSaved( $id ) {

		return false !== self::raw( $id ) && self::hasPreviewValue( $id );

	}

	/**
	 * In the Customizer preview, whether a theme mod is saved or changed in this session (otherwise get_theme_mod()
	 * returns its registered default, which visitors don't get). Always true outside the preview.
	 *
	 * @param string $id The option id.
	 *
	 * @return bool
	 */
	public static function hasPreviewValue( $id ) {

		global $wp_customize;

		if ( ! is_customize_preview() || ! $wp_customize instanceof \WP_Customize_Manager ) {
			return true;
		}

		return array_key_exists( $id, (array) get_theme_mods() ) || array_key_exists( $id, $wp_customize->unsanitized_post_values() );

	}

	/**
	 * A theme mod as get_theme_mod() returns it (no default, not typed), read without counting as a read of the area.
	 *
	 * @param string $id The option id.
	 *
	 * @return mixed The value, false when nothing is saved.
	 */
	private static function raw( $id ) {

		$outer         = self::$in_rule;
		self::$in_rule = true;
		$value         = get_theme_mod( $id );
		self::$in_rule = $outer;

		return $value;

	}

	/**
	 * The option placeholders in a declaration value.
	 *
	 * @param string $value The declaration value.
	 *
	 * @return array Placeholder => array( option id, key or '', unit for plain numbers or '' ).
	 */
	private static function refs( $value ) {

		if ( isset( self::$parsed[ $value ] ) ) {
			return self::$parsed[ $value ];
		}

		preg_match_all( self::REF, $value, $found, PREG_SET_ORDER );

		$refs = array();

		foreach ( $found as $ref ) {
			$refs[ $ref[0] ] = array( $ref[1], isset( $ref[2] ) ? $ref[2] : '', isset( $ref[3] ) ? $ref[3] : '' );
		}

		self::$parsed[ $value ] = $refs;

		return $refs;

	}

	/**
	 * An option's value for wpbf_css(): its value, or its default when it's empty.
	 *
	 * @param string $id The option id.
	 *
	 * @return mixed The value.
	 */
	private static function value( $id ) {

		$value = self::mod( $id );

		return self::isEmpty( $value ) ? self::defaultOf( $id ) : $value;

	}

	/**
	 * An option's value (wpbf_mod()), read without counting as a read of the area.
	 *
	 * @param string $id The option id.
	 *
	 * @return mixed The value.
	 */
	private static function mod( $id ) {

		if ( null !== self::$values && array_key_exists( $id, self::$values ) ) {
			return self::$values[ $id ];
		}

		self::$in_rule = true;
		$value         = wpbf_mod( $id );
		self::$in_rule = false;

		if ( null !== self::$values ) {
			self::$values[ $id ] = $value;
		}

		return $value;

	}

	/**
	 * An option's default from the schema.
	 *
	 * @param string $id The option id.
	 *
	 * @return mixed The default, null when the option is unknown.
	 */
	private static function defaultOf( $id ) {

		$entry = OptionSchema::find( $id );

		return null === $entry ? null : OptionSchema::defaultValue( $entry );

	}

	/**
	 * Whether a value counts as not set.
	 *
	 * @param mixed $value The value.
	 *
	 * @return bool
	 */
	private static function isEmpty( $value ) {

		return null === $value || '' === $value || false === $value || array() === $value;

	}

	/**
	 * Whether a value equals a default. Numbers compare as numbers ('20' equals 20), hex colors without letter case,
	 * JSON options as a whole with empty parts left out.
	 *
	 * @param mixed $value   The value.
	 * @param mixed $default_value The default.
	 *
	 * @return bool
	 */
	private static function same( $value, $default_value ) {

		if ( is_array( $value ) || is_array( $default_value ) ) {
			return is_array( $value ) && is_array( $default_value ) && self::normalize( $value ) === self::normalize( $default_value );
		}

		if ( is_numeric( $value ) && is_numeric( $default_value ) ) {
			return (float) $value === (float) $default_value;
		}

		// Hex colors ignore letter case (#FFFFFF is the default #ffffff).
		if ( is_string( $value ) && is_string( $default_value ) && preg_match( self::HEX, $value ) && preg_match( self::HEX, $default_value ) ) {
			return strtolower( $value ) === strtolower( $default_value );
		}

		return $value === $default_value;

	}

	/**
	 * A JSON option's parts for comparing: empty parts left out, numbers as numbers, sorted by key.
	 *
	 * @param array $value The value.
	 *
	 * @return array
	 */
	private static function normalize( $value ) {

		$normal = array();

		foreach ( $value as $key => $part ) {
			if ( self::isEmpty( $part ) ) {
				continue;
			}

			$normal[ (string) $key ] = is_numeric( $part ) ? (float) $part : ( is_array( $part ) ? wp_json_encode( $part ) : $part );
		}

		ksort( $normal, SORT_STRING );

		return $normal;

	}

	/**
	 * A value as text.
	 *
	 * @param mixed $value The value.
	 *
	 * @return string
	 */
	private static function text( $value ) {

		if ( is_bool( $value ) ) {
			return $value ? '1' : '';
		}

		return (string) $value;

	}

	/**
	 * Include an area's file.
	 *
	 * @param string $area The area name.
	 */
	private static function includeArea( $area ) {

		if ( ! in_array( $area, self::AREAS, true ) ) {
			return;
		}

		$outer        = self::$values;
		self::$values = array();

		include WPBF_THEME_DIR . '/inc/customizer/styles/' . $area . '.php';

		self::$values = $outer;

	}

	/**
	 * Note which options an area reads outside wpbf_css() (Customizer preview).
	 */
	private static function watchReads() {

		global $wp_customize;

		if ( self::$watching || ! $wp_customize instanceof \WP_Customize_Manager ) {
			return;
		}

		self::$watching = true;

		foreach ( $wp_customize->settings() as $setting ) {
			$id   = $setting->id_data()['base'];
			$hook = 'option' === $setting->type ? 'option_' . $id : 'theme_mod_' . $id;

			add_filter(
				$hook,
				function ( $value ) use ( $id ) {
					if ( null !== self::$recording && ! self::$in_rule ) {
						self::$recording['reads'][ $id ] = true;
					}

					return $value;
				},
				PHP_INT_MAX
			);
		}

	}

}
