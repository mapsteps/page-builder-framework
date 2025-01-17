<?php
/**
 * Responsive builder control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Builder;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use Mapsteps\Wpbf\Customizer\Controls\Generic\AssocArrayControl;
use WP_Customize_Setting;

/**
 * Class to add Wpbf customizer builder control.
 */
class ResponsiveBuilderControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-responsive-builder';

	/**
	 * Available widgets.
	 *
	 * @var array
	 */
	private $available_widgets = array();

	/**
	 * Active widget keys.
	 *
	 * @var array
	 */
	private $active_widget_keys = array();

	/**
	 * Available slots.
	 *
	 * @var array
	 */
	private $available_slots = array();

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Optional. Array of properties for the new Control object.
	 *                                                   Default empty array.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		parent::__construct( $wp_customize_manager, $id, $args );

		if ( isset( $args['available_widgets'] ) && is_array( $args['available_widgets'] ) ) {
			if ( isset( $args['available_widgets']['desktop'] ) && is_array( $args['available_widgets']['desktop'] ) ) {
				$this->available_widgets = $args['available_widgets'];
			}
		}

		if ( isset( $args['available_slots'] ) && is_array( $args['available_slots'] ) ) {
			if ( isset( $args['available_slots']['desktop'] ) && is_array( $args['available_slots']['desktop'] ) ) {
				$this->available_slots = $args['available_slots'];
			}
		}

		if ( ! ( $this->setting instanceof WP_Customize_Setting ) ) {
			return;
		}

		$this->setting->default = AssocArrayControl::make_default_value( $this->setting );

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-builder-control', WPBF_THEME_URI . '/Customizer/Controls/Builder/dist/builder-control-min.css', array(), WPBF_VERSION );

		// Enqueue jQuery UI scripts.
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-responsive-builder-control',
			WPBF_THEME_URI . '/Customizer/Controls/Builder/dist/responsive-builder-control-min.js',
			array(
				'customize-controls',
				'jquery-ui-draggable',
				'jquery-ui-droppable',
				'jquery-ui-sortable',
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

		$value = $this->value();

		if ( ! empty( $value ) && is_array( $value ) ) {
			foreach ( $value as $device => $device_value ) {
				if ( 'desktop' !== $device && 'mobile' !== $device ) {
					continue;
				}

				if ( ! is_array( $device_value ) ) {
					continue;
				}

				if ( 'mobile' === $device && isset( $device_value['sidebar'] ) && is_array( $device_value['sidebar'] ) ) {
					foreach ( $device_value['sidebar'] as $widget_key ) {
						if ( empty( $widget_key ) || ! is_string( $widget_key ) ) {
							continue;
						}

						if ( ! $this->widgetExists( $widget_key, $device ) ) {
							continue;
						}

						$this->active_widget_keys[ $device ] = $widget_key;
					}

					continue;
				}

				if ( ! isset( $device_value['rows'] ) || ! is_array( $device_value['rows'] ) ) {
					continue;
				}

				foreach ( $device_value['rows'] as $row_key => $columns ) {
					if ( ! is_array( $columns ) ) {
						continue;
					}

					if ( ! $this->rowKeyExists( $row_key, $device ) ) {
						continue;
					}

					foreach ( $columns as $column_key => $widget_keys ) {
						if ( ! $this->columnKeyExists( $column_key, $device ) ) {
							continue;
						}

						foreach ( $widget_keys as $widget_key ) {
							if ( empty( $widget_key ) ) {
								continue;
							}

							if ( ! $this->widgetExists( $widget_key, $device ) ) {
								continue;
							}

							$this->active_widget_keys[ $device ] = $widget_key;
						}
					}
				}
			}
		} else {
			$value = null;
		}

		$this->json['value'] = $value;

		$this->json['builder'] = [
			'desktop' => [
				'availableWidgets' => isset( $this->available_widgets['desktop'] ) ? $this->available_widgets['desktop'] : array(),
				'availableSlots'   => isset( $this->available_slots['desktop'] ) ? $this->available_slots['desktop'] : array(),
				'activeWidgetKeys' => isset( $this->active_widget_keys['desktop'] ) ? $this->active_widget_keys['desktop'] : array(),
			],
			'mobile' => [
				'availableWidgets' => isset( $this->available_widgets['mobile'] ) ? $this->available_widgets['mobile'] : array(),
				'availableSlots'   => isset( $this->available_slots['mobile'] ) ? $this->available_slots['mobile'] : array(),
				'activeWidgetKeys' => isset( $this->active_widget_keys['mobile'] ) ? $this->active_widget_keys['mobile'] : array(),
			],
		];

	}

	/**
	 * Check if the row key exists in $this->available_slots.
	 *
	 * @param string $row_key The row key.
	 * @param string $device The device name. Accepts 'desktop' or 'mobile'.
	 *
	 * @return bool
	 */
	private function rowKeyExists( $row_key, $device ) {

		if ( isset( $this->available_slots[ $device ] ) && is_array( $this->available_slots[ $device ] ) ) {
			if ( isset( $this->available_slots[ $device ]['rows'] ) ) {
				foreach ( $this->available_slots[ $device ]['rows'] as $available_row ) {
					if ( isset( $available_row['key'] ) && $available_row['key'] === $row_key ) {
						return true;
					}
				}
			}
		}

		return false;

	}

	/**
	 * Check if the column key exists in $this->available_slots.
	 *
	 * @param string $column_key The column key.
	 * @param string $device The device name. Accepts 'desktop' or 'mobile'.
	 *
	 * @return bool
	 */
	private function columnKeyExists( $column_key, $device ) {

		if ( isset( $this->available_slots[ $device ] ) && is_array( $this->available_slots[ $device ] ) ) {
			if ( isset( $this->available_slots[ $device ]['rows'] ) ) {
				foreach ( $this->available_slots[ $device ]['rows'] as $available_row ) {
					foreach ( $available_row['columns'] as $available_column ) {
						if ( $available_column['key'] === $column_key ) {
							return true;
						}
					}
				}
			}
		}

		return false;

	}

	/**
	 * Check if the widget key exists in $this->available_widgets.
	 *
	 * @param string $widget_key The widget key.
	 * @param string $device The device name. Accepts 'desktop' or 'mobile'.
	 *
	 * @return bool
	 */
	private function widgetExists( $widget_key, $device ) {

		if ( isset( $this->available_widgets[ $device ] ) && is_array( $this->available_widgets[ $device ] ) ) {
			foreach ( $this->available_widgets[ $device ] as $available_widget ) {
				if ( $available_widget['key'] === $widget_key ) {
					return true;
				}
			}
		}

		return false;

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

		<header class="wpbf-control-header">
			<?php if ( $this->label ) : ?>
				<label class="customize-control-label" for="_customize-input-<?php echo esc_attr( $this->id ); ?>">
					<span class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</span>
				</label>
			<?php endif; ?>

			<?php if ( $this->description ) : ?>
				<div class="customize-control-description">
					<?php echo esc_html( $this->description ); ?>
				</div>
			<?php endif; ?>
		</header>

		<div class="customize-control-notifications-container"></div>

		<div class="wpbf-control-form"></div>

		<?php
	}

}
