<?php
/**
 * 404
 *
 * Construct the Theme's 404 Page
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

		<div id="content">

			<?php do_action( 'wpbf_content_open' ); ?>

			<?php wpbf_inner_content(); ?>

				<?php do_action( 'wpbf_inner_content_open' ); ?>

				<main id="main" class="wpbf-main<?php echo wpbf_singular_class(); // WPCS: XSS ok. ?>">

					<div class="wpbf-text-center">

						<?php echo '<h1 class="entry-title" itemprop="headline">' . apply_filters( 'wpbf_404_headline', __( "404 - This page couldn't be found.", 'page-builder-framework' ) ) . '</h1>'; // WPCS: XSS ok. ?>

						<div class="wpbf-container-center wpbf-medium-1-2" itemprop="text">

							<?php echo '<p>' . apply_filters( 'wpbf_404_text', __( "Oops! We're sorry, this page couldn't be found!", 'page-builder-framework' ) ) . '</p>'; // WPCS: XSS ok. ?>

							<?php get_search_form(); ?>

						</div>

					</div>

				</main>

				<?php do_action( 'wpbf_inner_content_close' ); ?>

			<?php wpbf_inner_content_close(); ?>

			<?php do_action( 'wpbf_content_close' ); ?>
			
		</div>