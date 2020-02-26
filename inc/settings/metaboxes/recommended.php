<?php
/**
 * Metabox template for displaying recommended plugins.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="neatbox is-smooth has-medium-gap has-bigger-heading recommended-box">
	<h2>
		Recommended
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
					<a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf#premium" target="_blank" class="button button-small"><?php _e( 'Learn More', 'page-builder-framework' ); ?></a>
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
					<a href="https://wordpress.org/plugins/customizer-reset/" target="_blank" class="button button-small"><?php _e( 'Learn More', 'page-builder-framework' ); ?></a>
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
					<a href="https://wordpress.org/plugins/swift-control/" target="_blank" class="button button-small"><?php _e( 'Learn More', 'page-builder-framework' ); ?></a>
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
					<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank" class="button button-small"><?php _e( 'Learn More', 'page-builder-framework' ); ?></a>
				<?php endif; ?>
			</div>
		</li>
	</ul>
</div><!-- .recommended-box -->
