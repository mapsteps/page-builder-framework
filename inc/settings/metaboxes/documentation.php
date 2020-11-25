<?php
/**
 * Metabox template for displaying documentation links.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="wpbf-documentation-metabox">

	<div class="wpbf-documentation-boxes">

		<?php

			$docs_boxes = array(
				array(
					'icon'    => 'dashicons-book-alt',
					'title'   => __( 'Documentation', 'page-builder-framework' ),
					'content' => __( 'Not sure how something works? <br><br> Our extensive Documentation is a great place to get started and learn more about Page Builder Framework.', 'page-builder-framework' ),
					'link'    => 'https://wp-pagebuilderframework.com/docs/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'icon'    => 'dashicons-admin-users',
					'title'   => __( 'Community', 'page-builder-framework' ),
					'content' => __( 'Did you know? There is a Facebook Community of Page Builder Framework users, just like you! <br><br> Join the community and meet 1500+ Page Builder Framework users.', 'page-builder-framework' ),
					'link'    => 'https://www.facebook.com/groups/wpagebuilderframework/',
				),
				array(
					'icon'    => 'dashicons-download',
					'title'   => __( 'Child Theme', 'page-builder-framework' ),
					'content' => __( 'Are you planning to make code changes to your website? We\'ve got you covered! <br><br> Download the Page Builder Framework child theme or generate your own, white labeled version of it.', 'page-builder-framework' ),
					'link'    => 'https://wp-pagebuilderframework.com/child-theme-generator/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'icon'    => 'dashicons-sos',
					'title'   => __( 'Support Forum', 'page-builder-framework' ),
					'content' => __( 'Any questions? Don\'t hesitate to reach out! <br><br> Post your question in the official WordPress support forum and we will help you out asap!', 'page-builder-framework' ),
					'link'    => 'https://wordpress.org/support/theme/page-builder-framework/',
				),
			);

			foreach ( $docs_boxes as $docs_box ) {

				?>

				<div class="heatbox">
					<h2>
						<a href="<?php echo esc_url( $docs_box['link'] ); ?>" target="_blank">
							<span class="dashicons <?php echo esc_attr( $docs_box['icon'] ); ?>"></span> <?php echo esc_html( $docs_box['title'] ); ?>
						</a>
					</h2>
					<div class="heatbox-content">
						<div class="wpbf-documentation-content">
							<p>
								<?php echo $docs_box['content']; ?>
							</p>
							<a href="<?php echo esc_url( $docs_box['link'] ); ?>" target="_blank" class="button button-primary button-larger">
								<?php echo esc_html( $docs_box['title'] ); ?>
							</a>
						</div>
					</div>
				</div>

				<?php

			}

		?>

	</div>

</div>
