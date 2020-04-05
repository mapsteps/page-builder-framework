<?php
/**
 * 404.
 *
 * Construct the theme 404 page.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div id="content">

	<?php do_action( 'wpbf_content_open' ); ?>

	<?php wpbf_inner_content(); ?>

		<?php do_action( 'wpbf_inner_content_open' ); ?>

		<main id="main" class="wpbf-main<?php echo wpbf_singular_class(); ?>">

			<div class="wpbf-text-center">

				<?php echo '<h1 class="entry-title" itemprop="headline">' . apply_filters( 'wpbf_404_headline', __( "404 - This page couldn't be found.", 'page-builder-framework' ) ) . '</h1>'; ?>

				<div class="wpbf-container-center wpbf-medium-1-2" itemprop="text">

					<?php echo '<p>' . apply_filters( 'wpbf_404_text', __( "Oops! We're sorry, this page couldn't be found!", 'page-builder-framework' ) ) . '</p>'; ?>

					<?php get_search_form(); ?>

				</div>

			</div>

		</main>

		<?php do_action( 'wpbf_inner_content_close' ); ?>

	<?php wpbf_inner_content_close(); ?>

	<?php do_action( 'wpbf_content_close' ); ?>

</div>
