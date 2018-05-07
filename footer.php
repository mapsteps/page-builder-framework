<?php
/**
 * Theme Footer
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

		do_action( 'wpbf_before_footer' );

		if ( get_theme_mod( 'footer_layout' ) !== 'none' ) do_action( 'wpbf_footer' );

		do_action( 'wpbf_after_footer' );

		?>

		<?php if ( get_theme_mod( 'layout_scrolltop' ) ) { ?>

		<div class="scrolltop"></div>

		<?php } ?>

	</div>

<?php wp_footer(); ?>

</body>

</html>