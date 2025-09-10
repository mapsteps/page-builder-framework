<?php

namespace Mapsteps\Wpbf\Customizer\Sections;

use WP_Customize_Section;

class LinkSection extends WP_Customize_Section {

	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = 'wpbf-link';

	/**
	 * Link text.
	 *
	 * @var string
	 */
	protected $link_text = '';

	/**
	 * Link URL.
	 *
	 * @var string
	 */
	protected $link_url = '';

	/**
	 * Constructor.
	 *
	 * Any supplied $args override class property defaults.
	 *
	 * @since 3.4.0
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      A specific ID of the section.
	 * @param array                $args    Array of properties for the new Section object. Default empty array.
	 */
	public function __construct( $manager, $id, $args = array() ) {

		if ( isset( $args['link_text'] ) && is_string( $args['link_text'] ) ) {
			$this->link_text = wp_kses_post( $args['link_text'] );
		}

		if ( isset( $args['link_url'] ) && is_string( $args['link_url'] ) ) {
			$this->link_url = esc_url_raw( $args['link_url'] );
		}

	}

	/**
	 * Gather the parameters passed to client JavaScript via JSON.
	 *
	 * @since 4.1.0
	 *
	 * @return array The array to be exported to the client as JSON.
	 */
	public function json() {

		$json = parent::json();

		$json['linkUrl']  = $this->link_url;
		$json['linkText'] = $this->link_text;

		return $json;

	}

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

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				{{ data.title }}
				<a href="{{ data.linkUrl }}" class="button alignright" target="_blank" rel="nofollow">
					{{ data.linkText }}
				</a>
			</h3>
		</li>

		<?php
	}

}
