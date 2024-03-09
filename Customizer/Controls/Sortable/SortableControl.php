<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Sortable;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class SortableControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-sortable';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-sortable-control', WPBF_THEME_URI . '/Customizer/Controls/Sortable/dist/sortable-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-sortable-control',
			WPBF_THEME_URI . '/Customizer/Controls/Sortable/dist/sortable-control-min.js',
			array(
				'customize-controls',
				'react-dom',
			),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Control::to_json().
	 *
	 * @see WP_Customize_Control::print_template()
	 */
	protected function content_template() {
		?>

		<label class='wpbf-sortable'>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<ul class="sortable">
				<# _.each( data.value, function( choiceID ) { #>
					<# if ( data.choices[ choiceID ] ) { #>
						<li {{{ data.inputAttrs }}} class='wpbf-sortable-item' data-value='{{ choiceID }}'>
							<i class='dashicons dashicons-menu'></i>
							<i class="dashicons dashicons-visibility visibility"></i>
							{{{ data.choices[ choiceID ] }}}
						</li>
					<# } #>
				<# }); #>
				<# _.each( data.choices, function( choiceLabel, choiceID ) { #>
					<# if ( -1 === data.value.indexOf( choiceID ) ) { #>
						<li {{{ data.inputAttrs }}} class='wpbf-sortable-item invisible' data-value='{{ choiceID }}'>
							<i class='dashicons dashicons-menu'></i>
							<i class="dashicons dashicons-visibility visibility"></i>
							{{{ data.choices[ choiceID ] }}}
						</li>
					<# } #>
				<# }); #>
			</ul>
		</label>

		<?php
	}

}
