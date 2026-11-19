<?php
/**
 * Option schema: the one home of every theme option's type, default and stored format.
 *
 * The entries live in one file per area (general.php, header.php …), each returning `id => entry`:
 *
 *     'page_max_width' => array(
 *         'type'    => 'dimension',   // The control type, as wpbf_customizer_field()->type() takes it.
 *         'default' => '1200px',      // The value visitors see when nothing is saved. A closure for translated or site-dependent text.
 *         'json'    => true,          // Optional: saved as JSON text (the control's `save_as_json`), read back as an array.
 *     ),
 *
 * Ids with `{archive}` / `{single}` stand for every entry of the `wpbf_archives` / `wpbf_singles` filters
 * ('{archive}_layout' covers archive_layout, search_layout, docs-archive_layout …).
 *
 * Only options that store a value are listed. Fields that only show something (separators, headlines, notes)
 * stay in the settings files. A plugin adds entries for its own options with the `wpbf_option_schema` filter (the
 * Premium Add-On); its fields then take type and default from here like the theme's. Fields registered
 * without an entry (older Premium, child themes, plugins) aren't listed: the builder records their declared type and
 * default (see record()), so wpbf_mod() reads them too.
 *
 * @package Page Builder Framework
 */

namespace Mapsteps\Wpbf\Customizer\Schema;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Option schema.
 */
final class OptionSchema {

	/**
	 * The area files, in Customizer order.
	 *
	 * @var string[]
	 */
	const AREAS = array( 'general', 'typography', 'blog', 'header', 'footer', 'woocommerce', 'edd' );

	/**
	 * Option types read back as true/false.
	 *
	 * @var string[]
	 */
	const BOOLEAN_TYPES = array( 'toggle', 'checkbox', 'headline-toggle' );

	/**
	 * Option types read back as numbers.
	 *
	 * @var string[]
	 */
	const NUMBER_TYPES = array( 'slider', 'number' );

	/**
	 * The filter that lists the ids each placeholder stands for, and the filter's default.
	 *
	 * @var array
	 */
	const PLACEHOLDERS = array(
		'{archive}' => array( 'wpbf_archives', 'archive' ),
		'{single}'  => array( 'wpbf_singles', 'single' ),
	);

	/**
	 * Entries with a fixed id, by id. Null until loaded.
	 *
	 * @var array|null
	 */
	private static $options = null;

	/**
	 * Entries with a placeholder, by placeholder and then by the rest of the id ('{archive}' => [ '_layout' => entry ]).
	 *
	 * @var array
	 */
	private static $templates = array();

	/**
	 * Resolved placeholder ids, by id.
	 *
	 * @var array
	 */
	private static $resolved = array();

	/**
	 * Fields declared through the builder that aren't in the schema (Premium, child themes, plugins), by id.
	 *
	 * @var array
	 */
	private static $recorded = array();

	/**
	 * Get the schema entry of a theme option.
	 *
	 * @param string $id The option id.
	 *
	 * @return array|null The entry (type, default, json), or null if the theme doesn't define this option.
	 */
	public static function get( $id ) {

		if ( ! is_string( $id ) || '' === $id ) {
			return null;
		}

		self::load();

		if ( isset( self::$options[ $id ] ) ) {
			return self::$options[ $id ];
		}

		if ( isset( self::$resolved[ $id ] ) ) {
			return self::$resolved[ $id ];
		}

		foreach ( self::$templates as $placeholder => $entries ) {
			foreach ( $entries as $rest => $entry ) {
				$prefix_length = strlen( $id ) - strlen( $rest );

				if ( $prefix_length < 1 || substr( $id, $prefix_length ) !== $rest ) {
					continue;
				}

				if ( in_array( substr( $id, 0, $prefix_length ), self::placeholderIds( $placeholder ), true ) ) {
					self::$resolved[ $id ] = $entry;

					return $entry;
				}
			}
		}

		return null;

	}

	/**
	 * Get the entry of any option: the theme's schema first, then fields recorded from the builder.
	 *
	 * @param string $id The option id.
	 *
	 * @return array|null The entry, or null if the option is unknown.
	 */
	public static function find( $id ) {

		$entry = self::get( $id );

		if ( null !== $entry ) {
			return $entry;
		}

		return is_string( $id ) && isset( self::$recorded[ $id ] ) ? self::$recorded[ $id ] : null;

	}

	/**
	 * Record a field declared through the builder, so wpbf_mod() knows its default if the schema doesn't list it.
	 *
	 * Called for every declared field on every request (Premium declares its fields early), so it only stores:
	 * the schema itself is only loaded when something is read. find() asks the schema first.
	 *
	 * @param string $id The option id.
	 * @param string $type The control type.
	 * @param mixed  $default_value The declared default.
	 * @param bool   $json Whether the value is saved as JSON text.
	 * @param string $storage 'theme_mod' (default) or 'option'.
	 */
	public static function record( $id, $type, $default_value, $json, $storage = 'theme_mod' ) {

		if ( ! is_string( $id ) || '' === $id ) {
			return;
		}

		self::$recorded[ $id ] = array(
			'type'    => (string) $type,
			'default' => $default_value,
			'json'    => (bool) $json,
			'storage' => 'option' === $storage ? 'option' : 'theme_mod',
		);

	}

