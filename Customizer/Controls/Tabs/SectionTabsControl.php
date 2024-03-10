<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Tabs;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class SectionTabsControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-section-tabs';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-section-tabs-control', WPBF_THEME_URI . '/Customizer/Controls/Tabs/dist/section-tabs-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-section-tabs-control',
			WPBF_THEME_URI . '/Customizer/Controls/Tabs/dist/section-tabs-control-min.js',
			array(
				'customize-controls',
				'react-dom',
			),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$tabs = ! empty( $this->choices ) ? $this->choices : [];

		$tab_menu_output = '';
		$loop_index      = 0;

		foreach ( $tabs as $tab_key => $tab_args ) {
			++$loop_index;

			$tab_menu_output .= '
			<li class="wpbf-tab-menu-item' . ( 1 === $loop_index ? ' is-active' : '' ) . '" data-wpbf-tab-menu-id="' . esc_attr( $tab_key ) . '">
				<a href="#" class="wpbf-tab-link">' . esc_html( $tab_args['label'] ) . '</a>
			</li>
			';
		}

		$this->json['tabMenuOutput'] = $tab_menu_output;

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

		<div class="wpbf-tab" data-wpbf-tab-id="{{{ data.sectionId }}}">
			<ul class="wpbf-tab-menu">
				{{{ data.tabMenuOutput }}}
			</ul>
		</div>

		<?php
	}

}
