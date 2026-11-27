<?php
/**
 * Blog Layout | Beside.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$template_parts         = wpbf_blog_layout();
$template_parts_header  = $template_parts['template_parts_header'];
$template_parts_content = $template_parts['template_parts_content'];
$template_parts_footer  = $template_parts['template_parts_footer'];
$style                  = $template_parts['style'];
$post_classes           = array( 'wpbf-blog-layout-beside' );
$post_classes[]         = 'wpbf-post-style-' . $style;

// The image column only with Featured Image switched on in the header parts (Blog / Archive Layout -> Header).
$show_featured = has_post_thumbnail() && is_array( $template_parts_header ) && in_array( 'featured', $template_parts_header, true );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?> <?php wpbf_archive_schema_markup(); ?>>

	<?php if ( $show_featured ) { ?>

	<div class="wpbf-grid wpbf-grid-medium">

		<header class="article-header wpbf-large-2-5">

			<?php get_template_part( 'inc/template-parts/blog/blog-featured' ); ?>

		</header>

		<div class="wpbf-large-3-5">

	<?php } ?>

		<section class="article-content">

			<?php
			if ( ! empty( $template_parts_header ) && is_array( $template_parts_header ) ) {
				foreach ( $template_parts_header as $part ) {
					if ( 'featured' !== $part ) {
						get_template_part( 'inc/template-parts/blog/blog-' . $part );
					}
				}
			}
			?>

			<div class="entry-summary" itemprop="text">

				<?php
				if ( ! empty( $template_parts_content ) && is_array( $template_parts_content ) ) {
					if ( in_array( 'post', $template_parts_content ) ) {
							the_content();
					} elseif ( in_array( 'excerpt', $template_parts_content ) ) {
							the_excerpt();
					}
				}
				?>

				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'page-builder-framework' ),
					'after'  => '</div>',
				) );
				?>

			</div>

		</section>

		<?php if ( $template_parts_footer != false ) { ?>

		<footer class="article-footer">

			<?php
			if ( ! empty( $template_parts_footer ) && is_array( $template_parts_footer ) ) {
				foreach ( $template_parts_footer as $part ) {
					get_template_part( 'inc/template-parts/blog/blog-' . $part );
				}
			}
			?>

		</footer>

		<?php } ?>

	<?php if ( $show_featured ) { ?>

		</div>

	</div>

	<?php } ?>

</article>
