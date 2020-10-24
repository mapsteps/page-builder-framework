<?php
/**
 * Custom responsive padding control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

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
				<input style="text-align:center;" type="number" <?php echo esc_attr( $link ); ?> value="<?php echo intval( $this->value() ); ?>">
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
