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
	 * Accepts one of this values: "number", "number-unit", "text", "textarea", "email", "url", and "content".
	 *
	 * @var string
	 */
	protected $subtype = 'text';

	/**
	 * The allowed 'subtype' property.
	 *
	 * @var string[]
	 */
	protected $allowed_subtypes = [ 'number', 'number-unit', 'text', 'textarea', 'email', 'url', 'content' ];

	/**
	 * Number of rows for 'textarea' & 'content' subtype.
	 *
	 * @var int
	 */
	protected $rows = 5;

	/**
	 * Minimum value for 'number' and 'number-unit' subtype.
	 *
	 * @var int|float|null
	 */
	public $min = null;

	/**
	 * Maximum value for 'number' and 'number-unit' subtype.
	 *
	 * @var int|float|null
	 */
	public $max = null;

	/**
	 * Increase/decrease step value for 'number' and 'number-unit' subtype.
	 *
	 * @var int|float
	 */
	public $step = 1;

	/**
	 * Instance of `NumberUtil` class.
	 *
	 * @var NumberUtil
	 */
	protected $number_util;

	/**
	 * Instance of `ResponsiveGenericUtil` class.
	 *
	 * @var ResponsiveGenericUtil
	 */
	protected $responsive_util;

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

		$this->number_util     = new NumberUtil();
		$this->responsive_util = new ResponsiveGenericUtil();

		// Already sanitized in `addControl` method in `GenericField` class.
		if ( ! empty( $args['subtype'] ) ) {
			$this->subtype = $args['subtype'];
		}

		if ( ! in_array( $this->subtype, $this->allowed_subtypes, true ) ) {
			$this->subtype = 'text';
		}

		if ( 'number' === $this->subtype || 'number-unit' === $this->subtype ) {
			if ( isset( $args['min'] ) && is_numeric( $args['min'] ) ) {
				$this->min = (float) $args['min'];
			}

			if ( isset( $args['max'] ) && is_numeric( $args['max'] ) ) {
				$this->max = (float) $args['max'];
			}

			$this->max = $this->number_util->normalizeMaxValue( $this->min, $this->max );

			if ( isset( $args['step'] ) && is_numeric( $args['step'] ) ) {
				$this->step = (float) $args['step'];
			}
		} elseif ( 'textarea' === $this->subtype || 'content' === $this->subtype ) {
			if ( isset( $args['rows'] ) && is_numeric( $args['rows'] ) ) {
				$this->rows = absint( $args['rows'] );
			}
		}

		$this->customConstructor( $args );

	}

	/**
	 * Custom constructor that could be different with other controls that extend this control.
	 *
	 * @param array $args The control arguments.
	 */
	protected function customConstructor( $args ) {

		if ( $this->setting instanceof WP_Customize_Setting ) {
			$this->setting->default = $this->responsive_util->sanitizeSingleValue(
				$this->subtype,
				$this->setting->default,
				$this->min,
				$this->max
			);
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
		$this->json['inputTag'] = 'textarea' === $this->subtype || 'content' === $this->subtype ? 'textarea' : 'input';

		if ( 'textarea' !== $this->subtype && 'content' !== $this->subtype ) {
			$this->json['inputType'] = 'number-util' === $this->subtype ? 'text' : $this->subtype;
		}

		if ( 'number' === $this->subtype || 'number-unit' === $this->subtype ) {
			if ( ! is_null( $this->min ) ) {
				$this->json['min'] = $this->min;
			}

			if ( ! is_null( $this->max ) ) {
				$this->json['max'] = $this->max;
			}

			$this->json['step'] = $this->step;
		} elseif ( 'textarea' === $this->subtype || 'content' === $this->subtype ) {
			$this->json['rows'] = $this->rows;
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
			<# if ( 'textarea' === data.inputTag || 'content' === data.inputTag ) { #>
				<textarea
					{{{ data.inputAttrs }}}
					{{{ data.link }}}
					id="_customize-input-{{ data.id }}"
					rows="{{ data.rows }}">{{{ data.value }}}</textarea>
			<# } else { #>
				<input
					type="{{ data.inputType }}"
					id="_customize-input-{{ data.id }}"
					value="{{ data.value }}"

					<# if ( 'number' === data.subtype ) { #>
						<# if ( 'undefined' !== typeof data.min ) { #>
						min="{{ data.min }}"
						<# } #>

						<# if ( 'undefined' !== typeof data.max ) { #>
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
