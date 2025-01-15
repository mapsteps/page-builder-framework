<?php
/**
 * Wpbf customizer's base control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Base;

use Mapsteps\Wpbf\Customizer\Controls\Responsive\ResponsiveUtil;
use WP_Customize_Control;
use WP_Customize_Manager;
use WP_Customize_Setting;

/**
 * Class to add Wpbf customizer base control.
 */
class BaseControl extends WP_Customize_Control {

	/**
	 * ID of section where this control belongs to.
	 *
	 * @var string
	 */
	protected $section_id = '';

	/**
	 * Used to generate css variables.
	 *
	 * @var string
	 */
	public $css_vars = '';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @var array
	 */
	public $output = array();

	/**
	 * Wrapper attributes.
	 *
	 * The value of this property will be rendered to the wrapper element.
	 * Can be 'class', 'id', 'data-*', and other attributes.
	 *
	 * @var array
	 */
	public $wrapper_attrs = array();

	/**
	 * Whether to allow collapsing the control.
	 *
	 * @var bool
	 */
	public $allow_collapse = false;

	/**
	 * React version.
	 *
	 * @var string
	 */
	private $react_version = '18.3.1';

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

		if ( ! empty( $args['section'] ) ) {
			$this->section_id = $args['section'];
		}

		if ( ! empty( $args['wrapper_attrs'] ) && is_array( $args['wrapper_attrs'] ) ) {
			$this->wrapper_attrs = $args['wrapper_attrs'];

			// Prevent bloated data.
			unset( $args['wrapper_attrs'] );
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		$react_version = $this->react_version;

		if ( ! wp_script_is( 'react', 'registered' ) ) {
			wp_register_script(
				'react',
				WPBF_THEME_URI . '/Customizer/Controls/Base/libs/react.min.js',
				array(),
				$react_version,
				true
			);
		}

		if ( ! wp_script_is( 'react-dom', 'registered' ) ) {
			wp_register_script(
				'react-dom',
				WPBF_THEME_URI . '/Customizer/Controls/Base/libs/react.dom-min.js',
				array( 'react' ),
				$react_version,
				true
			);
		}

		if ( ! wp_script_is( 'react-jsx-runtime', 'registered' ) ) {
			wp_register_script(
				'react-jsx-runtime',
				WPBF_THEME_URI . '/Customizer/Controls/Base/libs/react-jsx-runtime.min.js',
				array( 'react' ),
				$react_version,
				true
			);
		}

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-base-control', WPBF_THEME_URI . '/Customizer/Controls/Base/dist/base-control-min.css', array(), WPBF_VERSION );
		( new ResponsiveUtil() )->enqueueAssets();

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-base-control', WPBF_THEME_URI . '/Customizer/Controls/Base/dist/base-control-min.js', array( 'jquery', 'react', 'react-dom', 'react-jsx-runtime', 'customize-controls' ), WPBF_VERSION, false );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		// Section ID.
		$this->json['sectionId'] = $this->section_id;

		if ( $this->setting instanceof WP_Customize_Setting ) {
			// Default value.
			$this->json['default'] = $this->setting->default;
		}

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

		// The ajax url in case we need it.
		$this->json['ajaxurl'] = admin_url( 'admin-ajax.php' );

		// Input attributes.
		$this->json['inputAttrs'] = '';

		if ( is_array( $this->input_attrs ) ) {
			foreach ( $this->input_attrs as $attr => $value ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
			}
		}

		// Input id.
		$this->json['inputId'] = '_customize-input-' . $this->id;

		// The CSS-Variables.
		$this->json['css-var'] = $this->css_vars;

		// Wrapper Attributes.
		$this->json['wrapperAttrs'] = $this->wrapper_attrs;

		$this->json['allowCollapse'] = $this->allow_collapse;

	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 */
	protected function render() {

		$type_class = str_replace( 'wpbf-', '', $this->type );

		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control wpbf-customize-control wpbf-customize-control-' . $type_class;
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

		// phpcs:ignore
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
