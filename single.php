<?php
/**
 * Single.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$grid_gap = get_theme_mod( 'sidebar_gap', 'medium' );

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

				<?php get_template_part( 'inc/template-parts/single-article' ); ?>

				<?php endwhile; endif; ?>

				<?php do_action( 'wpbf_after_article' ); ?>

				<?php do_action( 'wpbf_main_content_close' ); ?>

			</main>

			<?php do_action( 'wpbf_sidebar_right' ); ?>

		</div>

		<?php do_action( 'wpbf_inner_content_close' ); ?>

	<?php wpbf_inner_content_close(); ?>

	<?php else : ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

		<?php endwhile; endif; ?>

	<?php endif; ?>

	<?php do_action( 'wpbf_content_close' ); ?>

</div>

<?php get_footer(); ?>
