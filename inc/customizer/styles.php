<?php
/**
 * Dynamic CSS file
 *
 * Holds Customizer CSS styles
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

do_action( 'wpbf_before_customizer_css' );

/* Typography */

// Page Font Settings
$page_font_family_value = get_theme_mod( 'page_font_family', array() );
$page_font_toggle = get_theme_mod( 'page_font_toggle' );

if( $page_font_toggle && $page_font_family_value ) { ?>

	body,
	button,
	input,
	optgroup,
	select,
	textarea,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6 {

	<?php if( isset( $page_font_family_value['font-family'] ) && !empty( $page_font_family_value['font-family'] ) ) { ?>

		font-family: <?php echo html_entity_decode( esc_attr( $page_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;

	<?php } ?>

	<?php if( isset( $page_font_family_value['variant'] ) && !empty( $page_font_family_value['variant'] ) ) {

		$page_font_family_font_weight = str_replace( 'italic', '', $page_font_family_value['variant'] );
		$page_font_family_font_weight = ( in_array( $page_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_font_family_font_weight;

		$page_font_family_is_italic = ( false !== strpos( $page_font_family_value['variant'], 'italic' ) );
		$page_font_family_font_style = $page_font_family_is_italic ? 'italic' : 'normal' ;

		?>

		font-weight: <?php echo esc_attr( $page_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $page_font_family_font_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php
if( get_theme_mod( 'page_font_color' ) ) { ?>
body {
	color: <?php echo esc_attr( get_theme_mod( 'page_font_color' ) ); ?>;
}
<?php } ?>

<?php

// Menu Font Settings
$menu_font_family_value = get_theme_mod( 'menu_font_family', array() );
$menu_font_family_toggle = get_theme_mod( 'menu_font_family_toggle' );

if( $menu_font_family_toggle && $menu_font_family_value ) { ?>

	.wpbf-menu, .wpbf-mobile-menu {

	<?php if( isset( $menu_font_family_value['font-family'] ) && !empty( $menu_font_family_value['font-family'] ) ) { ?>
		font-family: <?php echo html_entity_decode( esc_attr( $menu_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;
	<?php } ?>

	<?php if( isset( $menu_font_family_value['variant'] ) && !empty( $menu_font_family_value['variant'] ) ) {

		$menu_font_family_font_weight = str_replace( 'italic', '', $menu_font_family_value['variant'] );
		$menu_font_family_font_weight = ( in_array( $menu_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $menu_font_family_font_weight;

		$menu_font_family_is_italic = ( false !== strpos( $menu_font_family_value['variant'], 'italic' ) );
		$menu_font_family_is_style = $menu_font_family_is_italic ? 'italic' : 'normal' ;

		?>
		
		font-weight: <?php echo esc_attr( $menu_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $menu_font_family_is_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php

// H1 Font Settings
$page_h1_font_family_value = get_theme_mod( 'page_h1_font_family', array() );
$page_h1_toggle = get_theme_mod( 'page_h1_toggle' );

if( $page_h1_toggle && $page_h1_font_family_value ) { ?>

	h1,
	h2,
	h3,
	h4,
	h5,
	h6 {

	<?php if( isset( $page_h1_font_family_value['font-family'] ) && !empty( $page_h1_font_family_value['font-family'] ) ) { ?>
		font-family: <?php echo html_entity_decode( esc_attr( $page_h1_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;
	<?php } ?>

	<?php if( isset( $page_h1_font_family_value['variant'] ) && !empty( $page_h1_font_family_value['variant'] ) ) {

		$page_h1_font_family_font_weight = str_replace( 'italic', '', $page_h1_font_family_value['variant'] );
		$page_h1_font_family_font_weight = ( in_array( $page_h1_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h1_font_family_font_weight;

		$page_h1_font_family_is_italic = ( false !== strpos( $page_h1_font_family_value['variant'], 'italic' ) );
		$page_h1_font_family_is_style = $page_h1_font_family_is_italic ? 'italic' : 'normal' ;

		?>

		font-weight: <?php echo esc_attr( $page_h1_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $page_h1_font_family_is_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php

// H2 Font Settings
$page_h2_font_family_value = get_theme_mod( 'page_h2_font_family', array() );
$page_h2_toggle = get_theme_mod( 'page_h2_toggle' );

if( $page_h2_toggle && $page_h2_font_family_value ) { ?>

	h2 {

	<?php if( isset( $page_h2_font_family_value['font-family'] ) && !empty( $page_h2_font_family_value['font-family'] ) ) { ?>
		font-family: <?php echo html_entity_decode( esc_attr( $page_h2_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;
	<?php } ?>

	<?php if( isset( $page_h2_font_family_value['variant'] ) && !empty( $page_h2_font_family_value['variant'] ) ) {

		$page_h2_font_family_font_weight = str_replace( 'italic', '', $page_h2_font_family_value['variant'] );
		$page_h2_font_family_font_weight = ( in_array( $page_h2_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h2_font_family_font_weight;

		$page_h2_font_family_is_italic = ( false !== strpos( $page_h2_font_family_value['variant'], 'italic' ) );
		$page_h2_font_family_is_style = $page_h2_font_family_is_italic ? 'italic' : 'normal';

		?>

		font-weight: <?php echo esc_attr( $page_h2_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $page_h2_font_family_is_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php

// H3 Font Settings
$page_h3_font_family_value = get_theme_mod( 'page_h3_font_family', array() );
$page_h3_toggle = get_theme_mod( 'page_h3_toggle' );

if( $page_h3_toggle && $page_h3_font_family_value ) { ?>

	h3 {

	<?php if( isset( $page_h3_font_family_value['font-family'] ) && !empty( $page_h3_font_family_value['font-family'] ) ) { ?>
		font-family: <?php echo html_entity_decode( esc_attr( $page_h3_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;
	<?php } ?>

	<?php if( isset( $page_h3_font_family_value['variant'] ) && !empty( $page_h3_font_family_value['variant'] ) ) {

		$page_h3_font_family_font_weight = str_replace( 'italic', '', $page_h3_font_family_value['variant'] );
		$page_h3_font_family_font_weight = ( in_array( $page_h3_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h3_font_family_font_weight;

		$page_h3_font_family_is_italic = ( false !== strpos( $page_h3_font_family_value['variant'], 'italic' ) );
		$page_h3_font_family_is_style = $page_h3_font_family_is_italic ? 'italic' : 'normal' ;

		?>

		font-weight: <?php echo esc_attr( $page_h3_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $page_h3_font_family_is_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php

// H4 Font Settings
$page_h4_font_family_value = get_theme_mod( 'page_h4_font_family', array() );
$page_h4_toggle = get_theme_mod( 'page_h4_toggle' );

if( $page_h4_toggle && $page_h4_font_family_value ) { ?>

	h4 {

	<?php if( isset( $page_h4_font_family_value['font-family'] ) && !empty( $page_h4_font_family_value['font-family'] ) ) { ?>
		font-family: <?php echo html_entity_decode( esc_attr( $page_h4_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;
	<?php } ?>

	<?php if( isset( $page_h4_font_family_value['variant'] ) && !empty( $page_h4_font_family_value['variant'] ) ) {

		$page_h4_font_family_font_weight = str_replace( 'italic', '', $page_h4_font_family_value['variant'] );
		$page_h4_font_family_font_weight = ( in_array( $page_h4_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h4_font_family_font_weight;

		$page_h4_font_family_is_italic = ( false !== strpos( $page_h4_font_family_value['variant'], 'italic' ) );
		$page_h4_font_family_is_style = $page_h4_font_family_is_italic ? 'italic' : 'normal' ;

		?>

		font-weight: <?php echo esc_attr( $page_h4_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $page_h4_font_family_is_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php

// H5 Font Settings
$page_h5_font_family_value = get_theme_mod( 'page_h5_font_family', array() );
$page_h5_toggle = get_theme_mod( 'page_h5_toggle' );

if( $page_h5_toggle && $page_h5_font_family_value ) { ?>

	h5 {

	<?php if( isset( $page_h5_font_family_value['font-family'] ) && !empty( $page_h5_font_family_value['font-family'] ) ) { ?>
		font-family: <?php echo html_entity_decode( esc_attr( $page_h5_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;
	<?php } ?>

	<?php if( isset( $page_h5_font_family_value['variant'] ) && !empty( $page_h5_font_family_value['variant'] ) ) {

		$page_h5_font_family_font_weight = str_replace( 'italic', '', $page_h5_font_family_value['variant'] );
		$page_h5_font_family_font_weight = ( in_array( $page_h5_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h5_font_family_font_weight;

		$page_h5_font_family_is_italic = ( false !== strpos( $page_h5_font_family_value['variant'], 'italic' ) );
		$page_h5_font_family_is_style = $page_h5_font_family_is_italic ? 'italic' : 'normal' ;

		?>

		font-weight: <?php echo esc_attr( $page_h5_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $page_h5_font_family_is_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php

 // H6 Font Settings
$page_h6_font_family_value = get_theme_mod( 'page_h6_font_family', array() );
$page_h6_toggle = get_theme_mod( 'page_h6_toggle' );

if( $page_h6_toggle && $page_h6_font_family_value ) { ?>

	h6 {

	<?php if( isset( $page_h6_font_family_value['font-family'] ) && !empty( $page_h6_font_family_value['font-family'] ) ) { ?>
		font-family: <?php echo html_entity_decode( esc_attr( $page_h6_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;
	<?php } ?>

	<?php if( isset( $page_h6_font_family_value['variant'] ) && !empty( $page_h6_font_family_value['variant'] ) ) {

		$page_h6_font_family_font_weight = str_replace( 'italic', '', $page_h6_font_family_value['variant'] );
		$page_h6_font_family_font_weight = ( in_array( $page_h6_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $page_h6_font_family_font_weight;

		$page_h6_font_family_is_italic = ( false !== strpos( $page_h6_font_family_value['variant'], 'italic' ) );
		$page_h6_font_family_is_style = $page_h6_font_family_is_italic ? 'italic' : 'normal' ;

		?>

		font-weight: <?php echo esc_attr( $page_h6_font_family_font_weight ); ?>;
		font-style: <?php echo esc_attr( $page_h6_font_family_is_style ); ?>;

	<?php } ?>

	}

<?php } ?>

<?php

// General
if( get_theme_mod( 'page_max_width' ) ) { ?>

.wpbf-container {
	max-width: <?php echo esc_attr( get_theme_mod( 'page_max_width' ) ) ?>;
}

<?php } ?>

<?php if( get_theme_mod( 'page_boxed' ) ) { ?>

	<?php if( get_theme_mod( 'page_boxed_padding' ) ) { ?>

	.wpbf-container {
			padding-left: <?php echo esc_attr( get_theme_mod( 'page_boxed_padding' ) ) ?>px;
			padding-right: <?php echo esc_attr( get_theme_mod( 'page_boxed_padding' ) ) ?>px;
	}

	<?php } ?>

	.wpbf-page {
		<?php if( get_theme_mod( 'page_max_width' ) ) { ?>
			max-width: <?php echo esc_attr( get_theme_mod( 'page_max_width' ) ) ?>;
		<?php } else { ?>
			max-width: 1200px;
		<?php } ?>
			margin: 0 auto;

		<?php if( get_theme_mod( 'page_boxed_margin' ) ) { ?>
			margin-top: <?php echo esc_attr( get_theme_mod( 'page_boxed_margin' ) ) ?>px;
			margin-bottom: <?php echo esc_attr( get_theme_mod( 'page_boxed_margin' ) ) ?>px;
		<?php } ?>

		<?php if( get_theme_mod( 'page_boxed_background' ) ) { ?>
			background-color: <?php echo esc_attr( get_theme_mod( 'page_boxed_background' ) ) ?>;
		<?php } ?>
	}

	<?php if( get_theme_mod( 'page_boxed_box_shadow' ) ) { ?>
	#container {
		box-shadow: <?php if( get_theme_mod( 'page_boxed_box_shadow_horizontal' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_horizontal' ) ) . 'px'; else : echo'0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_vertical' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_vertical' ) ) . 'px'; else : echo '0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_blur' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_blur' ) ) . 'px'; else : echo '25px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_spread' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_spread' ) ) . 'px'; else : echo '0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_color' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_color' ) ); else : echo 'rgba(0,0,0,.15)'; endif; ?>;
		-moz-box-shadow: <?php if( get_theme_mod( 'page_boxed_box_shadow_horizontal' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_horizontal' ) ) . 'px'; else : echo'0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_vertical' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_vertical' ) ) . 'px'; else : echo '0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_blur' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_blur' ) ) . 'px'; else : echo '25px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_spread' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_spread' ) ) . 'px'; else : echo '0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_color' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_color' ) ); else : echo 'rgba(0,0,0,.15)'; endif; ?>;
		-webkit-box-shadow: <?php if( get_theme_mod( 'page_boxed_box_shadow_horizontal' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_horizontal' ) ) . 'px'; else : echo '0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_vertical' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_vertical' ) ) . 'px'; else : echo '0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_blur' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_blur' ) ) . 'px'; else : echo '25px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_spread' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_spread' ) ) . 'px'; else : echo '0px'; endif; ?> <?php if( get_theme_mod( 'page_boxed_box_shadow_color' ) ) : echo esc_attr( get_theme_mod( 'page_boxed_box_shadow_color' ) ); else : echo 'rgba(0,0,0,.15)'; endif; ?>;
	}
	<?php } ?>

<?php } ?>

<?php // ScrollTop ?>

<?php if( get_theme_mod( 'layout_scrolltop' ) ) { ?>

	<?php if( get_theme_mod( 'scrolltop_position' ) == 'left' ) { ?>

	.scrolltop {
		right: auto;
		left: 20px;
	}

	<?php } ?>

	<?php if( get_theme_mod( 'scrolltop_bg_color' ) || get_theme_mod( 'scrolltop_border_radius' ) ) { ?>

	.scrolltop {

		<?php if( get_theme_mod( 'scrolltop_bg_color' ) ) { ?>
		background: <?php echo esc_attr( get_theme_mod( 'scrolltop_bg_color' ) ) ?>;
		<?php } ?>

		<?php if( get_theme_mod( 'scrolltop_border_radius' ) ) { ?>
		border-radius: <?php echo esc_attr( get_theme_mod( 'scrolltop_border_radius' ) ) ?>px;
		<?php } ?>

	}

	<?php } ?>

	<?php if( get_theme_mod( 'scrolltop_bg_color_alt' ) ) { ?>

	.scrolltop:hover {
		background: <?php echo esc_attr( get_theme_mod( 'scrolltop_bg_color_alt' ) ) ?>;
	}

	<?php } ?>

<?php } ?>

<?php // Background (backwards compatibility) ?>

<?php if( get_theme_mod( 'page_background_color' ) || get_theme_mod( 'page_background_image' ) ) { ?>

body {

<?php if( get_theme_mod( 'page_background_color' ) ) { ?>
	background-color: <?php echo esc_attr( get_theme_mod( 'page_background_color' ) ) ?>;
<?php } ?>

<?php if( get_theme_mod( 'page_background_image' ) ) { ?>
	background-image: url(<?php echo esc_url( get_theme_mod( 'page_background_image' ) ) ?>);
<?php } ?>

<?php if( get_theme_mod( 'page_background_attachment' ) ) { ?>
	background-attachment: <?php echo esc_attr( get_theme_mod( 'page_background_attachment' ) ) ?>;
<?php } ?>

<?php if( get_theme_mod( 'page_background_position' ) ) { ?>
	background-position: <?php echo esc_attr( get_theme_mod( 'page_background_position' ) ) ?>;
<?php } ?>

<?php if( get_theme_mod( 'page_background_repeat' ) ) { ?>
	background-repeat: <?php echo esc_attr( get_theme_mod( 'page_background_repeat' ) ) ?>;
<?php } ?>

<?php if( get_theme_mod( 'page_background_size' ) ) { ?>
	background-size: <?php echo esc_attr( get_theme_mod( 'page_background_size' ) ) ?>;
<?php } ?>

}

<?php } ?>

<?php // Accent Color ?>

<?php if( get_theme_mod( 'page_accent_color' ) ) { ?>
a {
	color: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
}
.bypostauthor, .bypostauthor .avatar {
	border-color: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
}
.wpbf-button-primary {
	background: <?php echo esc_attr( get_theme_mod( 'page_accent_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'page_accent_color_alt' ) ) { ?>
a:hover {
	color: <?php echo esc_attr( get_theme_mod( 'page_accent_color_alt' ) ) ?>;
}
.wpbf-button-primary:hover {
	background: <?php echo esc_attr( get_theme_mod( 'page_accent_color_alt' ) ) ?>;
}

.wpbf-menu > .current-menu-item > a {
	color: <?php echo esc_attr( get_theme_mod( 'page_accent_color_alt' ) ) ?> !important;
}

<?php } ?>

<?php // Buttons ?>

<?php if( get_theme_mod( 'button_border_width' ) ) { ?>

	.wpbf-button, input[type="submit"] {
		border-width: <?php echo esc_attr( get_theme_mod( 'button_border_width' ) ) ?>px;
		border-style: solid;
	<?php if( get_theme_mod( 'button_border_color' ) ) { ?>
		border-color: <?php echo esc_attr( get_theme_mod( 'button_border_color' ) ) ?>;
	<?php } ?>
	}	

	<?php if( get_theme_mod( 'button_border_color_alt' ) ) { ?>
	.wpbf-button:hover, input[type="submit"]:hover {
		border-color: <?php echo esc_attr( get_theme_mod( 'button_border_color_alt' ) ) ?>;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'button_primary_border_color' ) ) { ?>
	.wpbf-button-primary {
		border-color: <?php echo esc_attr( get_theme_mod( 'button_primary_border_color' ) ) ?>;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'button_primary_border_color_alt' ) ) { ?>
	.wpbf-button-primary:hover {
		border-color: <?php echo esc_attr( get_theme_mod( 'button_primary_border_color_alt' ) ) ?>;
	}
	<?php } ?>

<?php } ?>

<?php if( get_theme_mod( 'button_bg_color' ) || get_theme_mod( 'button_text_color' ) || get_theme_mod( 'button_border_radius' ) ) { ?>

	.wpbf-button, input[type="submit"] {
	<?php if( get_theme_mod( 'button_border_radius' ) ) { ?>
		border-radius: <?php echo esc_attr( get_theme_mod( 'button_border_radius' ) ) ?>px;
	<?php } ?>
	<?php if( get_theme_mod( 'button_bg_color' ) ) { ?>
		background: <?php echo esc_attr( get_theme_mod( 'button_bg_color' ) ) ?>;
	<?php } ?>
	<?php if( get_theme_mod( 'button_text_color' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'button_text_color' ) ) ?>;
	<?php } ?>
	}

<?php } ?>

<?php if( get_theme_mod( 'button_bg_color_alt' ) || get_theme_mod( 'button_text_color_alt' ) ) { ?>

	.wpbf-button:hover, input[type="submit"]:hover {
	<?php if( get_theme_mod( 'button_bg_color_alt' ) ) { ?>
		background: <?php echo esc_attr( get_theme_mod( 'button_bg_color_alt' ) ) ?>;
	<?php } ?>
	<?php if( get_theme_mod( 'button_text_color_alt' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'button_text_color_alt' ) ) ?>;
	<?php } ?>
	}

<?php } ?>

<?php if( get_theme_mod( 'button_primary_bg_color' ) || get_theme_mod( 'button_primary_text_color' ) ) { ?>

	.wpbf-button-primary {
	<?php if( get_theme_mod( 'button_primary_bg_color' ) ) { ?>
		background: <?php echo esc_attr( get_theme_mod( 'button_primary_bg_color' ) ) ?>;
	<?php } ?>
	<?php if( get_theme_mod( 'button_primary_text_color' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'button_primary_text_color' ) ) ?>;
	<?php } ?>
	}

<?php } ?>

<?php if( get_theme_mod( 'button_primary_bg_color_alt' ) || get_theme_mod( 'button_primary_text_color_alt' ) ) { ?>

	.wpbf-button-primary:hover {
	<?php if( get_theme_mod( 'button_primary_bg_color_alt' ) ) { ?>
		background: <?php echo esc_attr( get_theme_mod( 'button_primary_bg_color_alt' ) ) ?>;
	<?php } ?>
	<?php if( get_theme_mod( 'button_primary_text_color_alt' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'button_primary_text_color_alt' ) ) ?>;
	<?php } ?>
	}

<?php } ?>

<?php // Blog ?>

<?php if( get_theme_mod( 'blog_custom_width' ) ) { ?>

.blog #inner-content {
	max-width: <?php echo esc_attr( get_theme_mod( 'blog_custom_width' ) ) ?>;
}

<?php } ?>

<?php if( get_theme_mod( 'single_custom_width' ) ) { ?>

.single #inner-content {
	max-width: <?php echo esc_attr( get_theme_mod( 'single_custom_width' ) ) ?>;
}

<?php } ?>

<?php if( get_theme_mod( 'archive_custom_width' ) ) { ?>

.archive #inner-content {
	max-width: <?php echo esc_attr( get_theme_mod( 'archive_custom_width' ) ) ?>;
}

<?php } ?>

<?php if( get_theme_mod( 'category_custom_width' ) ) { ?>

.category #inner-content {
	max-width: <?php echo esc_attr( get_theme_mod( 'category_custom_width' ) ) ?>;
}

<?php } ?>

<?php // Sidebar ?>

<?php if( get_theme_mod( 'sidebar_bg_color' ) ) { ?>

.wpbf-sidebar .widget {
	background: <?php echo esc_attr( get_theme_mod( 'sidebar_bg_color' ) ) ?>;
}

<?php } ?>

<?php if( is_numeric( get_theme_mod( 'sidebar_widget_padding_top' ) ) || is_numeric( get_theme_mod( 'sidebar_widget_padding_right' ) ) || is_numeric( get_theme_mod( 'sidebar_widget_padding_bottom' ) ) || is_numeric( get_theme_mod( 'sidebar_widget_padding_left' ) ) ) { ?>
.wpbf-sidebar .widget {
	<?php if( is_numeric( get_theme_mod( 'sidebar_widget_padding_top' ) ) ) { ?>
	padding-top: <?php echo esc_attr( get_theme_mod( 'sidebar_widget_padding_top' ) ) ?>px;
	<?php } ?>

	<?php if( is_numeric( get_theme_mod( 'sidebar_widget_padding_right' ) ) ) { ?>
	padding-right: <?php echo esc_attr( get_theme_mod( 'sidebar_widget_padding_right' ) ) ?>px;
	<?php } ?>

	<?php if( is_numeric( get_theme_mod( 'sidebar_widget_padding_bottom' ) ) ) { ?>
	padding-bottom: <?php echo esc_attr( get_theme_mod( 'sidebar_widget_padding_bottom' ) ) ?>px;
	<?php } ?>

	<?php if( is_numeric( get_theme_mod( 'sidebar_widget_padding_left' ) ) ) { ?>
	padding-left: <?php echo esc_attr( get_theme_mod( 'sidebar_widget_padding_left' ) ) ?>px;
	<?php } ?>
}
<?php } ?>

<?php if( get_theme_mod( 'sidebar_width' ) && !wpbf_has_responsive_breakpoints() ) { ?>

@media (min-width: 769px) {

	body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3 {
		width: <?php echo esc_attr( get_theme_mod( 'sidebar_width' ) ) ?>%;
	}

	body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3 {
		width: <?php echo esc_attr( 100 - get_theme_mod( 'sidebar_width' ) ) ?>%;
	}

}

<?php } ?>

<?php // Logo ?>

<?php if( get_theme_mod( 'menu_logo_container_width' ) ) { ?>

<?php $calculation = 100 - get_theme_mod( 'menu_logo_container_width' ); ?>

.wpbf-navigation .wpbf-1-4 {
	width: <?php echo esc_attr( get_theme_mod( 'menu_logo_container_width' ) ) ?>%;
}

.wpbf-navigation .wpbf-3-4 {
	width: <?php echo esc_attr( $calculation ) ?>%;
}

<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_logo_container_width' ) ) { ?>

<?php $calculation = 100 - get_theme_mod( 'mobile_menu_logo_container_width' ); ?>

.wpbf-navigation .wpbf-2-3 {
	width: <?php echo esc_attr( get_theme_mod( 'mobile_menu_logo_container_width' ) ) ?>%;
}

.wpbf-navigation .wpbf-1-3 {
	width: <?php echo esc_attr( $calculation ) ?>%;
}

<?php } ?>

<?php $menu_logo_font_family_value = get_theme_mod( 'menu_logo_font_family', array() ); ?>

<?php if( !get_theme_mod( 'custom_logo' ) ) { ?>

	<?php if( $menu_logo_font_family_value || get_theme_mod( 'menu_logo_font_size' ) || get_theme_mod( 'menu_logo_color' ) ) { ?>

		.wpbf-logo a, .wpbf-mobile-logo {

		<?php if( isset( $menu_logo_font_family_value['font-family'] ) && !empty( $menu_logo_font_family_value['font-family'] ) ) { ?>

			font-family: <?php echo html_entity_decode( esc_attr( $menu_logo_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;

		<?php } ?>

		<?php if( isset( $menu_logo_font_family_value['variant'] ) && !empty( $menu_logo_font_family_value['variant'] ) ) {

			$menu_logo_font_family_font_weight = str_replace( 'italic', '', $menu_logo_font_family_value['variant'] );
			$menu_logo_font_family_font_weight = ( in_array( $menu_logo_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $menu_logo_font_family_font_weight;

			$menu_logo_font_family_is_italic = ( false !== strpos( $menu_logo_font_family_value['variant'], 'italic' ) );
			$menu_logo_font_family_font_style = $menu_logo_font_family_is_italic ? 'italic' : 'normal' ;

			?>
			
			font-weight: <?php echo esc_attr( $menu_logo_font_family_font_weight ); ?>;
			font-style: <?php echo esc_attr( $menu_logo_font_family_font_style ); ?>;

		<?php } ?>

		<?php if( isset( $menu_logo_font_family_value['color'] ) && !empty( $menu_logo_font_family_value['color'] ) ) { ?>

			color: <?php echo esc_attr( $menu_logo_font_family_value['color'] ) ?>;

		<?php } ?>

		<?php if( get_theme_mod( 'menu_logo_color' ) ) { ?>

		color: <?php echo esc_attr( get_theme_mod( 'menu_logo_color' ) ) ?>;

		<?php } ?>

		<?php if( get_theme_mod( 'menu_logo_font_size' ) ) { ?>

		font-size: <?php echo esc_attr( get_theme_mod( 'menu_logo_font_size' ) ) ?>;
		
		<?php } ?>

		}

	<?php } ?>

	<?php if( get_theme_mod( 'menu_logo_color_alt' ) ) { ?>

	.wpbf-logo a:hover, .wpbf-mobile-logo:hover {
		color: <?php echo esc_attr( get_theme_mod( 'menu_logo_color_alt' ) ) ?>;
	}

	<?php } ?>

<?php } else { ?>

	<?php if( get_theme_mod( 'menu_logo_size' ) ) { ?>
	.wpbf-logo img {
		height: <?php echo esc_attr( get_theme_mod( 'menu_logo_size' ) ) ?>px;
	}
	<?php } ?>

	<?php if( get_theme_mod( 'menu_mobile_logo_size' ) ) { ?>
	.wpbf-mobile-logo img {
		height: <?php echo esc_attr( get_theme_mod( 'menu_mobile_logo_size' ) ) ?>px;
	}
	<?php } ?>

<?php } ?>

<?php // Tagline ?>

<?php $menu_logo_description_font_family_value = get_theme_mod( 'menu_logo_description_font_family', array() ); ?>

<?php if( !get_theme_mod( 'custom_logo' ) && get_theme_mod( 'menu_logo_description' ) ) { ?>

	<?php if( $menu_logo_description_font_family_value || get_theme_mod( 'menu_logo_description_font_size' ) || get_theme_mod( 'menu_logo_description_color' ) ) { ?>

		.wpbf-tagline {

		<?php if( isset( $menu_logo_description_font_family_value['font-family'] ) && !empty( $menu_logo_description_font_family_value['font-family'] ) ) { ?>

			font-family: <?php echo html_entity_decode( esc_attr( $menu_logo_description_font_family_value['font-family'] ), ENT_QUOTES ); // WPCS: XSS ok. ?>;

		<?php } ?>

		<?php if( isset( $menu_logo_description_font_family_value['variant'] ) && !empty( $menu_logo_description_font_family_value['variant'] ) ) {

			$menu_logo_description_font_family_font_weight = str_replace( 'italic', '', $menu_logo_description_font_family_value['variant'] );
			$menu_logo_description_font_family_font_weight = ( in_array( $menu_logo_description_font_family_font_weight, array( '', 'regular' ) ) ) ? '400' : $menu_logo_description_font_family_font_weight;

			$menu_logo_font_family_is_italic = ( false !== strpos( $menu_logo_description_font_family_value['variant'], 'italic' ) );
			$menu_logo_description_font_family_font_style = $menu_logo_font_family_is_italic ? 'italic' : 'normal' ;

			?>
			
			font-weight: <?php echo esc_attr( $menu_logo_description_font_family_font_weight ); ?>;
			font-style: <?php echo esc_attr( $menu_logo_description_font_family_font_style ); ?>;

		<?php } ?>

		<?php if( get_theme_mod( 'menu_logo_description_color' ) ) { ?>

		color: <?php echo esc_attr( get_theme_mod( 'menu_logo_description_color' ) ) ?>;

		<?php } ?>

		<?php if( get_theme_mod( 'menu_logo_description_font_size' ) ) { ?>

		font-size: <?php echo esc_attr( get_theme_mod( 'menu_logo_description_font_size' ) ) ?>;
		
		<?php } ?>

		}

	<?php } ?>

<?php } ?>

<?php // Pre Header ?>

<?php if( get_theme_mod( 'pre_header_layout' ) && get_theme_mod( 'pre_header_layout' ) != 'none' ) { ?>

	<?php if( get_theme_mod( 'pre_header_bg_color' ) || get_theme_mod( 'pre_header_font_color' ) ) { ?>

	#wpbf-pre-header {

	<?php if( get_theme_mod( 'pre_header_bg_color' ) ) { ?>
		background-color: <?php echo esc_attr( get_theme_mod( 'pre_header_bg_color' ) ) ?>;
	<?php } ?>
	<?php if( get_theme_mod( 'pre_header_font_color' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'pre_header_font_color' ) ) ?>;
	<?php } ?>

	}

	<?php } ?>

	<?php if( get_theme_mod( 'pre_header_height' ) ) { ?>
	.wpbf-inner-pre-header {
		padding-top: <?php echo esc_attr( get_theme_mod( 'pre_header_height' ) ) ?>px;
		padding-bottom: <?php echo esc_attr( get_theme_mod( 'pre_header_height' ) ) ?>px;
	}
	<?php } ?>

<?php } ?>

<?php // Navigation ?>

<?php if( get_theme_mod( 'menu_width' ) || get_theme_mod( 'menu_height' ) ) { ?>

.wpbf-nav-wrapper {

	<?php if( get_theme_mod( 'menu_width' ) ) { ?>
		max-width: <?php echo esc_attr( get_theme_mod( 'menu_width' ) ); ?>;
	<?php } ?>

	<?php if( get_theme_mod( 'menu_height' ) ) { ?>
		padding-top: <?php echo esc_attr( get_theme_mod( 'menu_height' ) ); ?>px;
		padding-bottom: <?php echo esc_attr( get_theme_mod( 'menu_height' ) ); ?>px;
	<?php } ?>

}

<?php } ?>

<?php if( get_theme_mod( 'menu_height' ) && get_theme_mod( 'menu_position' ) == 'menu-stacked' ) { ?>

.wpbf-menu-stacked nav {
	margin-top: <?php echo esc_attr( get_theme_mod( 'menu_height' ) ); ?>px;
}

<?php } ?>

<?php if( get_theme_mod( 'menu_padding' ) ) { ?>
.wpbf-menu > .menu-item > a {
	padding-left: <?php echo esc_attr( get_theme_mod( 'menu_padding' ) ); ?>px;
	padding-right: <?php echo esc_attr( get_theme_mod( 'menu_padding' ) ); ?>px;
}

<?php if( get_theme_mod( 'menu_position' ) == 'menu-centered' ) { ?>
.wpbf-menu-centered .logo-container {
	padding: 0 <?php echo esc_attr( get_theme_mod( 'menu_padding' ) ); ?>px;
}
<?php } ?>

<?php } ?>

<?php if( get_theme_mod( 'menu_bg_color' ) ) { ?>
.wpbf-navigation {
	background-color: <?php echo esc_attr( get_theme_mod( 'menu_bg_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'menu_font_color' ) ) { ?>
.wpbf-menu a,
.wpbf-mobile-menu a,
.wpbf-close {
	color: <?php echo esc_attr( get_theme_mod( 'menu_font_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'menu_font_color_alt' ) ) { ?>
.wpbf-menu a:hover,
.wpbf-mobile-menu a:hover {
	color: <?php echo esc_attr( get_theme_mod( 'menu_font_color_alt' ) ) ?>;
}
.wpbf-menu > .current-menu-item > a,
.wpbf-mobile-menu > .current-menu-item > a {
	color: <?php echo esc_attr( get_theme_mod( 'menu_font_color_alt' ) ) ?> !important;
}
<?php } ?>

<?php // Sub Menu ?>

<?php if( get_theme_mod( 'sub_menu_bg_color' ) ) { ?>
.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li,
.wpbf-sub-menu > .wpbf-mega-menu > .sub-menu {
	background-color: <?php echo esc_attr( get_theme_mod( 'sub_menu_bg_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'sub_menu_bg_color_alt' ) ) { ?>
.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover {
	background-color: <?php echo esc_attr( get_theme_mod( 'sub_menu_bg_color_alt' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'sub_menu_width' ) ) { ?>
.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu {
	width: <?php echo esc_attr( get_theme_mod( 'sub_menu_width' ) ) ?>px;
}
<?php } ?>

<?php if( get_theme_mod( 'sub_menu_padding_top' ) || get_theme_mod( 'sub_menu_padding_right' ) || get_theme_mod( 'sub_menu_padding_bottom' ) || get_theme_mod( 'sub_menu_padding_left' ) ) { ?>
.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {
	<?php if( get_theme_mod( 'sub_menu_padding_top' ) ) { ?>
	padding-top: <?php echo esc_attr( get_theme_mod( 'sub_menu_padding_top' ) ) ?>px;
	<?php } ?>

	<?php if( get_theme_mod( 'sub_menu_padding_right' ) ) { ?>
	padding-right: <?php echo esc_attr( get_theme_mod( 'sub_menu_padding_right' ) ) ?>px;
	<?php } ?>

	<?php if( get_theme_mod( 'sub_menu_padding_bottom' ) ) { ?>
	padding-bottom: <?php echo esc_attr( get_theme_mod( 'sub_menu_padding_bottom' ) ) ?>px;
	<?php } ?>

	<?php if( get_theme_mod( 'sub_menu_padding_left' ) ) { ?>
	padding-left: <?php echo esc_attr( get_theme_mod( 'sub_menu_padding_left' ) ) ?>px;
	<?php } ?>
}
<?php } ?>

<?php if( get_theme_mod( 'sub_menu_accent_color' ) || get_theme_mod( 'sub_menu_font_size' ) ) { ?>

.wpbf-menu .sub-menu a {

	<?php if( get_theme_mod( 'sub_menu_accent_color' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'sub_menu_accent_color' ) ) ?>;
	<?php } ?>

	<?php if( get_theme_mod( 'sub_menu_font_size' ) ) { ?>
		font-size: <?php echo esc_attr( get_theme_mod( 'sub_menu_font_size' ) ) ?>;
	<?php } ?>

}

<?php } ?>

<?php if( get_theme_mod( 'sub_menu_accent_color_alt' ) ) { ?>
.wpbf-menu .sub-menu a:hover {
	color: <?php echo esc_attr( get_theme_mod( 'sub_menu_accent_color_alt' ) ) ?>;
}
<?php } ?>

<?php // Mobile Navigation ?>

<?php if( get_theme_mod( 'mobile_menu_height' ) ){ ?>
.wpbf-mobile-nav-wrapper {
		padding-top: <?php echo esc_attr( get_theme_mod( 'mobile_menu_height' ) ) ?>px;
		padding-bottom: <?php echo esc_attr( get_theme_mod( 'mobile_menu_height' ) ) ?>px;
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_background_color' ) ){ ?>
.wpbf-mobile-nav-wrapper {
		background: <?php echo esc_attr( get_theme_mod( 'mobile_menu_background_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_padding_top' ) || get_theme_mod( 'mobile_menu_padding_right' ) || get_theme_mod( 'mobile_menu_padding_bottom' ) || get_theme_mod( 'mobile_menu_padding_left' ) ) { ?>
.wpbf-mobile-menu a,
.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {
	<?php if( get_theme_mod( 'mobile_menu_padding_top' ) ) { ?>
	padding-top: <?php echo esc_attr( get_theme_mod( 'mobile_menu_padding_top' ) ) ?>px;
	<?php } ?>

	<?php if( get_theme_mod( 'mobile_menu_padding_right' ) ) { ?>
	padding-right: <?php echo esc_attr( get_theme_mod( 'mobile_menu_padding_right' ) ) ?>px;
	<?php } ?>

	<?php if( get_theme_mod( 'mobile_menu_padding_bottom' ) ) { ?>
	padding-bottom: <?php echo esc_attr( get_theme_mod( 'mobile_menu_padding_bottom' ) ) ?>px;
	<?php } ?>

	<?php if( get_theme_mod( 'mobile_menu_padding_left' ) ) { ?>
	padding-left: <?php echo esc_attr( get_theme_mod( 'mobile_menu_padding_left' ) ) ?>px;
	<?php } ?>
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_font_color' ) ){ ?>
.wpbf-mobile-menu a,
.wpbf-mobile-menu-container .wpbf-close {
		color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_font_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_font_color_alt' ) ){ ?>
.wpbf-mobile-menu a:hover {
		color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_font_color_alt' ) ) ?>;
}
.wpbf-mobile-menu > .current-menu-item > a {
		color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_font_color_alt' ) ) ?> !important;
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_border_color' ) ){ ?>
.wpbf-mobile-menu .menu-item {
		border-top-color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_border_color' ) ) ?>;
}
.wpbf-mobile-menu > .menu-item:last-child {
		border-bottom-color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_border_color' ) ) ?>;
}
<?php } ?>

<?php if( ( !get_theme_mod( 'mobile_menu_options' ) || get_theme_mod( 'mobile_menu_options' ) == 'menu-mobile-hamburger' || get_theme_mod( 'mobile_menu_options' ) == 'menu-mobile-off-canvas' ) && ( get_theme_mod( 'mobile_menu_hamburger_color' ) || get_theme_mod( 'mobile_menu_hamburger_size' ) ) ) { ?>
.wpbf-mobile-menu-toggle {
	<?php if( get_theme_mod( 'mobile_menu_hamburger_color' ) ) { ?>
	color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_hamburger_color' ) ) ?>;
	<?php } ?>

	<?php if( get_theme_mod( 'mobile_menu_hamburger_size' ) ) { ?>
	font-size: <?php echo esc_attr( get_theme_mod( 'mobile_menu_hamburger_size' ) ) ?>px;
	<?php } ?>
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_bg_color' ) ){ ?>
.wpbf-mobile-menu > .menu-item a {
	background-color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_bg_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_bg_color_alt' ) ){ ?>
.wpbf-mobile-menu > .menu-item a:hover {
	background-color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_bg_color_alt' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_submenu_arrow_color' ) ){ ?>
.wpbf-mobile-menu .wpbf-submenu-toggle {
	color: <?php echo esc_attr( get_theme_mod( 'mobile_menu_submenu_arrow_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'mobile_menu_font_size' ) ){ ?>
.wpbf-mobile-menu {
	font-size: <?php echo esc_attr( get_theme_mod( 'mobile_menu_font_size' ) ) ?>;
}
<?php } ?>

<?php // Footer ?>

<?php if( get_theme_mod( 'footer_height' ) && get_theme_mod( 'footer_layout' ) != 'none' ) { ?>
.wpbf-inner-footer {
	padding-top: <?php echo esc_attr( get_theme_mod( 'footer_height' ) ) ?>px;
	padding-bottom: <?php echo esc_attr( get_theme_mod( 'footer_height' ) ) ?>px;
}
<?php } ?>

<?php if( ( get_theme_mod( 'footer_bg_color' ) || get_theme_mod( 'footer_font_color' ) ) && get_theme_mod( 'footer_layout' ) != 'none' ) { ?>

.wpbf-page-footer {

	<?php if( get_theme_mod( 'footer_bg_color' ) ) { ?>
	background-color: <?php echo esc_attr( get_theme_mod( 'footer_bg_color' ) ) ?>;
	<?php } ?>

	<?php if( get_theme_mod( 'footer_font_color' ) ) { ?>
		color: <?php echo esc_attr( get_theme_mod( 'footer_font_color' ) ) ?>;
	<?php } ?>

}

<?php } ?>

<?php if( get_theme_mod( 'footer_accent_color' ) && get_theme_mod( 'footer_layout' ) != 'none' ) { ?>
.wpbf-page-footer a {
	color: <?php echo esc_attr( get_theme_mod( 'footer_accent_color' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'footer_accent_color_alt' ) && get_theme_mod( 'footer_layout' ) != 'none' ) { ?>
.wpbf-page-footer a:hover {
	color: <?php echo esc_attr( get_theme_mod( 'footer_accent_color_alt' ) ) ?>;
}
<?php } ?>

<?php if( get_theme_mod( 'footer_font_size' ) && get_theme_mod( 'footer_layout' ) != 'none' ) { ?>
.wpbf-inner-footer {
	font-size: <?php echo esc_attr( get_theme_mod( 'footer_font_size' ) ) ?>;
}
<?php } ?>

<?php do_action( 'wpbf_after_customizer_css' ); ?>