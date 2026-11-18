<?php
/**
 * Kirki safety net. FROZEN: keep it working exactly as it is, don't improve or extend it.
 *
 * What it's for
 * The theme used the Kirki library for its Customizer until it got its own engine. Code written for that time still
 * calls Kirki directly:
 * - Premium Add-On 2.9 and older (all its Customizer options, Kirki::add_panel/add_section/add_field). Its EDD
 *   integration calls Kirki::add_field() on after_setup_theme without checking that Kirki exists, so without this file
 *   every site with Premium 2.9 or older and Easy Digital Downloads active crashes (fatal error).
 * - Child themes and plugins that add Customizer options the Kirki way.
 * Premium 2.10 and newer use the theme's builder (wpbf_customizer_field() …) and don't need this file. Compatibility is
 * promised for Premium 2.10+ only; older versions must just not crash, and their users see the "update Premium" notice
 * (inc/settings/compatibility-notice.php, and the Customizer's "Compatibility Warning" section).
 *
 * How it works
 * Every class below is only declared when the real one doesn't exist, so the Kirki plugin, if active, wins. The stand-ins
 * hand what they get to the theme's builder (wpbf_customizer_panel(), wpbf_customizer_section(), wpbf_customizer_field()),
 * which records it like any other option. Nothing here runs unless someone calls it.
 *
 * What it supports
 * - \Kirki::add_config(), get_config(), add_panel(), add_section(), add_field(); a config's capability, and its
 *   option_type "option"/"options" + option_name, which only renames the setting to option_name[setting]: it's still
 *   saved as a theme mod (theme_mods_…[option_name][setting]), not in the option real Kirki used (so it has been since
 *   2024; Premium 2.9 doesn't use configs).
 * - Field arguments: type, settings, section, tab, label, description, default (0, '0' and false kept), choices, priority,
 *   transport, tooltip, active_callback (Kirki rules "setting"/"operator"/"value", operator defaults to "=="; rules without a
 *   setting and nested OR groups are left out; a callable is passed through), sanitize_callback, partial_refresh,
 *   input_attrs, wrapper_attrs/wrapper_opts. Choices min/max/step, alpha, multiple, save_as, form_component and
 *   accept_unitless become field properties; color swatches/palettes, editor tinymce/quicktags and repeater row_label,
 *   button_label, limit and fields are passed on.
 * - Types: every type the theme's builder knows, plus the old names switch (toggle with switch look), code_editor (code),
 *   radio_buttonset (radio-buttonset), link (url), input_slider (input-slider), and the theme's old custom types
 *   padding_control, responsive_padding, responsive_input_slider and responsive_input (saved as JSON, as before).
 * - Kirki 4 classes: \Kirki\Panel, \Kirki\Section, \Kirki\Control\Base and the fields Checkbox, Checkbox_Switch,
 *   Checkbox_Toggle, Toggle, Code, Color, ReactColorful, Dimension, Editor, Generic, Image, URL, Number, Radio,
 *   Radio_Buttonset, Radio_Image, Repeater, Select, ReactSelect, Slider, Sortable, Text, Textarea, Typography, Upload;
 *   Kirki Pro's Margin, Padding, Headline, HeadlineToggle, Divider, InputSlider.
 * - Classes that only exist so code checking or extending them doesn't crash: Kirki_Control_Base,
 *   Kirki_Customize_Control, WPBF_Customize_Input_Slider, WPBF_Customize_Padding_Control, WPBF_Customize_Font_Size_Control,
 *   WPBF_Customize_Responsive_Input_Slider, WPBF_Customize_Responsive_Padding_Control.
 *
 * What it doesn't support (no error, the option just doesn't appear or the argument is ignored)
 * Kirki 4's Background, Color_Palette, Dashicons, Date, Dimensions (plural), Dropdown_Pages, Multicheck, Multicolor and
 * Palette fields; Kirki's "output"/"js_vars" (Kirki-generated CSS and live preview); Kirki Pro's "responsive" argument.
 *
 * Kirki-era pieces elsewhere (part of the theme's API, not of this file): the pluggable wpbf_kirki_sanitize_helper() in
 * inc/customizer/settings/settings-helpers.php (loads on after_setup_theme, so Premium 2.9's own copy keeps winning), the
 * wpbf_kirki_font_choices, kirki_color_swatches and kirki_default_color_swatches filters, the color field's swatches/palettes
 * properties and Kirki's choices format for selects (Customizer/Controls/Select/SelectChoices.php).
 *
 * Changes here only to keep it from crashing (e.g. if the builder's API changes); then test with Premium 2.9.2
 * (its git tag) + EDD and with fields added through every class above.
 *
 * @package Page Builder Framework
 */

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound, Universal.Namespaces.DisallowCurlyBraceSyntax, Universal.Namespaces.OneDeclarationPerFile, Universal.Namespaces.DisallowDeclarationWithoutName

