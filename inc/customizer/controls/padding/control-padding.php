<?php
/**
 * Custom padding control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

class WPBF_Customize_Padding_Control extends WP_Customize_Control {

	public $type = 'wpbf-padding';

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
				<input style="text-align:center;" type="number" <?php echo esc_attr( $link ); ?> value="<?php echo intval( $this->value() ); ?>">
				<small><?php echo esc_attr( ucfirst( $area ) ); ?></small>
			</label>

		</div>

		<?php } ?>

		<span class="px">px</span>

		<?php

	}

}
