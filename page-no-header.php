<?php
/**
 * Template Name: No Header (Deprecated)
 *
 * Page Template to display Content without Header
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

remove_action( 'wpbf_header', 'wpbf_do_header' );

get_header(); ?>

		<div id="content">
			
			<?php wpbf_inner_content(); ?>

				<main id="main" class="wpbf-main wpbf-page-content">

					<?php wpbf_title(); ?>
					<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
					<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'page-builder-framework' ),
						'after'  => '</div>',
					) );
					?>

					<?php endwhile; endif; ?>

					<?php comments_template(); ?>

				</main>

			<?php wpbf_inner_content_close(); ?>
			
		</div>

<?php get_footer(); ?>