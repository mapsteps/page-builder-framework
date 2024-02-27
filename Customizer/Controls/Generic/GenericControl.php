<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class GenericControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-generic';

	/**
	 * Input's type.
	 *
	 * @var string
	 */
	public $input_type = 'text';

	/**
	 * Minimum value.
	 *
	 * @var int|float
	 */
	public $min = 0;

	/**
	 * Maximum value.
	 *
	 * @var int|float
	 */
	public $max = 100;

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-generic-control',
			WPBF_THEME_URI . '/Customizer/Controls/Generic/dist/generic-control-min.js',
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

		$this->json['inputType'] = $this->input_type;
		$this->json['min']       = $this->min;
		$this->json['max']       = $this->max;
		$this->json['inputTag']  = $this->input_type === 'textarea' ? 'textarea' : 'input';

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

		<label class="customize-control-label" for="_customize-input-{{ data.id }}">
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<div class="wpbf-control-form">
			<# if ( 'textarea' === data.inputTag ) { #>
			<textarea
				{{{ data.inputAttrs }}}
				{{{ data.link }}}
				id="_customize-input-{{ data.id }}">{{{ data.value }}}</textarea>
			<# } else { #>
			<input
				type="{{ data.inputType }}"
				id="_customize-input-{{ data.id }}"
				value="{{ data.value }}"
				{{{ data.inputAttrs }}}
				{{{ data.link }}}
			>
			<# } #>
		</div>

		<?php
	}

}