<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;
use WP_Customize_Setting;

class GenericControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-generic';

	/**
	 * Control's subtype.
	 *
	 * @var string
	 */
	public $subtype = 'text';

	/**
	 * Minimum value.
	 *
	 * @var int|float|null
	 */
	public $min = null;

	/**
	 * Maximum value.
	 *
	 * @var int|float|null
	 */
	public $max = null;

	/**
	 * Step value.
	 *
	 * @var int|float
	 */
	public $step = 1;

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

		// Already sanitized in `addControl` method in `GenericField` class.
		if ( ! empty( $args['subtype'] ) ) {
			$this->subtype = $args['subtype'];
		}

		if ( 'number' === $this->subtype ) {
			if ( isset( $args['min'] ) && is_numeric( $args['min'] ) ) {
				$this->min = (float) $args['min'];
			}

			if ( isset( $args['max'] ) && is_numeric( $args['max'] ) ) {
				$this->max = (float) $args['max'];
			}

			if ( ! is_null( $this->min ) && ! is_null( $this->max ) ) {
				if ( $this->min > $this->max ) {
					$this->max = $this->min;
				}
			}

			if ( isset( $args['step'] ) && is_numeric( $args['step'] ) ) {
				$this->step = (float) $args['step'];
			}

			if ( $this->setting instanceof WP_Customize_Setting ) {
				$default_value = $this->setting->default;

				$this->setting->default = ( new NumberUtil() )->parse_number( $default_value, $this->min, $this->max );
			}
		}

	}

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

		$this->json['subtype']  = $this->subtype;
		$this->json['inputTag'] = $this->subtype === 'textarea' ? 'textarea' : 'input';

		if ( 'number' === $this->subtype ) {
			if ( ! is_null( $this->min ) ) {
				$this->json['min'] = $this->min;
			}

			if ( ! is_null( $this->max ) ) {
				$this->json['max'] = $this->max;
			}

			$this->json['step'] = $this->step;
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
				type="{{ data.subtype }}"
				id="_customize-input-{{ data.id }}"
				value="{{ data.value }}"

			<# if ( 'number' === data.subtype ) { #>
			<# if ( 'undefined' !== data.min ) { #>
			min="{{ data.min }}"
			<# } #>

			<# if ( 'undefined' !== data.max ) { #>
			max="{{ data.max }}"
			<# } #>

			step="{{ data.step }}"
			<# } #>

			{{{ data.inputAttrs }}}
			{{{ data.link }}}
			>
			<# } #>
		</div>

		<?php
	}

}