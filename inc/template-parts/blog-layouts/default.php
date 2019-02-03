<?php
/**
 * Blog Layout | Default
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$template_parts_header = wpbf_blog_layout();
$template_parts_header = $template_parts_header['template_parts_header'];

$template_parts_footer = wpbf_blog_layout();
$template_parts_footer = $template_parts_footer['template_parts_footer'];

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'wpbf-blog-layout-default' ); ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork">

	<header class="article-header">

		<?php

		if( !empty( $template_parts_header ) && is_array( $template_parts_header ) ) {
			foreach ( $template_parts_header as $part ) {
				get_template_part( 'inc/template-parts/blog/blog-' . $part );
			}
		}

		?>

	</header>

	<section class="entry-summary article-content" itemprop="text">

		<?php the_excerpt(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'page-builder-framework' ),
			'after'  => '</div>',
		) );
		?>

	</section>

	<?php if( $template_parts_footer != false ) { ?>

		<footer class="article-footer">

			<?php

			if( !empty( $template_parts_footer ) && is_array( $template_parts_footer ) ) {
				foreach ( $template_parts_footer as $part ) {
					get_template_part( 'inc/template-parts/blog/blog-' . $part );
				}
			}

			?>

		</footer>

	<?php } ?>

</article>