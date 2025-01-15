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
	 * Available widgets for desktop.
	 *
	 * @var array
	 */
	private $desktop_available_widgets = array();

	/**
	 * Available widgets for tablet & phone.
	 *
	 * @var array
	 */
	private $mobile_available_widgets = array();

	/**
	 * Active widgets for desktop.
	 *
	 * @var string[]
	 */
	private $desktop_active_widget_keys = array();

	/**
	 * Active widgets for tablet & phone.
	 *
	 * @var string[]
	 */
	private $mobile_active_widget_keys = array();

	/**
	 * Available rows for desktop.
	 *
	 * @var array
	 */
	private $desktop_available_rows = array();

	/**
	 * Available rows for tablet & phone.
	 *
	 * @var array
	 */
	private $mobile_available_rows = array();

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

		if ( isset( $args['desktop'] ) && is_array( $args['desktop'] ) ) {
			if ( isset( $args['desktop']['available_widgets'] ) && is_array( $args['desktop']['available_widgets'] ) ) {
				$this->desktop_available_widgets = $args['desktop']['available_widgets'];
			}

			if ( isset( $args['desktop']['available_rows'] ) && is_array( $args['desktop']['available_rows'] ) ) {
				$this->desktop_available_rows = $args['desktop']['available_rows'];
			}
		}

		if ( isset( $args['mobile'] ) && is_array( $args['mobile'] ) ) {
			if ( isset( $args['mobile']['available_widgets'] ) && is_array( $args['mobile']['available_widgets'] ) ) {
				$this->mobile_available_widgets = $args['mobile']['available_widgets'];
			}

			if ( isset( $args['mobile']['available_rows'] ) && is_array( $args['mobile']['available_rows'] ) ) {
				$this->mobile_available_rows = $args['mobile']['available_rows'];
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
			WPBF_THEME_URI . '/Customizer/Controls/Builder/dist/builder-control-min.js',
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
			if ( isset( $value['desktop'] ) && is_array( $value['desktop'] ) ) {
				foreach ( $value['desktop'] as $row_key => $columns ) {
					if ( ! $this->rowKeyExists( $row_key ) ) {
						continue;
					}

					foreach ( $columns as $column_key => $widget_keys ) {
						if ( ! $this->columnKeyExists( $column_key ) ) {
							continue;
						}

						foreach ( $widget_keys as $widget_key ) {
							if ( empty( $widget_key ) ) {
								continue;
							}

							if ( ! $this->widgetExists( $widget_key ) ) {
								continue;
							}

							$this->active_widget_keys[] = $widget_key;
						}
					}
				}
			}
		}

		$this->json['builder'] = [
			'desktop' => [
				'availableWidgets' => $this->desktop_available_widgets,
				'availableRows'    => $this->desktop_available_rows,
				'activeWidgetKeys' => $this->desktop_active_widget_keys,
			],
			'mobile' => [
				'availableWidgets' => $this->mobile_available_widgets,
				'availableRows'    => $this->mobile_available_rows,
				'activeWidgetKeys' => $this->mobile_active_widget_keys,
			],
		];

	}

	/**
	 * Check if the row key exists in $this->available_rows.
	 *
	 * @param string $row_key The row key.
	 *
	 * @return bool
	 */
	private function rowKeyExists( $row_key ) {

		foreach ( $this->available_rows as $available_row ) {
			if ( $available_row['key'] === $row_key ) {
				return true;
			}
		}

		return false;

	}

	/**
	 * Check if the column key exists in $this->available_rows.
	 *
	 * @param string $column_key The column key.
	 *
	 * @return bool
	 */
	private function columnKeyExists( $column_key ) {

		foreach ( $this->available_rows as $available_row ) {
			foreach ( $available_row['columns'] as $available_column ) {
				if ( $available_column['key'] === $column_key ) {
					return true;
				}
			}
		}

		return false;

	}

	/**
	 * Check if the widget key exists in $this->available_widgets.
	 *
	 * @param string $widget_key The widget key.
	 *
	 * @return bool
	 */
	private function widgetExists( $widget_key ) {

		foreach ( $this->available_widgets as $available_widget ) {
			if ( $available_widget['key'] === $widget_key ) {
				return true;
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
