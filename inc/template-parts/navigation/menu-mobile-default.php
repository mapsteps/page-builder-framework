<?php
/**
 * Default mobile menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="wpbf-mobile-menu-default wpbf-hidden-large">

	<div class="wpbf-mobile-nav-wrapper wpbf-container">

		<div class="wpbf-mobile-logo-container">

			<?php get_template_part( 'inc/template-parts/logo/logo-mobile' ); ?>

		</div>

		<div class="wpbf-menu-toggle-container">

			<a id="wpbf-mobile-menu-toggle" href="javascript:void(0)" class="wpbf-mobile-menu-toggle wpbf-button wpbf-button-full" aria-label="<?php _e( 'Site Navigation', 'page-builder-framework' ); ?>" aria-controls="navigation" aria-expanded="false" aria-haspopup="true" role="button">
				<?php echo apply_filters( 'wpbf_mobile_menu_text', __( 'Menu', 'page-builder-framework' ) ); ?>
			</a>

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

	</div>

</div>
