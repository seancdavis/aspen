		<?php get_sidebar( 'footer' ); ?>
		
		<div id="footer">
		
			<?php if( has_nav_menu( 'footer-menu' ) ) wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'footer-menu', 'theme_location' => 'footer-menu', 'container' => 'div', 'container_id' => 'footer-menu', 'container_class' => 'clearfix'  ) ); ?>
		
			<div id="site-info">
				<span id="copyright">&copy; 2013 <a href="<?php echo get_option( 'home' )?>"><?php bloginfo('name'); ?></a> | All Rights Reserved.</span>
				<span id="theme-designer">Design by <a href="http://rocktreedesign.com" target="_blank">rocktree Design</a></span>
			</div>
        
    </div>
    
</div>
 
<?php wp_footer(); ?>

</body>
</html>