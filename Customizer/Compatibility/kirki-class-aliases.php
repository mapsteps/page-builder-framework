<?php

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Add Kirki field aliases.
 */
function wpbf_aliases_kirki_fields() {
	$aliases = array(
		[ 'Kirki\Field\Background', 'Kirki_Field_Background' ],
		[ 'Kirki\Field\Checkbox', 'Kirki_Field_Checkbox' ],
		[ 'Kirki\Field\Checkbox_Switch', 'Kirki_Field_Switch' ],
		[ 'Kirki\Field\Checkbox_Switch', 'Kirki\Field\Switch' ], // Preventing typo.
		[ 'Kirki\Field\Checkbox_Toggle', 'Kirki_Field_Toggle' ],
		[ 'Kirki\Field\Checkbox_Toggle', 'Kirki\Field\Toggle' ], // Preventing typo.
		[ 'Kirki\Field\Code', 'Kirki_Field_Code' ],
		[ 'Kirki\Field\Color', 'Kirki_Field_Color' ],
		[ 'Kirki\Field\Color', 'Kirki_Field_Color_Alpha' ],
		[ 'Kirki\Field\Color_Palette', 'Kirki_Field_Color_Palette' ],
		[ 'Kirki\Field\Custom', 'Kirki_Field_Custom' ],
		[ 'Kirki\Field\Dashicons', 'Kirki_Field_Dashicons' ],
		[ 'Kirki\Field\Date', 'Kirki_Field_Date' ],
		[ 'Kirki\Field\Dimension', 'Kirki_Field_Dimension' ],
		[ 'Kirki\Field\Dimensions', 'Kirki_Field_Dimensions' ],
		[ 'Kirki\Field\Dimensions', 'Kirki_Field_Spacing' ],
		[ 'Kirki\Field\Dimensions', 'Kirki\Field\Spacing' ],
		[ 'Kirki\Field\Editor', 'Kirki_Field_Editor' ],
		[ 'Kirki\Field\Generic', 'Kirki_Field_FontAwesome' ], // Kirki doesn't have a FontAwesome field (anymore).
		[ 'Kirki\Field\Generic', 'Kirki_Field_Kirki_Generic' ],
		[ 'Kirki\Field\Generic', 'Kirki_Field_Generic' ],
		[ 'Kirki\Field\Text', 'Kirki_Field_Text' ],
		[ 'Kirki\Field\Textarea', 'Kirki_Field_Textarea' ],
		[ 'Kirki\Field\URL', 'Kirki_Field_URL' ],
		[ 'Kirki\Field\URL', 'Kirki_Field_Link' ],
		[ 'Kirki\Field\URL', 'Kirki\Field\Link' ],
		[ 'Kirki\Field\Image', 'Kirki_Field_Image' ],
		[ 'Kirki\Field\Multicheck', 'Kirki_Field_Multicheck' ],
		[ 'Kirki\Field\Multicolor', 'Kirki_Field_Multicolor' ],
		[ 'Kirki\Field\Number', 'Kirki_Field_Number' ],
		[ 'Kirki\Field\Palette', 'Kirki_Field_Palette' ],
		[ 'Kirki\Field\Repeater', 'Kirki_Field_Repeater' ],
		[ 'Kirki\Field\Dropdown_Pages', 'Kirki_Field_Dropdown_Pages' ],
		[ 'Kirki\Field\Generic', 'Kirki_Field_Preset' ], // Preset field is not mentioned in Kirki's documentation.
		[ 'Kirki\Field\Select', 'Kirki_Field_Select' ],
		[ 'Kirki\Field\Slider', 'Kirki_Field_Slider' ],
		[ 'Kirki\Field\Sortable', 'Kirki_Field_Sortable' ],
		[ 'Kirki\Field\Typography', 'Kirki_Field_Typography' ],
		[ 'Kirki\Field\Upload', 'Kirki_Field_Upload' ],
	);

	foreach ( $aliases as $alias ) {
		if ( class_exists( $alias[0] ) ) {
			Kirki::add_field( $alias[0], $alias[1] );
		}
	}

}

wpbf_aliases_kirki_fields();
