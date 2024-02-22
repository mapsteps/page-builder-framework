<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Divider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class DividerControl extends BaseControl {
	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-divider';

	/**
	 * Border top color.
	 *
	 * @var string
	 */
	public $border_top_color = '#ccc';

	/**
	 * Border bottom color.
	 *
	 * @var string
	 */
	public $border_bottom_color = '#f8f8f8';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['borderTopColor']    = $this->border_top_color;
		$this->json['borderBottomColor'] = $this->border_bottom_color;

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

		<hr style="border-top: 1px solid {{ data.borderTopColor }}; border-bottom: 1px solid {{ data.borderBottomColor }}"/>

		<?php
	}
}