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

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading customizer-box">
				<h2>
					<?php _e( 'Links to Customizer Settings', 'page-builder-framework' ); ?>
				</h2>
				<ul class="neatbox-list customizer-list">
					<li class="list-item">

						<div class="customizer-items">
							<div class="customizer-item">
								<a href="<?php echo esc_url( admin_url() ); ?>/customize.php?autofocus%5Bsection%5D=title_tagline">
									<?php _e( 'Logo', 'page-builder-framework' ); ?>
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

					<li class="list-item inline-action">
						<div class="customizer-item list-content">
							<h3 class="title">Launch WordPress Customizer</h3>
							<p class="description">
								Explore all of the Page Builder Framework features.
							</p>
						</div>
						<div class="list-action">
							<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class="button button-primary">Customize</a>
						</div>
					</li>

				</ul>
			</div><!-- .customizer-box -->

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading premium-box">
				<h2>
					<?php _e( 'Premium Add-On Options', 'page-builder-framework' ); ?>
					<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" style="float: right;"><?php _e( 'Learn more', 'page-builder-framework' ); ?></a>
				</h2>
				<ul class="neatbox-list premium-list">

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">Transparent Header</a></h3>
							<p class="description">
								Create customizable transparent headers with just a few clicks.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">Sticky Navigation</a></h3>
							<p class="description">
								Create a fully customizable sticky navigation with just a few clicks.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">White Label Settings</a></h3>
							<p class="description">
								Your theme, your branding. Fully white label Page Builder Framework & the Premium Add-On.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">Advanced Typography</a></h3>
							<p class="description">
								Customize fonts and add Typekit- & Custom Fonts to your website.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">Adjustable Breakpoints</a></h3>
							<p class="description">
								Set custom responsive breakpoints for tablets and desktops & mobiles for a pixel perfect design.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">Advanced WooCommerce Features</a></h3>
							<p class="description">
								Take full control over the design of your online store with more advanced WooCommerce features.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">Mega Menu</a></h3>
							<p class="description">
								Easily create an advanced mega menu with up to 4 rows.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title"><a href="#" target="_blank">Call to Action Button</a></h3>
							<p class="description">
								Add a customizable Call to Action Button to your navigation with just a few clicks.
							</p>
						</div>
						<div class="list-action">
							<i class="dashicons dashicons-yes-alt"></i>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title">And a lot more!</h3>
							<p class="description">
								Check out all the Premium Add-On features.
							</p>
						</div>
						<div class="list-action">
							<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" class="button button-primary"><?php _e( 'Go Premium', 'page-builder-framework' ); ?></a>
						</div>
					</li>

				</ul>
			</div><!-- .premium-box -->

		</div><!-- .left-section -->
		<div class="right-section">

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading recommended-box">
				<h2>
					<?php _e( 'Recommended', 'page-builder-framework' ); ?>
				</h2>
				<ul class="neatbox-list recommended-list">
					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title">Premium Add-On</h3>
							<p class="description">
								Take your website to the next level with the Premium Add-On.
							</p>
						</div>
						<div class="list-action">
							<?php if ( wpbf_is_premium() ) : ?>
								<i class="dashicons dashicons-yes-alt"></i>
							<?php else : ?>
								<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" class="button button-small"><?php _e( 'Go Premium', 'page-builder-framework' ); ?></a>
							<?php endif; ?>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title">Customizer Reset</h3>
							<p class="description">
								<strong>Reset, Export & Import</strong> your customizer settings with a simple click of a button.
							</p>
						</div>
						<div class="list-action">
							<?php if ( defined( 'CUSTOMIZER_RESET_PLUGIN_VERSION' ) ) : ?>
								<i class="dashicons dashicons-yes-alt"></i>
							<?php else : ?>
								<a href="https://wordpress.org/plugins/customizer-reset/" target="_blank" class="button button-small"><?php _e( 'Learn more', 'page-builder-framework' ); ?></a>
							<?php endif; ?>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title">Swift Control</h3>
							<p class="description">
								Quickly access all important areas of your WordPress website.
							</p>
						</div>
						<div class="list-action">
							<?php if ( defined( 'SWIFT_CONTROL_PLUGIN_VERSION' ) || defined( 'SWIFT_CONTROL_PRO_PLUGIN_VERSION' ) ) : ?>
								<i class="dashicons dashicons-yes-alt"></i>
							<?php else : ?>
								<a href="https://wordpress.org/plugins/swift-control/" target="_blank" class="button button-small"><?php _e( 'Learn more', 'page-builder-framework' ); ?></a>
							<?php endif; ?>
						</div>
					</li>

					<li class="list-item inline-action">
						<div class="list-content">
							<h3 class="title">Ultimate Dashboard</h3>
							<p class="description">
								Replace the default WordPress dashboard with your own set of icon- & text widgets.
							</p>
						</div>
						<div class="list-action">
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
					<?php _e( 'Documentation', 'page-builder-framework' ); ?>
				</h2>
				<div class="neatbox-content">
					<p class="description">
						<?php _e( 'Not sure how something works? Our extensive Documentation is a great place to learn more about Page Builder Framework.', 'page-builder-framework' ); ?>
					</p>
					<a href="https://wp-pagebuilderframework.com/docs/" target="_blank" class="button button-primary">
						<?php _e( 'Documentation', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div><!-- .documentation-box -->

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading community-box">
				<h2>
					<?php _e( 'Join the Community', 'page-builder-framework' ); ?>
				</h2>
				<div class="neatbox-content">
					<p class="description">
						<?php _e( 'Join the community and meet 1000+ Page Builder Framework users in our private Facebook group.', 'page-builder-framework' ); ?>
					</p>
					<a href="https://www.facebook.com/groups/wpagebuilderframework/" target="_blank" class="button button-primary">
						<?php _e( 'Join the Community', 'page-builder-framework' ); ?>
					</a>
				</div>
			</div><!-- .community-box -->

			<div class="neatbox is-smooth has-medium-gap has-bigger-heading additional-box">
				<h2>
					<?php _e( 'Additional Resources', 'page-builder-framework' ); ?>
				</h2>
				<ul class="neatbox-list additional-list">
					<li class="list-item">
						<a href="https://wp-pagebuilderframework.com/" target="_blank">
							<span class="dashicons dashicons-admin-site-alt"></span>
							<?php _e( 'Page Builder Framework Website', 'page-builder-framework' ); ?>
						</a>
					</li>
					<li class="list-item">
						<a href="https://wordpress.org/support/theme/page-builder-framework/" target="_blank">
							<span class="dashicons dashicons-sos"></span> <?php _e( 'Support Forum', 'page-builder-framework' ); ?>
						</a>
					</li>
					<li class="list-item">
						<a href="https://wordpress.org/support/theme/page-builder-framework/reviews/#new-post" target="_blank">
							<span class="dashicons dashicons-star-filled"></span>
							<?php _e( 'Love PBF? Leave a Review', 'page-builder-framework' ); ?>
						</a>
					</li>
				</ul>
			</div><!-- .additional-box -->

		</div><!-- .right-section -->
	</div><!-- .wpbf-admin-page -->

</div>
