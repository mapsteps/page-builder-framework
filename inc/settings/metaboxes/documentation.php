<?php
/**
 * Metabox template for displaying documentation links.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$wpbf_docs_boxes = array(
	array(
		'title'   => __( 'Documentation', 'page-builder-framework' ),
		'content' => __( 'Not sure how something works? <br><br> Our extensive Documentation is a great place to get started and learn more about Page Builder Framework.', 'page-builder-framework' ),
		'link'    => 'https://wp-pagebuilderframework.com/docs/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
	),
	array(
		'title'   => __( 'Community', 'page-builder-framework' ),
		'content' => __( 'Did you know? There is a Facebook Community of Page Builder Framework users, just like you! <br><br> Join the community and meet 1700+ Page Builder Framework users.', 'page-builder-framework' ),
		'link'    => 'https://www.facebook.com/groups/wpagebuilderframework/',
	),
	array(
		'title'   => __( 'Child Theme', 'page-builder-framework' ),
		'content' => __( 'Are you planning to make code changes to your website? We\'ve got you covered! <br><br> Download the Page Builder Framework child theme or generate your own, white labeled version of it.', 'page-builder-framework' ),
		'link'    => 'https://wp-pagebuilderframework.com/child-theme-generator/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
	),
	array(
		'title'   => __( 'Support Forum', 'page-builder-framework' ),
		'content' => __( 'Any questions? Don\'t hesitate to reach out! <br><br> Post your question in the official WordPress support forum and we will help you out asap!', 'page-builder-framework' ),
		'link'    => 'https://wordpress.org/support/theme/page-builder-framework/',
	),
);

?>

<div class="heatbox-columns wpbf-documentation-boxes">

	<?php foreach ( $wpbf_docs_boxes as $wpbf_docs_box ) : ?>

		<div class="heatbox">
			<h2><?php echo esc_html( $wpbf_docs_box['title'] ); ?></h2>
			<div class="heatbox-content">
				<?php
				// The texts have two parts, split by <br><br>.
				foreach ( preg_split( '/\s*<br\s*\/?>\s*<br\s*\/?>\s*/', $wpbf_docs_box['content'] ) as $wpbf_docs_paragraph ) {
					echo '<p class="description">' . esc_html( $wpbf_docs_paragraph ) . '</p>';
				}
				?>
				<a href="<?php echo esc_url( $wpbf_docs_box['link'] ); ?>" target="_blank" class="button">
					<?php echo esc_html( $wpbf_docs_box['title'] ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
				</a>
			</div>
		</div>

	<?php endforeach; ?>

</div>
