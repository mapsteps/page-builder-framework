<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Radio;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class RadioControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-radio';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * Assets are now loaded via the controls bundle.
	 * This method is kept for backwards compatibility.
	 */
	public function enqueue() {

		parent::enqueue();

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

		<span class="customize-control-title">{{{ data.label }}}</span>

		<# if ( data.description ) { #>
		<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<# _.each( data.choices, function( val, key ) { #>
		<label for="_customize-input-{{ data.id }}_{{ key }}">
			<input
				type="radio"
				id="_customize-input-{{ data.id }}_{{ key }}"
				name="_customize-radio-{{ data.id }}"
				value="{{ key }}"
				data-id="{{ data.id }}"
				{{{ data.inputAttrs }}}
				{{ data.link }}
			<# if ( data.value === key ) { #> checked<# } #>
			>

			<# if ( Array.isArray( val ) ) { #>
			{{{ val[0] }}}<span class="option-description">{{{ val[1] }}}</span>
			<# } else { #>
			{{ val }}
			<# } #>
		</label>
		<# } ); #>

		<?php
	}

}
