<?php
/**
 * Plugin Name: zz-test Kirki fields (temporary, dev only)
 *
 * Options added the Kirki way, as Premium 2.9 and older and child themes do: \Kirki::add_config/add_panel/add_section/
 * add_field with every type and old type name, the Kirki 4 / Kirki Pro classes (supported and unsupported ones), an
 * "option" config, falsy defaults, show/hide rules, and classes extending the old control base classes. For
 * kirki-dump.php (second argument) and, copied into wp-content/mu-plugins for a run, the Customizer check. Delete the
 * copy afterwards; nothing is saved.
 *
 * @package Page Builder Framework
 */

// phpcs:disable -- Dev tool.

function zz_test_kirki_fields() {

	if ( ! class_exists( 'Kirki' ) ) {
		return;
	}

	// Custom controls written against the old base classes (child themes).
	if ( ! class_exists( 'ZZ_Test_Kirki3_Control' ) ) {
		class ZZ_Test_Kirki3_Control extends Kirki_Customize_Control {}
		class ZZ_Test_Kirki3_Base_Control extends Kirki_Control_Base {}
		class ZZ_Test_Kirki4_Control extends \Kirki\Control\Base {}
		class ZZ_Test_Old_Wpbf_Control extends WPBF_Customize_Responsive_Padding_Control {}
	}

	Kirki::add_config( 'zz_kirki', array( 'capability' => 'edit_theme_options', 'option_type' => 'theme_mod' ) );
	Kirki::add_config( 'zz_kirki_opt', array( 'option_type' => 'option', 'option_name' => 'zz_kirki_opts' ) );

	Kirki::add_panel( 'zz_kirki_panel', array( 'title' => 'zz Kirki panel', 'priority' => 0 ) );
	Kirki::add_section( 'zz_kirki_section', array( 'title' => 'zz Kirki section', 'panel' => 'zz_kirki_panel', 'priority' => 1 ) );
	Kirki::add_section( 'zz_kirki_section_tabs', array( 'title' => 'zz Kirki tabs', 'panel' => 'zz_kirki_panel', 'tabs' => array( 'general' => array( 'label' => 'General' ), 'design' => array( 'label' => 'Design' ) ) ) );
	new \Kirki\Panel( 'zz_kirki_panel4', array( 'title' => 'zz Kirki 4 panel', 'priority' => 0 ) );
	new \Kirki\Section( 'zz_kirki_section4', array( 'title' => 'zz Kirki 4 section', 'panel' => 'zz_kirki_panel4' ) );

	$s = 'zz_kirki_section';
	$f = function ( $args ) use ( $s ) {
		Kirki::add_field( 'zz_kirki', array_merge( array( 'section' => $s ), $args ) );
	};

	// As Premium 2.9.2's EDD integration (called without a class_exists check).
	$f( array( 'type' => 'custom', 'settings' => 'zz_kirki_separator', 'default' => '<hr style="border-top: 1px solid #ccc">', 'priority' => 40 ) );
	$f( array( 'type' => 'select', 'settings' => 'zz_kirki_select', 'label' => 'zz Select', 'default' => 'show', 'priority' => 50, 'multiple' => 1, 'choices' => array( 'show' => 'Enable', 'hide' => 'Disable' ) ) );

	$f( array( 'type' => 'checkbox', 'settings' => 'zz_kirki_checkbox', 'label' => 'zz Checkbox', 'default' => false ) );
	$f( array( 'type' => 'switch', 'settings' => 'zz_kirki_switch', 'label' => 'zz Switch', 'default' => 0, 'choices' => array( 'on' => 'On', 'off' => 'Off' ) ) );
	$f( array( 'type' => 'toggle', 'settings' => 'zz_kirki_toggle', 'label' => 'zz Toggle', 'default' => '0', 'priority' => 0 ) );
	$f( array( 'type' => 'code_editor', 'settings' => 'zz_kirki_code_editor', 'label' => 'zz Code editor', 'choices' => array( 'language' => 'html' ) ) );
	$f( array( 'type' => 'color', 'settings' => 'zz_kirki_color', 'label' => 'zz Color', 'default' => 'rgba(0,0,0,0.5)', 'choices' => array( 'alpha' => true ), 'transport' => 'postMessage' ) );
	$f( array( 'type' => 'color', 'settings' => 'zz_kirki_color_swatches', 'label' => 'zz Color swatches', 'default' => '#ff0000', 'choices' => array( 'swatches' => array( '#000000', '#ffffff' ) ) ) );
	$f( array( 'type' => 'color', 'settings' => 'zz_kirki_color_palettes', 'label' => 'zz Color palettes', 'default' => '', 'choices' => array( 'palettes' => array( '#111111', '#222222' ) ) ) );
	$f( array( 'type' => 'dimension', 'settings' => 'zz_kirki_dimension', 'label' => 'zz Dimension', 'default' => '10px' ) );
	$f( array( 'type' => 'editor', 'settings' => 'zz_kirki_editor', 'label' => 'zz Editor', 'default' => '<p>zz</p>', 'choices' => array( 'tinymce' => true, 'quicktags' => false ) ) );
	$f( array( 'type' => 'image', 'settings' => 'zz_kirki_image', 'label' => 'zz Image', 'choices' => array( 'save_as' => 'id' ) ) );
	$f( array( 'type' => 'url', 'settings' => 'zz_kirki_url', 'label' => 'zz URL' ) );
	$f( array( 'type' => 'link', 'settings' => 'zz_kirki_link', 'label' => 'zz Link (old name)' ) );
	$f( array( 'type' => 'number', 'settings' => 'zz_kirki_number', 'label' => 'zz Number', 'default' => 0, 'choices' => array( 'min' => 0, 'max' => 10, 'step' => 2 ) ) );
	$f( array( 'type' => 'radio', 'settings' => 'zz_kirki_radio', 'label' => 'zz Radio', 'default' => 'a', 'choices' => array( 'a' => 'A', 'b' => 'B' ) ) );
	$f( array( 'type' => 'radio_buttonset', 'settings' => 'zz_kirki_radio_buttonset_old', 'label' => 'zz Buttonset (old name)', 'default' => 'b', 'choices' => array( 'a' => 'A', 'b' => 'B' ) ) );
	$f( array( 'type' => 'radio-buttonset', 'settings' => 'zz_kirki_radio_buttonset', 'label' => 'zz Buttonset', 'default' => 'a', 'choices' => array( 'a' => 'A', 'b' => 'B' ), 'tab' => 'design' ) );
	$f( array( 'type' => 'radio-image', 'settings' => 'zz_kirki_radio_image', 'label' => 'zz Radio image', 'default' => 'a', 'choices' => array( 'a' => 'http://pbf.local/a.png', 'b' => 'http://pbf.local/b.png' ) ) );
	$f( array( 'type' => 'repeater', 'settings' => 'zz_kirki_repeater', 'label' => 'zz Repeater', 'choices' => array( 'row_label' => array( 'type' => 'field', 'value' => 'Row', 'field' => 'zz_text' ), 'button_label' => 'Add', 'limit' => 3 ), 'fields' => array(), 'default' => array() ) );
	$f( array( 'type' => 'repeater', 'settings' => 'zz_kirki_repeater_fields', 'label' => 'zz Repeater fields', 'choices' => array( 'limit' => 2, 'fields' => array( 'zz_text' => array( 'type' => 'text', 'label' => 'T', 'default' => '' ), 'zz_select' => array( 'type' => 'select', 'label' => 'S', 'default' => array(), 'choices' => array( 'multiple' => 3, 'a' => 'A', 'b' => 'B' ) ), 'zz_num' => array( 'type' => 'number', 'label' => 'N', 'choices' => array( 'min' => 1, 'max' => 5, 'step' => 1 ) ), 'zz_upload' => array( 'type' => 'upload', 'label' => 'U', 'choices' => array( 'save_as' => 'id' ) ) ) ) ) );
	$f( array( 'type' => 'select', 'settings' => 'zz_kirki_select_multi', 'label' => 'zz Select multiple', 'default' => array( 'a' ), 'choices' => array( 'multiple' => 2, 'a' => 'A', 'b' => 'B', 'c' => 'C' ) ) );
	$f( array( 'type' => 'slider', 'settings' => 'zz_kirki_slider', 'label' => 'zz Slider', 'default' => 0, 'choices' => array( 'min' => 0, 'max' => 100, 'step' => 5 ) ) );
	$f( array( 'type' => 'sortable', 'settings' => 'zz_kirki_sortable', 'label' => 'zz Sortable', 'default' => array( 'b', 'a' ), 'choices' => array( 'a' => 'A', 'b' => 'B', 'c' => 'C' ) ) );
	$f( array( 'type' => 'text', 'settings' => 'zz_kirki_text', 'label' => 'zz Text', 'default' => '0', 'tooltip' => 'zz tip', 'input_attrs' => array( 'placeholder' => 'zz' ), 'partial_refresh' => array( 'zz_kirki_text' => array( 'selector' => '.zz-test', 'render_callback' => '__return_empty_string' ) ) ) );
	$f( array( 'type' => 'textarea', 'settings' => 'zz_kirki_textarea', 'label' => 'zz Textarea', 'sanitize_callback' => 'wp_kses_post' ) );
	$f( array( 'type' => 'typography', 'settings' => 'zz_kirki_typography', 'label' => 'zz Typography', 'default' => array( 'font-family' => 'Roboto', 'variant' => '700' ) ) );
	$f( array( 'type' => 'upload', 'settings' => 'zz_kirki_upload', 'label' => 'zz Upload' ) );
	$f( array( 'type' => 'input_slider', 'settings' => 'zz_kirki_input_slider', 'label' => 'zz Input slider (old name)', 'default' => '20px', 'choices' => array( 'min' => 0, 'max' => 50, 'step' => 1 ) ) );
	$f( array( 'type' => 'padding_control', 'settings' => 'zz_kirki_padding_control', 'label' => 'zz Padding control', 'default' => '{"top":"5","right":"","bottom":"5","left":""}' ) );
	$f( array( 'type' => 'responsive_padding', 'settings' => 'zz_kirki_responsive_padding', 'label' => 'zz Responsive padding', 'default' => '{"desktop_top":"10","mobile_top":"5"}' ) );
	$f( array( 'type' => 'responsive_input_slider', 'settings' => 'zz_kirki_responsive_input_slider', 'label' => 'zz Responsive input slider', 'default' => '{"desktop":"30","tablet":"","mobile":""}', 'choices' => array( 'min' => 0, 'max' => 100, 'step' => 1 ) ) );
	$f( array( 'type' => 'responsive_input', 'settings' => 'zz_kirki_responsive_input_number', 'label' => 'zz Responsive input numbers', 'default' => '{"desktop":"4","tablet":"2","mobile":"1"}' ) );
	$f( array( 'type' => 'responsive_input', 'settings' => 'zz_kirki_responsive_input_text', 'label' => 'zz Responsive input text', 'default' => '{"desktop":"4px","tablet":"","mobile":"1"}' ) );

	// Show/hide rules: operator missing, a nested OR group, a callable.
	$f( array( 'type' => 'text', 'settings' => 'zz_kirki_rules', 'label' => 'zz Rules', 'active_callback' => array( array( 'setting' => 'zz_kirki_checkbox', 'value' => true ), array( 'setting' => 'zz_kirki_radio', 'operator' => '!=', 'value' => 'b' ), array( array( 'setting' => 'zz_kirki_toggle', 'value' => true ), array( 'setting' => 'zz_kirki_switch', 'value' => true ) ) ) ) );
	$f( array( 'type' => 'text', 'settings' => 'zz_kirki_rules_callable', 'label' => 'zz Rules callable', 'active_callback' => '__return_true' ) );

	// A config that stores in an option (option_name[setting], also with a sub key).
	Kirki::add_field( 'zz_kirki_opt', array( 'type' => 'text', 'settings' => 'zz_kirki_opt_text', 'label' => 'zz Option text', 'section' => $s, 'default' => 'zz' ) );
	Kirki::add_field( 'zz_kirki_opt', array( 'type' => 'text', 'settings' => 'zz_kirki_opt_group[sub]', 'label' => 'zz Option sub', 'section' => $s ) );
	Kirki::add_field( 'zz_kirki', array( 'type' => 'text', 'settings' => 'zz_kirki_options_type', 'label' => 'zz options type', 'section' => $s, 'option_type' => 'options', 'option_name' => 'zz_kirki_opts2' ) );

	// Kirki 4 classes.
	$s4 = 'zz_kirki_section4';
	$classes = array( 'Checkbox', 'Checkbox_Switch', 'Checkbox_Toggle', 'Toggle', 'Code', 'Color', 'ReactColorful', 'Dimension', 'Editor', 'Image', 'URL', 'Number', 'Radio', 'Radio_Buttonset', 'Radio_Image', 'Repeater', 'Select', 'ReactSelect', 'Slider', 'Sortable', 'Text', 'Textarea', 'Typography', 'Upload' );
	foreach ( $classes as $class ) {
		$fqcn = '\\Kirki\\Field\\' . $class;
		new $fqcn( array( 'settings' => 'zz_kirki4_' . strtolower( $class ), 'label' => 'zz 4 ' . $class, 'section' => $s4, 'choices' => array( 'a' => 'A', 'b' => 'B' ) ) );
	}
	new \Kirki\Field\Generic( array( 'settings' => 'zz_kirki4_generic', 'label' => 'zz 4 Generic', 'section' => $s4, 'choices' => array( 'element' => 'input', 'type' => 'number', 'min' => 1, 'max' => 9, 'step' => 2, 'placeholder' => 'zz' ) ) );
	new \Kirki\Field\Generic( array( 'settings' => 'zz_kirki4_generic_textarea', 'label' => 'zz 4 Generic textarea', 'section' => $s4, 'choices' => array( 'element' => 'textarea', 'rows' => 4 ) ) );
	foreach ( array( 'Background', 'Color_Palette', 'Dashicons', 'Date', 'Dimensions', 'Dropdown_Pages', 'Multicheck', 'Multicolor', 'Palette' ) as $class ) {
		$fqcn = '\\Kirki\\Field\\' . $class;
		new $fqcn( array( 'settings' => 'zz_kirki4_unsupported_' . strtolower( $class ), 'label' => 'zz 4 ' . $class, 'section' => $s4 ) );
	}
	foreach ( array( 'Margin', 'Padding', 'Headline', 'HeadlineToggle', 'Divider', 'InputSlider' ) as $class ) {
		$fqcn = '\\Kirki\\Pro\\Field\\' . $class;
		new $fqcn( array( 'settings' => 'zz_kirki_pro_' . strtolower( $class ), 'label' => 'zz Pro ' . $class, 'section' => $s4 ) );
	}
}

if ( did_action( 'after_setup_theme' ) ) {
	zz_test_kirki_fields();
} else {
	add_action( 'after_setup_theme', 'zz_test_kirki_fields' );
}
