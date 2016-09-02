<?php
/**
 * Template part for displaying first post on index page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ohsheswooned
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('first-post in-loop'); ?>>
	<!-- Display Category unless on a Single Post Page -->
	<div class="entry-category hr-title">
		<?php 
			$categories = get_the_category();

			echo '<a class="entry-category-title" href="' . get_category_link(get_cat_ID($categories[0]->name)) . '">' . $categories[0]->name . '</a>';
		?>
	</div>

	<a class="entry-image-link-wrap" href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail(''); ?>
	</a>
	<div class="entry-content-wrap">
		<header class="entry-header">
			<div class="entry-title-wrap">
				<?php
					the_title( '<h2 class="entry-title hr-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</div>
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
</article><!-- #post-## -->
