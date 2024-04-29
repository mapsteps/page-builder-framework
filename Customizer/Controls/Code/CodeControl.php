<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Code;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class CodeControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-code';

	/**
	 * The language of the code.
	 *
	 * @var string
	 */
	protected $language = '';

	/**
	 * The code editor settings.
	 *
	 * @var array
	 */
	protected $editor_settings = array();

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

		$this->input_attrs['aria-describedby'] = 'wpbf-code editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4';

		if ( ! empty( $args['language'] ) && is_string( $args['language'] ) ) {
			$this->language = $args['language'];
			$this->parse_language();
		}

		if ( ! empty( $args['editor_settings'] ) && is_array( $args['editor_settings'] ) ) {
			$this->editor_settings = $args['editor_settings'];
		}

	}

	/**
	 * Parse the language of the code.
	 */
	protected function parse_language() {

		if ( empty( $this->language ) || ! is_string( $this->language ) ) {
			return;
		}

		switch ( $this->language ) {
			case 'json':
			case 'xml':
				$this->language = 'application/' . $this->language;
				break;
			case 'http':
				$this->language = 'message/' . $this->language;
				break;
			case 'js':
			case 'javascript':
				$this->language = 'text/javascript';
				break;
			case 'txt':
				$this->language = 'text/plain';
				break;
			case 'css':
			case 'jsx':
			case 'html':
				$this->language = 'text/' . $this->language;
				break;
			default:
				$this->language = ( 'js' === $this->language ) ? 'javascript' : $this->language;
				$this->language = ( 'htm' === $this->language ) ? 'html' : $this->language;
				$this->language = ( 'yml' === $this->language ) ? 'yaml' : $this->language;
				$this->language = 'text/x-' . $this->language;
				break;
		}

		if ( ! isset( $this->editor_settings ) ) {
			$this->editor_settings = [];
		}

		if ( ! isset( $this->editor_settings['codemirror'] ) ) {
			$this->editor_settings['codemirror'] = [];
		}

		if ( ! isset( $this->editor_settings['codemirror']['mode'] ) ) {
			$this->editor_settings['codemirror']['mode'] = $this->language;
		}

		if ( 'text/x-scss' === $this->editor_settings['codemirror']['mode'] ) {
			$this->editor_settings['codemirror'] = array_merge(
				$this->editor_settings['codemirror'],
				[
					'lint'              => false,
					'autoCloseBrackets' => true,
					'matchBrackets'     => true,
				]
			);
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		$this->editor_settings = wp_enqueue_code_editor(
			array_merge(
				array(
					'type'       => $this->language,
					'codemirror' => array(
						'indentUnit' => 2,
						'tabSize'    => 2,
					),
				),
				$this->editor_settings
			)
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		if ( ! empty( $this->editor_settings ) ) {
			$this->json['editorSettings'] = $this->editor_settings;
		}

		$this->json['inputAttrsRecord'] = $this->input_attrs;

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

		<# var idPrefix = 'el' + String( Math.random() ); #>

		<# if ( data.label ) { #>
			<label for="{{ idPrefix }}_editor" class="customize-control-title">
				{{ data.label }}
			</label>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		
		<div class="customize-control-notifications-container"></div>
		
		<textarea
			id="{{ idPrefix }}_editor"
			<# _.each( _.extend( { 'class': 'code' }, data.inputAttrsRecord ), function( value, key ) { #>
				{{{ key }}}="{{ value }}"
			<# }); #>
			></textarea>

		<?php
	}

}
