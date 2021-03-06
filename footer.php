<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen - modded for therapisty
 * @since 1.0
 * @version 1.0
 */

?>

		</div><!-- #content -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
	<?php
	//Front Page Tile Widgets
	if(is_active_sidebar('x2-ftrw')): ?>
		<div id="x2-ftrw" class="widget-area" role="complementary">
			<?php 
				dynamic_sidebar( 'x2-ftrw' ); 
			?>
		</div>
	<?php endif; ?>	
<footer id="colophon" class="site-footer" role="contentinfo">
	<?php
	if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation" role="navigation" aria-label="<?php _e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'social',
								'menu_class'     => 'social-links-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
							) );
						?>
					</nav><!-- .social-navigation -->
	<?php endif; ?>
	<p>Copyright &copy; <?php echo date("Y") ?> <a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a>.  All rights reserved.</p>
	<?php 
		if (strlen(X2_get_theme_option( 'footer_text' )) > 3)
		{
			?>
				<p class="additionalFooterText"><?php echo X2_get_theme_option( 'footer_text' ); ?></p>
			<?php
		}
	?>
	<?php 
		if (X2_get_theme_option( 'show_design_credits' ))
		{
			?>
				<div id="x2design_credits"><?php echo X2_get_theme_option( 'design_credits' ); ?></div>
			<?php
		}
	?>
</footer><!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>