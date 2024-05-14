<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Code;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class CodeControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'code_editor';
	// public $type = 'wpbf-code';

	/**
	 * Type of code that is being edited.
	 *
	 * @var string
	 */
	protected $code_type = '';

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
			$this->parse_language( $args['language'] );
		}

		if ( ! empty( $args['editor_settings'] ) && is_array( $args['editor_settings'] ) ) {
			$this->editor_settings = $args['editor_settings'];
		}

	}

	/**
	 * Parse the language of the code.
	 *
	 * @param string $language The language of the code.
	 */
	protected function parse_language( $language = '' ) {

		if ( empty( $language ) || ! is_string( $language ) ) {
			return;
		}

		switch ( $language ) {
			case 'json':
			case 'xml':
				$this->code_type = 'application/' . $this->code_type;
				break;
			case 'http':
				$this->code_type = 'message/' . $this->code_type;
				break;
			case 'js':
			case 'javascript':
				$this->code_type = 'text/javascript';
				break;
			case 'txt':
				$this->code_type = 'text/plain';
				break;
			case 'css':
			case 'jsx':
			case 'html':
				$this->code_type = 'text/' . $this->code_type;
				break;
			default:
				$this->code_type = ( 'js' === $this->code_type ) ? 'javascript' : $this->code_type;
				$this->code_type = ( 'htm' === $this->code_type ) ? 'html' : $this->code_type;
				$this->code_type = ( 'yml' === $this->code_type ) ? 'yaml' : $this->code_type;
				$this->code_type = 'text/x-' . $this->code_type;
				break;
		}

		if ( ! isset( $this->editor_settings['codemirror'] ) ) {
			$this->editor_settings['codemirror'] = [];
		}

		if ( ! isset( $this->editor_settings['codemirror']['mode'] ) ) {
			$this->editor_settings['codemirror']['mode'] = $this->code_type;
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
					'type'       => $this->code_type,
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
	 * Get the data to export to the client via JSON.
	 *
	 * @since 4.1.0
	 *
	 * @return array Array of parameters passed to the JavaScript.
	 */
	public function json() {

		$json = parent::json();

		$json['editor_settings'] = $this->editor_settings;
		$json['input_attrs']     = $this->input_attrs;

		return $json;

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Control::to_json().
	 *
	 * @see WP_Customize_Control::print_template()
	 */
	public function content_template() {
		?>

		<# var elementIdPrefix = 'el' + String( Math.random() ); #>

		<# if ( data.label ) { #>
			<label for="{{ elementIdPrefix }}_editor" class="customize-control-title">
				{{ data.label }}
			</label>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="customize-control-notifications-container"></div>

		<textarea id="{{ elementIdPrefix }}_editor"
			<# _.each( _.extend( { 'class': 'code' }, data.input_attrs ), function( value, key ) { #>
				{{{ key }}}="{{ value }}"
			<# }); #>
			></textarea>

		<?php
	}

}
