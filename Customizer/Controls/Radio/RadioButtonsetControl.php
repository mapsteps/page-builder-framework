<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Radio;

class RadioButtonsetControl extends RadioControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-radio-buttonset';

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
			<# for ( key in data.choices ) { #>
				<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="{{ key }}" name="_customize-radio-{{{ data.id }}}" id="{{ data.id }}-{{ key }}" {{{ data.link }}}<# if ( key === data.value ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( key === data.value ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}-{{ key }}">{{{ data.choices[ key ] }}}</label>
				</input>
			<# } #>
		</div>

		<?php
	}

}
