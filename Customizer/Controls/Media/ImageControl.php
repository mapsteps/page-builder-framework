<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use Mapsteps\Wpbf\Customizer\Controls\Slider\ImageUtil;
use WP_Customize_Setting;

class ImageControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-image';

	/**
	 * Allowed save_as value.
	 *
	 * @var string[]
	 */
	public static $allowed_save_as = [ 'url', 'id', 'array' ];

	/**
	 * Default of the 'save_as' property.
	 *
	 * @var string
	 */
	public static $default_save_as = 'url';

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

			if ( in_array( $args['save_as'], static::$allowed_save_as, true ) ) {
				$this->save_as = $args['save_as'];
			}
		} else {
			$this->save_as = static::$default_save_as;
		}

		$this->default_src = $this->image_util->makeEmptySrcArray();

		// Normalize the default value.
		if ( $this->setting instanceof WP_Customize_Setting ) {
			$default_value     = $this->setting->default;
			$this->default_src = $this->image_util->unknownToArray( $default_value );

			if ( 'array' === $this->save_as ) {
				$this->setting->default = $this->default_src;
			} elseif ( 'id' === $this->save_as ) {
				$this->setting->default = $this->default_src['id'];
			} else {
				$this->setting->default = $this->default_src['url'];
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

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-image-control', WPBF_THEME_URI . '/Customizer/Controls/Media/dist/image-control-min.css', array(), WPBF_VERSION );

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

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['labels']     = $this->labels;
		$this->json['saveAs']     = $this->save_as;
		$this->json['defaultSrc'] = $this->default_src;
		$this->json['valueSrc']   = $this->image_util->unknownToArray( $this->value() );

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

		<div class="image-wrapper attachment-media-view image-upload">
			<# if ( data.valueSrc ) { #>
				<div class="thumbnail thumbnail-image">
					<img src="{{ data.valueSrc }}"/>
				</div>
			<# } else { #>
				<div class="placeholder">
					<# if ( data.labels.placeholder ) { #>
						{{ data.labels.placeholder }}
					<# } #>
				</div>
			<# } #>

			<div class="actions">
				<button type="button" class="button image-upload-remove-button<# if ( !data.valueSrc.url ) { #> hidden <# } #>">
					{{ data.labels.remove }}
				</button>

				<# if ( data.defaultSrc.url ) { #>
					<button type="button" class="button image-default-button"<# if ( data.defaultSrc.url === data.valueSrc.url ) { #> style="display:none;"<# } #>>
						{{ data.labels.default }}
					</button>
				<# } #>

				<button type="button" class="button image-upload-button">
					{{ data.labels.select }}
				</button>
			</div>
		</div>

		<?php
	}

}
