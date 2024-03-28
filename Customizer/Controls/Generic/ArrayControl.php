<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;
use WP_Customize_Setting;

class ArrayControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-array';

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

		if ( ! ( $this->setting instanceof WP_Customize_Setting ) ) {
			return;
		}

		$default_value = [];

		if ( ! empty( $this->setting->default ) && is_string( $this->setting->default ) ) {
			$decoded = json_decode( $this->setting->default, true );

			if ( is_array( $decoded ) ) {
				$default_value = $decoded;
			}
		}

		$this->setting->default = ArrayField::sanitize( $default_value );

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-array-control',
			WPBF_THEME_URI . '/Customizer/Controls/Generic/dist/array-control-min.js',
			array( 'wpbf-base-control' ),
			WPBF_VERSION,
			false
		);

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
			<input
				type="hidden"
				id="_customize-input-<?php echo esc_attr( $this->id ); ?>"
				value="<?php echo esc_attr( wp_json_encode( $this->value() ) ); ?>"
			>
		</div>

		<?php
	}

}
