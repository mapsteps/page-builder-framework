<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;
use WP_Customize_Setting;

class AssocArrayControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-assoc-array';

	/**
	 * Whether to use $args['settings'] to construct the input fields.
	 *
	 * @var bool
	 */
	protected $use_settings = false;

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

		if ( ! empty( $args['settings'] ) && is_array( $args['settings'] ) ) {
			$this->use_settings = true;
		}

		if ( ! ( $this->setting instanceof WP_Customize_Setting ) ) {
			return;
		}

		$this->setting->default = static::make_default_value( $this->setting );

	}

	/**
	 * Make default value.
	 *
	 * @param WP_Customize_Setting $setting The setting object.
	 *
	 * @return array
	 */
	public static function make_default_value( $setting ) {

		$default_value = [];

		if ( ! empty( $setting->default ) ) {
			if ( is_string( $setting->default ) ) {
				$decoded = json_decode( $setting->default, true );

				if ( is_array( $decoded ) ) {
					$default_value = $decoded;
				}
			} elseif ( is_array( $setting->default ) ) {
				$default_value = $setting->default;
			}
		}

		return AssocArrayField::sanitize( $default_value, 'block_' );

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-assoc-array-control',
			WPBF_THEME_URI . '/Customizer/Controls/Generic/dist/assoc-array-control-min.js',
			array( 'wpbf-base-control' ),
			WPBF_VERSION,
			false
		);

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
		?>

		<?php if ( $this->label || $this->description ) : ?>
			<div class="customize-control-label">
				<?php if ( $this->label ) : ?>
					<label class="customize-control-title" for="_customize-input-<?php echo esc_attr( $this->id ); ?>">
						<?php echo esc_html( $this->label ); ?>
					</label>
				<?php endif; ?>

				<?php if ( $this->description ) : ?>
					<span class="description customize-control-description">
						<?php echo wp_kses_post( $this->description ); ?>
					</span>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<div class="customize-control-notifications-container"></div>

		<div class="wpbf-control-form">

			<?php
			if ( $this->use_settings && is_array( $this->settings ) ) {
				foreach ( $this->settings as $setting_key => $linked_setting ) {
					if ( ! ( $linked_setting instanceof WP_Customize_Setting ) ) {
						continue;
					}
					?>

					<input
						type="hidden"
						id="_customize-input-<?php echo esc_attr( $this->id ); ?>_<?php echo esc_attr( $setting_key ); ?>"
						value="<?php echo esc_attr( $linked_setting->value() ); ?>"
						data-setting-prop="<?php echo esc_attr( $setting_key ); ?>"
						<?php $this->link( $setting_key ); ?>
					>

					<?php
				}
			} elseif ( ! $this->use_settings && is_array( $this->value() ) ) {
				foreach ( $this->value() as $key => $value ) {
					?>

					<input
						type="hidden"
						id="_customize-input-<?php echo esc_attr( $this->id ); ?>_<?php echo esc_attr( $key ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						data-setting-prop="<?php echo esc_attr( $key ); ?>"
						data-customize-setting-link="<?php echo esc_attr( $this->id . "[$key]" ); ?>"
					>

					<?php
				}
			}
			?>

		</div>

		<?php
	}

}
