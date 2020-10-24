<?php
/**
 * Custom input slider control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

class WPBF_Customize_Input_Slider extends Kirki_Control_Base {

	public $type = 'wpbf-input-slider';

	public function enqueue() {

		wp_enqueue_script( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/js/customizer-controls.js', array( 'jquery' ), WPBF_VERSION, true );
		wp_enqueue_style( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/css/customizer-controls.css', '', WPBF_VERSION );

	}

	public function render_content() {
		$saved_value = get_theme_mod( $this->id );
		?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<div class="wpbf-input-slider-control">
			<div class="slider" slider-min-value="<?php echo esc_attr( $this->choices['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->choices['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->choices['step'] ); ?>"></div>

			<span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $saved_value ); ?>"></span>

			<input type="text" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $saved_value ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
		</div>

		<?php

	}

}

/**
 * Register input slider control with Kirki.
 *
 * @param array $controls The controls.
 *
 * @return array The updated controls.
 */
add_filter(
	'kirki_control_types',
	function ( $controls ) {

		$controls['input_slider'] = 'WPBF_Customize_Input_Slider';

		return $controls;

	}
);

