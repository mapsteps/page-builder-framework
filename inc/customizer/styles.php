<?php
/**
 * Dynamic customizer CSS.
 *
 * Holds Customizer CSS styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

do_action( 'wpbf_before_customizer_css' );

/* Typography */

wpbf_css_area( 'typography' );

/* General */

wpbf_css_area( 'general' );

/* Blog */

wpbf_css_area( 'blog' );

/* Header */

wpbf_css_area( 'header' );

/* Footer */

wpbf_css_area( 'footer' );

do_action( 'wpbf_after_customizer_css' );
