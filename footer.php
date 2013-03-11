	<div id="footer">
    
        <div id="footer-menu" class="clearfix">
       		<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'footer-menu', 'theme_location' => 'footer-menu' ) ); ?>
   		</div>
        
        <p id="copyright">
        	&copy; 2013 <a href="<?php echo get_option( 'home' )?>"><?php bloginfo('name'); ?></a> | All Rights Reserved.
        </p>
        
        <p id="theme-designer">
        	Designed by <a href="http://thepolymathlab.com" target="_blank">rocktree Design</a>
        </p>
        
    </div>
    
</div>
 
<?php wp_footer(); ?>

</body>
</html>