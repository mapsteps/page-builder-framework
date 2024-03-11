<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

class ResponsiveMarginPaddingControl extends MarginPaddingControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-responsive-margin-padding';

	/**
	 * Control's subtype.
	 *
	 * @var string
	 */
	protected $subtype = 'responsive-margin';

	/**
	 * Control's allowed devices.
	 *
	 * @var string[]
	 */
	public $devices = [ 'desktop', 'tablet', 'mobile' ];

	/**
	 * Control's allowed dimensions.
	 *
	 * @var string[]
	 */
	public static $default_dimensions = [
		'desktop_top',
		'desktop_right',
		'desktop_bottom',
		'desktop_left',
		'tablet_top',
		'tablet_right',
		'tablet_bottom',
		'tablet_left',
		'mobile_top',
		'mobile_right',
		'mobile_bottom',
		'mobile_left',
	];

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['devices'] = $this->devices;

	}

}
