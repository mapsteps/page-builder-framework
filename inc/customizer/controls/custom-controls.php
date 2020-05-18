<?php
/**
 * Custom controls.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Custom Controls
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Responsive font size control.
	 */
	class WPBF_Customize_Font_Size_Control extends WP_Customize_Control {

		public $type = 'wpbf-responsive-font-size';

		public function enqueue() {

			wp_enqueue_script( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/js/customizer-controls.js', array( 'jquery' ), WPBF_VERSION, true );
			wp_enqueue_style( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/css/customizer-controls.css', '', WPBF_VERSION );

		}

		public function render_content() {

			$devices = array( 'desktop', 'tablet', 'mobile' );

			?>

			<span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span>

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

			<?php foreach ( $devices as $device ) { ?>

			<div class="wpbf-control-device wpbf-control-<?php echo esc_attr( $device ); ?>">

				<?php $link = $this->get_link(); ?>

				<?php $link = str_replace( 'mobile', $device, $link ); ?>

				<?php $link = str_replace( '"', '', $link ); ?>

				<label>
					<input type="text" <?php echo esc_html( $link ); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
				</label>

			</div>

				<?php

			}

		}

	}

	/**
	 * Padding control.
	 */
	class WPBF_Customize_Padding_Control extends WP_Customize_Control {

		public $type = 'wpbf-padding';

		public function enqueue() {

			wp_enqueue_script( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/js/customizer-controls.js', array( 'jquery' ), WPBF_VERSION, true );
			wp_enqueue_style( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/css/customizer-controls.css', '', WPBF_VERSION );

		}

		public function render_content() {

			$areas = array( 'top', 'right', 'bottom', 'left' );

			?>

			<span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span>

			<?php foreach ( $areas as $area ) { ?>

			<div class="wpbf-control-padding-<?php echo esc_attr( $area ); ?>">

				<?php

				$link = $this->get_link();
				$link = str_replace( 'left', $area, $link );
				$link = str_replace( '"', '', $link );

				?>

				<label>
					<input style="text-align:center;" type="number" <?php echo esc_attr( $link ); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
					<small><?php echo esc_attr( ucfirst( $area ) ); ?></small>
				</label>

			</div>

			<?php } ?>

			<span class="px">px</span>

			<?php

		}

	}

	/**
	 * Responsive padding control.
	 */
	class WPBF_Customize_Responsive_Padding_Control extends WP_Customize_Control {

		public $type = 'wpbf-responsive-padding';

		public function enqueue() {

			wp_enqueue_script( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/js/customizer-controls.js', array( 'jquery' ), WPBF_VERSION, true );
			wp_enqueue_style( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/css/customizer-controls.css', '', WPBF_VERSION );

		}

		public function render_content() {

			$devices = array( 'desktop', 'tablet', 'mobile' );
			$areas   = array( 'top', 'right', 'bottom', 'left' );

			?>

			<span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span>

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

			<?php foreach ( $devices as $device ) { ?>

			<div class="wpbf-control-device wpbf-control-<?php echo esc_attr( $device ); ?>">

				<?php foreach ( $areas as $area ) { ?>

			<div class="wpbf-control-padding-<?php echo esc_attr( $area ); ?>">

					<?php

					$link = $this->get_link();
					$link = str_replace( 'left', $area, $link );
					$link = str_replace( 'mobile', $device, $link );
					$link = str_replace( '"', '', $link );

					?>

				<label>
					<input style="text-align:center;" type="number" <?php echo esc_attr( $link ); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
					<small><?php echo esc_attr( ucfirst( $area ) ); ?></small>
				</label>

			</div>

			<?php } ?>

			<span class="px">px</span>

			</div>

				<?php

			}

		}

	}

	/**
	 * Input slider control.
	 */
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

	/**
	 * Responsive input slider control.
	 */
	class WPBF_Customize_Responsive_Input_Slider extends WP_Customize_Control {

		public $type = 'wpbf-responsive-input-slider';

		public function enqueue() {

			wp_enqueue_script( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/js/customizer-controls.js', array( 'jquery' ), WPBF_VERSION, true );
			wp_enqueue_style( 'wpbf-customizer-controls', WPBF_THEME_URI . '/inc/customizer/css/customizer-controls.css', '', WPBF_VERSION );

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

}
