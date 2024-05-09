<?php
/**
 * Collections of PBF's "fake" Kirki field classes for compatiblity purpose.
 * These classes will transform supported Kirki's fields into PBF's new customizer fields.
 *
 * Supported fields:
 * - Checkbox
 * - Code
 * - Color
 * - ReactColorful
 * - Dimension
 * - Editor
 * - Generic
 * - Image
 * - URL
 * - Number
 * - Radio
 * - Radio Buttonset
 * - Radio Image
 * - Repeater
 * - Select
 * - ReactSelect
 * - Slider
 * - Sortable
 * - Switch
 * - Text
 * - Textarea
 * - Toggle
 * - Typography
 * - Upload
 *
 * @package Page Builder Framework
 */

namespace Kirki\Field;

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( ! class_exists( ( '\Kirki\Field\Checkbox' ) ) ) {
	/**
	 * PBF's "fake" Checkbox class for compatiblity purpose.
	 * This class will transform Kirki's "checkbox" fields into PBF's new Customizer "checkbox" fields.
	 */
	class Checkbox {

		/**
		 * PBF's "fake"Checkbox field constructor.
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

if ( ! class_exists( ( '\Kirki\Field\Code' ) ) ) {
	/**
	 * PBF's "fake" Code class for compatiblity purpose.
	 * This class will transform Kirki's "code" fields into PBF's new Customizer "code" fields.
	 */
	class Code {

		/**
		 * Code field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'code';

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
		 * Color field constructor.
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
		 * ReactColorful field constructor.
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
		 * Dimension field constructor.
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

if ( ! class_exists( ( '\Kirki\Field\Editor' ) ) ) {
	/**
	 * PBF's "fake" Editor class for compatiblity purpose.
	 * This class will transform Kirki's "editor" fields into PBF's new Customizer "editor" fields.
	 */
	class Editor {

		/**
		 * Editor field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'editor';

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

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Image' ) ) ) {
	/**
	 * PBF's "fake" Image class for compatiblity purpose.
	 * This class will transform Kirki's "image" fields into PBF's new Customizer "image" fields.
	 */
	class Image {

		/**
		 * Image field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'image';

			if ( ! isset( $field_args['choices'] ) ) {
				$field_args['choices'] = [];
			}

			if ( ! isset( $field_args['choices']['save_as'] ) ) {
				$field_args['choices']['save_as'] = 'url';
			}

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\URL' ) ) ) {
	/**
	 * PBF's "fake" URL class for compatiblity purpose.
	 * This class will transform Kirki's "url" fields into PBF's new Customizer "url" fields.
	 */
	class URL {

		/**
		 * URL field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'url';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Number' ) ) ) {
	/**
	 * PBF's "fake" Number class for compatiblity purpose.
	 * This class will transform Kirki's "number" fields into PBF's new Customizer "number" fields.
	 */
	class Number {

		/**
		 * Number field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'number';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Radio' ) ) ) {
	/**
	 * PBF's "fake" Radio class for compatiblity purpose.
	 * This class will transform Kirki's "radio" fields into PBF's new Customizer "radio" fields.
	 */
	class Radio {

		/**
		 * Radio field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'radio';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Radio_Buttonset' ) ) ) {
	/**
	 * PBF's "fake" Radio_Buttonset class for compatiblity purpose.
	 * This class will transform Kirki's "radio-buttonset" fields into PBF's new Customizer "radio-buttonset" fields.
	 */
	class Radio_Buttonset {

		/**
		 * Radio_Buttonset field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'radio-buttonset';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Radio_Image' ) ) ) {
	/**
	 * PBF's "fake" Radio_Image class for compatiblity purpose.
	 * This class will transform Kirki's "radio-image" fields into PBF's new Customizer "radio-image" fields.
	 */
	class Radio_Image {

		/**
		 * Radio_Image field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'radio-image';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Repeater' ) ) ) {
	/**
	 * PBF's "fake" Repeater class for compatiblity purpose.
	 * This class will transform Kirki's "repeater" fields into PBF's new Customizer "repeater" fields.
	 */
	class Repeater {

		/**
		 * Repeater field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'repeater';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Select' ) ) ) {
	/**
	 * PBF's "fake" Select class for compatiblity purpose.
	 * This class will transform Kirki's "select" fields into PBF's new Customizer "select" fields.
	 */
	class Select {

		/**
		 * Select field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'select';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\ReactSelect' ) ) ) {
	/**
	 * PBF's "fake" ReactSelect class for compatiblity purpose.
	 * This class will transform Kirki's "select" fields into PBF's new Customizer "select" fields.
	 */
	class ReactSelect {

		/**
		 * ReactSelect field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'select';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Slider' ) ) ) {
	/**
	 * PBF's "fake" Slider class for compatiblity purpose.
	 * This class will transform Kirki's "slider" fields into PBF's new Customizer "slider" fields.
	 */
	class Slider {

		/**
		 * Slider field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'slider';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Sortable' ) ) ) {
	/**
	 * PBF's "fake" Sortable class for compatiblity purpose.
	 * This class will transform Kirki's "sortable" fields into PBF's new Customizer "sortable" fields.
	 */
	class Sortable {

		/**
		 * Sortable field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'sortable';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Checkbox_Switch' ) ) ) {
	/**
	 * PBF's "fake" Checkbox_Switch class for compatiblity purpose.
	 * This class will transform Kirki's "switch" fields into PBF's new Customizer "toggle" fields with checkbox type set to "switch".
	 */
	class Checkbox_Switch {

		/**
		 * Checkbox_Switch field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'switch';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Text' ) ) ) {
	/**
	 * PBF's "fake" Text class for compatiblity purpose.
	 * This class will transform Kirki's "text" fields into PBF's new Customizer "text" fields.
	 */
	class Text {

		/**
		 * Text field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'text';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Textarea' ) ) ) {
	/**
	 * PBF's "fake" Textarea class for compatiblity purpose.
	 * This class will transform Kirki's "textarea" fields into PBF's new Customizer "textarea" fields.
	 */
	class Textarea {

		/**
		 * Textarea field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'textarea';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Checkbox_Toggle' ) ) ) {
	/**
	 * PBF's "fake" Checkbox_Toggle class for compatiblity purpose.
	 * This class will transform Kirki's "toggle" fields into PBF's new Customizer "toggle" fields.
	 */
	class Checkbox_Toggle {

		/**
		 * Checkbox_Toggle field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'toggle';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Toggle' ) ) ) {
	/**
	 * PBF's "fake" Toggle class for compatiblity purpose.
	 * This class will transform Kirki's "toggle" fields into PBF's new Customizer "toggle" fields.
	 */
	class Toggle {

		/**
		 * Toggle field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'toggle';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Typography' ) ) ) {
	/**
	 * PBF's "fake" Typography class for compatiblity purpose.
	 * This class will transform Kirki's "typography" fields into PBF's new Customizer "typography" fields.
	 */
	class Typography {

		/**
		 * Typography field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'typography';

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Field\Upload' ) ) ) {
	/**
	 * PBF's "fake" Upload class for compatiblity purpose.
	 * This class will transform Kirki's "upload" fields into PBF's new Customizer "upload" fields.
	 */
	class Upload {

		/**
		 * Upload field constructor.
		 *
		 * @param array $field_args The field arguments.
		 */
		public function __construct( $field_args = [] ) {

			$field_args['type'] = 'upload';

			if ( ! isset( $field_args['choices'] ) ) {
				$field_args['choices'] = [];
			}

			if ( ! isset( $field_args['choices']['save_as'] ) ) {
				$field_args['choices']['save_as'] = 'url';
			}

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_field( '', $field_args );
			}

		}

	}
}
