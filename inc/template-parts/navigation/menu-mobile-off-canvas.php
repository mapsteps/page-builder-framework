<?php
/**
 * Off canvas mobile menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

if ( get_theme_mod( 'mobile_menu_overlay' ) ) {
	echo '<div class="wpbf-mobile-menu-overlay"></div>';
}

?>

<div class="wpbf-mobile-menu-off-canvas wpbf-hidden-large">

	<div class="wpbf-mobile-nav-wrapper wpbf-container">

		<div class="wpbf-mobile-logo-container wpbf-2-3">

			<?php get_template_part( 'inc/template-parts/logo/logo-mobile' ); ?>

		</div>

		<div class="wpbf-menu-toggle-container wpbf-1-3">

			<?php do_action( 'wpbf_before_mobile_toggle' ); ?>

			<button id="wpbf-mobile-menu-toggle" class="wpbf-mobile-nav-item wpbf-mobile-menu-toggle wpbff wpbff-hamburger" aria-label="<?php _e( 'Site Navigation', 'page-builder-framework' ); ?>" aria-controls="navigation" aria-expanded="false" aria-haspopup="true">
				<span class="screen-reader-text"><?php _e( 'Menu Toggle', 'page-builder-framework' ); ?></span>
			</button>

			<?php do_action( 'wpbf_after_mobile_toggle' ); ?>

		</div>

	</div>

	<div class="wpbf-mobile-menu-container">

		<?php do_action( 'wpbf_before_mobile_menu' ); ?>

		<nav id="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-labelledby="wpbf-mobile-menu-toggle">

			<?php do_action( 'wpbf_mobile_menu_open' ); ?>

			<?php do_action( 'wpbf_mobile_menu' ); ?>

			<?php do_action( 'wpbf_mobile_menu_close' ); ?>

		</nav>

		<?php do_action( 'wpbf_after_mobile_menu' ); ?>

		<i class="wpbf-close wpbff wpbff-times" aria-hidden="true"></i>

	</div>

</div>
