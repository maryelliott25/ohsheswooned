<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ohsheswooned
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- Display Category unless on a Single Post Page -->
    <?php if ( !is_single() ) : ?>
        <div class="entry-category">
            <?php 
                $categories = get_the_category();

                echo '<a class="entry-category-title" href="' . get_category_link(get_cat_ID($categories[0]->name)) . '">' . $categories[0]->name . '</a>'
            ?>
        </div>
    <?php endif; ?>

    <?php if (MultiPostThumbnails::has_post_thumbnail(array( 'post', 'recipe' ),'header-image')): ?>
        <?php $img_url = MultiPostThumbnails::get_post_thumbnail_url(array( 'post', 'recipe' ),'header-image'); ?>
        <div class="full-width-header-image" style="background-image: url('<?php echo $img_url ?>')"></div>
    <?php else: ?>
        <div class="header-image">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php endif; ?>

    <div class="article-body">
        <header class="entry-header">
            <?php
                if ( is_single() ) {
                    the_title( '<div class="hr-title"><h1 class="entry-title">', '</h1></div>' );
                } else {
                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                }

            if ( 'recipe' === get_post_type() ) : ?>
            <div class="entry-meta">
                <div class="post-date"><?php the_time('l, F jS, Y'); ?></div>
            </div><!-- .entry-meta -->
            <?php
            endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-content">

            <?php
                the_content( sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ohsheswooned' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );
            ?>
        </div><!-- .entry-content -->
    </div>

    <?php
    $prev_post = mod_get_adjacent_post('prev', array('post', 'recipe'));
    $next_post = mod_get_adjacent_post('next', array('post', 'recipe'));
    ?>

    <div class="pn-posts">

        <?php if($prev_post) : ?>
            <div class="pn-post previous-post">
                <div class="meta-wrapper">
                    <div class="hr-title"><div class="pn-meta">Previous Post</div></div>
                </div>

                <?php $prev_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'thumbnail' )[0]; ?>

                <div class="pn-content">
                    <img src="<?php echo $prev_thumbnail; ?>" class="pn-image" />
                    <h4 class="pn-title"><a href="<?php echo get_permalink($prev_post->ID); ?>"><?php echo get_the_title($prev_post->ID); ?></a></h4>
                </div>
            </div>
        <?php endif; ?>

        <?php if($next_post) : ?>
            <div class="pn-post next-post">
                <div class="meta-wrapper">
                    <div class="hr-title"><div class="pn-meta">Next Post</div></div>
                </div>

                <?php $next_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'thumbnail' )[0]; ?>

                <div class="pn-content">
                    <img src="<?php echo $next_thumbnail; ?>" class="pn-image" />
                    <h4 class="pn-title"><a href="<?php echo get_permalink($next_post->ID); ?>"><?php echo get_the_title($next_post->ID); ?></a></h4>
                </div>
            </div>
        <?php endif; ?>
    </div>
</article><!-- #post-## -->
