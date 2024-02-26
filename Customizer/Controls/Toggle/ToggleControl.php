<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Toggle;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class ToggleControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-toggle';

	/**
	 * The checkbox type.
	 *
	 * @var string $checkboxType Accepts 'toggle' or 'switch'.
	 */
	public $checkboxType = 'toggle';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-toggle-control', WPBF_THEME_URI . '/Customizer/Controls/Toggle/dist/toggle-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
//		wp_enqueue_script(
//			'wpbf-toggle-control',
//			WPBF_THEME_URI . '/Customizer/Controls/Toggle/dist/toggle-control-min.js',
//			array(
//				'customize-controls',
//				'react-dom',
//			),
//			WPBF_VERSION,
//			false
//		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['checkboxType'] = $this->checkboxType;

		$this->json['defaultChoices'] = [
			'on'  => __( 'On', 'page-builder-framework' ),
			'off' => __( 'Off', 'page-builder-framework' ),
		];

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

		<div class="wpbf-{{ data.checkboxType }}-control wpbf-{{ data.checkboxType }}">
			<# if ( data.label || data.description ) { #>
			<div class="wpbf-control-label">
				<# if ( data.label ) { #>
				<label class="customize-control-title" for="wpbf_{{ data.checkboxType }}_{{ data.id }}">
					{{{ data.label }}}
				</label>
				<# } #>

				<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</div>
			<# } #>

			<div class="wpbf-control-form">
				<input
					id="wpbf_{{ data.checkboxType }}_{{ data.id }}" type="checkbox" value="{{ data.value }}"
					name="wpbf_{{ data.checkboxType }}_{{ data.id }}"
					class="screen-reader-text wpbf-toggle-switch-input"
					{{{ data.inputAttrs }}}
					{{{ data.link }}} <# if ( '1' == data.value ) { #> checked<# } #>
				>

				<label class="wpbf-toggle-switch-label" for="wpbf_{{ data.checkboxType }}_{{ data.id }}">
					<# if ('switch' === data.checkboxType) { #>
					<span class="toggle-on">
							<# data.choices.on = data.choices.on || data.defaultChoices.on #>
							{{ data.choices.on }}
					</span>
					<span class="toggle-off">
							<# data.choices.off = data.choices.off || data.defaultChoices.off #>
							{{ data.choices.off }}
					</span>
					<# } #>
				</label>
			</div>
		</div>

		<?php
	}

}