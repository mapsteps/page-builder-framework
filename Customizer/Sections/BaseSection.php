<?php

namespace Mapsteps\Wpbf\Customizer\Sections;

use WP_Customize_Manager;
use WP_Customize_Section;

class BaseSection extends WP_Customize_Section {

	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = 'wpbf-base';

	/**
	 * Path of the section class for this field.
	 *
	 * This property is required for the `WP_Customize_Section::render_template()` method to work.
	 *
	 * @var string
	 */
	public $class_path = '\Mapsteps\Wpbf\Customizer\Sections\BaseSection';

	/**
	 * Tabs for the section.
	 *
	 * @var array
	 */
	protected $tabs = [];

	/**
	 * TabSection constructor.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Array of properties for the new Control object. Default empty array.
	 */
	public function __construct( $manager, $id, $args = array() ) {

		parent::__construct( $manager, $id, $args );

		if ( ! empty( $args['tabs'] ) && is_array( $args['tabs'] ) ) {
			$this->tabs = $args['tabs'];
		}

	}

	/**
	 * Gather the parameters passed to client JavaScript via JSON.
	 *
	 * @return array The array to be exported to the client as JSON.
	 */
	public function json() {

		$arr = parent::json();

		$arr['tabMenuOutput'] = '';

		if ( ! empty( $this->tabs ) ) {
			$arr['tabs'] = $this->tabs;

			$loop_index = -1;

			foreach ( $this->tabs as $tab_key => $tab_args ) {
				++$loop_index;

				$arr['tabMenuOutput'] .= '
				<div class="wpbf-tab-menu-item' . ( 0 === $loop_index ? ' is-active' : '' ) . '" data-wpbf-tab-menu-id="' . esc_attr( $tab_key ) . '">
					<a href="#" class="wpbf-tab-link">' . esc_html( $tab_args['label'] ) . '</a>
				</div>
				';
			}
		}

		$arr['tabClassName'] = ! empty( $this->tabs ) ? 'wpbf-tab-section' : '';

		return $arr;

	}

	/**
	 * An Underscore (JS) template for rendering tabs template.
	 *
	 * Class variables for this section class are available in the `data` JS object;
	 */
	protected function render_tabs_template() {
		?>

		<# if ( data.tabs && Object.keys( data.tabs ).length ) { #>
			<li class="wpbf-tab" data-wpbf-tab-id="{{ data.id }}">
				<div class="wpbf-tab-menu">
					{{{ data.tabMenuOutput }}}
				</div>
			</li>
		<# } #>

		<?php
	}

	/**
	 * An Underscore (JS) template for rendering this section.
	 *
	 * Class variables for this section class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Section::json().
	 *
	 * @see WP_Customize_Section::print_template()
	 */
	protected function render_template() {
		?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-default control-section-{{ data.type }} {{ data.tabClassName }}">
			<h3 class="accordion-section-title">
				<button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="{{ data.id }}-content">
					{{ data.title }}
				</button>
			</h3>
			<ul class="accordion-section-content" id="{{ data.id }}-content">
				<li class="customize-section-description-container section-meta <# if ( data.description_hidden ) { #>customize-info<# } #>">
					<div class="customize-section-title">
						<button class="customize-section-back" tabindex="-1">
							<span class="screen-reader-text">
								<?php
								/* translators: Hidden accessibility text. */
								_e( 'Back', 'page-builder-framework' );
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
								_e( 'Help', 'page-builder-framework' );
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
