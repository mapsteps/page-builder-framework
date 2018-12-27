<?php
/**
 * Theme Footer
 * See also inc/template-parts/footer.php
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

		do_action( 'wpbf_before_footer' );

		if ( get_theme_mod( 'footer_layout' ) !== 'none' ) do_action( 'wpbf_footer' );

		do_action( 'wpbf_after_footer' );

		?>

	</div>

<?php do_action( 'wpbf_body_close' ); ?>

<?php wp_footer(); ?>

</body>

</html>