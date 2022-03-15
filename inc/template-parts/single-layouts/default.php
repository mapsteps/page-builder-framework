<?php
/**
 * Blog Layout | Default.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$template_parts        = wpbf_post_layout();
$template_parts_header = $template_parts['template_parts_header'];
$template_parts_footer = $template_parts['template_parts_footer'];
$style                 = $template_parts['style'];
$post_classes          = array( 'wpbf-post-layout-default' );
$post_classes[]        = 'wpbf-post-style-' . $style;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?> <?php wpbf_single_schema_markup(); ?>>

	<div class="wpbf-article-wrapper">

		<?php do_action( 'wpbf_article_open' ); ?>

		<header class="article-header">

			<?php
			if ( ! empty( $template_parts_header ) && is_array( $template_parts_header ) ) {
				foreach ( $template_parts_header as $part ) {
					get_template_part( 'inc/template-parts/single/single-' . $part );
				}
			}
			?>

		</header>

		<section class="entry-content article-content" itemprop="text">

			<?php do_action( 'wpbf_entry_content_open' ); ?>

			<?php the_content(); ?>

			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'page-builder-framework' ),
				'after'  => '</div>',
			) );
			?>

			<?php do_action( 'wpbf_entry_content_close' ); ?>

		</section>

		<footer class="article-footer">

			<?php
			if ( ! empty( $template_parts_footer ) && is_array( $template_parts_footer ) ) {
				foreach ( $template_parts_footer as $part ) {
					get_template_part( 'inc/template-parts/single/single-' . $part );
				}
			}
			?>

		</footer>

		<?php do_action( 'wpbf_article_close' ); ?>

	</div>

	<?php do_action( 'wpbf_post_links' ); ?>

	<?php comments_template(); ?>

</article>
