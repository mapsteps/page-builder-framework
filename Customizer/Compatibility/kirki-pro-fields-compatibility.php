<?php

namespace Kirki\Pro\Field;

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( class_exists( '\Kirki' ) ) {
	return;
}

if ( ! class_exists( ( '\Kirki\Pro\Field\Margin' ) ) ) {
	class Margin {

		/**
		 * Margin field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'margin';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Pro\Field\Padding' ) ) ) {
	class Padding {

		/**
		 * Padding field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'padding';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Pro\Field\Headline' ) ) ) {
	class Headline {

		/**
		 * Headline field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'headline';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Pro\Field\HeadlineToggle' ) ) ) {
	class HeadlineToggle {

		/**
		 * Headline Toggle field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'headline-toggle';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Pro\Field\Divider' ) ) ) {
	class Divider {

		/**
		 * Divider field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'divider';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Pro\Field\InputSlider' ) ) ) {
	class InputSlider {

		/**
		 * Divider field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'input-slider';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}
