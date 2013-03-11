<?php

/* The CORE functions
------------------------------------------------------------------------ */
add_action( 'build_content', 'core_content_builder' );

function core_content_builder($layout) {
		
	get_header();
	
	if( is_front_page() ) {
		get_sidebar( 'front' );
	}
	else{
	 
		echo '<div id="container">';
		
		$post = $posts[0]; // Hack. Set $post so that the_date() works.
		/* If this is a category archive */ 
		if (is_category()) {
			echo '<h2>Archive for the ' . single_cat_title() . ' Category:</h2>'; 
		} 
		/* If this is a tag archive */ 
		elseif( is_tag() ) {
			echo '<h2>Posts Tagged &#8216;' . single_tag_title() . '&#8217;</h2>';
		} 
		/* If this is a daily archive */ 
		elseif (is_day()) {
			echo '<h2>Archive for ' . the_time('F jS, Y') . ':</h2>';
		} 
		/* If this is a monthly archive */
		elseif (is_month()) {
			echo '<h2>Archive for ' . the_time('F, Y') . ':</h2>';
		}
		/* If this is a yearly archive */
		elseif (is_year()) {
			echo '<h2>Archive for ' . the_time('Y') . ':</h2>';
		}
		/* If this is an author archive */ 
		elseif (is_author()) {
			echo '<h2>Author Archive</h2>';
		}
		/* If this is a paged archive */ 
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			echo '<h2>Blog Archives</h2>';
		}		
		
		// builds correct content containers based on page template	
		if( $layout == 'right-sidebar' ) {
			echo '<div id="left-column">';
			do_action( 'build_loop' );
			echo '</div>';
			get_sidebar();
		}
		else {
			echo '<div id="full-width-column">';
			do_action( 'build_loop' );
			echo '</div>';
		}		
	
		echo '</div>';
	
	}
	
	get_footer();
    
}

/* The LOOP
------------------------------------------------------------------------ */
add_action( 'build_loop', 'the_loop');

function the_loop() {
	
	if(have_posts()) :
			
		while(have_posts()) : the_post(); ?>
			 
			<div class="post">            
				<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				
				<?php if( is_home() || is_single() ) : ?>
                
                    <div class="post-metadata">
                        <span class="post-author">
                            <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a>
                        </span>
                        <?php _e('&#183;'); ?>
                        <span class="post-date">
                            <?php echo get_the_date('n.j.y'); ?>
                        </span>
                        <?php _e('&#183;'); ?>
                        <span class="post-comments">
                            <?php comments_popup_link('No Comments', '1 Comment', '% Comments');?>
                        </span>
                        <?php _e('&#183;'); ?>
                        <span class="edit-post">					
                            <?php edit_post_link('Edit'); ?>
                        </span>
                    </div>
                    
                    <hr class="post-separator">
                    
				<?php endif; ?>
                 
                    <div class="content">   
                        
                        <?php 
							if( is_home() ) {
								the_post_thumbnail( 'blog-home-thumbnail', array('class' => 'blog-home-thumbnail'));
								the_excerpt();
							}
							elseif( is_page() || is_single() ) {
								the_content();
								if( is_page() ) { edit_post_link('Edit Page'); }
							}
						?>
                        
                    </div>
				
                <?php if( is_home() ) : ?>
         
                    <a class="read-more-button" href="<?php echo get_permalink(); ?>">Read More...</a> 
                    
                    <p class="post-category">
                        <?php _e('Posted in&#58;'); ?> <?php the_category(', ') ?>                
                    </p>    
                    
				<?php endif; ?>
				
			</div>
	
			<?php endwhile; ?>
            
            <?php if( is_home() ) : ?>			
            
                <div class="nav-page">
                    <?php posts_nav_link(); ?>
                </div>
                
			<?php endif; ?>
		 
		<?php endif;
	
}

/* Feature Image
------------------------------------------------------------------------ */
add_action( 'feature_image', 'get_feature_image' );

function get_feature_image() {
	
	$url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	
	echo '<div id="feature-image-container" style="background-image: url(' . $url . ' );" ></div>';    

}

/* Social Icons
------------------------------------------------------------------------ */
add_action( 'rt_display_social_icons', 'rt_display_social_icons' );

function rt_display_social_icons() {
	
	if( rt_get_option('rt_facebook') != '' ) { _e( '<a href="' . rt_get_option('rt_facebook') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/facebook-24.png" /></a>' ); }
				if( rt_get_option('rt_twitter') != '' ) { _e( '<a href="' . rt_get_option('rt_twitter') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/twitter-24.png" /></a>' ); }
				if( rt_get_option('rt_linkedin') != '' ) { _e( '<a href="' . rt_get_option('rt_linkedin') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/linkedin-24.png" /></a>' ); }
				if( rt_get_option('rt_pinterest') != '' ) { _e( '<a href="' . rt_get_option('rt_pinterest') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/pinterest-24.png" /></a>' ); }
	
}

/* displays main menu as a dropdown list --- click directs you to that page.
------------------------------------------------------------------------ */
add_action( 'get_main_menu_as_dropdown', 'get_main_menu_as_dropdown' );

function get_main_menu_as_dropdown() {

            $menu_name = 'primary-menu';

            if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
            $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

            $menu_items = wp_get_nav_menu_items($menu->term_id);

            $menu_list = '<select id="main-menu-small">';

            foreach ( (array) $menu_items as $key => $menu_item ) {
                $title = $menu_item->title;
                $url = $menu_item->url;
                $menu_list .= '<option value="' . $url . '">' . $title . '</option>';
            }
            $menu_list .= '</select>';
            } else {
            $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
            }            
            
            echo $menu_list;
	
}

?>