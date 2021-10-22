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

				<button id="wpbf-mobile-menu-toggle" class="wpbf-mobile-nav-item wpbf-mobile-menu-toggle wpbf-icon" aria-label="<?php _e( 'Mobile Site Navigation', 'page-builder-framework' ); ?>" aria-controls="navigation" aria-expanded="false" aria-haspopup="true">

					<span class="screen-reader-text"><?php _e( 'Menu Toggle', 'page-builder-framework' ); ?></span>
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" role="img" aria-hidden="true">
					<path d="M30.939 17.785h-29.876c-0.579 0-1.048-0.469-1.048-1.048v-1.482c0-0.579 0.469-1.048 1.048-1.048h29.876c0.579 0 1.048 0.469 1.048 1.048v1.482c0 0.579-0.469 1.048-1.048 1.048z"></path>
					<path d="M30.939 27.979h-29.876c-0.579 0-1.048-0.469-1.048-1.048v-1.482c0-0.579 0.469-1.048 1.048-1.048h29.876c0.579 0 1.048 0.469 1.048 1.048v1.482c0 0.579-0.469 1.048-1.048 1.048z"></path>
					<path d="M30.939 7.584h-29.876c-0.579 0-1.048-0.469-1.048-1.048v-1.482c0-0.579 0.469-1.048 1.048-1.048h29.876c0.579 0 1.048 0.469 1.048 1.048v1.482c0 0.579-0.469 1.048-1.048 1.048z"></path>
					</svg>

					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" role="img" aria-hidden="true">
					<path d="M29.094 5.43l-23.656 23.656c-0.41 0.41-1.074 0.41-1.483 0l-1.049-1.049c-0.41-0.41-0.41-1.073 0-1.483l23.656-23.656c0.41-0.41 1.073-0.41 1.483 0l1.049 1.049c0.41 0.409 0.41 1.073 0 1.483z"></path>
					<path d="M26.562 29.086l-23.656-23.656c-0.41-0.41-0.41-1.074 0-1.483l1.049-1.049c0.409-0.41 1.073-0.41 1.483 0l23.656 23.656c0.41 0.41 0.41 1.073 0 1.483l-1.049 1.049c-0.41 0.41-1.073 0.41-1.483 0z"></path>
					</svg>

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
