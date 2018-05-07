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
		<article <?php comment_class(); ?>>
			<footer class="comment-meta vcard">

			<?php echo get_avatar( $comment, 120 ); ?>

			<?php if ( $comment->user_id ) {
				// show display name if user is registered or show author link if not
				$user = get_userdata( $comment->user_id ); ?>
				<?php printf( '<cite class="comment-author">%s</cite>', esc_html( $user->display_name ) ); ?>
			<?php } else { ?>
				<?php printf( '<cite class="comment-author">%s</cite>', get_comment_author_link() ); ?>
			<?php } ?>

			<?php edit_comment_link(); ?>

				<time class="comment-time" datetime="<?php comment_time('c'); ?>">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php comment_time( __( 'F d, Y', 'page-builder-framework' ) ); ?>
					</a>
				</time>

			</footer>
		<?php if ($comment->comment_approved == '0') : ?>
		<div class="alert alert-info">
			<p><?php _e( 'Your comment has yet to be approved.', 'page-builder-framework' ); // WPCS: XSS ok. ?></p>
		</div>
		<?php endif; ?>
		<div class="comment-content">
			<?php comment_text() ?>
		</div>
		<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'class' => 'wpbf-button' ) ) ) ?>
		</article>
	</li>

	<?php }

}