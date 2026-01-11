<?php
/**
 * Footer Builder.
 *
 * Construct the theme footer when Footer Builder is enabled.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Ensure footer builder hooks are set up (needed for partialRefresh AJAX calls).
if ( ! has_action( 'wpbf_footer_builder_content' ) ) {
	wpbf_footer_builder_hooks();
}

$footer_classes = apply_filters( 'wpbf_footer_classes', 'wpbf-page-footer' );

?>

<footer id="footer" class="<?php echo esc_attr( $footer_classes ); ?>" itemscope="itemscope" itemtype="https://schema.org/WPFooter">

	<?php do_action( 'wpbf_footer_open' ); ?>

	<?php do_action( 'wpbf_footer_builder_content' ); ?>

	<?php do_action( 'wpbf_footer_close' ); ?>

</footer>
