<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use WP_Customize_Media_Control;

class UploadControl extends WP_Customize_Media_Control {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-upload';

	/**
	 * ID of the attachment.
	 *
	 * @var int
	 */
	protected $attachment_id;

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

		$value = $this->value();

		if ( ! empty( $value ) ) {
			if ( is_array( $value ) && ! empty( $value['id'] ) ) {
				$this->attachment_id = absint( $value['id'] );
			} elseif ( is_numeric( $value ) ) {
				$this->attachment_id = absint( $value );
			} elseif ( is_string( $value ) && ! is_numeric( $value ) ) {
				$this->attachment_id = attachment_url_to_postid( $value );
			}
		}

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		if ( ! empty( $this->attachment_id ) ) {
			$this->json['attachment'] = wp_prepare_attachment_for_js( $this->attachment_id );
		}

	}

}
