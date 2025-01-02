<?php
/**
 * Select control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Select;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

/**
 * Class to add Wpbf customizer select control.
 */
class NativeSelectControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-native-select';

	/**
	 * Whether to allow multiple selection.
	 *
	 * @var bool
	 */
	public $multiple = false;

	/**
	 * Maximum number of selections allowed.
	 *
	 * @var int
	 */
	public $max_selections = -1;

	/**
	 * Placeholder text.
	 *
	 * @var string
	 */
	public $placeholder = '';

	/**
	 * The layout style.
	 *
	 * @var string
	 */
	public $layout_style = 'default';

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

		$this->choices = ( new SelectUtil() )->toSelect2Format( $this->choices );
		$this->setSelectedOptions();

	}

	/**
	 * Set the selected options.
	 */
	private function setSelectedOptions() {

		$values = $this->value();

		if ( ! is_array( $values ) ) {
			$values = '' === $values || null === $values || false === $values ? [] : [ $values ];
		}

		foreach ( $this->choices as $index => $choice ) {
			if ( isset( $choice['id'] ) && in_array( $choice['id'], $values, true ) ) {
				$this->choices[ $index ]['selected'] = true;
			}

			if ( is_array( $choice ) && ! empty( $choice['children'] ) ) {
				foreach ( $choice['children'] as $child_index => $child_choice ) {
					if ( isset( $child_choice['id'] ) && in_array( $child_choice['id'], $values, true ) ) {
						$this->choices[ $index ]['children'][ $child_index ]['selected'] = true;
					}
				}
			}
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		wp_enqueue_style( 'wpbf-select-control', WPBF_THEME_URI . '/Customizer/Controls/Select/dist/select-control-min.css', array( 'wpbf-base-control' ), WPBF_VERSION );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['multiple']    = $this->multiple;
		$this->json['placeholder'] = ( $this->placeholder ) ? $this->placeholder : esc_html__( 'Select...', 'page-builder-framework' );

		// Will be a custom implementation, couldn't find an official prop to set this in react-select.
		$this->json['maxSelections'] = $this->max_selections;

		$this->json['messages'] = array(
			// translators: %s is the limit of selection number.
			'maxLimitReached' => sprintf( esc_html__( 'You can only select %s items', 'page-builder-framework' ), $this->max_selections ),
		);

		$this->json['layoutStyle'] = $this->layout_style;

	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 */
	protected function render_content() {

		$input_id         = '_customize-input-' . $this->id;
		$description_id   = '_customize-description-' . $this->id;
		$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';

		$label_template = '';

		if ( ! empty( $this->label ) ) {
			$label_template = '
				<label class="customize-control-title" for="' . esc_attr( $input_id ) . '">
					<span class="customize-control-title">
					' . esc_html( $this->label ) . '
					</span>
				</label>
			';
		}

		$label_description_template = '';

		if ( ! empty( $this->description ) ) {
			$label_description_template = '
				<div class="customize-control-description description" id="' . esc_attr( $description_id ) . '">
					' . wp_kses_post( $this->description ) . '
				</div>
			';
		}

		$header_template = '
			<header class="wpbf-control-header">
				' . $label_template . '
				' . $label_description_template . '
				<div class="customize-control-notifications-container"></div>
			</header>
		';

		ob_start();
		$this->build_options( $this->choices );
		$select_opts_output = ob_get_clean();

		$form_template = '
			<div class="wpbf-control-form">
				<select id="' . esc_attr( $input_id ) . '" ' . $describedby_attr . ' ' . $this->get_link() . '>
					' . $select_opts_output . '
				</select>
			</div>
		';

		$template = $header_template . $form_template;

		if ( 'horizontal' === $this->layout_style ) {
			$template = sprintf(
				'<div class="wpbf-control-cols">
					<div class="wpbf-control-left-col wpbf-w50">%s</div>
					<div class="wpbf-control-right-col wpbf-flex wpbf-content-end wpbf-w50">%s</div>
				</div>',
				$header_template,
				$form_template
			);
		}

		echo $template;

	}

	/**
	 * Build the options.
	 */
	private function build_options() {

		foreach ( $this->choices as $index => $choice ) {
			$option_value = isset( $choice['id'] ) ? $choice['id'] : '';
			$option_label = isset( $choice['text'] ) ? $choice['text'] : '';
			$is_selected  = isset( $choice['selected'] ) && $choice['selected'];
			$sub_options  = isset( $choice['children'] ) ? $choice['children'] : [];
			?>

			<?php if ( ! empty( $sub_options ) ) : ?>
				<optgroup label="<?php echo esc_html( $option_label ); ?>">
					<?php $this->build_options( $sub_options ); ?>
				</optgroup>
			<?php else : ?>
				<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $is_selected, true ); ?>>
					<?php echo esc_html( $option_label ); ?>
				</option>
			<?php endif; ?>

			<?php
		}

	}

}
