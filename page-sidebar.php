<?php
/**
 * Template Name: Sidebar
 *
 * Page Template to display Content with Sidebar
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$grid_gap = get_theme_mod( 'sidebar_gap', 'medium' );

get_header(); ?>

		<div id="content">

			<?php do_action( 'wpbf_content_open' ); ?>

			<?php wpbf_inner_content(); ?>

				<?php do_action( 'wpbf_inner_content_open' ); ?>

				<div class="wpbf-grid wpbf-main-grid wpbf-grid-<?php echo esc_attr( $grid_gap ); ?>">

					<?php do_action( 'wpbf_sidebar_left' ); ?>

					<main id="main" class="wpbf-main wpbf-medium-2-3<?php echo wpbf_singular_class(); // WPCS: XSS ok. ?>">

						<?php do_action( 'wpbf_main_content_open' ); ?>

						<?php wpbf_title(); ?>

						<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<div class="entry-content" itemprop="text">

							<?php the_content(); ?>

							<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'page-builder-framework' ),
								'after'  => '</div>',
							) );
							?>

						</div>

						<?php endwhile; endif; ?>

						<?php comments_template(); ?>

						<?php do_action( 'wpbf_main_content_close' ); ?>

					</main>

					<?php do_action( 'wpbf_sidebar_right' ); ?>

				</div>

				<?php do_action( 'wpbf_inner_content_close' ); ?>

			<?php wpbf_inner_content_close(); ?>

			<?php do_action( 'wpbf_content_close' ); ?>

		</div>

<?php get_footer(); ?>