<?php

namespace Mapsteps\Wpbf\Customizer\Panels;

use WP_Customize_Panel;

class BuilderPanel extends WP_Customize_Panel {

	/**
	 * Type of this panel.
	 *
	 * @var string
	 */
	public $type = 'wpbf-builder';

	/**
	 * An Underscore (JS) template for rendering this panel's container.
	 *
	 * Class variables for this panel class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Panel::json().
	 *
	 * @see WP_Customize_Panel::print_template()
	 *
	 * @since 4.3.0
	 */
	protected function render_template() {
		?>

		<li id="accordion-panel-{{ data.id }}" class="accordion-section control-section control-panel control-panel-{{ data.type }}">
			<h3 class="accordion-section-title" tabindex="0">
				{{ data.title }}
				<span class="screen-reader-text">
					<?php
					/* translators: Hidden accessibility text. */
					_e( 'Press return or enter to open this panel' );
					?>
				</span>
			</h3>
			<ul class="accordion-sub-container control-panel-content"></ul>
		</li>

		<?php
	}

}
