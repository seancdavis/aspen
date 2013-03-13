<?php

/*
 * Controls the drag and drop re-ordering of features.
 *
 * Page is 'Re-Order Features' under the Features Post Type tab
 *
 */

/* Registration --- add submenu page
-------------------------------------------------------------------------------- */
add_action('admin_menu', 'rt_register_feature_order');

function rt_register_feature_order() {
	add_submenu_page('edit.php?post_type=rt_feature', 'Re-Order Features', 'Re-Order Features', 'manage_options', 'rt_feature_order_options', 'rt_features_order');
}

/* Display 'Re-Order Features' page
-------------------------------------------------------------------------------- */
function rt_features_order() { ?>
    
    <div>
    
    	<h2>Re-Order Features</h2>
        <p>Drag and drop to re-order your active features.</p>
    		
		<?php if ($_GET['settings-updated']==true) { _e( '<div id="message" class="updated"><p>Settings updated.</p></div>' ); } ?>
        
        <form action="options.php" method="post">
        	
			<?php settings_fields('rt_features_order'); ?>
        	<?php do_settings_sections('rt_feature_order_options'); ?>
            <?php submit_button(); ?>
        	
        </form>
        
	</div><?php
}


/* Settings Control
-------------------------------------------------------------------------------- */
add_action('admin_init', 'rt_feature_order_admin_init');
 
function rt_feature_order_admin_init(){
	
	// Registers entire page of settings (rt_features_order)
	register_setting( 'rt_features_order', 'rt_features_order', 'rt_validate_feat_order_options' );
	
	// Only one section in this page (rt_feat_order)
	add_settings_section( 'rt_feat_order', '', 'rt_feat_section_order', 'rt_feature_order_options' );	
	
}

// Displays section content
function rt_feat_section_order() {
	
	echo '<ul id="sortable-features">';
	
	$temp_order = 1;
	
	$loop = new WP_Query( array ( 'post_type' => 'rt_feature', 'orderby' => 'meta_value', 'order' => 'ASC', 'meta_key' => '_order', 'posts_per_page' => 100 ) );

		while ( $loop->have_posts() ) : $loop->the_post();			
			
			$disable_feature = get_post_meta( get_the_ID(), '_disable_feature', true );
			
			if( $disable_feature == 0 ) :
			
			$order = get_post_meta( get_the_ID(), '_order', true );
			
				the_title( '<li class="active-feature" id="feature_' . $temp_order . '_' . get_the_ID() . '">', '&nbsp;<input style="display:none;" id="input_' . get_the_ID() . '" type="text" size="5" name="_order_' . get_the_ID() . '" value="' . $order . '"/></li>' );				
					
					$order = $temp_order; 
					
					$temp_order++;
			
			endif;
			
		endwhile;
	
	echo '</ul><div id="results"></div>';
}

/* Validate Options (how the settings are saved)
-------------------------------------------------------------------------------- */
function rt_validate_feat_order_options() {	
	
	$loop = new WP_Query( array ( 'post_type' => 'rt_feature', 'orderby' => 'meta_value', 'order' => 'ASC', 'meta_key' => '_order', 'posts_per_page' => '100' ) );

		while ( $loop->have_posts() ) : $loop->the_post();	
		
			$disable_feature = get_post_meta( get_the_ID(), '_disable_feature', true );
			
			if( $disable_feature == 0 ) :
			
				update_post_meta( get_the_ID(), '_order', $_POST['_order_' . get_the_ID()] );
			
			endif;
			
		endwhile;
}

?>