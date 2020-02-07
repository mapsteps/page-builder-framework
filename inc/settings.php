<?php
/**
 * Swift Control page template.
 *
 * @package Swift_Control
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="wrap settingstuff wpbf-settings border-box">

	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="wpbf-admin-page">
		<div class="left-section">

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading customizer-links-box">
				<h2>
					<?php _e( 'Links to Customizer Settings', 'swift-control' ); ?>
				</h2>
				<ul class="neatbox-list customizer-link-list">
					<li class="list-item">

						<div class="customizer-link-items">
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url() ); ?>/customize.php?autofocus%5Bsection%5D=title_tagline" class="customizer-link">
									<?php _e( 'Logo & Site Identity', 'page-builder-framework' ); ?>
								</a>
							</div>
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url() ); ?>/customize.php?autofocus%5Bsection%5D=wpbf_menu_options" class="customizer-link">
									<?php _e( 'Site Navigation', 'page-builder-framework' ); ?>
								</a>
							</div>
						</div>

					</li>
					<li class="list-item">

						<div class="customizer-link-items">
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=header_panel' ) ); ?>" class="customizer-link">
									<?php _e( 'Header Settings', 'page-builder-framework' ); ?>
								</a>
							</div>
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_footer_options' ) ); ?>" class="customizer-link">
									<?php _e( 'Footer Settings', 'page-builder-framework' ); ?>
								</a>
							</div>
						</div>

					</li>
					<li class="list-item">

						<div class="customizer-link-items">
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_page_options' ) ); ?>" class="customizer-link">
									<?php _e( 'Layout Settings', 'page-builder-framework' ); ?>
								</a>
							</div>
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_sidebar_options' ) ); ?>" class="customizer-link">
									<?php _e( 'Sidebar Settings', 'page-builder-framework' ); ?>
								</a>
							</div>
						</div>

					</li>
					<li class="list-item">

						<div class="customizer-link-items">
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=blog_panel' ) ); ?>" class="customizer-link">
									<?php _e( 'Blog Settings', 'page-builder-framework' ); ?>
								</a>
							</div>
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_single_options' ) ); ?>" class="customizer-link">
									<?php _e( 'Post Layout', 'page-builder-framework' ); ?>
								</a>
							</div>
						</div>

					</li>
					<li class="list-item">

						<div class="customizer-link-items">
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=typo_panel' ) ); ?>" class="customizer-link">
									<?php _e( 'Typography', 'page-builder-framework' ); ?>
								</a>
							</div>
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_button_options' ) ); ?>" class="customizer-link">
									<?php _e( 'Theme Buttons', 'page-builder-framework' ); ?>
								</a>
							</div>
						</div>

					</li>
					<li class="list-item">

						<div class="customizer-link-items">
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=static_front_page' ) ); ?>" class="customizer-link">
									<?php _e( 'Homepage Settings', 'page-builder-framework' ); ?>
								</a>
							</div>
							<div class="customizer-link-item">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=nav_menus' ) ); ?>" class="customizer-link">
									<?php _e( 'Manage Menu', 'page-builder-framework' ); ?>
								</a>
							</div>
						</div>

					</li>
				</ul>
			</div><!-- .customizer-links-box -->

		</div><!-- .left-section -->
		<div class="right-section">

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading recommended-plugins-box">
				<h2>
					<?php _e( 'Recommended Plugins', 'swift-control' ); ?>
				</h2>
				<ul class="neatbox-list recommended-plugins">
					<li class="list-item">
						<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" class="plugin-name">Premium Add-On</a>
						<div class="plugin-link">
							<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" class="button button-primary button-small buy-button"><?php _e( 'Buy Now', 'page-builder-framework' ); ?></a>
						</div>
					</li>
					<?php if ( ! defined( 'SWIFT_CONTROL_PRO_PLUGIN_VERSION' ) ) : ?>
						<li class="list-item">
							<a href="https://wpswiftcontrol.com/" target="_blank" class="plugin-name">Swift Control Pro</a>
							<div class="plugin-link">
								<a href="https://wpswiftcontrol.com/pricing/" target="_blank" class="button button-primary button-small buy-button"><?php _e( 'Buy Now', 'page-builder-framework' ); ?></a>
							</div>
						</li>
						<?php endif; ?>
						<li class="list-item">
						<a href="https://wp-video-popup.com/" target="_blank" class="plugin-name">WP Video Popup</a>
						<div class="plugin-link">
							<a href="https://wp-video-popup.com/pricing/" target="_blank" class="button button-primary button-small buy-button"><?php _e( 'Buy Now', 'page-builder-framework' ); ?></a>
						</div>
					</li>
					<?php if ( ! defined( 'CUSTOMIZER_RESET_PLUGIN_VERSION' ) ) : ?>
						<li class="list-item">
							<a href="https://wordpress.org/plugins/customizer-reset/" target="_blank" class="plugin-name">Customizer Reset</a>
						</li>
					<?php endif; ?>
				</ul>
			</div><!-- .recommended-plugins-box -->

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading community-links-box">
				<h2>
					<?php _e( 'Join the Community', 'swift-control' ); ?>
				</h2>
				<div class="neatbox-body">
					<p>
						<?php _e( 'Join the Facebook group for updates, discussions, chat with other Page Builder Framework users.', 'page-builder-framework' ); ?>
					</p>
					<a href="" class="button button-primary">
						<?php _e( 'Join Our Facebook Group', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div><!-- .community-links-box -->

		</div><!-- .right-section -->
	</div><!-- .wpbf-admin-page -->

</div>
