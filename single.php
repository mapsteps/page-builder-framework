<?php
/**
 * Single.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$grid_gap				= get_theme_mod( 'sidebar_gap', 'medium' );
$template_parts_header	= get_theme_mod( 'single_sortable_header', array( 'title', 'meta', 'featured' ) );
$template_parts_footer	= get_theme_mod( 'single_sortable_footer', array( 'categories' ) );
$post_style             = get_theme_mod( 'single_post_style', 'plain' );
$post_style            .= get_theme_mod( 'single_boxed_image_stretched', false ) ? ' stretched' : '';
$post_classes           = array( 'wpbf-post-style-' . $post_style );

get_header();

?>

<div id="content">

	<?php do_action( 'wpbf_content_open' ); ?>

	<?php if ( ! is_singular( array( 'elementor_library', 'et_pb_layout', 'wpbf_hooks' ) ) ) : ?>

	<?php wpbf_inner_content(); ?>

		<?php do_action( 'wpbf_inner_content_open' ); ?>

		<div class="wpbf-grid wpbf-main-grid wpbf-grid-<?php echo esc_attr( $grid_gap ); ?>">

			<?php do_action( 'wpbf_sidebar_left' ); ?>

			<main id="main" class="wpbf-main wpbf-medium-2-3<?php echo wpbf_singular_class(); ?>">

				<?php do_action( 'wpbf_main_content_open' ); ?>

				<?php do_action( 'wpbf_before_article' ); ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork">

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
				
				<?php endwhile; endif; ?>

				<?php do_action( 'wpbf_after_article' ); ?>

				<?php do_action( 'wpbf_main_content_close' ); ?>

			</main>

			<?php do_action( 'wpbf_sidebar_right' ); ?>

		</div>

		<?php do_action( 'wpbf_inner_content_close' ); ?>

	<?php wpbf_inner_content_close(); ?>

	<?php else : ?>

		<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

		<?php endwhile; endif; ?>

	<?php endif; ?>

	<?php do_action( 'wpbf_content_close' ); ?>

</div>

<?php get_footer(); ?>
