<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ohsheswooned
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php 
		if ( has_nav_menu( 'fixed' ) ) : ?>
			<div class="fixed-nav-wrapper">
				<span class="fa fa-bars mobile-nav-btn" aria-hidden="true"></span>
				<div class="mobile-ing-btn">
					<img src="/wp-content/themes/ohsheswooned/assets/images/measuring-spoons.png" alt="">
				</div>
				<?php wp_nav_menu( array( 'theme_location' => 'fixed', 'menu_id' => 'fixed-menu', 'container_class' => 'menu-container') ); ?>
			</div>
	<?php
	endif; ?>

	<div class="fixed-mobile-menu">
		<nav id="site-navigation" class="mobile-main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'menu-container', 'menu_class' => 'menu' ) ); ?>
		</nav><!-- #site-navigation -->

		<div class="mobile-ingredients">
			<?php $ingredients = ohsheswooned_has_ingredients($post->ID);
			  if($ingredients) { ?>
			  <div class="ingredients-wrapper">
			    <div id="ingredients" class="ingredients">
			        <h3 class="widget-title">Ingredients</h3>
			        <?php ohsheswooned_print_ingredients($ingredients); ?>
			    </div>
			  </div>
			<?php } ?>
		</div>
	</div>

<div class="site-wrap">
	<div id="page" class="site <?php if ( has_nav_menu( 'fixed' ) ) { echo 'has-fixed-menu'; } ?>">
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'ohsheswooned' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
					if ( get_header_image() ) : ?>
						<h1 class="site-title image-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
						</a></h1>

					<?php else : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					
					<?php
					endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'menu-container', 'menu_class' => 'menu underline-links' ) ); ?>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->

		<div id="content" class="site-content">
