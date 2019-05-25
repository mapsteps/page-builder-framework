<?php
/**
 * Page Template
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>

		<div id="content">

			<?php do_action( 'wpbf_content_open' ); ?>
			
			<?php wpbf_inner_content(); ?>

				<?php do_action( 'wpbf_inner_content_open' ); ?>

				<main id="main" class="wpbf-main<?php echo wpbf_singular_class(); // WPCS: XSS ok. ?>">

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

				<?php do_action( 'wpbf_inner_content_close' ); ?>

			<?php wpbf_inner_content_close(); ?>

			<?php do_action( 'wpbf_content_close' ); ?>
			
		</div>
	    
<?php get_footer(); ?>