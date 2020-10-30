<?php
/**
 * Custom font size control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

class WPBF_Customize_Font_Size_Control extends WP_Customize_Control {

	public $type = 'wpbf-responsive-font-size';

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
