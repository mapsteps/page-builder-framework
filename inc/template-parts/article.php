<?php
/**
 * Article
 *
 * displays posts on archives, category, search and index pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$template_parts_header = get_theme_mod( 'archive_sortable_header', array( 'title', 'meta', 'featured' ) );
$template_parts_footer = get_theme_mod( 'archive_sortable_footer', array( 'readmore', 'categories' ) );
$wpbf_blog_layout = get_theme_mod( 'archive_layout', 'default' );

if ( is_category() ) {
	
	$template_parts_header = get_theme_mod( 'category_sortable_header', array( 'title', 'meta', 'featured' ) );
	$template_parts_footer = get_theme_mod( 'category_sortable_footer', array( 'readmore', 'categories' ) );
	$wpbf_blog_layout = get_theme_mod( 'category_layout', 'default' );

} 

if ( is_home() ) {

	$template_parts_header = get_theme_mod( 'blog_sortable_header', array( 'title', 'meta', 'featured' ) );
	$template_parts_footer = get_theme_mod( 'blog_sortable_footer', array( 'readmore', 'categories' ) );
	$wpbf_blog_layout = get_theme_mod( 'blog_layout', 'default' );

}

?>

<?php if( $wpbf_blog_layout == 'beside' ) { ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'wpbf-blog-layout-' . $wpbf_blog_layout ); ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork">

	<?php if( has_post_thumbnail() ) { ?>

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
					if ( $part !== 'featured') {
						get_template_part( 'inc/template-parts/blog/blog-' . $part );
					}
				}
			}

			?>

			<div class="entry-summary" itemprop="text">
				<?php the_excerpt(); ?>
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

	<?php if( has_post_thumbnail() ) { ?>

		</div>

	</div>

	<?php } ?>

</article>

<?php } else { ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'wpbf-blog-layout-' . $wpbf_blog_layout ); ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork">

	<header class="article-header">

		<?php

		if ( ! empty( $template_parts_header ) && is_array( $template_parts_header ) ) {
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

</article>

<?php } ?>