<?php
/**
 * Full screen menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="wpbf-container wpbf-container-center wpbf-visible-large wpbf-nav-wrapper wpbf-menu-right">

	<div class="wpbf-grid wpbf-grid-collapse">

		<div class="wpbf-1-4 wpbf-logo-container">

			<?php get_template_part( 'inc/template-parts/logo/logo' ); ?>

		</div>

		<div class="wpbf-3-4 wpbf-menu-container">

			<div class="wpbf-menu-toggle-container">

				<?php do_action( 'wpbf_before_menu_toggle' ); ?>

				<button id="wpbf-menu-toggle" class="wpbf-nav-item wpbf-menu-toggle wpbff wpbff-hamburger" aria-label="<?php _e( 'Site Navigation', 'page-builder-framework' ); ?>" aria-controls="navigation" aria-expanded="false" aria-haspopup="true">
					<span class="screen-reader-text"><?php _e( 'Menu Toggle', 'page-builder-framework' ); ?></span>
				</button>

				<?php do_action( 'wpbf_after_menu_toggle' ); ?>

			</div>

		</div>

	</div>

</div>

<div class="wpbf-menu-full-screen wpbf-visible-large">

	<?php do_action( 'wpbf_before_main_menu' ); ?>

	<nav id="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-labelledby="wpbf-menu-toggle">

		<?php do_action( 'wpbf_main_menu_open' ); ?>

		<?php do_action( 'wpbf_main_menu' ); ?>

		<?php do_action( 'wpbf_main_menu_close' ); ?>

	</nav>

	<?php do_action( 'wpbf_after_main_menu' ); ?>

	<i class="wpbf-close wpbff wpbff-times" aria-hidden="true"></i>

</div>
