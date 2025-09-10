<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Responsive\ResponsiveUtil;
use WP_Customize_Setting;

class ResponsiveGenericControl extends GenericControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-responsive-generic';

	/**
	 * Control's allowed devices.
	 *
	 * @var string[]
	 */
	protected $devices = [];

	/**
	 * Control's device icons.
	 *
	 * @var array
	 */
	protected $device_icons = [];

	/**
	 * Whether to save the value as a JSON encoded string.
	 *
	 * @var bool
	 */
	protected $save_as_json = false;

	/**
	 * Control's default value as array.
	 *
	 * @var array
	 */
	protected $default_array = [];

	/**
	 * Control's actual value as array.
	 *
	 * @var array
	 */
	protected $value_array = [];

	/**
	 * Custom constructor containing different logic than the parent class.
	 *
	 * @param array $args The control arguments.
	 */
	protected function customConstructor( $args ) {

		$responsive_util = new ResponsiveUtil();

		if ( ! empty( $args['devices'] ) && is_array( $args['devices'] ) ) {
			$this->devices = $args['devices'];
		} else {
			$this->devices = $responsive_util->default_devices;
		}

		if ( ! empty( $args['device_icons'] ) && is_array( $args['device_icons'] ) ) {
			$this->device_icons = $args['device_icons'];
		} else {
			$this->device_icons = $responsive_util->default_device_icons;
		}

		if ( ! empty( $args['save_as_json'] ) && is_bool( $args['save_as_json'] ) ) {
			$this->save_as_json = true;
		}

		if ( ! ( $this->setting instanceof WP_Customize_Setting ) ) {
			return;
		}

		$has_actual_value = $this->value() ? true : false;

		$this->default_array = $responsive_util->toArrayValue( $this->devices, $this->subtype, $this->setting->default, $this->min, $this->max );

		$this->setting->default = $this->save_as_json ? wp_json_encode( $this->default_array ) : $this->default_array;

		$extra_classname = 'wpbf-customize-control-generic wpbf-customize-control-responsive';

		if ( ! empty( $this->wrapper_attrs['class'] ) ) {
			$existing_classname = $this->wrapper_attrs['class'];
			$existing_classname = str_ireplace( '{default_class}', '', $existing_classname );

			$this->wrapper_attrs['class'] = '{default_class} ' . $existing_classname . ' ' . $extra_classname;
		} else {
			$this->wrapper_attrs['class'] = '{default_class} ' . $extra_classname;
		}

		if ( $has_actual_value ) {
			$this->value_array = $responsive_util->toArrayValue( $this->devices, $this->subtype, $this->value(), $this->min, $this->max );
		} else {
			$this->value_array = $this->default_array;
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-responsive-generic-control',
			WPBF_THEME_URI . '/Customizer/Controls/Generic/dist/responsive-generic-control-min.js',
			array( 'wpbf-base-control' ),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['defaultArray'] = $this->default_array;
		$this->json['valueArray']   = $this->value_array;
		$this->json['devices']      = $this->devices;
		$this->json['deviceIcons']  = $this->device_icons;
		$this->json['saveAsJson']   = $this->save_as_json;

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

		$input_tag  = 'textarea' === $this->subtype || 'content' === $this->subtype ? 'textarea' : 'input';
		$input_type = 'text';

		if ( 'textarea' !== $this->subtype && 'content' !== $this->subtype ) {
			$input_type = 'number-unit' === $this->subtype ? 'text' : $this->subtype;
		}

		$first_device = ! empty( $this->devices ) ? $this->devices[0] : '';
		?>

		<header class="wpbf-control-header">
			<?php if ( $this->label ) : ?>
				<label class="customize-control-title" for="_customize-input-<?php echo esc_attr( $this->id . '-' . $first_device ); ?>">
					<?php echo esc_html( $this->label ); ?>
				</label>
			<?php endif; ?>

			<div class="wpbf-device-buttons">
				<?php foreach ( $this->devices as $loop_index => $device ) : ?>
					<?php
					$device_icon = empty( $this->device_icons[ $device ] ) ? 'dashicons-marker' : $this->device_icons[ $device ];
					?>

					<button
						type="button"
						class="wpbf-device-button wpbf-device-button-<?php echo esc_attr( $device . ( 0 === $loop_index ? ' is-active' : '' ) ); ?>"
						data-wpbf-device="<?php echo esc_attr( $device ); ?>"
					>
						<i class="dashicons <?php echo esc_attr( $device_icon ); ?>"></i>
					</button>
					
				<?php endforeach; ?>
			</div>
		</header>

		<?php if ( $this->description ) : ?>
			<span class="description customize-control-description">
				<?php echo wp_kses_post( $this->description ); ?>
			</span>
		<?php endif; ?>

		<div class="customize-control-notifications-container"></div>

		<div class="wpbf-control-form">
			<?php if ( $this->save_as_json ) : ?>
				<?php if ( 'textarea' === $input_tag ) : ?>
					<textarea
						data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>"
						style="position: fixed; opacity: 0; visibility: hidden; height: 0; width: 0; z-index: -1;"
					><?php echo esc_textarea( wp_json_encode( $this->value_array ) ); ?></textarea>
				<?php else : ?>
					<input
						type="hidden"
						data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>"
						value="<?php echo esc_attr( wp_json_encode( $this->value_array ) ); ?>"
					>
				<?php endif; ?>
			<?php endif; ?>

			<?php foreach ( $this->devices as $loop_index => $device ) : ?>
				<?php
				// The value here is already sanitized from `customConstructor` call process.
				$value = isset( $this->value_array[ $device ] ) ? $this->value_array[ $device ] : '';
				$id    = "$this->id-$device";
				?>

				<div
					class="wpbf-control-device wpbf-control-device-<?php echo esc_attr( $device ); ?><?php echo ( 0 === $loop_index ? ' is-active' : '' ); ?>"
					data-wpbf-device="<?php echo esc_attr( $device ); ?>"
				>
					<?php if ( 'textarea' === $input_tag ) : ?>
						<textarea
							<?php $this->input_attrs(); ?>
							id="_customize-input-<?php echo esc_attr( $id ); ?>"
							
							<?php if ( ! $this->save_as_json ) : ?>
								data-customize-setting-property-link="<?php echo esc_attr( $device ); ?>"
							<?php endif; ?>
							
							rows="<?php echo esc_attr( $this->rows ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
					<?php else : ?>
						<input
							<?php
							$this->input_attrs();
							?>
							type="<?php echo esc_attr( $input_type ); ?>"
							id="_customize-input-<?php echo esc_attr( $id ); ?>"
							value="<?php echo esc_attr( $value ); ?>"

							<?php if ( ! $this->save_as_json ) : ?>
								data-customize-setting-property-link="<?php echo esc_attr( $device ); ?>"
							<?php endif; ?>
							
							<?php if ( 'number' === $input_type ) : ?>
								<?php if ( null !== $this->min ) : ?>
									min="<?php echo esc_attr( $this->min ); ?>"
								<?php endif; ?>

								<?php if ( null !== $this->max ) : ?>
									max="<?php echo esc_attr( $this->max ); ?>"
								<?php endif; ?>

								step="<?php echo esc_attr( $this->step ); ?>"
							<?php endif; ?>
						>
					<?php endif; ?>
				</div>

			<?php endforeach; ?>
		</div>

		<?php
	}

}