	/**
	 * Get the ids of every option of a type: the theme's (placeholder ids left out) and those recorded from the builder.
	 *
	 * @param string $type The control type, e.g. 'typography'.
	 *
	 * @return array Entries by id, in schema order, then in the order they were declared.
	 */
	public static function ofType( $type ) {

		self::load();

		$found = array();

		foreach ( array( self::$options, self::$recorded ) as $entries ) {
			foreach ( $entries as $id => $entry ) {
				if ( isset( $entry['type'] ) && $type === $entry['type'] && ! isset( $found[ $id ] ) ) {
					$found[ $id ] = null === self::get( $id ) ? $entry : self::get( $id );
				}
			}
		}

		return $found;

	}

	/**
	 * Get every entry of the theme's schema, placeholder ids as written ('{archive}_layout').
	 *
	 * @return array The entries, by id.
	 */
	public static function all() {

		self::load();

		$all = self::$options;

		foreach ( self::$templates as $placeholder => $entries ) {
			foreach ( $entries as $rest => $entry ) {
				$all[ $placeholder . $rest ] = $entry;
			}
		}

		return $all;

	}

	/**
	 * Get an entry's default value, as wpbf_mod() returns it.
	 *
	 * @param array $entry The entry.
	 *
	 * @return mixed The default.
	 */
	public static function defaultValue( $entry ) {

		$value = isset( $entry['default'] ) ? $entry['default'] : '';

		return $value instanceof \Closure ? $value() : $value;

	}

	/**
	 * Turn a saved value into the type the entry stands for.
	 *
	 * JSON options come back as arrays (the default if the text can't be read), toggles as true/false
	 * (same truthiness the output code has always used), sliders and numbers as int or float. Everything
	 * else is returned as saved.
	 *
	 * @param array $entry The entry.
	 * @param mixed $value The saved value.
	 *
	 * @return mixed The typed value.
	 */
	public static function typed( $entry, $value ) {

		if ( ! empty( $entry['json'] ) ) {
			if ( is_string( $value ) ) {
				$value = json_decode( $value, true );
			}

			return is_array( $value ) ? $value : self::defaultValue( $entry );
		}

		$type = isset( $entry['type'] ) ? $entry['type'] : '';

		if ( in_array( $type, self::BOOLEAN_TYPES, true ) ) {
			return (bool) $value;
		}

		if ( in_array( $type, self::NUMBER_TYPES, true ) && is_numeric( $value ) ) {
			$number = (float) $value;

			return floor( $number ) === $number && abs( $number ) < PHP_INT_MAX ? (int) $number : $number;
		}

		return $value;

	}

	/**
	 * Get the ids a placeholder stands for.
	 *
	 * @param string $placeholder The placeholder, e.g. '{archive}'.
	 *
	 * @return string[] The ids.
	 */
	private static function placeholderIds( $placeholder ) {

		list( $filter, $default_id ) = self::PLACEHOLDERS[ $placeholder ];

		$ids = apply_filters( $filter, array( $default_id ) );

		return is_array( $ids ) ? $ids : array( $default_id );

	}

	/**
	 * Load the area files once, then the entries plugins add.
	 */
	private static function load() {

		if ( null !== self::$options ) {
			return;
		}

		self::$options = array();

		foreach ( self::AREAS as $area ) {
			self::addEntries( require __DIR__ . '/' . $area . '.php', true );
		}

		/**
		 * Filters the option schema entries a plugin adds for the options it registers (the Premium Add-On), in the
		 * format of the theme's area files: id => entry, `{archive}` / `{single}` ids included. Read once, the first
		 * time an option is looked up. The theme's own entries can't be replaced.
		 *
		 * @param array $entries Entries by id.
		 */
		$entries = apply_filters( 'wpbf_option_schema', array() );

		if ( is_array( $entries ) ) {
			self::addEntries( $entries, false );
		}

	}

	/**
	 * Add entries to the loaded schema.
	 *
	 * @param array $entries The entries, by id.
	 * @param bool  $replace Whether an entry replaces one with the same id.
	 */
	private static function addEntries( $entries, $replace ) {

		foreach ( $entries as $id => $entry ) {
			if ( ! is_string( $id ) || '' === $id || ! is_array( $entry ) ) {
				continue;
			}

			$placeholder = strpos( $id, '{' ) === 0 ? substr( $id, 0, strpos( $id, '}' ) + 1 ) : '';

			if ( $placeholder && isset( self::PLACEHOLDERS[ $placeholder ] ) ) {
				$rest = substr( $id, strlen( $placeholder ) );

				if ( $replace || ! isset( self::$templates[ $placeholder ][ $rest ] ) ) {
					self::$templates[ $placeholder ][ $rest ] = $entry;
				}
			} elseif ( $replace || ! isset( self::$options[ $id ] ) ) {
				self::$options[ $id ] = $entry;
			}
		}

	}

}
