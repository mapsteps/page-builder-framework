<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Editor;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class EditorControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-editor';

	/**
	 * TinyMCE settings.
	 *
	 * @var array|boolean
	 */
	public $tinymce = true;

	/**
	 * Quicktags settings.
	 *
	 * @var array|boolean
	 */
	public $quicktags = true;

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the `$id` as the setting ID.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Optional. Array of properties for the new Control object.
	 *                                                   Default empty array.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		parent::__construct( $wp_customize_manager, $id, $args );

		if ( ! empty( $args['tinymce'] ) && ( is_bool( $args['tinymce'] ) || is_array( $args['tinymce'] ) ) ) {
			$this->tinymce = $args['tinymce'];
		}

		if ( ! empty( $args['quicktags'] ) && ( is_bool( $args['quicktags'] ) || is_array( $args['quicktags'] ) ) ) {
			$this->quicktags = $args['quicktags'];
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-editor-control', WPBF_THEME_URI . '/Customizer/Controls/Editor/dist/editor-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-editor-control',
			WPBF_THEME_URI . '/Customizer/Controls/Editor/dist/editor-control-min.js',
			array( 'wpbf-base-control' ),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['tinymce']   = $this->tinymce;
		$this->json['quicktags'] = $this->quicktags;

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

		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</label>
		<textarea id="wpbf-editor-{{{ data.id.replace( '[', '' ).replace( ']', '' ) }}}" {{{ data.inputAttrs }}} {{{ data.link }}}>{{ data.value }}</textarea>

		<?php
	}

}
