<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class CheckboxControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-checkbox';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-checkbox-control', WPBF_THEME_URI . '/Customizer/Controls/Checkbox/dist/checkbox-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-checkbox-control',
			WPBF_THEME_URI . '/Customizer/Controls/Checkbox/dist/checkbox-control-min.js',
			array( 'wpbf-base-control' ),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Control::to_json().
	 *
	 * @see WP_Customize_Control::print_template()
	 */
	protected function content_template() {
		?>

		<input
			id="_customize-input-{{ data.id }}"
			type="checkbox"
			value="{{ data.value }}"
			{{{ data.link }}}
		<# if ( data.description ) { #>aria-describedby="_customize-description-{{ data.id }}"<# } #>
		<# if ( data.value ) { #>checked="checked"<# } #>
		>

		<label for="_customize-input-{{ data.id }}">{{{ data.label }}}</label>

		<# if ( data.description ) { #>
		<span id="_customize-description-{{ data.id }}" class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<?php
	}

}
