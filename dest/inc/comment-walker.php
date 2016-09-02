<?php
	class ohsheswooned_Comment_Walker extends Walker_Comment {
		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

		// constructor – wrapper for the comments list
		function __construct() { ?>

			<section class="comments-list">

		<?php }

		// start_lvl – wrapper for child comments list
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			<section class="child-comments comments-list">

		<?php }

		// end_lvl – closing wrapper for child comments list
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			</section>

		<?php }

		// start_el – HTML for comment template
		function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

			if ( 'article' == $args['style'] ) {
				$tag = 'article';
				$add_below = 'comment';
			} else {
				$tag = 'article';
				$add_below = 'comment';
			} ?>

			<article <?php comment_class(empty( $args['has_children'] ) ? 'comment-main' :'parent comment-main') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment" >
        <div class="comment-table">
  				<figure class="gravatar"><?php echo get_avatar( $comment, 100, 'mm', 'Author’s gravatar' ); ?></figure>
          <div class="comment-content-outer">
            <div class="comment-content-inner">
      				<div class="comment-meta post-meta" role="complementary">
      					<h2 class="comment-author">
      						<a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a><span class="comment-author-phrase"> says:</span>
      					</h2>
      					<?php edit_comment_link('<p class="comment-meta-item">Edit this comment</p>','',''); ?>
      					<?php if ($comment->comment_approved == '0') : ?>
      					<p class="comment-meta-item">Your comment is awaiting moderation.</p>
      					<?php endif; ?>
      				</div>
      				<div class="comment-content post-content" itemprop="text">
      					<?php comment_text() ?>
                <time class="comment-meta-item" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><?php echo human_time_diff( strtotime(get_comment_date('Y-m-d') . 'T' . get_comment_time('H:i:s')), current_time('timestamp')) ?> ago</time>
      					<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      				</div>
            </div>
          </div>
        </div>

		<?php }

		// end_el – closing HTML for comment template
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

			</article>

		<?php }

		// destructor – closing wrapper for the comments list
		function __destruct() { ?>

			</section>

		<?php }

	}
?>
