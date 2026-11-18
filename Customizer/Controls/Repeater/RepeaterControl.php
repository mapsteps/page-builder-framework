<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Repeater;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

class RepeaterControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-repeater';

	/**
	 * The fields that each container row will contain.
	 *
	 * @var array
	 */
	public $fields = [];

	/**
	 * Will store a filtered version of value for advenced fields (like images).
	 *
	 * @var array
	 */
	protected $filtered_value = [];

	/**
	 * The limit of the repeater.
	 *
	 * @var int|bool
	 */
	public $limit = false;

	/**
	 * The row label
	 *
	 * @var array
	 */
	public $row_label = [];

	/**
	 * The button label
	 *
	 * @var string
	 */
	public $button_label = '';

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the `$id` as the setting ID.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Optional. Array of properties for the new Control object. Default empty array.
	 */
	public function __construct( $manager, $id, $args = [] ) {

		parent::__construct( $manager, $id, $args );

		// Set up defaults for row labels.
		$this->row_label = [
			'type'  => 'text',
			'value' => esc_attr__( 'row', 'page-builder-framework' ),
			'field' => false,
		];

		if ( ! empty( $args['row_label'] ) && is_array( $args['row_label'] ) ) {
			$this->row_label = $args['row_label'];
		}

		$this->validate_row_label( $args );

		if ( empty( $this->button_label ) ) {
			/* translators: %s represents the label of the row. */
			$this->button_label = sprintf( esc_html__( 'Add new %s', 'page-builder-framework' ), $this->row_label['value'] );
		}

		if ( ! empty( $args['button_label'] ) && is_string( $args['button_label'] ) ) {
			$this->button_label = $args['button_label'];
		}

		if ( empty( $args['fields'] ) || ! is_array( $args['fields'] ) ) {
			$args['fields'] = [];
		}

		// An array to store keys of fields that need to be filtered.
		$media_fields_to_filter = [];

		foreach ( $args['fields'] as $key => $value ) {
			if ( ! isset( $value['default'] ) ) {
				$args['fields'][ $key ]['default'] = '';
			}

			if ( ! isset( $value['label'] ) ) {
				$args['fields'][ $key ]['label'] = '';
			}

			$args['fields'][ $key ]['id'] = $key;

			// Upload fields show the file's name: their value gets extra filtering below.
			if ( isset( $value['type'] ) && 'upload' === $value['type'] ) {
				$media_fields_to_filter[ $key ] = true;
			}
		}

		$this->fields = $args['fields'];

		// Now we are going to filter the fields.
		// First we create a copy of the value that would be used otherwise.
		$this->filtered_value = $this->value();

		if ( is_array( $this->filtered_value ) && ! empty( $this->filtered_value ) ) {

			// We iterate over the list of fields.
			foreach ( $this->filtered_value as &$filtered_value_field ) {

				if ( is_array( $filtered_value_field ) && ! empty( $filtered_value_field ) ) {

					// We iterate over the list of properties for this field.
					foreach ( $filtered_value_field as $key => &$value ) {

						// We check if this field was marked as requiring extra filtering (upload fields).
						if ( array_key_exists( $key, $media_fields_to_filter ) ) {

							/**
							 * What follows was made this way to preserve backward compatibility.
							 * The repeater control use to store the URL for images instead of the attachment ID.
							 * We check if the value look like an ID (otherwise it's probably a URL so don't filter it).
							 */
							if ( is_numeric( $value ) ) {

								// "sanitize" the value.
								$attachment_id = (int) $value;

								// Try to get the attachment_url.
								$url = wp_get_attachment_url( $attachment_id );

								$filename = basename( get_attached_file( $attachment_id ) );

								// If we got a URL.
								if ( $url ) {

									// 'id' is needed for form hidden value, URL is needed to display the image.
									$value = [
										'id'       => $attachment_id,
										'url'      => $url,
										'filename' => $filename,
									];
								}
							}
						}
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

		$this->json['fields']      = $this->fields;
		$this->json['limit']       = $this->limit;
		$this->json['rowLabel']    = $this->row_label;
		$this->json['buttonLabel'] = $this->button_label;

		$this->json['l10n'] = array(
			'remove'     => __( 'Remove', 'page-builder-framework' ),
			'noFile'     => __( 'No File Selected', 'page-builder-framework' ),
			'addFile'    => __( 'Add File', 'page-builder-framework' ),
			'changeFile' => __( 'Change File', 'page-builder-framework' ),
			/* translators: %s represents the number of rows we're limiting the repeater to allow. */
			'limit'      => sprintf( __( 'Limit: %s rows', 'page-builder-framework' ), false === $this->limit ? '' : $this->limit ),
		);

		// If filtered_value has been set and is not empty we use it instead of the actual value.
		if ( is_array( $this->filtered_value ) && ! empty( $this->filtered_value ) ) {
			$this->json['value'] = $this->filtered_value;
		}

		$this->json['value'] = apply_filters( "wpbf_controls_repeater_value_{$this->id}", $this->json['value'] );

	}

	/**
	 * The form (rows, add button) is rendered in the browser (RepeaterForm.tsx).
	 */
	protected function render_content() {
	}

	/**
	 * Validate row-labels.
	 *
	 * @param array $args {@see WP_Customize_Control::__construct}.
	 */
	protected function validate_row_label( $args ) {

		// Validating args for row labels.
		if ( isset( $args['row_label'] ) && is_array( $args['row_label'] ) && ! empty( $args['row_label'] ) ) {

			// Validating row label type.
			if ( isset( $args['row_label']['type'] ) && ( 'text' === $args['row_label']['type'] || 'field' === $args['row_label']['type'] ) ) {
				$this->row_label['type'] = $args['row_label']['type'];
			}

			// Validating row label type.
			if ( isset( $args['row_label']['value'] ) && ! empty( $args['row_label']['value'] ) ) {
				$this->row_label['value'] = esc_html( $args['row_label']['value'] );
			}

			// Validating row label field.
			if ( isset( $args['row_label']['field'] ) && ! empty( $args['row_label']['field'] ) && isset( $args['fields'][ sanitize_key( $args['row_label']['field'] ) ] ) ) {
				$this->row_label['field'] = esc_html( $args['row_label']['field'] );
			} else {
				// If from field is not set correctly, making sure standard is set as the type.
				$this->row_label['type'] = 'text';
			}
		}

	}

}
