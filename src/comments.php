<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ohsheswooned
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<div class="comments-divider"></div>

	<div class="comments-inner">
		<div class="hr-title">
			<h3 class="entry-title"><a>Comments</a></h3>
		</div>

		<?php // You can start editing here -- including this comment! ?>

		<?php if ( have_comments() ) : ?>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'ohsheswooned' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'ohsheswooned' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'ohsheswooned' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
			<?php endif; // check for comment navigation ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'walker' => new ohsheswooned_Comment_Walker(),
						'short_ping' => true,
						'reply_text' => 'Reply to this comment',
						'avatar_size' => 100,
					) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'ohsheswooned' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'ohsheswooned' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'ohsheswooned' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'ohsheswooned' ); ?></p>
		<?php endif; ?>

		<?php comment_form(
			array(
				'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="80" rows="8" aria-required="true" placeholder="enter a comment..."></textarea></p>',
				'title_reply' => 'Leave a comment',
				'label_submit' => 'Submit',
				'comment_notes_before' => '',
				'fields' => array(
					'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="name*" value="' . esc_attr( $commenter['comment_author'] ) . '" size="80"' . $aria_req . ' /></p>',
					'email' => '<p class="comment-form-email"><input id="email" name="email" type="text" placeholder="email*" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="80"' . $aria_req . ' /></p>',
					'url' => '<p class="comment-form-url"><label for="url"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="80" placeholder="website" /></p>',
				)
			)); ?>
	</div>
</div><!-- #comments -->
