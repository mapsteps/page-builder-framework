<?php
/**
 * Theme setting's template.
 *
 * @package Page_Builder_Framework
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

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading premium-links-box">
				<h2>
					<?php _e( 'Premium Add-On Options', 'swift-control' ); ?>
					<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" style="float: right;" class=""><?php _e( 'Learn more', 'page-builder-framework' ); ?></a>
				</h2>
				<ul class="neatbox-list premium-link-list">

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">Transparent Header</a></h3>
								<p>Create customizable transparent headers with just a few clicks.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">Sticky Navigation</a></h3>
								<p>Create a fully customizable sticky navigation with just a few clicks.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">White Label Settings</a></h3>
								<p>Your theme, your branding. Fully white label Page Builder Framework & the Premium Add-On.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">Advanced Typography</a></h3>
								<p>Customize fonts and add Typekit- & Custom Fonts to your website.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">Adjustable Breakpoints</a></h3>
								<p>Set custom responsive breakpoints for tablets and desktops & mobiles for a pixel perfect design.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">Advanced WooCommerce Features</a></h3>
								<p>Take full control over the design of your online store with more advanced WooCommerce features.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">Mega Menu</a></h3>
								<p>Easily create an advanced mega menu with up to 4 rows.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3><a href="#" target="_blank">Call to Action Button</a></h3>
								<p>Add a customizable Call to Action Button to your navigation with just a few clicks.</p>
							</div>
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item">
						<div class="premium-link-item">
							<div class="premium-link-item-content">
								<h3>And a lot more!</h3>
								<p>Check out all the Premium Add-On features.</p>
							</div>
							<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" class="button button-primary"><?php _e( 'Go Premium', 'page-builder-framework' ); ?></a>
						</div>
					</li>

				</ul>
			</div><!-- .premium-links-box -->

		</div><!-- .left-section -->
		<div class="right-section">

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading recommended-box">
				<h2>
					<?php _e( 'Recommended', 'swift-control' ); ?>
				</h2>
				<ul class="neatbox-list recommended-plugins">
					<li class="list-item">
						<div class="plugin-content">
							<h3>Premium Add-On</h3>
							<p class="plugin-description">
								Take your website to the next level with the Premium Add-On.
							</p>
						</div>
						<div class="plugin-link">
							<?php if ( wpbf_is_premium() ) : ?>
								<i class="dashicons dashicons-yes-alt"></i>
							<?php else : ?>
								<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" class="button button-small"><?php _e( 'Go Premium', 'page-builder-framework' ); ?></a>
							<?php endif; ?>
						</div>
					</li>

					<li class="list-item">
						<div class="plugin-content">
							<h3>Customizer Reset</h3>
							<p class="plugin-description">
								<strong>Reset, Export & Import</strong> your customizer settings with a simple click of a button.
							</p>
						</div>
						<div class="plugin-link">
							<?php if ( defined( 'CUSTOMIZER_RESET_PLUGIN_VERSION' ) ) : ?>
								<i class="dashicons dashicons-yes-alt"></i>
							<?php else : ?>
								<a href="https://wordpress.org/plugins/customizer-reset/" target="_blank" class="button button-small"><?php _e( 'Learn more', 'page-builder-framework' ); ?></a>
							<?php endif; ?>
						</div>
					</li>

					<li class="list-item">
						<div class="plugin-content">
							<h3>Swift Control</h3>
							<p class="plugin-description">
								Quickly access all important areas of your WordPress website.
							</p>
						</div>
						<div class="plugin-link">
							<?php if ( defined( 'SWIFT_CONTROL_PLUGIN_VERSION' ) || defined( 'SWIFT_CONTROL_PRO_PLUGIN_VERSION' ) ) : ?>
								<i class="dashicons dashicons-yes-alt"></i>
							<?php else : ?>
								<a href="https://wordpress.org/plugins/swift-control/" target="_blank" class="button button-small"><?php _e( 'Learn more', 'page-builder-framework' ); ?></a>
							<?php endif; ?>
						</div>
					</li>

					<li class="list-item">
						<div class="plugin-content">
							<h3>Ultimate Dashboard</h3>
							<div class="plugin-description">
								<p>
									Replace the default WordPress dashboard with your own set of icon- & text widgets.
								</p>
							</div>
						</div>
						<div class="plugin-link">
							<?php if ( defined( 'ULTIMATE_DASHBOARD_PLUGIN_URL' ) || defined( 'ULTIMATE_DASHBOARD_PRO_PLUGIN_URL' ) ) : ?>
								<i class="dashicons dashicons-yes-alt"></i>
							<?php else : ?>
								<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank" class="button button-small"><?php _e( 'Learn more', 'page-builder-framework' ); ?></a>
							<?php endif; ?>
						</div>
					</li>
				</ul>
			</div><!-- .recommended-box -->

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading documentation-box">
				<h2>
					<?php _e( 'Documentation', 'swift-control' ); ?>
				</h2>
				<div class="neatbox-body">
					<p>
						<?php _e( 'Not sure how something works? Our extensive Documentation is a great place to learn more about Page Builder Framework.', 'page-builder-framework' ); ?>
					</p>
					<a href="https://wp-pagebuilderframework.com/docs/" target="_blank" class="button button-primary">
						<?php _e( 'Documentation', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div><!-- .documentation-box -->

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading community-box">
				<h2>
					<?php _e( 'Join the Community', 'swift-control' ); ?>
				</h2>
				<div class="neatbox-body">
					<p>
						<?php _e( 'Join the community and meet 1000+ Page Builder Framework users in our private Facebook group.', 'page-builder-framework' ); ?>
					</p>
					<a href="https://www.facebook.com/groups/wpagebuilderframework/" target="_blank" class="button button-primary">
						<?php _e( 'Join the Community', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div><!-- .community-box -->

		</div><!-- .right-section -->
	</div><!-- .wpbf-admin-page -->

</div>
