<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ohsheswooned
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'after-five' ) ) : ?>
			<div id="footer-widget" class="footer-widget widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-widget' ); ?>
			</div>
		<?php endif; ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<!-- <script type="text/javascript" src="/ohsheswooned/wordpress-v1/target/wp-content/themes/ohsheswooned/js/app.js"></script> -->
<script type="text/javascript" src="/wp-content/themes/ohsheswooned/js/app.js"></script>
<?php wp_footer(); ?>
</div>
</body>
</html>
