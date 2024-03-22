<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Setting;

class ImageControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-image';

	/**
	 * The 'array' format of the default value.
	 *
	 * @var array
	 */
	protected $default_src;

	/**
	 * Save the value as 'url', 'id' or 'array'.
	 *
	 * @var string
	 */
	protected $save_as;

	/**
	 * Labels for the control's UI.
	 *
	 * @var array
	 */
	protected $labels = [];

	/**
	 * The image utility.
	 *
	 * @var ImageUtil
	 */
	protected $image_util;

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

		$this->image_util = new ImageUtil();

		if ( ! empty( $args['save_as'] ) && is_string( $args['save_as'] ) ) {
			$args['save_as'] = strtolower( $args['save_as'] );

			if ( in_array( $args['save_as'], $this->image_util->allowed_save_as, true ) ) {
				$this->save_as = $args['save_as'];
			}
		} else {
			$this->save_as = $this->image_util->default_save_as;
		}

		$this->default_src = $this->image_util->makeEmptySrcArray();

		// Normalize the default value.
		if ( $this->setting instanceof WP_Customize_Setting ) {
			$default_value     = $this->setting->default;
			$this->default_src = $this->image_util->unknownToSrcArray( $default_value );

			// We allow empty string.
			if ( '' !== $default_value ) {
				if ( 'array' === $this->save_as ) {
					$this->setting->default = $this->default_src;
				} elseif ( 'id' === $this->save_as ) {
					$this->setting->default = $this->default_src['id'];
				} elseif ( 'url' === $this->save_as ) {
					$this->setting->default = $this->default_src['url'];
				}
			}
		}

		$this->labels = [
			'select'       => __( 'Select image', 'page-builder-framework' ),
			'change'       => __( 'Change image', 'page-builder-framework' ),
			'default'      => __( 'Default', 'page-builder-framework' ),
			'remove'       => __( 'Remove', 'page-builder-framework' ),
			'placeholder'  => __( 'No image selected', 'page-builder-framework' ),
			'frame_title'  => __( 'Select image', 'page-builder-framework' ),
			'frame_button' => __( 'Choose image', 'page-builder-framework' ),
		];

		if ( ! empty( $args['labels'] ) && is_array( $args['labels'] ) ) {
			$this->labels = wp_parse_args( $args['labels'], $this->labels );
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-image-control',
			WPBF_THEME_URI . '/Customizer/Controls/Media/dist/image-control-min.js',
			array(
				'customize-controls',
				'react-dom',
			),
			WPBF_VERSION,
			false
		);

		wp_set_script_translations( 'wpbf-control-image', 'wpbf' );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['labels']     = $this->labels;
		$this->json['saveAs']     = $this->save_as;
		$this->json['defaultSrc'] = $this->default_src;
		$this->json['valueSrc']   = $this->image_util->unknownToSrcArray( $this->value() );

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
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<div class="attachment-media-view">
			<div class="thumbnail thumbnail-image<# if ( !data.valueSrc.url ) { #> hidden <# } #>">
				<# if ( data.valueSrc.url ) { #>
					<img class="attachment-thumb" src="{{ data.valueSrc.url }}"/>
				<# } #>
			</div>

			<button type="button" class="upload-button button-add-media<# if ( data.valueSrc.url ) { #> hidden <# } #>">
				<# if ( data.labels.placeholder ) { #>
					{{ data.labels.placeholder }}
				<# } #>
			</button>

			<div class="actions">
				<button type="button" class="button remove-button<# if ( !data.valueSrc.url ) { #> hidden <# } #>">
					{{ data.labels.remove }}
				</button>

				<# if ( data.defaultSrc.url ) { #>
					<button type="button" class="button default-button<# if ( data.defaultSrc.url === data.valueSrc.url ) { #> hidden <# } #>">
						{{ data.labels.default }}
					</button>
				<# } #>

				<button type="button" class="button change-button<# if ( !data.valueSrc.url ) { #> hidden <# } #>">
					{{ data.labels.change }}
				</button>
			</div>
		</div>

		<?php
	}

}
