<?php

if ( class_exists( '\Kirki' ) ) {
	return;
}

/**
 * Faking Kirki class to support PBF's Kirki compatibility.
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

		$priority    = isset( $panel_args['priority'] ) ? $panel_args['priority'] : 10;
		$title       = isset( $panel_args['title'] ) ? $panel_args['title'] : '';
		$description = isset( $panel_args['description'] ) ? $panel_args['description'] : '';

		wpbf_customizer_panel()
			->id( $panel_id )
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
		$priority    = isset( $section_args['priority'] ) ? $section_args['priority'] : 10;
		$title       = isset( $section_args['title'] ) ? $section_args['title'] : '';
		$description = isset( $section_args['description'] ) ? $section_args['description'] : '';
		$tabs        = isset( $section_args['tabs'] ) ? $section_args['tabs'] : [];

		wpbf_customizer_section()
			->id( $section_id )
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

		$config      = self::get_config( $config_key );
		$option_type = isset( $field_args['option_type'] ) ? $field_args['option_type'] : '';
		$option_type = 'options' === $option_type ? 'option' : $option_type;
		$option_name = isset( $field_args['option_name'] ) ? $field_args['option_name'] : '';

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

		$type              = ! empty( $field_args['type'] ) ? $field_args['type'] : '';
		$settings          = ! empty( $field_args['settings'] ) ? $field_args['settings'] : '';
		$section           = ! empty( $field_args['section'] ) ? $field_args['section'] : '';
		$label             = ! empty( $field_args['label'] ) ? $field_args['label'] : '';
		$description       = ! empty( $field_args['description'] ) ? $field_args['description'] : '';
		$priority          = ! empty( $field_args['priority'] ) ? $field_args['priority'] : 10;
		$default           = ! empty( $field_args['default'] ) ? $field_args['default'] : '';
		$choices           = ! empty( $field_args['choices'] ) ? $field_args['choices'] : array();
		$is_multi          = ! empty( $field_args['multiple'] ) && 1 < $field_args['multiple'];
		$max_selections    = $is_multi ? absint( $field_args['multiple'] ) : 1;
		$active_callback   = ! empty( $field_args['active_callback'] ) && is_array( $field_args['active_callback'] ) ? $field_args['active_callback'] : [];
		$sanitize_callback = ! empty( $field_args['sanitize_callback'] ) ? $field_args['sanitize_callback'] : '';
		$partial_refresh   = ! empty( $field_args['partial_refresh'] ) ? $field_args['partial_refresh'] : array();
		$transport         = ! empty( $field_args['transport'] ) ? $field_args['transport'] : '';
		$min               = ! empty( $field_args['min'] ) ? $field_args['min'] : null;
		$max               = ! empty( $field_args['max'] ) ? $field_args['max'] : null;
		$step              = ! empty( $field_args['step'] ) ? $field_args['step'] : null;
		$alpha_mode        = ! empty( $field_args['alpha'] ) ? $field_args['alpha'] : false;
		$save_as           = ! empty( $field_args['save_as'] ) ? $field_args['save_as'] : '';
		$tab               = ! empty( $field_args['tab'] ) ? $field_args['tab'] : '';
		$wrapper_attrs     = ! empty( $field_args['wrapper_opts'] ) && is_array( $field_args['wrapper_opts'] ) ? $field_args['wrapper_opts'] : [];
		$input_attrs       = ! empty( $field_args['input_attrs'] ) && is_array( $field_args['input_attrs'] ) ? $field_args['input_attrs'] : [];

		$custom_props = [];

		if ( ! is_null( $min ) || ! is_null( $max ) || ! is_null( $step ) || $alpha_mode || ! empty( $tab ) || ! empty( $wrapper_attrs ) || ! empty( $input_attrs ) || $is_multi ) {
			if ( ! is_null( $min ) ) {
				$custom_props['min'] = $min;
			}

			if ( ! is_null( $max ) ) {
				$custom_props['max'] = $max;
			}

			if ( ! is_null( $step ) ) {
				$custom_props['step'] = $step;
			}

			if ( $alpha_mode ) {
				$custom_props['mode'] = 'alpha';
			}

			if ( $is_multi ) {
				$custom_props['is_multi']       = true;
				$custom_props['max_selections'] = $max_selections;
			}

			if ( ! empty( $save_as ) ) {
				$custom_props['save_as'] = $save_as;
			}

			if ( ! empty( $tab ) ) {
				$custom_props['tab'] = $tab;
			}

			if ( ! empty( $wrapper_attrs ) ) {
				$custom_props['wrapper_attrs'] = $wrapper_attrs;
			}

			if ( ! empty( $input_attrs ) ) {
				$custom_props['input_attrs'] = $input_attrs;
			}
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
			$active_callback = array_map( function ( $dependency_arg ) {
				if ( empty( $dependency_arg ) || ! is_array( $dependency_arg ) ) {
					return [];
				}

				return [
					'id'       => $dependency_arg['setting'],
					'operator' => $dependency_arg['operator'],
					'value'    => $dependency_arg['value'],
				];
			}, $active_callback );
		}

		wpbf_customizer_field()
			->id( $settings )
			->type( $type )
			->tab( $tab )
			->label( $label )
			->description( $description )
			->defaultValue( $default )
			->choices( $choices )
			->priority( $priority )
			->activeCallback( $active_callback )
			->sanitizeCallback( $sanitize_callback )
			->partialRefresh( $partial_refresh )
			->transport( $transport )
			->properties( $custom_props )
			->addToSection( $section );

	}

}
