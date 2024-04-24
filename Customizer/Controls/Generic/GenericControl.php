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
	 * Accepts one of this values: "number", "number-unit", "text", "textarea", "email", "password", "url", "hidden", and "content".
	 *
	 * @var string
	 */
	protected $subtype = 'text';

	/**
	 * The allowed 'subtype' property.
	 *
	 * @var string[]
	 */
	public static $allowed_subtypes = [ 'number', 'number-unit', 'text', 'textarea', 'email', 'password', 'url', 'hidden', 'content' ];

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

		$this->number_util = new NumberUtil();

		// Already sanitized in `addControl` method in `GenericField` class.
		if ( ! empty( $args['subtype'] ) ) {
			$this->subtype = $args['subtype'];
		}

		if ( ! in_array( $this->subtype, static::$allowed_subtypes, true ) ) {
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
			$this->setting->default = ( new GenericSanitizer() )->sanitize(
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
			$this->json['inputType'] = 'number-unit' === $this->subtype ? 'text' : $this->subtype;
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

		$input_tag  = 'textarea' === $this->subtype || 'content' === $this->subtype ? 'textarea' : 'input';
		$input_type = 'text';

		if ( 'textarea' !== $this->subtype && 'content' !== $this->subtype ) {
			$input_type = 'number-unit' === $this->subtype ? 'text' : $this->subtype;
		}
		?>

		<?php if ( $this->label || $this->description ) : ?>
			<div class="customize-control-label">
				<?php if ( $this->label ) : ?>
					<label class="customize-control-title" for="_customize-input-<?php echo esc_attr( $this->id ); ?>">
						<?php echo esc_html( $this->label ); ?>
					</label>
				<?php endif; ?>

				<?php if ( $this->description ) : ?>
					<span class="description customize-control-description">
						<?php echo wp_kses_post( $this->description ); ?>
					</span>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<div class="customize-control-notifications-container"></div>

		<div class="wpbf-control-form">
			<?php if ( 'textarea' === $input_tag ) : ?>
				<textarea
					<?php $this->link(); ?>
					<?php $this->input_attrs(); ?>
					id="_customize-input-<?php echo esc_attr( $this->id ); ?>"
					rows="<?php echo esc_attr( $this->rows ); ?>"><?php echo esc_textarea( $this->value() ); ?></textarea>
			<?php else : ?>
				<input
					<?php
					$this->link();
					$this->input_attrs();
					?>
					type="<?php echo esc_attr( $input_type ); ?>"
					id="_customize-input-<?php echo esc_attr( $this->id ); ?>"
					value="<?php echo esc_attr( $this->value() ); ?>"
					
					<?php if ( 'number' === $input_type ) : ?>
						<?php if ( null !== $this->min ) : ?>
							min="<?php echo esc_attr( $this->min ); ?>"
						<?php endif; ?>

						<?php if ( null !== $this->max ) : ?>
							max="<?php echo esc_attr( $this->max ); ?>"
						<?php endif; ?>

						step="<?php echo esc_attr( $this->step ); ?>"
					<?php endif; ?>
				>
			<?php endif; ?>
		</div>

		<?php
	}

}
