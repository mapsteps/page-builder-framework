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
class SelectControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-select';

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

		$this->choices = ( new SelectChoices() )->toSelect2Format( $this->choices );
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

		$this->json['isClearable'] = $this->clearable;
		$this->json['isMulti']     = $this->multiple;
		$this->json['placeholder'] = ( $this->placeholder ) ? $this->placeholder : esc_html__( 'Select...', 'page-builder-framework' );

		// Most choices of a multiple select (-1 or 0: no limit).
		$this->json['maxSelections'] = $this->max_selections;

		// Shown as text by the select form (React escapes them).
		$this->json['messages'] = array(
			// translators: %s is the limit of selection number.
			'maxLimitReached' => sprintf( __( 'You can only select %s items', 'page-builder-framework' ), $this->max_selections ),
			'noResults'       => __( 'No results found', 'page-builder-framework' ),
			'clear'           => __( 'Remove all items', 'page-builder-framework' ),
			'remove'          => __( 'Remove item', 'page-builder-framework' ),
		);

	}

}
