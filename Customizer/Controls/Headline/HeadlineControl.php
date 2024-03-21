<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Headline;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class HeadlineControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-headline';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-headline-control', WPBF_THEME_URI . '/Customizer/Controls/Headline/dist/headline-control-min.css', array(), WPBF_VERSION );

	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 */
	protected function render_content() {
		?>

		<input type="hidden" data-customize-setting-link="<?php echo esc_attr( $this->settings['default']->id ); ?>">
		<div class="wpbf-control-label">
			<?php if ( $this->label ) : ?>
				<h4 class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</h4>
			<?php endif; ?>

			<?php if ( $this->description ) : ?>
				<p class="customize-control-description">
					<?php echo esc_html( $this->description ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php
	}

}
