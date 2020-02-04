<?php
/**
 * Comments template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Don't load it if you can't comment.
if ( post_password_required() )	return;

?>

<?php if ( have_comments() ) : ?>

	<?php do_action( 'wpbf_before_comments' ); ?>

	<section class="commentlist">

		<h3 id="comments-title">
			<?php
			comments_number(
				__( '<span>No</span> Comments', 'page-builder-framework' ),
				__( '<span>One</span> Comment', 'page-builder-framework' ),
				__( '<span>%</span> Comments', 'page-builder-framework' )
			);
			?>
		</h3>

		<ul id="comments" class="comments">
			<?php
			wp_list_comments( array(
				'avatar_size' => 80,
				'callback'    => 'wpbf_comments',
				'reply_text'  => __( 'Reply', 'page-builder-framework' ),
			) );
			?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="wpbf-comment-nav wpbf-clearfix" aria-label="<?php _e( 'Comments Navigation', 'page-builder-framework' ); ?>">
			<span class="screen-reader-text"><?php _e( 'Comments Navigation', 'page-builder-framework' ) ?></span>
			<div class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'page-builder-framework' ) ); ?></div>
			<div class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'page-builder-framework' ) ); ?></div>
		</nav>
		<?php endif; ?>

	</section>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.' , 'page-builder-framework' ); ?></p>
	<?php endif; ?>

	<?php do_action( 'wpbf_after_comments' ); ?>

<?php endif; ?>

<?php

do_action( 'wpbf_before_comment_form' );

comment_form();

do_action( 'wpbf_after_comment_form' );
