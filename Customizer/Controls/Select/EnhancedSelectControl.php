<?php
/**
 * Select control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Select;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

/**
 * Class to add Wpbf customizer select control.
 */
class EnhancedSelectControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-enhanced-select';

	/**
	 * Whether to allow multiple selection.
	 *
	 * @var bool
	 */
	public $multiple = false;

	/**
	 * Maximum number of selections allowed.
	 *
	 * @var int
	 */
	public $max_selections = -1;

	/**
	 * Placeholder text.
	 *
	 * @var string
	 */
	public $placeholder = '';

	/**
	 * Whether the select is clearable.
	 *
	 * @var bool
	 */
	public $clearable = false;

	/**
	 * Whether the select is searchable.
	 *
	 * @var bool
	 */
	public $searchable = true;

	/**
	 * The layout style.
	 *
	 * @var string
	 */
	public $layout_style = 'default';

	/**
	 * Global JS variable name to be used as choices.
	 * It will be accessed via `window[choices_global_var]`.
	 *
	 * If this is set, the normal choices won't be used.
	 *
	 * @var string|null
	 */
	public $choices_global_var = null;

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

		$this->choices = ( new SelectUtil() )->toSelect2Format( $this->choices );
		$this->setSelectedOptions();

	}

	/**
	 * Set the selected options.
	 */
	private function setSelectedOptions() {

		$values = $this->value();

		if ( ! is_array( $values ) ) {
			$values = '' === $values || null === $values || false === $values ? [] : [ $values ];
		}

		foreach ( $this->choices as $index => $choice ) {
			if ( isset( $choice['id'] ) && in_array( $choice['id'], $values, true ) ) {
				$this->choices[ $index ]['selected'] = true;
			}

			if ( is_array( $choice ) && ! empty( $choice['children'] ) ) {
				foreach ( $choice['children'] as $child_index => $child_choice ) {
					if ( isset( $child_choice['id'] ) && in_array( $child_choice['id'], $values, true ) ) {
						$this->choices[ $index ]['children'][ $child_index ]['selected'] = true;
					}
				}
			}
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * Most assets are now loaded via the controls bundle.
	 * Select2 library is kept separate as per project requirements.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue select2 library (kept separate - not bundled).
		wp_enqueue_style( 'select2', WPBF_THEME_URI . '/css/min/select2.min.css', array(), WPBF_VERSION );

		$select2_src = WPBF_THEME_URI . '/js/min/select2.full.min.js';

		wp_enqueue_script( 'select2', $select2_src, array( 'jquery' ), WPBF_VERSION, true );

		if ( isset( wp_scripts()->registered ['select2'] ) ) {
			if ( wp_scripts()->registered ['select2']->src !== $select2_src ) {
				// In customizer, force change the select2 src to use our version.
				wp_scripts()->registered ['select2']->src = $select2_src;
			}
		}

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['clearable']   = $this->clearable;
		$this->json['searchable']  = $this->searchable;
		$this->json['multiple']    = $this->multiple;
		$this->json['placeholder'] = ( $this->placeholder ) ? $this->placeholder : esc_html__( 'Select...', 'page-builder-framework' );

		// Will be a custom implementation, couldn't find an official prop to set this in react-select.
		$this->json['maxSelections'] = $this->max_selections;

		$this->json['messages'] = array(
			// translators: %s is the limit of selection number.
			'maxLimitReached' => sprintf( esc_html__( 'You can only select %s items', 'page-builder-framework' ), $this->max_selections ),
		);

		$this->json['layoutStyle'] = $this->layout_style;

		if ( ! empty( $this->choices_global_var ) ) {
			// Normal choices won't be used.
			$this->choices = [];

			$this->json['choices'] = [];

			$this->json['choicesGlobalVar'] = $this->choices_global_var;
		}

	}

}
