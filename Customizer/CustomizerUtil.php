<?php
/**
 * Wpbf customizer's utility helper class.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Controls\Slider\SliderField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use WP_Customize_Manager;

/**
 * Wpbf customizer's utility helper class.
 */
class CustomizerUtil {

	/**
	 * The available controls.
	 *
	 * @var string[] $available_controls
	 */
	public $available_controls = array(
		'slider',
	);

	/**
	 * Determine the sanitize callback.
	 *
	 * @param string $type The control type.
	 *
	 * @return callable|string
	 */
	public function determineSanitizeCallback( $type ) {

		if ( ! in_array( $type, $this->available_controls, true ) ) {
			return '';
		}

		if ( 'slider' === $type ) {
			$slider_field = new SliderField();

			if ( method_exists( $slider_field, 'sanitizeCallback' ) ) {
				return array( $slider_field, 'sanitizeCallback' );
			}

			return '';
		}

		return '';

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager    $wp_customize_manager The customizer manager object.
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function addControl( $wp_customize_manager, $control ) {

		$control_type = $control->type;

		if ( ! in_array( $control_type, $this->available_controls, true ) ) {
			return;
		}

		if ( 'slider' === $control_type ) {
			$slider_field = new SliderField();

			if ( method_exists( $slider_field, 'addControl' ) ) {
				$slider_field->addControl( $wp_customize_manager, $control );
			}
		}

	}

	/**
	 * Generate the control dependencies js object.
	 *
	 * @return string
	 */
	public function makeControlDependenciesJsObj() {

		$js_object = '{';

		foreach ( Customizer::$added_control_dependencies as $control_id => $field_dependencies ) {

			if ( ! is_array( $field_dependencies ) ) {
				continue;
			}

			$js_object .= $control_id . ': [';

			foreach ( $field_dependencies as $field_dependency ) {

				$dep_id       = $field_dependency['id'];
				$dep_operator = $field_dependency['operator'];
				$dep_value    = $field_dependency['value'];

				$dep_value_type = 'string';

				if ( is_float( $dep_value ) ) {
					$dep_value_type = 'float';
				} elseif ( is_int( $dep_value ) ) {
					$dep_value_type = 'int';
				} elseif ( is_bool( $dep_value ) ) {
					$dep_value_type = 'boolean';
				}

				$js_object .= '{';
				$js_object .= 'id:"' . $dep_id . '",';
				$js_object .= 'operator:"' . $dep_operator . '",';

				if ( 'boolean' === $dep_value_type ) {
					$js_object .= 'value:' . ( $dep_value ? 'true' : 'false' ) . ',';
				} elseif ( 'int' === $dep_value_type || 'float' === $dep_value_type ) {
					$js_object .= 'value:' . $dep_value . ',';
				} else {
					$js_object .= 'value:"' . $dep_value . '",';
				}

				$js_object  = rtrim( $js_object, ',' );
				$js_object .= '},';

			}

			$js_object  = rtrim( $js_object, ',' );
			$js_object .= '],';

		}

		$js_object  = rtrim( $js_object, ',' );
		$js_object .= '}';

		return $js_object;

	}

}
