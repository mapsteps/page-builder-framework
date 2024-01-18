<?php
/**
 * Control slider.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use WP_Customize_Control;

/**
 * Class to add Wpbf customizer slider control.
 */
class SliderControl extends WP_Customize_Control {
	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-slider';

	/**
	 * Control's value unit.
	 *
	 * @var string
	 */
	public $value_unit = '%';

	/**
	 * Control's value number.
	 *
	 * @var string
	 */
	public $value_number = 100;

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 3.4.0
	 */
	public function enqueue() {}

	/**
	 * Renders the range control wrapper and calls $this->render_content() for the internals.
	 */
	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-' . $this->type . ' udb-customize-control udb-customize-control-' . $this->type;

		$this->value_unit   = preg_replace( '/\d+/', '', $this->value() );
		$this->value_number = str_ireplace( $this->value_unit, '', $this->value() );

		printf( '<li id="%s" class="%s" data-control-name="%s">', esc_attr( $id ), esc_attr( $class ), esc_attr( $this->id ) );
		$this->render_content();
		echo '</li>';
	}

	/**
	 * Render the range control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 */
	public function render_content() {
		$input_id         = '_customize-input-' . $this->id;
		$description_id   = '_customize-description-' . $this->id;
		$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';

		$min  = isset( $this->input_attrs['min'] ) ? $this->input_attrs['min'] : 0;
		$max  = isset( $this->input_attrs['max'] ) ? $this->input_attrs['max'] : 100;
		$step = isset( $this->input_attrs['step'] ) ? $this->input_attrs['step'] : 1;

		if ( ! isset( $this->input_attrs['class'] ) ) {
			$this->input_attrs['class'] = '';
		}

		$this->input_attrs['class'] .= ' udb-customize-field udb-customize-range-field';
		?>

		<header class="udb-customize-control-header">
			<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>"
						class="customize-control-title udb-customize-control-label udb-customize-control-title"><?php echo esc_html( $this->label ); ?></label>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>"
						class="description customize-control-description udb-customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<span class="dashicons dashicons-image-rotate udb-customize-control-reset"
					title="<?php _e( 'Reset Value', 'ultimate-dashboard' ); ?>"
					data-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
		</header>
		<div class="udb-customize-control--cols">
			<div class="udb-customize-control--left-col">
				<input
					type="<?php echo esc_attr( $this->type ); ?>"
					value="<?php echo esc_attr( $this->value_number ); ?>"
					min="<?php echo esc_attr( $min ); ?>"
					max="<?php echo esc_attr( $max ); ?>"
					step="<?php echo esc_attr( $step ); ?>"
					class="udb-customize-control-range-slider"
					data-slider-for="<?php echo esc_attr( $this->id ); ?>"
				/>
			</div>
			<div class="udb-customize-control--right-col">
				<input
					type="text"
					id="<?php echo esc_attr( $input_id ); ?>"
					class="<?php echo esc_attr( $this->input_attrs['class'] ); ?>"
					data-min="<?php echo esc_attr( $min ); ?>"
					data-max="<?php echo esc_attr( $max ); ?>"
					data-step="<?php echo esc_attr( $step ); ?>"
					<?php if ( ! isset( $this->input_attrs['value'] ) ) : ?>
						value="<?php echo esc_attr( $this->value() ); ?>"
					<?php endif; ?>
					<?php $this->link(); ?>
					<?php echo $describedby_attr; ?>
				>
			</div>
		</div>

		<?php
	}
}
