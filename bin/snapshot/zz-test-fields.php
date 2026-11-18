<?php
/**
 * Plugin Name: zz-test fields (temporary, dev only)
 *
 * Fields of the control types and variants the theme and Premium don't use, in a "zz-test" section: checkbox,
 * switch, headline toggle, plain radio, every generic subtype, responsive generics, dimension with the label below,
 * margin/padding without JSON, upload, image saved as array, editor, sortable. For control-dump.php (second argument)
 * and, copied into wp-content/mu-plugins for a run, the Customizer checks. Delete the copy afterwards; nothing is saved.
 *
 * @package Page Builder Framework
 */

// phpcs:disable -- Dev tool.

function zz_test_7b_fields() {

	if ( ! function_exists( 'wpbf_customizer_field' ) ) {
		return;
	}

	wpbf_customizer_section()->id( 'zz_test_section' )->title( 'zz-test' )->priority( 1 )->add();

	$s = 'zz_test_section';

	wpbf_customizer_field()->id( 'zz_test_checkbox' )->type( 'checkbox' )->label( 'zz Checkbox' )->description( 'zz <b>desc</b>' )->defaultValue( true )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_checkbox_off' )->type( 'checkbox' )->label( 'zz Checkbox off' )->defaultValue( 'off' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_toggle' )->type( 'toggle' )->label( 'zz Toggle' )->description( 'zz toggle desc' )->defaultValue( 1 )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_toggle_nolabel' )->type( 'toggle' )->defaultValue( 0 )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_switch' )->type( 'toggle' )->label( 'zz Switch' )->defaultValue( 0 )->properties( array( 'checkbox_type' => 'switch' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_switch_choices' )->type( 'toggle' )->label( 'zz Switch choices' )->defaultValue( true )->choices( array( 'on' => 'Yes', 'off' => 'No' ) )->properties( array( 'checkbox_type' => 'switch' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_headline_toggle' )->type( 'headline-toggle' )->label( 'zz Headline toggle' )->defaultValue( false )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_radio' )->type( 'radio' )->label( 'zz Radio' )->description( 'zz radio desc' )->defaultValue( 'b' )->choices( array( 'a' => 'Option A', 'b' => array( 'Option B', 'B <i>desc</i>' ), 'c' => 'C & D' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_buttonset' )->type( 'radio-buttonset' )->label( 'zz Buttonset' )->defaultValue( 'two' )->choices( array( 'one' => 'One', 'two' => '<b>Two</b>', '3' => 3 ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_radio_image' )->type( 'radio-image' )->label( 'zz Radio image' )->description( 'zz img desc' )->defaultValue( 'left' )->choices( array( 'left' => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg', 'right' => array( 'src' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg', 'alt' => 'Right "alt"' ) ) )->inputAttrs( array( 'style' => 'width: 50%;', 'data-zz' => 'x' ) )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_text' )->type( 'text' )->label( 'zz Text' )->description( 'zz text <a href="#">desc</a>' )->defaultValue( 'hello' )->inputAttrs( array( 'placeholder' => 'zz ph' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_number' )->type( 'number' )->label( 'zz Number' )->defaultValue( 5 )->properties( array( 'min' => 1, 'max' => 10, 'step' => 0.5 ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_number_unit' )->type( 'number-unit' )->label( 'zz Number unit' )->defaultValue( '3em' )->properties( array( 'min' => 0, 'max' => 100 ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_textarea' )->type( 'textarea' )->label( 'zz Textarea' )->defaultValue( "line 1\nline <b>2</b>" )->properties( array( 'rows' => 3 ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_email' )->type( 'email' )->label( 'zz Email' )->defaultValue( 'zz@example.com' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_url' )->type( 'url' )->label( 'zz Url' )->defaultValue( 'https://example.com' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_password' )->type( 'password' )->defaultValue( '' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_hidden' )->type( 'hidden' )->defaultValue( 'h' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_content' )->type( 'content' )->label( 'zz Content' )->defaultValue( '<p>c</p>' )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_resp_number' )->type( 'responsive-number' )->label( 'zz Resp number' )->description( 'zz resp desc' )->defaultValue( array( 'desktop' => 10, 'tablet' => 20, 'mobile' => '' ) )->properties( array( 'min' => 0, 'max' => 50, 'save_as_json' => true ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_resp_text' )->type( 'responsive-text' )->label( 'zz Resp text' )->defaultValue( array( 'desktop' => 'a', 'tablet' => 'b' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_resp_textarea' )->type( 'responsive-textarea' )->label( 'zz Resp textarea' )->defaultValue( '{"desktop":"x","tablet":"","mobile":"z"}' )->properties( array( 'save_as_json' => true, 'devices' => array( 'desktop', 'mobile' ) ) )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_dimension' )->type( 'dimension' )->label( 'zz Dimension' )->description( 'zz dim desc' )->defaultValue( '20px' )->inputAttrs( array( 'class' => 'zz-class', 'placeholder' => 'zz' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_dimension_bottom' )->type( 'dimension' )->label( 'zz Dim bottom' )->defaultValue( '50%%' )->properties( array( 'label_position' => 'bottom', 'allow_unitless' => false ) )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_margin' )->type( 'margin' )->label( 'zz Margin' )->description( 'zz margin desc' )->defaultValue( array( 'top' => '1', 'right' => '2px', 'bottom' => '', 'left' => 4 ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_padding_em' )->type( 'padding' )->label( 'zz Padding em' )->defaultValue( '' )->properties( array( 'unit' => 'em', 'dimensions' => array( 'top', 'bottom' ) ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_padding_json' )->type( 'padding' )->label( 'zz Padding json' )->defaultValue( '{"top":5,"right":"","bottom":7,"left":""}' )->properties( array( 'save_as_json' => true, 'dont_save_unit' => true ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_resp_margin' )->type( 'responsive-margin' )->label( 'zz Resp margin' )->defaultValue( array( 'desktop_top' => 1, 'tablet_right' => '2px' ) )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_upload' )->type( 'upload' )->label( 'zz Upload' )->defaultValue( '' )->properties( array( 'save_as' => 'id' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_image_array' )->type( 'image' )->label( 'zz Image array' )->defaultValue( '' )->properties( array( 'save_as' => 'array' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_editor' )->type( 'editor' )->label( 'zz Editor' )->defaultValue( '<p>zz</p>' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_sortable' )->type( 'sortable' )->label( 'zz Sortable' )->defaultValue( array( 'b', 'a' ) )->choices( array( 'a' => 'A', 'b' => 'B', 'c' => 'C' ) )->addToSection( $s );

	// 7c: color variants, typography, repeater with every sub-field type.
	wpbf_customizer_field()->id( 'zz_test_color' )->type( 'color' )->label( 'zz Color' )->description( 'zz color <b>desc</b>' )->defaultValue( '#123ABC' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_short' )->type( 'color' )->label( 'zz Color short' )->defaultValue( '#abc' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_alpha' )->type( 'color' )->label( 'zz Color alpha' )->defaultValue( 'rgba(10, 20, 30, 0.5)' )->properties( array( 'mode' => 'alpha' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_transparent' )->type( 'color' )->label( 'zz Color transparent' )->defaultValue( 'transparent' )->properties( array( 'mode' => 'alpha' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_var' )->type( 'color' )->label( 'zz Color var' )->defaultValue( 'var(--zz-color)' )->properties( array( 'mode' => 'alpha' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_empty' )->type( 'color' )->label( 'zz Color empty' )->defaultValue( '' )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_hue' )->type( 'color' )->label( 'zz Color hue' )->defaultValue( 120 )->properties( array( 'mode' => 'hue' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_top' )->type( 'color' )->label( 'zz Color top' )->defaultValue( '#ff0000' )->properties( array( 'label_style' => 'top', 'color_swatches' => array( '#111111', '#222222' ) ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_tooltip' )->type( 'color' )->label( 'zz Color tooltip' )->defaultValue( '#00ff00' )->properties( array( 'label_style' => 'tooltip', 'swatches' => array( '#333333' ) ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_rgba_object' )->type( 'color' )->label( 'zz Color rgba object' )->defaultValue( array( 'r' => 1, 'g' => 2, 'b' => 3, 'a' => 0.5 ) )->properties( array( 'form_component' => 'RgbaColorPicker' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_color_hsla' )->type( 'color' )->label( 'zz Color hsla' )->defaultValue( 'hsla(200, 50%, 40%, 0.7)' )->properties( array( 'form_component' => 'HslaStringColorPicker' ) )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_typography' )->type( 'typography' )->label( 'zz Typography' )->description( 'zz typo desc' )->defaultValue( array( 'font-family' => 'Roboto', 'variant' => '700' ) )->addToSection( $s );
	wpbf_customizer_field()->id( 'zz_test_typography_label' )->type( 'typography' )->label( 'zz Typography label only' )->defaultValue( array( 'font-size' => '14px' ) )->addToSection( $s );

	wpbf_customizer_field()->id( 'zz_test_repeater' )->type( 'repeater' )->label( 'zz Repeater' )->description( 'zz rep desc' )
		->defaultValue( array( array( 'zz_text' => 'Row "one"', 'zz_select' => 'b', 'zz_multi' => array( 'a', 'c' ), 'zz_upload' => false, 'zz_checkbox' => true, 'zz_textarea' => "t\nx", 'zz_color' => '#ff0000', 'zz_radio' => 'y' ) ) )
		->properties( array(
			'row_label'    => array( 'type' => 'field', 'value' => 'zz row', 'field' => 'zz_text' ),
			'button_label' => 'zz add',
			'limit'        => 3,
			'fields'       => array(
				'zz_text'     => array( 'type' => 'text', 'label' => 'zz Text', 'description' => 'zz text desc' ),
				'zz_select'   => array( 'type' => 'select', 'label' => 'zz Select', 'choices' => array( 'a' => 'A', 'b' => 'B' ) ),
				'zz_multi'    => array( 'type' => 'select', 'label' => 'zz Multi', 'multiple' => 3, 'choices' => array( 'a' => 'A', 'b' => 'B', 'c' => 'C' ) ),
				'zz_upload'   => array( 'type' => 'upload', 'label' => 'zz Upload', 'mime_type' => array() ),
				'zz_number'   => array( 'type' => 'number', 'label' => 'zz Number' ),
				'zz_checkbox' => array( 'type' => 'checkbox', 'label' => 'zz Checkbox' ),
				'zz_textarea' => array( 'type' => 'textarea', 'label' => 'zz Textarea' ),
				'zz_color'    => array( 'type' => 'color', 'label' => 'zz Color' ),
				'zz_radio'    => array( 'type' => 'radio', 'label' => 'zz Radio', 'choices' => array( 'x' => 'X', 'y' => 'Y' ) ),
			),
		) )
		->addToSection( $s );

}

if ( did_action( 'after_setup_theme' ) ) {
	zz_test_7b_fields();
} else {
	add_action( 'after_setup_theme', 'zz_test_7b_fields', 20 );
}
