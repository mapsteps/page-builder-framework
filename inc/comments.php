<?php
/**
 * Comments
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function wpbf_comments( $comment, $args, $depth ) {

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) { ?>

	<li id="comment-<?php comment_ID(); ?>">

		<article <?php comment_class(); ?>>

			<?php _e( 'Pingback:', 'page-builder-framework' ); // WPCS: XSS ok. ?>

			<?php comment_author_link(); ?>

			<?php edit_comment_link(); ?>

		</article>

	</li>

	<?php } else { ?>

	<li id="comment-<?php comment_ID(); ?>">

		<article <?php comment_class(); ?> itemscope="itemscope" itemtype="https://schema.org/Comment">

			<footer class="comment-meta">

				<?php echo get_avatar( $comment, 120 ); ?>

				<div class="comment-author-info">

					<span class="comment-author author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person">

					<?php if ( $comment->user_id ) {

						$user = get_userdata( $comment->user_id ); ?>
						<?php printf( '<cite itemprop="name" class="fn">%s</cite>', esc_html( $user->display_name ) ); ?>

					<?php } else { ?>

						<?php printf( '<cite itemprop="name" class="fn">%s</cite>', get_comment_author_link() ); ?>

					<?php } ?>

					</span>

					<?php edit_comment_link( __( 'Edit', 'page-builder-framework' ) ); ?>

					<time class="comment-time" datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">

						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php comment_time( __( 'F d, Y', 'page-builder-framework' ) ); ?></a>

					</time>

				</div>

			</footer>

			<?php if ( $comment->comment_approved == '0' ) : ?>

			<div class="wpbf-notice wpbf-notice-warning">

				<p><?php _e( 'Your comment has yet to be approved.', 'page-builder-framework' ); // WPCS: XSS ok. ?></p>

			</div>

			<?php endif; ?>

			<div class="comment-content" itemprop="text">

				<?php comment_text() ?>

			</div>

			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>

		</article>
	</li>

	<?php }

}