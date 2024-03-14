<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Custom;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class CustomControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-custom';

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

		<div>
			<# if ( data.label ) { #>
				<label class="customize-control-title">{{{ data.label }}}</label>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<?php
			/**
			 * The value is defined by the developer in the field configuration as 'default'.
			 *
			 * There is no user input on this field, it's a raw HTML/JS field and we do not sanitize it.
			 * Don't be alarmed, this is not a security issue.
			 *
			 * In order for someone to be able to change this they would have to have access to your filesystem.
			 * If that happens, they can change whatever they want anyways.
			 * This field is not a concern.
			 */
			?>
			{{{ data.value }}}
		</label>

		<?php
	}

}
