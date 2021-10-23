<?php
/**
 * Hamburger mobile menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="wpbf-mobile-menu-hamburger wpbf-hidden-large">

	<div class="wpbf-mobile-nav-wrapper wpbf-container wpbf-container-center">

		<div class="wpbf-mobile-logo-container wpbf-2-3">

			<?php get_template_part( 'inc/template-parts/logo/logo-mobile' ); ?>

		</div>

		<div class="wpbf-menu-toggle-container wpbf-1-3">

			<?php do_action( 'wpbf_before_mobile_toggle' ); ?>

			<?php if ( wpbf_svg_enabled() ) { ?>

				<button id="wpbf-mobile-menu-toggle" class="wpbf-mobile-nav-item wpbf-mobile-menu-toggle" aria-label="<?php _e( 'Mobile Site Navigation', 'page-builder-framework' ); ?>" aria-controls="navigation" aria-expanded="false" aria-haspopup="true">
					<span class="screen-reader-text"><?php _e( 'Menu Toggle', 'page-builder-framework' ); ?></span>
					<?php echo wpbf_svg( 'hamburger' ); ?>
					<?php echo wpbf_svg( 'times' ); ?>
				</button>

			<?php } else { ?>

				<button id="wpbf-mobile-menu-toggle" class="wpbf-mobile-nav-item wpbf-mobile-menu-toggle wpbff wpbff-hamburger" aria-label="<?php _e( 'Mobile Site Navigation', 'page-builder-framework' ); ?>" aria-controls="navigation" aria-expanded="false" aria-haspopup="true">
					<span class="screen-reader-text"><?php _e( 'Menu Toggle', 'page-builder-framework' ); ?></span>
				</button>

			<?php } ?>


			<?php do_action( 'wpbf_after_mobile_toggle' ); ?>

		</div>

	</div>

	<div class="wpbf-mobile-menu-container">

		<?php do_action( 'wpbf_before_mobile_menu' ); ?>

		<nav id="mobile-navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-labelledby="wpbf-mobile-menu-toggle">

			<?php do_action( 'wpbf_mobile_menu_open' ); ?>

			<?php do_action( 'wpbf_mobile_menu' ); ?>

			<?php do_action( 'wpbf_mobile_menu_close' ); ?>

		</nav>

		<?php do_action( 'wpbf_after_mobile_menu' ); ?>

	</div>

</div>
