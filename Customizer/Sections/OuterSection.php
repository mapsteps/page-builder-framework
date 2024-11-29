<?php

namespace Mapsteps\Wpbf\Customizer\Sections;

class OuterSection extends BaseSection {

	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = 'wpbf-expanded';

	/**
	 * Path of the section class for this field.
	 *
	 * This property is required for the `WP_Customize_Section::render_template()` method to work.
	 *
	 * @var string
	 */
	public $class_path = '\Mapsteps\Wpbf\Customizer\Sections\OuterSection';

}
