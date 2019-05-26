</div><!-- #content -->
<div class="container footer">
	<footer id="colophon" class="site-footer row" style="background: url('/rttheme/wp-content/themes/rttheme/inc/footer-bg.jpg')">
		<div class="site-info col-md-6">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'menu-2',
                'menu_id'        => 'footer-menu',
            ) );
            	/* translators: %s: CMS name, i.e. WordPress. */
				 echo get_theme_mod('footer_copyright'); 
                printf( esc_html__( 'Designed By rtCamp', 'rttheme' ) );
			?>

		</div><!-- .site-info -->
        <div class="col-md-6 footer_logo">
            <p><img src="<?php  echo get_theme_mod('footer_logo');  ?>"></p>
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->
</div>
<?php wp_footer(); ?>

</body>
</html>
