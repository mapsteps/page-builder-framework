<?php
/**
 * Custom responsive input slider control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

class WPBF_Customize_Responsive_Input_Slider extends WP_Customize_Control {

	public $type = 'wpbf-responsive-input-slider';

	public function enqueue() {

		wp_enqueue_script( 'input-slider', WPBF_THEME_URI . '/inc/customizer/controls/input-slider/js/input-slider.js', array( 'jquery' ), WPBF_VERSION, true );
		wp_enqueue_style( 'input-slider', WPBF_THEME_URI . '/inc/customizer/controls/input-slider/css/input-slider.css', '', WPBF_VERSION );

	}

	public function render_content() {

		$devices = array( 'desktop', 'tablet', 'mobile' );
		$areas   = array( 'top', 'right', 'bottom', 'left' );

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

		<?php foreach ( $devices as $device ) : ?>

			<div class="wpbf-control-device wpbf-control-<?php echo esc_attr( $device ); ?>">

				<?php
				$link = $this->get_link();
				$link = str_replace( 'mobile', $device, $link );
				$link = str_replace( '"', '', $link );

				$saved_value = get_theme_mod( 'menu_logo_font_size_' . $device );
				?>

				<div class="wpbf-input-slider-control">
					<div class="slider" slider-min-value="<?php echo esc_attr( $this->choices['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->choices['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->choices['step'] ); ?>"></div>

					<span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $saved_value ); ?>"></span>

					<input type="text" id="<?php echo esc_attr( $this->id ); ?>_<?php echo esc_attr( $device ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $saved_value ); ?>" class="customize-control-slider-value" <?php echo $link; ?> />
				</div>

			</div>

			<?php

		endforeach;

	}

}
