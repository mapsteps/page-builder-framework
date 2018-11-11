<?php
/**
 * Template Name: No Header/Footer (Deprecated)
 *
 * Page Template to display Content without Header & Footer
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

remove_action( 'wpbf_header', 'wpbf_do_header' );
remove_action( 'wpbf_footer', 'wpbf_do_footer' );
remove_action( 'wpbf_before_footer', 'wpbf_custom_footer' );

get_header(); ?>

		<div id="content">

			<?php do_action( 'wpbf_content_open' ); ?>
			
			<?php wpbf_inner_content(); ?>

				<?php do_action( 'wpbf_inner_content_open' ); ?>

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

					<?php do_action( 'wpbf_before_comments' ); ?>

					<?php comments_template(); ?>

					<?php do_action( 'wpbf_after_comments' ); ?>

				</main>

				<?php do_action( 'wpbf_inner_content_close' ); ?>

			<?php wpbf_inner_content_close(); ?>

			<?php do_action( 'wpbf_content_close' ); ?>
			
		</div>

<?php get_footer(); ?>