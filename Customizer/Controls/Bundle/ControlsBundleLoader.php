<?php
/**
 * Controls Bundle Loader.
 *
 * Handles loading of bundled customizer control assets.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Bundle;

/**
 * Handles loading of bundled customizer control assets.
 */
class ControlsBundleLoader {

	/**
	 * Whether the control bundle has been enqueued.
	 *
	 * @var bool
	 */
	private static $control_enqueued = false;

	/**
	 * Whether the preview bundle has been enqueued.
	 *
	 * @var bool
	 */
	private static $preview_enqueued = false;

	/**
	 * React version.
	 *
	 * @var string
	 */
	private $react_version = '18.3.1';

	/**
	 * Enqueue the bundled control assets.
	 *
	 * This method is idempotent - calling it multiple times
	 * will only enqueue the assets once.
	 */
	public function enqueue() {

		if ( self::$control_enqueued ) {
			return;
		}

		$this->registerReactDependencies();

		// Enqueue bundled CSS.
		wp_enqueue_style(
			'wpbf-controls-bundle',
			WPBF_THEME_URI . '/Customizer/Controls/Bundle/dist/controls-bundle-min.css',
			array(),
			WPBF_VERSION
		);

		// Enqueue bundled JS.
		wp_enqueue_script(
			'wpbf-controls-bundle',
			WPBF_THEME_URI . '/Customizer/Controls/Bundle/dist/controls-bundle-min.js',
			array(
				'jquery',
				'react',
				'react-dom',
				'react-jsx-runtime',
				'customize-controls',
			),
			WPBF_VERSION,
			false
		);

		self::$control_enqueued = true;

	}

	/**
	 * Enqueue the bundled preview assets.
	 *
	 * This method is idempotent - calling it multiple times
	 * will only enqueue the assets once.
	 */
	public function enqueuePreview() {

		if ( self::$preview_enqueued ) {
			return;
		}

		wp_enqueue_script(
			'wpbf-controls-preview-bundle',
			WPBF_THEME_URI . '/Customizer/Controls/Bundle/dist/controls-preview-bundle-min.js',
			array(
				'wp-hooks',
				'customize-preview',
			),
			WPBF_VERSION,
			true
		);

		self::$preview_enqueued = true;

	}

	/**
	 * Register React dependencies if not already registered.
	 */
	private function registerReactDependencies() {

		if ( ! wp_script_is( 'react', 'registered' ) ) {
			wp_register_script(
				'react',
				WPBF_THEME_URI . '/Customizer/Controls/Base/libs/react.min.js',
				array(),
				$this->react_version,
				true
			);
		}

		if ( ! wp_script_is( 'react-dom', 'registered' ) ) {
			wp_register_script(
				'react-dom',
				WPBF_THEME_URI . '/Customizer/Controls/Base/libs/react.dom-min.js',
				array( 'react' ),
				$this->react_version,
				true
			);
		}

		if ( ! wp_script_is( 'react-jsx-runtime', 'registered' ) ) {
			wp_register_script(
				'react-jsx-runtime',
				WPBF_THEME_URI . '/Customizer/Controls/Base/libs/react-jsx-runtime.min.js',
				array( 'react' ),
				$this->react_version,
				true
			);
		}

	}

	/**
	 * Check if the control bundle has been enqueued.
	 *
	 * @return bool
	 */
	public static function isControlEnqueued() {

		return self::$control_enqueued;

	}

	/**
	 * Check if the preview bundle has been enqueued.
	 *
	 * @return bool
	 */
	public static function isPreviewEnqueued() {

		return self::$preview_enqueued;

	}

	/**
	 * Reset the enqueued state (useful for testing).
	 */
	public static function reset() {

		self::$control_enqueued  = false;
		self::$preview_enqueued = false;

	}

}
