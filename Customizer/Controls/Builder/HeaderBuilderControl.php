<?php
/**
 * Builder control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Builder;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

/**
 * Class to add Wpbf customizer header builder control.
 */
class HeaderBuilderControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-header-builder';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-builder-control', WPBF_THEME_URI . '/Customizer/Controls/Builder/dist/builder-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-builder-control',
			WPBF_THEME_URI . '/Customizer/Controls/Builder/dist/builder-control-min.js',
			array(
				'customize-controls',
				'react-dom',
			),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

	}

}
