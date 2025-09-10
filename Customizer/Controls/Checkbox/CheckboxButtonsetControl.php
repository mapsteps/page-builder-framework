<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class CheckboxButtonsetControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-checkbox-buttonset';

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

		<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>

		<div id="input_{{ data.id }}" class="buttonset">
			<# var index = 0; #>
			<# var totalChoices = Object.keys( data.choices ).length; #>

			<# for ( key in data.choices ) { #>
				<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="checkbox" value="{{ key }}" name="_customize-checkbox-{{{ data.id }}}" id="{{ data.id }}-{{ key }}"<# if ( data.value.includes(key) ) { #> checked="checked" <# } #> />

				<label class="switch-label<# if ( index === 0 ) {#> first-label <#} #><# if ( index === totalChoices - 1 ) {#> last-label <#} #>" for="{{ data.id }}-{{ key }}">
					{{{ data.choices[ key ] }}}
				</label>

				<# index++; #>
			<# } #>
		</div>

		<?php
	}

}
