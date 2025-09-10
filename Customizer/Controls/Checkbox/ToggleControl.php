<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

class ToggleControl extends CheckboxControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-toggle';

	/**
	 * The checkbox type. Accepts 'toggle' or 'switch'.
	 *
	 * @var string
	 */
	protected $checkbox_type = 'toggle';

	/**
	 * Allowed checkbox types.
	 *
	 * @var string[]
	 */
	protected $allowed_checkbox_types = [ 'toggle', 'switch' ];

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the `$id` as the setting ID.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Optional. Array of properties for the new Control object.
	 *                                                   Default empty array.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		parent::__construct( $wp_customize_manager, $id, $args );

		if ( ! empty( $args['checkbox_type'] ) && in_array( $args['checkbox_type'], $this->allowed_checkbox_types, true ) ) {
			$this->checkbox_type = $args['checkbox_type'];
		}

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['checkboxType'] = $this->checkbox_type;

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
				<label class="customize-control-title" for="_customize-input-{{ data.id }}">
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
					id="_customize-input-{{ data.id }}" type="checkbox" value="{{ data.value }}"
					name="wpbf_{{ data.id }}"
					class="screen-reader-text wpbf-toggle-switch-input"
					{{{ data.inputAttrs }}}
					{{{ data.link }}} <# if ( '1' == data.value ) { #> checked<# } #>
				>

				<label class="wpbf-toggle-switch-label" for="_customize-input-{{ data.id }}">
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
