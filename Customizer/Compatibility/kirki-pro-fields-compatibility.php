<?php
/**
 * PBF's "fake" Kirki Pro classes for compatiblity purpose.
 * These classes will transform supported Kirki Pro's fields into PBF's new Customizer fields.
 *
 * Currently, "responsive" argument is not supported.
 * When possible, please use PBF's responsive controls instead.
 *
 * @package Page Builder Framework
 */

namespace Kirki\Pro\Field;

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( ! class_exists( ( '\Kirki\Pro\Field\Margin' ) ) ) {
	/**
	 * PBF's "fake" Margin class for compatiblity purpose.
	 * This class will transform Kirki Pro's "Margin" fields into PBF's new Customizer "margin" fields.
	 */
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
	/**
	 * PBF's "fake" Padding class for compatiblity purpose.
	 * This class will transform Kirki Pro's "Padding" fields into PBF's new Customizer "padding" fields.
	 */
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
	/**
	 * PBF's "fake" Headline class for compatiblity purpose.
	 * This class will transform Kirki Pro's "Headline" fields into PBF's new Customizer "headline" fields.
	 */
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
	/**
	 * PBF's "fake" HeadlineToggle class for compatiblity purpose.
	 * This class will transform Kirki Pro's "HeadlineToggle" fields into PBF's new Customizer "headline-toggle" fields.
	 */
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
	/**
	 * PBF's "fake" Divider class for compatiblity purpose.
	 * This class will transform Kirki Pro's "Divider" fields into PBF's new Customizer "divider" fields.
	 */
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
	/**
	 * PBF's "fake" InputSlider class for compatiblity purpose.
	 * This class will transform Kirki Pro's "InputSlider" fields into PBF's new Customizer "input-slider" fields.
	 */
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
