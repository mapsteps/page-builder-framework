<?php
/**
 * Custom responsive input slider control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

class WPBF_Customize_Responsive_Input_Slider extends Kirki\Control\Base {

	public $type = 'wpbf-responsive-input-slider';

	public function enqueue() {
		wp_enqueue_script( 'responsive-input-slider', WPBF_THEME_URI . '/inc/customizer/controls/responsive-input-slider/js/responsive-input-slider.js', array( 'jquery' ), WPBF_VERSION, true );
		wp_enqueue_script( 'input-slider', WPBF_THEME_URI . '/inc/customizer/controls/input-slider/js/input-slider.js', array( 'jquery' ), WPBF_VERSION, true );
		wp_enqueue_style( 'input-slider', WPBF_THEME_URI . '/inc/customizer/controls/input-slider/css/input-slider.css', '', WPBF_VERSION );
	}

	public function render_content() {

		$devices = array( 'desktop', 'tablet', 'mobile' );

		$value_bucket = empty( $this->value() ) ? [] : json_decode( $this->value(), true );

		echo '<div class="wpbf-responsive-input-slider-wrap">';

		?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<ul class="wpbf-responsive-options">
			<li class="desktop">
				<button type="button" class="preview-desktop active" data-device="desktop">
					<i class="dashicons dashicons-desktop"></i>
				</button>
			</li>
			<li class="tablet">
				<button type="button" class="preview-tablet" data-device="tablet">
					<i class="dashicons dashicons-tablet"></i>
				</button>
			</li>
			<li class="mobile">
				<button type="button" class="preview-mobile" data-device="mobile">
					<i class="dashicons dashicons-smartphone"></i>
				</button>
			</li>
		</ul>

		<?php foreach ( $devices as $device ) : $saved_value = isset( $value_bucket[$device] ) ? $value_bucket[$device] : ''; ?>

			<div class="wpbf-control-device wpbf-control-<?php echo esc_attr( $device ); ?>">
				<div class="wpbf-input-slider-control">
					<div class="slider" slider-min-value="<?php echo esc_attr( $this->choices['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->choices['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->choices['step'] ); ?>"></div>
					<span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $saved_value ); ?>"></span>
					<input type="text" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $saved_value ); ?>" class="customize-control-slider-value" data-device-type="<?php echo $device; ?>" />
				</div>
			</div>

			<?php

		endforeach;

		printf(
			'<input type="hidden" class="wpbf-responsive-input-slider-db" name="%s" value="%s" %s/>',
			esc_attr( $this->id ), esc_attr( $this->value() ), $this->get_link()
		);

		echo '</div>';

	}

}

/**
 * Register input slider control with Kirki.
 *
 * @param array $controls The controls.
 *
 * @return array The updated controls.
 */
add_filter( 'kirki_control_types', function ( $controls ) {

		$controls['responsive_input_slider'] = 'WPBF_Customize_Responsive_Input_Slider';

		return $controls;

	}
);
