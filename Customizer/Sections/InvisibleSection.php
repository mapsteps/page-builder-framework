<?php

namespace Mapsteps\Wpbf\Customizer\Sections;

class InvisibleSection extends BaseSection {

	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = 'wpbf-invisible';

	/**
	 * Path of the section class for this field.
	 *
	 * This property is required for the `WP_Customize_Section::render_template()` method to work.
	 *
	 * @var string
	 */
	public $class_path = '\Mapsteps\Wpbf\Customizer\Sections\InvisibleSection';

	/**
	 * An Underscore (JS) template for rendering this section.
	 *
	 * Class variables for this section class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Section::json().
	 *
	 * @since 4.3.0
	 *
	 * @see WP_Customize_Section::print_template()
	 */
	protected function render_template() {
		?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} {{ data.tabClassName }}">
			<ul class="accordion-section-content">
				<li class="customize-section-description-container section-meta <# if ( data.description_hidden ) { #>customize-info<# } #>">
					<div class="customize-section-title">
						<button class="customize-section-back" tabindex="-1">
							<span class="screen-reader-text">
								<?php
								/* translators: Hidden accessibility text. */
								_e( 'Back' );
								?>
							</span>
						</button>
						<h3>
							<span class="customize-action">
								{{{ data.customizeAction }}}
							</span>
							{{ data.title }}
						</h3>
						<# if ( data.description && data.description_hidden ) { #>
							<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text">
								<?php
								/* translators: Hidden accessibility text. */
								_e( 'Help' );
								?>
							</span></button>
							<div class="description customize-section-description">
								{{{ data.description }}}
							</div>
						<# } #>

						<div class="customize-control-notifications-container"></div>
					</div>

					<# if ( data.description && ! data.description_hidden ) { #>
						<div class="description customize-section-description">
							{{{ data.description }}}
						</div>
					<# } #>
				</li>

				<?php $this->render_tabs_template(); ?>
			</ul>
		</li>

		<?php
	}

}
