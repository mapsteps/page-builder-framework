<?php
/**
 * Custom responsive padding control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

class WPBF_Customize_Responsive_Padding_Control extends Kirki\Control\Base {

	public $type = 'wpbf-responsive-padding';

	public function enqueue() {
		wp_enqueue_script( 'wpbf-responsive-padding', WPBF_THEME_URI . '/inc/customizer/controls/responsive-padding/js/responsive-padding.js', array( 'jquery' ), WPBF_VERSION, true );
	}

	public function render_content() {

		$devices = array( 'desktop', 'tablet', 'mobile' );
		$areas   = array( 'top', 'right', 'bottom', 'left' );

		$value_bucket = empty( $this->value() ) ? [] : json_decode( $this->value(), true );

		echo '<div class="wpbf-responsive-padding-wrap">';

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

		<?php foreach ( $devices as $device ) { ?>

			<div class="wpbf-control-device wpbf-control-<?php echo esc_attr( $device ); ?>">

				<?php foreach ( $areas as $area ) { ?>

					<div class="wpbf-control-padding-<?php echo esc_attr( $area ); ?>">

						<?php $saved_value = isset( $value_bucket[$device . '_' . $area] ) ? $value_bucket[$device . '_' . $area] : ''; ?>

						<label>
							<input type="number" value="<?php echo $saved_value; ?>"  class="customize-control-responsive-padding-value" data-area-device-type="<?php echo $device . '_' . $area; ?>">
							<small><?php echo esc_html( ucfirst( $area ) ); ?></small>
						</label>

					</div>

				<?php } ?>

				<span class="px">px</span>

			</div>

			<?php

		}

		printf(
			'<input type="hidden" class="wpbf-responsive-padding-db" name="%s" value="%s" %s/>',
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

		$controls['responsive_padding'] = 'WPBF_Customize_Responsive_Padding_Control';

		return $controls;

	}
);
