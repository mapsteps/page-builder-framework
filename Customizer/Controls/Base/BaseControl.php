<?php
/**
 * Wpbf customizer's base control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Base;

use WP_Customize_Control;

/**
 * Class to add Wpbf customizer base control.
 */
class BaseControl extends WP_Customize_Control {

	/**
	 * Used to generate css variables.
	 *
	 * @var string $css_vars
	 */
	public $css_vars = '';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @var array $output
	 */
	public $output = array();

	/**
	 * Wrapper attributes.
	 *
	 * The value of this property will be rendered to the wrapper element.
	 * Can be 'class', 'id', 'data-*', and other attributes.
	 *
	 * @var array $wrapper_attrs
	 */
	public $wrapper_attrs = array();

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-control-base', WPBF_THEME_URI . '/Customizer/Controls/Base/dist/base-control.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-control-base', WPBF_THEME_URI . '/Customizer/Controls/Base/dist/base-control.js', array( 'customize-controls' ), WPBF_VERSION, false );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		// Default value.
		$this->json['default'] = $this->setting->default;

		// CSS Output.
		$this->json['output'] = $this->output;

		// Value.
		$this->json['value'] = $this->value();

		// Choices.
		$this->json['choices'] = $this->choices;

		// The link.
		$this->json['link'] = $this->get_link();

		// The ID.
		$this->json['id'] = $this->id;

		// The ajaxurl in case we need it.
		$this->json['ajaxurl'] = admin_url( 'admin-ajax.php' );

		// Input attributes.
		$this->json['inputAttrs'] = '';

		if ( is_array( $this->input_attrs ) ) {
			foreach ( $this->input_attrs as $attr => $value ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
			}
		}

		// The CSS-Variables.
		$this->json['css-var'] = $this->css_vars;

		// Wrapper Attributes.
		$this->json['wrapper_attrs'] = $this->wrapper_attrs;

	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 */
	protected function render() {

		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control wpbf-customize-control wpbf-customize-control-' . $this->type;
		$gap   = isset( $this->wrapper_opts['gap'] ) ? $this->wrapper_opts['gap'] : 'default';
		$tag   = isset( $this->wrapper_opts['tag'] ) ? $this->wrapper_opts['tag'] : 'li';

		switch ( $gap ) {
			case 'small':
				$class .= ' customize-control-has-small-gap';
				break;

			case 'none':
				$class .= ' customize-control-is-gapless';
				break;

			default:
				break;
		}

		if ( isset( $this->wrapper_attrs['id'] ) ) {
			$id = $this->wrapper_attrs['id'];
		}

		if ( ! isset( $this->wrapper_attrs['data-wpbf-setting'] ) ) {
			$this->wrapper_attrs['data-wpbf-setting'] = $this->id;
		}

		if ( ! isset( $this->wrapper_attrs['data-wpbf-setting-link'] ) ) {
			if ( isset( $this->settings['default'] ) ) {
				$this->wrapper_attrs['data-wpbf-setting-link'] = $this->settings['default']->id;
			}
		}

		$data_attrs = '';

		foreach ( $this->wrapper_attrs as $attr_key => $attr_value ) {
			if ( 0 === strpos( $attr_key, 'data-' ) ) {
				$data_attrs .= ' ' . esc_attr( $attr_key ) . '="' . esc_attr( $attr_value ) . '"';
			}
		}

		if ( isset( $this->wrapper_attrs['class'] ) ) {
			$class = str_ireplace( '{default_class}', $class, $this->wrapper_attrs['class'] );
		}

		printf( '<' . esc_attr( $tag ) . ' id="%s" class="%s"%s>', esc_attr( $id ), esc_attr( $class ), $data_attrs );
		$this->render_content();
		echo '</' . esc_attr( $tag ) . '>';

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
	}

}
