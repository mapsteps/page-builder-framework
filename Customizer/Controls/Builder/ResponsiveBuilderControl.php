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
	 * Available rows.
	 *
	 * @var array
	 */
	private $available_rows = array();

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

		if ( isset( $args['available_rows'] ) && is_array( $args['available_rows'] ) ) {
			if ( isset( $args['available_rows']['desktop'] ) && is_array( $args['available_rows']['desktop'] ) ) {
				$this->available_rows = $args['available_rows'];
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
			'wpbf-builder-control',
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
				if ( ! is_array( $device_value ) ) {
					continue;
				}

				foreach ( $device_value as $row_key => $columns_or_widget_keys ) {
					if ( ! is_array( $columns_or_widget_keys ) ) {
						continue;
					}

					if ( 'mobile' === $device && 'sidebar' === $row_key ) {
						foreach ( $columns_or_widget_keys as $widget_key ) {
							if ( empty( $widget_key ) || ! is_string( $widget_key ) ) {
								continue;
							}

							$this->active_widget_keys[ $device ] = $widget_key;
						}

						continue;
					}

					if ( ! $this->rowKeyExists( $device, $row_key ) ) {
						continue;
					}

					foreach ( $columns_or_widget_keys as $column_key => $widget_keys ) {
						if ( ! $this->columnKeyExists( $device, $column_key ) ) {
							continue;
						}

						foreach ( $widget_keys as $widget_key ) {
							if ( empty( $widget_key ) ) {
								continue;
							}

							if ( ! $this->widgetExists( $device, $widget_key ) ) {
								continue;
							}

							$this->active_widget_keys[ $device ] = $widget_key;
						}
					}
				}
			}
		}

		$this->json['builder'] = [
			'desktop' => [
				'availableWidgets' => isset( $this->available_widgets['desktop'] ) ? $this->available_widgets['desktop'] : array(),
				'availableRows'    => isset( $this->available_rows['desktop'] ) ? $this->available_rows['desktop'] : array(),
				'activeWidgetKeys' => isset( $this->active_widget_keys['desktop'] ) ? $this->active_widget_keys['desktop'] : array(),
			],
			'mobile' => [
				'availableWidgets' => isset( $this->available_widgets['mobile'] ) ? $this->available_widgets['mobile'] : array(),
				'availableRows'    => isset( $this->available_rows['mobile'] ) ? $this->available_rows['mobile'] : array(),
				'activeWidgetKeys' => isset( $this->active_widget_keys['mobile'] ) ? $this->active_widget_keys['mobile'] : array(),
			],
		];

	}

	/**
	 * Check if the row key exists in $this->available_rows.
	 *
	 * @param string $device The device name. Accepts 'desktop' or 'mobile'.
	 * @param string $row_key The row key.
	 *
	 * @return bool
	 */
	private function rowKeyExists( $device, $row_key ) {

		if ( isset( $this->available_rows[ $device ] ) && is_array( $this->available_rows[ $device ] ) ) {
			foreach ( $this->available_rows[ $device ] as $available_row ) {
				if ( $available_row['key'] === $row_key ) {
					return true;
				}
			}
		}

		return false;

	}

	/**
	 * Check if the column key exists in $this->available_rows.
	 *
	 * @param string $device The device name. Accepts 'desktop' or 'mobile'.
	 * @param string $column_key The column key.
	 *
	 * @return bool
	 */
	private function columnKeyExists( $device, $column_key ) {

		if ( isset( $this->available_rows[ $device ] ) && is_array( $this->available_rows[ $device ] ) ) {
			foreach ( $this->available_rows[ $device ] as $available_row ) {
				foreach ( $available_row['columns'] as $available_column ) {
					if ( $available_column['key'] === $column_key ) {
						return true;
					}
				}
			}
		}

		return false;

	}

	/**
	 * Check if the widget key exists in $this->available_widgets.
	 *
	 * @param string $device The device name. Accepts 'desktop' or 'mobile'.
	 * @param string $widget_key The widget key.
	 *
	 * @return bool
	 */
	private function widgetExists( $device, $widget_key ) {

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

		<div class="wpbf-control-form">
			<div class="available-widgets-panel"></div>
		</div>

		<?php
	}

}