namespace {

	defined( 'ABSPATH' ) || die( "Can't access directly" );

	// The Kirki class (add_config, add_panel, add_section, add_field) and Kirki 3's control base classes.

	if ( ! class_exists( '\Kirki' ) ) {
		/**
		 * PBF's "fake" Kirki class for compatiblity purpose.
		 * This class will transform supported Kirki's fields into PBF's new customizer fields.
		 * Not all fields are supported yet.
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
		 * - Select
		 * - ReactSelect
		 * - Repeater
		 * - Slider
		 * - Sortable
		 * - Switch
		 * - Text
		 * - Textarea
		 * - Toggle
		 * - Typography
		 * - Upload
		 *
		 * Not all fields are supported yet. These fields are currently NOT supported:
		 * - Background
		 * - Color Palette
		 * - Dashicons
		 * - Date
		 * - Dimensions (the plural one)
		 * - Dropdown Pages
		 * - Multicheck
		 * - Multicolor
		 * - Palette
		 */
		class Kirki {

			/**
			 * An array containing all configurations.
			 *
			 * @var array
			 */
			public static $configs = array();

			/**
			 * Add a config.
			 *
			 * @param string $config_key The config key.
			 * @param array  $config_args The config arguments.
			 */
			public static function add_config( $config_key = '', $config_args = array() ) {

				self::$configs[ $config_key ] = $config_args;

			}

			/**
			 * Get a config.
			 *
			 * @param string $config_key The config key.
			 * @return array|null
			 */
			public static function get_config( $config_key = '' ) {

				return ! empty( self::$configs[ $config_key ] ) && is_array( self::$configs[ $config_key ] ) ? self::$configs[ $config_key ] : array();

			}

			/**
			 * Add a panel.
			 *
			 * @param string $panel_id The panel id.
			 * @param array  $panel_args The panel arguments.
			 */
			public static function add_panel( $panel_id = '', $panel_args = [] ) {

				$type        = isset( $panel_args['type'] ) ? $panel_args['type'] : '';
				$parent_id   = isset( $panel_args['panel'] ) ? $panel_args['panel'] : '';
				$priority    = isset( $panel_args['priority'] ) ? $panel_args['priority'] : 10;
				$title       = isset( $panel_args['title'] ) ? $panel_args['title'] : '';
				$description = isset( $panel_args['description'] ) ? $panel_args['description'] : '';

				wpbf_customizer_panel()
					->id( $panel_id )
					->parentId( $parent_id )
					->type( $type )
					->title( $title )
					->description( $description )
					->priority( $priority )
					->add();
			}

			/**
			 * Add a section.
			 *
			 * @param string $section_id The section id.
			 * @param array  $section_args The section arguments.
			 */
			public static function add_section( $section_id = '', $section_args = [] ) {

				$panel_id    = isset( $section_args['panel'] ) ? $section_args['panel'] : '';
				$type        = isset( $section_args['type'] ) ? $section_args['type'] : '';
				$parent_id   = isset( $section_args['section'] ) ? $section_args['section'] : '';
				$priority    = isset( $section_args['priority'] ) ? $section_args['priority'] : 10;
				$title       = isset( $section_args['title'] ) ? $section_args['title'] : '';
				$description = isset( $section_args['description'] ) ? $section_args['description'] : '';
				$tabs        = isset( $section_args['tabs'] ) ? $section_args['tabs'] : [];

				wpbf_customizer_section()
					->id( $section_id )
					->parentId( $parent_id )
					->type( $type )
					->title( $title )
					->description( $description )
					->priority( $priority )
					->tabs( $tabs )
					->addToPanel( $panel_id );

			}

			/**
			 * Add a field.
			 *
			 * @param string $config_key The config key.
			 * @param array  $field_args The field arguments.
			 */
			public static function add_field( $config_key = '', $field_args = array() ) {

				$config = self::get_config( $config_key );

				$option_type = isset( $field_args['option_type'] ) ? $field_args['option_type'] : '';
				$option_type = 'options' === $option_type ? 'option' : $option_type;
				$option_name = isset( $field_args['option_name'] ) ? $field_args['option_name'] : '';
				$capability  = isset( $field_args['capability'] ) ? $field_args['capability'] : '';

				if ( empty( $option_type ) ) {
					$option_type = $config && ! empty( $config['option_type'] ) ? $config['option_type'] : '';
				}

				if ( 'option' === $option_type ) {
					if ( empty( $option_name ) ) {
						$option_name = $config && ! empty( $config['option_name'] ) ? $config['option_name'] : '';
					}
				} else {
					$option_name = '';
				}

				if ( empty( $capability ) ) {
					$capability = $config && ! empty( $config['capability'] ) ? $config['capability'] : '';
				}

				$type              = ! empty( $field_args['type'] ) ? $field_args['type'] : '';
				$settings          = ! empty( $field_args['settings'] ) ? $field_args['settings'] : '';
				$tab               = ! empty( $field_args['tab'] ) ? $field_args['tab'] : '';
				$section           = ! empty( $field_args['section'] ) ? $field_args['section'] : '';
				$label             = ! empty( $field_args['label'] ) ? $field_args['label'] : '';
				$description       = ! empty( $field_args['description'] ) ? $field_args['description'] : '';
				$default           = isset( $field_args['default'] ) ? $field_args['default'] : ''; // Keeps 0, '0' and false.
				$choices           = ! empty( $field_args['choices'] ) && is_array( $field_args['choices'] ) ? $field_args['choices'] : array();
				$priority          = isset( $field_args['priority'] ) && is_numeric( $field_args['priority'] ) ? (int) $field_args['priority'] : 10;
				$transport         = ! empty( $field_args['transport'] ) ? $field_args['transport'] : '';
				$tooltip           = ! empty( $field_args['tooltip'] ) ? $field_args['tooltip'] : '';
				$active_callback   = ! empty( $field_args['active_callback'] ) && is_array( $field_args['active_callback'] ) ? $field_args['active_callback'] : [];
				$sanitize_callback = ! empty( $field_args['sanitize_callback'] ) ? $field_args['sanitize_callback'] : '';
				$partial_refresh   = ! empty( $field_args['partial_refresh'] ) ? $field_args['partial_refresh'] : array();
				$input_attrs       = ! empty( $field_args['input_attrs'] ) && is_array( $field_args['input_attrs'] ) ? $field_args['input_attrs'] : [];
				$wrapper_attrs     = ! empty( $field_args['wrapper_opts'] ) && is_array( $field_args['wrapper_opts'] ) ? $field_args['wrapper_opts'] : [];

				if ( ! empty( $field_args['wrapper_attrs'] ) && is_array( $field_args['wrapper_attrs'] ) ) {
					$wrapper_attrs = array_merge( $wrapper_attrs, $field_args['wrapper_attrs'] );
				}

				$custom_props = [];

				if ( isset( $choices['min'] ) ) {
					$custom_props['min'] = $choices['min'];
					unset( $choices['min'] );
				}

				if ( isset( $choices['max'] ) ) {
					$custom_props['max'] = $choices['max'];
					unset( $choices['max'] );
				}

				if ( isset( $choices['step'] ) ) {
					$custom_props['step'] = $choices['step'];
					unset( $choices['step'] );
				}

				if ( isset( $choices['alpha'] ) ) {
					$custom_props['mode'] = 'alpha';
					unset( $choices['alpha'] );
				}

				if ( isset( $choices['multiple'] ) ) {
					$custom_props['is_multi'] = is_numeric( $choices['multiple'] ) && 1 < $choices['multiple'];

					if ( $custom_props['is_multi'] ) {
						$custom_props['max_selections'] = absint( $choices['multiple'] );
					}

					unset( $choices['multiple'] );
				}

				if ( isset( $choices['save_as'] ) ) {
					$custom_props['save_as'] = $choices['save_as'];
					unset( $choices['save_as'] );
				}

				if ( ! empty( $wrapper_attrs ) ) {
					$custom_props['wrapper_attrs'] = $wrapper_attrs;
				}

				if ( isset( $choices['form_component'] ) ) {
					$custom_props['form_component'] = $choices['form_component'];
					unset( $choices['form_component'] );
				}

				if ( isset( $choices['accept_unitless'] ) ) {
					$custom_props['allow_unitless'] = boolval( $choices['accept_unitless'] );
					unset( $choices['accept_unitless'] );
				}

				if ( 'option' === $option_type && ! empty( $option_name ) ) {
					$has_sub_options = false !== stripos( $settings, '[' );

					if ( $has_sub_options ) {
						$splits_by_sub_option = explode( '[', $settings );
						$first_level_option   = $splits_by_sub_option[0];

						if ( ! empty( $first_level_option ) ) {
							$settings_without_first_level = str_ireplace( $first_level_option . '[', '[', $settings );

							$settings = $option_name . '[' . $first_level_option . ']' . $settings_without_first_level;
						}
					} else {
						$settings = $option_name . '[' . $settings . ']';
					}
				}

				if ( ! empty( $active_callback ) && is_array( $active_callback ) ) {
					// Kirki rules: "setting" + "value", "operator" optional (defaults to "==").
					// Rules without a setting (incl. Kirki's nested "OR" groups, which the engine doesn't support) are left out.
					$active_callback = array_values(
						array_filter(
							array_map(
								function ( $dependency_arg ) {
									if ( ! is_array( $dependency_arg ) || empty( $dependency_arg['setting'] ) || ! array_key_exists( 'value', $dependency_arg ) ) {
										return [];
									}

									return [
										'id'       => $dependency_arg['setting'],
										'operator' => ! empty( $dependency_arg['operator'] ) ? $dependency_arg['operator'] : '==',
										'value'    => $dependency_arg['value'],
									];
								},
								$active_callback
							)
						)
					);
				} elseif ( ! empty( $field_args['active_callback'] ) && is_callable( $field_args['active_callback'] ) ) {
					$active_callback = $field_args['active_callback'];
				}

				// Kirki's field types compatibility.

				if ( 'switch' === $type ) {
					$type = 'toggle';

					$custom_props['checkbox_type'] = 'switch';
				}

				if ( 'code_editor' === $type ) {
					$type = 'code';
				}

				if ( 'color' === $type ) {
					if ( isset( $choices['swatches'] ) ) {
						$custom_props['color_swatches'] = $choices['swatches'];
						unset( $choices['swatches'] );
					} elseif ( isset( $choices['palettes'] ) ) {
						$custom_props['color_swatches'] = $choices['palettes'];
						unset( $choices['palettes'] );
					}
				}

				if ( 'editor' === $type ) {
					if ( isset( $choices['tinymce'] ) ) {
						$custom_props['tinymce'] = $choices['tinymce'];
						unset( $choices['tinymce'] );
					}

					if ( isset( $choices['quicktags'] ) ) {
						$custom_props['quicktags'] = $choices['quicktags'];
						unset( $choices['quicktags'] );
					}
				}

				if ( 'repeater' === $type ) {
					$type = 'repeater';

					if ( isset( $choices['row_label'] ) ) {
						$custom_props['row_label'] = $choices['row_label'];
						unset( $choices['row_label'] );
					}

					if ( isset( $choices['button_label'] ) ) {
						$custom_props['button_label'] = $choices['button_label'];
						unset( $choices['button_label'] );
					}

					if ( isset( $choices['limit'] ) ) {
						$custom_props['limit'] = $choices['limit'];
						unset( $choices['limit'] );
					}

					$custom_props['fields'] = [];

					if ( isset( $choices['fields'] ) ) {
						$custom_props['fields'] = is_array( $choices['fields'] ) ? $choices['fields'] : [];
						unset( $choices['fields'] );
					}

					foreach ( $custom_props['fields'] as $field_id => $field ) {
						if ( isset( $field['choices'] ) ) {
							if ( ! isset( $field['properties'] ) ) {
								$custom_props['fields'][ $field_id ]['properties'] = [];
							}

							if ( isset( $field['choices']['save_as'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['save_as'] = $field['choices']['save_as'];
								unset( $field['choices']['save_as'] );
							}

							if ( ! empty( $field['choices']['alpha'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['mode'] = 'alpha';
								unset( $field['choices']['alpha'] );
							}

							if ( isset( $field['choices']['form_component'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['form_component'] = $field['choices']['form_component'];
								unset( $field['choices']['form_component'] );
							}

							if ( isset( $field['choices']['accept_unitless'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['allow_unitless'] = $field['choices']['accept_unitless'];
								unset( $field['choices']['accept_unitless'] );
							}

							if ( isset( $field['choices']['min'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['min'] = $field['choices']['min'];
								unset( $field['choices']['min'] );
							}

							if ( isset( $field['choices']['max'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['max'] = $field['choices']['max'];
								unset( $field['choices']['max'] );
							}

							if ( isset( $field['choices']['step'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['step'] = $field['choices']['step'];
								unset( $field['choices']['step'] );
							}

							if ( isset( $field['choices']['multiple'] ) ) {
								$custom_props['fields'][ $field_id ]['properties']['is_multi'] = 1 < $field['choices']['multiple'];
								unset( $field['choices']['multiple'] );
							}
						}
					}
				}

				// Page Builder Framework's custom controls.
				if ( 'padding_control' === $type || 'responsive_padding' === $type || 'responsive_input_slider' === $type || 'responsive_input' === $type ) {
					$default = [];

					if ( ! empty( $field_args['default'] ) && is_string( $field_args['default'] ) ) {
						$default = json_decode( $field_args['default'], true );
						$default = ! $default || ! is_array( $default ) ? [] : $default;
					}

					// Let's just use our new default sanitize callback.
					$sanitize_callback = '';

					$custom_props['save_as_json'] = true;

					if ( 'padding_control' === $type || 'responsive_padding' === $type ) {
						$custom_props['dont_save_unit'] = true;

						if ( 'padding_control' === $type ) {
							$type = 'padding';
						} else {
							$type = 'responsive-padding';
						}
					}

					if ( 'responsive_input_slider' === $type ) {
						$type = 'responsive-input-slider';
					}

					if ( 'responsive_input' === $type ) {
						$is_number_field = true;

						if ( ! empty( $default ) ) {
							foreach ( $default as $key => $value ) {
								if ( ! is_numeric( $value ) ) {
									$is_number_field = false;
									break;
								}
							}
						}

						if ( $is_number_field ) {
							$default = array_map( function ( $value ) {
								return (float) $value;
							}, $default );

							$type = 'responsive-number';
						} else {
							$type = 'responsive-text';
						}
					}
				}

				// Other PBF's field types compatibility.
				if ( 'input_slider' === $type ) {
					$type = 'input-slider';
				}

				// Old type names (e.g. Premium 2.9 and older).
				if ( 'radio_buttonset' === $type ) {
					$type = 'radio-buttonset';
				}

				if ( 'link' === $type ) {
					$type = 'url';
				}

				wpbf_customizer_field()
					->id( $settings )
					->type( $type )
					->tab( $tab )
					->label( $label )
					->description( $description )
					->defaultValue( $default )
					->choices( $choices )
					->capability( $capability )
					->priority( $priority )
					->transport( $transport )
					->tooltip( $tooltip )
					->inputAttrs( $input_attrs )
					->properties( $custom_props )
					->activeCallback( $active_callback )
					->sanitizeCallback( $sanitize_callback )
					->partialRefresh( $partial_refresh )
					->addToSection( $section );

			}

		}
	}

	if ( ! class_exists( '\Kirki_Control_Base' ) ) {
		/**
		 * PBF's "fake" Kirki_Control_Base class for compatiblity purpose.
		 */
		class Kirki_Control_Base {}
	}

	if ( ! class_exists( '\Kirki_Customize_Control' ) ) {
		/**
		 * PBF's "fake" Kirki_Customize_Control class for compatiblity purpose.
		 */
		class Kirki_Customize_Control {}
	}

}

namespace Kirki {

	// Kirki 4's panel and section classes.

	if ( ! class_exists( ( '\Kirki\Panel' ) ) ) {
		/**
		 * PBF's "fake" Kirki's Panel class for compatiblity purpose.
		 */
		class Panel {

			/**
			 * PBF's "fake" Kirki\Panel constructor.
			 *
			 * @param string $id ID of the panel.
			 * @param array  $args Arguments of the panel.
			 */
			public function __construct( $id, $args = [] ) {

				if ( class_exists( '\Kirki' ) ) {
					\Kirki::add_panel( $id, $args );
				}

			}

		}
	}

	if ( ! class_exists( ( '\Kirki\Section' ) ) ) {
		/**
		 * PBF's "fake" Kirki's Section class for compatiblity purpose.
		 */
		class Section {

			/**
			 * PBF's "fake" Kirki\Section constructor.
			 *
			 * @param string $id ID of the panel.
			 * @param array  $args Arguments of the panel.
			 */
			public function __construct( $id, $args = [] ) {

				if ( class_exists( '\Kirki' ) ) {
					\Kirki::add_section( $id, $args );
				}

			}

		}
	}

}

namespace Kirki\Control {

	// Kirki 4's control base class (custom controls extend it).

	if ( ! class_exists( ( '\Kirki\Control\Base' ) ) ) {
		/**
		 * PBF's "fake" Kirki's Base class for compatiblity purpose.
		 */
		class Base {}
	}

}

namespace Kirki\Field {

	// Kirki 4's field classes: each hands its arguments to \Kirki::add_field() with its type.

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

				// min/max/step stay in the choices (\Kirki::add_field turns them into the field's properties), everything else becomes an input attribute.
				foreach ( $choices as $key => $value ) {
					if ( in_array( $key, array( 'min', 'max', 'step' ), true ) ) {
						continue;
					}

					$field_args['input_attrs'][ $key ] = $value;
					unset( $choices[ $key ] );
				}

				$field_args['choices'] = $choices;

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

}

namespace Kirki\Field {

	// Kirki 4's field classes that aren't supported: they do nothing, they only prevent a fatal error.

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

}

namespace Kirki\Pro\Field {

	// Kirki Pro's field classes (their "responsive" argument isn't supported).

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

}

namespace {

	// The theme's control classes from before its own Customizer (code may still check or extend them): empty.

	if ( ! class_exists( 'WPBF_Customize_Input_Slider' ) ) {
		/**
		 * PBF's "fake" WPBF_Customize_Input_Slider class for compatiblity purpose.
		 */
		class WPBF_Customize_Input_Slider {}
	}

	if ( ! class_exists( 'WPBF_Customize_Padding_Control' ) ) {
		/**
		 * PBF's "fake" WPBF_Customize_Padding_Control class for compatiblity purpose.
		 */
		class WPBF_Customize_Padding_Control {}
	}

	if ( ! class_exists( 'WPBF_Customize_Font_Size_Control' ) ) {
		/**
		 * PBF's "fake" WPBF_Customize_Font_Size_Control class for compatiblity purpose.
		 */
		class WPBF_Customize_Font_Size_Control {}
	}

	if ( ! class_exists( 'WPBF_Customize_Responsive_Input_Slider' ) ) {
		/**
		 * PBF's "fake" WPBF_Customize_Responsive_Input_Slider class for compatiblity purpose.
		 */
		class WPBF_Customize_Responsive_Input_Slider {}
	}

	if ( ! class_exists( 'WPBF_Customize_Responsive_Padding_Control' ) ) {
		/**
		 * PBF's "fake" WPBF_Customize_Responsive_Padding_Control class for compatiblity purpose.
		 */
		class WPBF_Customize_Responsive_Padding_Control {}
	}

}
