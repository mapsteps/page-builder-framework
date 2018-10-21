<?php
/**
 * Full Screen Menu
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wpbf-container wpbf-container-center wpbf-visible-large wpbf-nav-wrapper wpbf-menu-right">

	<div class="wpbf-grid wpbf-grid-collapse">

		<div class="wpbf-1-4 wpbf-logo-container">

			<?php get_template_part( 'inc/template-parts/logo/logo' ); ?>
			<?php get_template_part( 'inc/template-parts/logo/tagline' ); ?>

		</div>

		<div class="wpbf-3-4 wpbf-menu-container">

			<?php do_action( 'wpbf_before_main_menu' ); ?>

			<div class="wpbf-menu">

				<i class="wpbf-menu-toggle wpbff wpbff-hamburger"></i>

			</div>

			<?php do_action( 'wpbf_after_main_menu' ); ?>

		</div>

	</div>

</div>

<div class="wpbf-menu-full-screen wpbf-visible-large">

	<?php do_action( 'wpbf_before_full_screen_menu' ); ?>

	<nav id="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">

		<?php do_action( 'wpbf_main_menu' ); ?>

	</nav>

	<?php do_action( 'wpbf_after_full_screen_menu' ); ?>

	<div class="wpbf-close wpbff wpbff-times"></div>

</div>