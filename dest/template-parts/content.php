<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ohsheswooned
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('in-loop after-first'); ?>>
	<!-- Display Category unless on a Single Post Page -->
	<div class="entry-category hr-title">
		<?php 
			$categories = get_the_category();

			echo '<a class="entry-category-title" href="' . get_category_link(get_cat_ID($categories[0]->name)) . '">' . $categories[0]->name . '</a>'
		?>
	</div>

	<div class="article-content-wrap">
		<a class="entry-image-link-wrap" href="<?php the_permalink(); ?>">
			<?php
				$thumbnail = get_post( get_post_thumbnail_id() );
				$thumbnail_alt = get_post_meta( $thumbnail->ID, '_wp_attachment_image_alt', true );
			?>
			<img class="left-aligned-thumb" src="<?php echo the_post_thumbnail_url('loop-thumb'); ?>" style="width: 100%; height: auto;" alt="<?php echo $thumbnail_alt; ?>">
		</a>
		
		<div class="entry-content-wrap">
			<header class="entry-header">
				<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				<div class="entry-meta">
					<?php the_time('l, F j, Y'); ?>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
			<div class="entry-tags">
				<img src="/wp-content/themes/ohsheswooned/assets/images/tag-icon.png" class="tag-icon" />
				<?php the_tags( '', ', ', '' ); ?>
			</div>
		</div>
	</div>

</article><!-- #post-## -->
