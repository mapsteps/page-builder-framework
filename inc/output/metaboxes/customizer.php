<?php
/**
 * Metabox template for displaying customizer settings.
 *
 * @package Page_Builder_Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="neatbox is-smooth has-medium-gap has-bigger-heading customizer-box">
	<h2>
		<?php _e( 'Links to Customizer Settings', 'page-builder-framework' ); ?>
	</h2>
	<ul class="neatbox-list customizer-list">
		<li class="list-item">

			<div class="customizer-items">
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url() ); ?>/customize.php?autofocus%5Bsection%5D=title_tagline">
						<?php _e( 'Logo & Site Identity', 'page-builder-framework' ); ?>
					</a>
				</div>
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url() ); ?>/customize.php?autofocus%5Bsection%5D=wpbf_menu_options">
						<?php _e( 'Site Navigation', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div>

		</li>
		<li class="list-item">

			<div class="customizer-items">
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=header_panel' ) ); ?>">
						<?php _e( 'Header Settings', 'page-builder-framework' ); ?>
					</a>
				</div>
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_footer_options' ) ); ?>">
						<?php _e( 'Footer Settings', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div>

		</li>
		<li class="list-item">

			<div class="customizer-items">
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_page_options' ) ); ?>">
						<?php _e( 'Layout Settings', 'page-builder-framework' ); ?>
					</a>
				</div>
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_sidebar_options' ) ); ?>">
						<?php _e( 'Sidebar Settings', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div>

		</li>
		<li class="list-item">

			<div class="customizer-items">
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=blog_panel' ) ); ?>">
						<?php _e( 'Blog Settings', 'page-builder-framework' ); ?>
					</a>
				</div>
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_single_options' ) ); ?>">
						<?php _e( 'Post Layout', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div>

		</li>
		<li class="list-item">

			<div class="customizer-items">
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=typo_panel' ) ); ?>">
						<?php _e( 'Typography', 'page-builder-framework' ); ?>
					</a>
				</div>
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_button_options' ) ); ?>">
						<?php _e( 'Theme Buttons', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div>

		</li>
		<li class="list-item">

			<div class="customizer-items">
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=static_front_page' ) ); ?>">
						<?php _e( 'Homepage Settings', 'page-builder-framework' ); ?>
					</a>
				</div>
				<div class="customizer-item">
					<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=nav_menus' ) ); ?>">
						<?php _e( 'Manage Menu', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div>

		</li>
	</ul>
</div><!-- .customizer-box -->
