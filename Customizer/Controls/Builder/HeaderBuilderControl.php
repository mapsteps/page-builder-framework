<?php
/**
 * Builder control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Builder;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use Mapsteps\Wpbf\Customizer\Controls\Generic\AssocArrayControl;
use WP_Customize_Setting;

/**
 * Class to add Wpbf customizer header builder control.
 */
class HeaderBuilderControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-header-builder';

	private $available_builder_widgets = array();

	private $available_builder_rows = array();

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

		$this->available_builder_widgets = array(
			array(
				'key'   => 'logo',
				'label' => __( 'Logo', 'page-builder-framework' ),
			),
			array(
				'key'   => 'search',
				'label' => __( 'Search', 'page-builder-framework' ),
			),
			array(
				'key'   => 'account',
				'label' => __( 'Account', 'page-builder-framework' ),
			),
			array(
				'key'   => 'block_1',
				'label' => __( 'Block 1', 'page-builder-framework' ),
			),
			array(
				'key'   => 'block_2',
				'label' => __( 'Block 2', 'page-builder-framework' ),
			),
			array(
				'key'   => 'block_3',
				'label' => __( 'Block 3', 'page-builder-framework' ),
			),
			array(
				'key'   => 'button_1',
				'label' => __( 'Button 1', 'page-builder-framework' ),
			),
			array(
				'key'   => 'button_2',
				'label' => __( 'Button 2', 'page-builder-framework' ),
			),
			array(
				'key'   => 'menu_1',
				'label' => __( 'Menu 1', 'page-builder-framework' ),
			),
			array(
				'key'   => 'menu_2',
				'label' => __( 'Menu 2', 'page-builder-framework' ),
			),
		);

		$this->available_builder_rows = array(
			[
				'key'     => 'row_1',
				'label'   => __( 'Pre-Header', 'page-builder-framework' ),
				'columns' => [
					[
						'key'   => 'column_1',
						'label' => __( 'Column 1', 'page-builder-framework' ),
					],
					[
						'key'   => 'column_2',
						'label' => __( 'Column 2', 'page-builder-framework' ),
					],
					[
						'key'   => 'column_3',
						'label' => __( 'Column 3', 'page-builder-framework' ),
					],
				],
			],
			[
				'key'     => 'row_2',
				'label'   => __( 'Main Row', 'page-builder-framework' ),
				'columns' => [
					[
						'key'   => 'column_1',
						'label' => __( 'Column 1', 'page-builder-framework' ),
					],
					[
						'key'   => 'column_2',
						'label' => __( 'Column 2', 'page-builder-framework' ),
					],
					[
						'key'   => 'column_3',
						'label' => __( 'Column 3', 'page-builder-framework' ),
					],
				],
			],
			[
				'key'     => 'row_3',
				'label'   => __( 'Secondary Row', 'page-builder-framework' ),
				'columns' => [
					[
						'key'   => 'column_1',
						'label' => __( 'Column 1', 'page-builder-framework' ),
					],
					[
						'key'   => 'column_2',
						'label' => __( 'Column 2', 'page-builder-framework' ),
					],
					[
						'key'   => 'column_3',
						'label' => __( 'Column 3', 'page-builder-framework' ),
					],
				],
			],
		);

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

		$this->json['headerBuilder'] = [
			'availableRows'    => $this->available_builder_rows,
			'availableWidgets' => $this->available_builder_widgets,
		];

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
