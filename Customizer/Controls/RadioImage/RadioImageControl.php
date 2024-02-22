<?php

namespace Mapsteps\Wpbf\Customizer\Controls\RadioImage;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class RadioImageControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-radio-image';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-radio-image-control', WPBF_THEME_URI . '/Customizer/Controls/RadioImage/dist/radio-image-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-radio-image-control',
			WPBF_THEME_URI . '/Customizer/Controls/RadioImage/dist/radio-image-control-min.js',
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

		foreach ( $this->input_attrs as $attr => $value ) {
			if ( 'style' !== $attr ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
				continue;
			}

			$this->json['labelStyle'] = 'style="' . esc_attr( $value ) . '" ';
		}

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

		<label class="customizer-text">
			<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>

			<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<div id="input_{{ data.id }}" class="image">
			<# for ( key in data.choices ) { #>

			<# dataAlt = ( _.isObject( data.choices[ key ] ) && ! _.isUndefined( data.choices[ key ].alt ) ) ?
			data.choices[ key ].alt : '' #>

			<input
				type="radio"
				class="image-select"
				value="{{ key }}"
				name="_customize-radio-{{ data.id }}"
				id="{{ data.id }}{{ key }}"
				data-alt="{{ dataAlt }}"
				{{{ data.inputAttrs }}}
				{{{ data.link }}} <# if ( data.value === key ) { #> checked="checked"<# } #>
			>

			<label for="{{ data.id }}{{ key }}" {{{ data.labelStyle }}} class="{{{ data.id + key }}}">
				<# if ( _.isObject( data.choices[ key ] ) ) { #>
				<img src="{{ data.choices[ key ].src }}" alt="{{ data.choices[ key ].alt }}">
				<span class="image-label"><span class="inner">{{ data.choices[ key ].alt }}</span></span>
				<# } else { #>
				<img src="{{ data.choices[ key ] }}">
				<# } #>
				<span class="image-clickable"></span>
			</label>
			<# } #>
		</div>

		<?php
	}

}