<?php
/**
 * Collections of PBF's "fake" Kirki field classes for compatiblity purpose.
 * These classes will NOT transform the fields.
 * They are here just to prevent fatal errors.
 *
 * List of Un-supported fields:
 * - Background
 * - Color Palette
 * - Dashicons
 * - Date
 * - Dimensions (the plural one, not the singular one)
 * - Dropdown Pages
 * - Multicheck
 * - Multicolor
 * - Palette
 *
 * @package Page Builder Framework
 */

namespace Kirki\Field;

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( ! class_exists( ( '\Kirki\Field\Background' ) ) ) {
	/**
	 * PBF's "fake" Background class for compatiblity purpose.
	 */
	class Background {

		/**
		 * Background field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Color_Palette' ) ) ) {
	/**
	 * PBF's "fake" Color_Palette class for compatiblity purpose.
	 */
	class Color_Palette {

		/**
		 * Color_Palette field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Dashicons' ) ) ) {
	/**
	 * PBF's "fake" Dashicons class for compatiblity purpose.
	 */
	class Dashicons {

		/**
		 * Dashicons field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Date' ) ) ) {
	/**
	 * PBF's "fake" Date class for compatiblity purpose.
	 */
	class Date {

		/**
		 * Date field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Dimensions' ) ) ) {
	/**
	 * PBF's "fake" Dimensions class for compatiblity purpose.
	 */
	class Dimensions {

		/**
		 * Dimensions field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Dropdown_Pages' ) ) ) {
	/**
	 * PBF's "fake" Dropdown_Pages class for compatiblity purpose.
	 */
	class Dropdown_Pages {

		/**
		 * Dropdown_Pages field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Multicheck' ) ) ) {
	/**
	 * PBF's "fake" Multicheck class for compatiblity purpose.
	 */
	class Multicheck {

		/**
		 * Multicheck field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Multicolor' ) ) ) {
	/**
	 * PBF's "fake" Multicolor class for compatiblity purpose.
	 */
	class Multicolor {

		/**
		 * Multicolor field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Palette' ) ) ) {
	/**
	 * PBF's "fake" Palette class for compatiblity purpose.
	 */
	class Palette {

		/**
		 * Palette field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {}

	}
}
