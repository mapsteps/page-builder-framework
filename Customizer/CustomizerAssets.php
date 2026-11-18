<?php
/**
 * The Customizer's control script and stylesheet.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

/**
 * Loads every control, panel and section type of the theme's Customizer as one script and one stylesheet
 * (built from Customizer/src/customizer-controls.ts by `pnpm build`).
 */
class CustomizerAssets {

	/**
	 * Handle of the script and of the stylesheet.
	 *
	 * @var string
	 */
	const HANDLE = 'wpbf-customizer-controls';

	/**
	 * Handles of the scripts each control used to load on its own. They're registered as aliases of the bundle, so code
	 * that depends on one of them (a child theme's script, say) still loads after the controls.
	 *
	 * @var string[]
	 */
	const SCRIPT_ALIASES = array(
		'wpbf-base-control',
		'wpbf-checkbox-control',
		'wpbf-color-control',
		'wpbf-dimension-control',
		'wpbf-editor-control',
		'wpbf-assoc-array-control',
		'wpbf-generic-control',
		'wpbf-margin-padding-control',
		'wpbf-image-control',
		'wpbf-radio-control',
		'wpbf-repeater-control',
		'wpbf-select-control',
		'wpbf-slider-control',
		'wpbf-sortable-control',
		'wpbf-section-tabs-control',
		'wpbf-typography-control',
		'wpbf-panels',
		'wpbf-sections',
	);

	/**
	 * Handles of the stylesheets each control used to load on its own (aliases, as above).
	 *
	 * @var string[]
	 */
	const STYLE_ALIASES = array(
		'wpbf-base-control',
		'wpbf-responsive-control',
		'wpbf-checkbox-control',
		'wpbf-color-control',
		'wpbf-dimension-control',
		'wpbf-editor-control',
		'wpbf-headline-control',
		'wpbf-headline-toggle-control',
		'wpbf-margin-padding-control',
		'wpbf-radio-control',
		'wpbf-repeater-control',
		'wpbf-select-control',
		'wpbf-slider-control',
		'wpbf-sortable-control',
		'wpbf-section-tabs-control',
		'wpbf-typography-control',
		'wpbf-sections',
	);

	/**
	 * Register the script, the stylesheet and the old handles (once).
	 *
	 * Called early on 'customize_controls_enqueue_scripts', before anything localizes data to the handle.
	 *
	 * @return void
	 */
	public static function register() {

		if ( wp_script_is( self::HANDLE, 'registered' ) ) {
			return;
		}

		/*
		 * React from WordPress (the forms use wp.element and its JSX runtime; react-colorful in the color control uses
		 * React directly), jQuery UI sortable (repeater rows), wp-color-picker (the color control reads the palettes
		 * third parties set on it: Premium's color palette is an inline script on that handle).
		 */
		wp_register_script(
			self::HANDLE,
			WPBF_THEME_URI . '/Customizer/dist/customizer-controls-min.js',
			array( 'jquery', 'customize-controls', 'react', 'wp-element', 'react-jsx-runtime', 'jquery-ui-sortable', 'wp-color-picker' ),
			WPBF_VERSION,
			false
		);

		wp_register_style( self::HANDLE, WPBF_THEME_URI . '/Customizer/dist/customizer-controls-min.css', array(), WPBF_VERSION );

		foreach ( self::SCRIPT_ALIASES as $alias ) {
			if ( ! wp_script_is( $alias, 'registered' ) ) {
				wp_register_script( $alias, false, array( self::HANDLE ), WPBF_VERSION, false );
			}
		}

		foreach ( self::STYLE_ALIASES as $alias ) {
			if ( ! wp_style_is( $alias, 'registered' ) ) {
				wp_register_style( $alias, false, array( self::HANDLE ), WPBF_VERSION );
			}
		}

	}

	/**
	 * Enqueue the script and the stylesheet.
	 *
	 * @return void
	 */
	public static function enqueue() {

		self::register();

		wp_enqueue_script( self::HANDLE );
		wp_enqueue_style( self::HANDLE );

	}

}
