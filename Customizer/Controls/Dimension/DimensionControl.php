<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Dimension;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class DimensionControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-dimension';

	/**
	 * Label position.
	 *
	 * @var string
	 */
	public $label_position = 'top';

	/**
	 * Whether to allow value without units.
	 *
	 * @var bool
	 */
	public $allow_unitless = true;

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-dimension-control', WPBF_THEME_URI . '/Customizer/Controls/Dimension/dist/dimension-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-dimension-control',
			WPBF_THEME_URI . '/Customizer/Controls/Dimension/dist/dimension-control-min.js',
			array( 'wpbf-base-control' ),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		$input_class = 'wpbf-control-input';

		if ( isset( $this->input_attrs['class'] ) ) {
			$input_class .= ' ' . $this->input_attrs['class'];
			unset( $this->input_attrs['class'] );
		}

		parent::to_json();

		$this->json['inputClass'] = $input_class;

		$this->json['labelPosition'] = $this->label_position;

		$this->json['allowUnitless'] = $this->allow_unitless;

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

		<div class="wpbf-control-form <# if ('bottom' === data.labelPosition) { #>has-label-bottom<# } #>">
			<# if ( 'top' === data.labelPosition ) { #>
			<label class="wpbf-control-label" for="{{ data.inputId }}">
				<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><#
				} #>
			</label>
			<# } #>

			<div class="wpbf-input-control">
				<# var val = ( data.value && _.isString( data.value ) ) ? data.value.replace( '%%', '%' ) : ''; #>
				<input id="{{ data.inputId }}" {{{ data.inputAttrs }}} type="text" value="{{ val }}"
						class="{{ data.inputClass }}"/>
			</div>

			<# if ( 'bottom' === data.labelPosition ) { #>
			<label class="wpbf-control-label" for="{{ data.inputId }}">
				<# if ( data.label ) { #>{{{ data.label }}} <# } #>
			</label>
			<# } #>
		</div>

		<?php
	}

}
