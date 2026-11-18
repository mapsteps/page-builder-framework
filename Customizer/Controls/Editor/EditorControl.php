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
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['tinymce']   = $this->tinymce;
		$this->json['quicktags'] = $this->quicktags;

	}

}
