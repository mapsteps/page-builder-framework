<?php
/**
 * PBF's "fake" Kirki field classes for compatiblity purpose.
 * These classes will transform supported Kirki's fields into PBF's new Customizer fields.
 *
 * Not all fields are supported yet. These fields are currently NOT supported:
 * - Background
 * - Code
 * - Color Palette
 * - Dashicons
 * - Date
 * - Dimensions (the plural one)
 * - Dropdown Pages
 * - Editor
 *
 * @package Page Builder Framework
 */

namespace Kirki\Field;

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( class_exists( '\Kirki' ) ) {
	return;
}

if ( ! class_exists( ( '\Kirki\Field\Checkbox' ) ) ) {
	/**
	 * PBF's "fake" Checkbox class for compatiblity purpose.
	 * This class will transform Kirki's "checkbox" fields into PBF's new Customizer "checkbox" fields.
	 */
	class Checkbox {

		/**
		 * Margin field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'checkbox';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Color' ) ) ) {
	/**
	 * PBF's "fake" Color class for compatiblity purpose.
	 * This class will transform Kirki's "color" fields into PBF's new Customizer "color" fields.
	 */
	class Color {

		/**
		 * Margin field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'color';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\ReactColorful' ) ) ) {
	/**
	 * PBF's "fake" ReactColorful class for compatiblity purpose.
	 * This class will transform Kirki's "color" fields into PBF's new Customizer "color" fields.
	 */
	class ReactColorful {

		/**
		 * Margin field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'color';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Dimension' ) ) ) {
	/**
	 * PBF's "fake" Dimension class for compatiblity purpose.
	 * This class will transform Kirki's "dimension" fields into PBF's new Customizer "dimension" fields.
	 */
	class Dimension {

		/**
		 * Margin field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'dimension';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Generic' ) ) ) {
	/**
	 * PBF's "fake" Generic class for compatiblity purpose.
	 * This class will transform Kirki's "generic" fields into PBF's new Customizer "generic" fields.
	 */
	class Generic {

		/**
		 * Generic field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$choices = ! empty( $field_args['choices'] ) && is_array( $field_args['choices'] ) ? $field_args['choices'] : [];

			$field_args['type'] = 'text';

			if ( isset( $choices['element'] ) && 'textarea' === $choices['element'] ) {
				$field_args['type'] = 'textarea';
			} elseif ( isset( $choices['type'] ) ) {
				$field_args['type'] = $choices['type'];
			}

			if ( isset( $choices['element'] ) ) {
				unset( $choices['element'] );
			}

			if ( isset( $choices['type'] ) ) {
				unset( $choices['type'] );
			}

			if ( ! isset( $field_args['input_attrs'] ) ) {
				$field_args['input_attrs'] = [];
			}

			foreach ( $choices as $key => $value ) {
				if ( 'min' === $key || 'max' === $key && 'step' === $key ) {
					continue;
				}

				$field_args['input_attrs'][ $key ] = $value;
				unset( $choices[ $key ] );
			}

			$field_args['choices'] = array_values( $choices );

			// Help free up memory.
			unset( $choices );

			$field_args['type'] = 'dimension';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}
