<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ohsheswooned
 */

get_header(); ?>

	<?php if(is_home() && !is_paged()):?>
		<?php
			$args = array( 
				'tag' => 'featured',
				'post_type' => array('post', 'recipe')
			);
			$query = new WP_Query( $args );
		
			// Check that we have query results.
			if ( $query->have_posts() ) : ?>

				<div class="featured-content-area">

				    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
				 
				        <div class="featured-post-slide">
				        	<a class="slide-link" href="<?php the_permalink(); ?>"></a>
			        		<?php
			        			$thumbnail = get_post( get_post_thumbnail_id() );
			        			$thumbnail_alt = get_post_meta( $thumbnail->ID, '_wp_attachment_image_alt', true );
			        		?>
							<img class="slide-image" src="<?php echo the_post_thumbnail_url('featured-slide'); ?>" style="width: 100%; height: auto;" alt="<?php echo $thumbnail_alt; ?>">
							<div class="slide-info">
								<div class="slide-copy">
									<?php 
										$categories = get_the_category();

										echo '<a class="slide-category" href="' . get_category_link(get_cat_ID($categories[0]->name)) . '">' . $categories[0]->name . '</a>'
									?>
									<a href="<?php the_permalink(); ?>"><h2 class="slide-title"><?php the_title(); ?></h2></a>
								</div>
							</div>
				        </div>
				 
				    <?php endwhile; ?>

				</div>
			
			<?php 
			endif;
			 
			// Restore original post data.
			wp_reset_postdata();
		 
		?>
	<?php endif;?>
	
	<div class="content-area-wrapper">
		<div id="primary" class="primary content-area">
			<main id="main" class="site-main" role="main">

			<?php

				$term = get_term_by('slug','featured', 'post_tag');
				$args=array(
  					'tag__not_in' => array($term->term_id),
  					'post_type' => array('post', 'recipe'),
  					'post_status' => 'publish',
  					'caller_get_posts'=> 1,
  					'paged' => $paged
				);

                query_posts($args);

			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) : ?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>

				<?php
				endif;

				/* Start the Loop */
				while ( have_posts() ) : the_post();
					$counter++;

					if ( $counter==1 ) {
						get_template_part( 'template-parts/content', 'first');
					} elseif ( $counter==3 ) {
						get_template_part( 'template-parts/content', get_post_format() );
						if ( is_active_sidebar( 'after-five' ) ) : ?>
							<div id="after5-sidebar" class="after5-sidebar widget-area" role="complementary">
								<?php dynamic_sidebar( 'after-five' ); ?>
							</div>
						<?php endif;	
					} else {
						get_template_part( 'template-parts/content', get_post_format() );
					}
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */

				endwhile;

				echo '<div class="index-post-pagination pagination">' . paginate_links(array(
					'prev_text' => '&larr; Newer Posts',
					'next_text' => 'Older Posts &rarr;'
				)) . '</div>';

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php
		get_sidebar();
		?>
	</div>
	
<?php get_footer();
