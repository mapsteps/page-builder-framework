<?php
/**
 * Custom padding control.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

class WPBF_Customize_Padding_Control extends Kirki\Control\Base {

	public $type = 'wpbf-padding';

	public function enqueue() {
		wp_enqueue_script( 'wpbf-padding', WPBF_THEME_URI . '/inc/customizer/controls/padding/js/padding.js', array( 'jquery' ), WPBF_VERSION, true );
	}

	public function render_content() {

		$areas = array( 'top', 'right', 'bottom', 'left' );

		$value_bucket = empty( $this->value() ) ? [] : json_decode( $this->value(), true );

		echo '<div class="wpbf-padding-wrap">';

		?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<?php foreach ( $areas as $area ) { ?>

			<?php $saved_value = isset( $value_bucket[$area] ) ? $value_bucket[$area] : ''; ?>

			<div class="wpbf-control-padding-<?php echo esc_attr( $area ); ?>">
				<label>
					<input type="number" value="<?php echo $saved_value; ?>" class="customize-control-padding-value" data-area-type="<?php echo $area; ?>">
					<small><?php echo esc_html( ucfirst( $area ) ); ?></small>
				</label>
			</div>

		<?php } ?>

		<span class="px">px</span>

		<?php

		printf(
			'<input type="hidden" class="wpbf-padding-db" name="%s" value="%s" %s/>',
			esc_attr( $this->id ), $this->value(), $this->get_link()
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

		$controls['padding_control'] = 'WPBF_Customize_Padding_Control';

		return $controls;

	}
);
