<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Headline;

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
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 */
	protected function render_content() {
		?>

		<input type="hidden" data-customize-setting-link="<?php echo esc_attr( $this->settings['default']->id ); ?>">
		<hr style="border-top: 1px solid <?php echo esc_attr( $this->border_top_color ); ?>; border-bottom: 1px solid <?php echo esc_attr( $this->border_bottom_color ); ?>"/>

		<?php
	}

}
