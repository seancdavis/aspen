<?php
	
/* Register Meta Box
------------------------------------------------------------------------- */
add_action( 'add_meta_boxes', 'rt_add_page_layout_metabox' );

function rt_add_page_layout_metabox() {
    add_meta_box('rt_page_layout', 'Page Layout', 'rt_page_layout_meta', 'page', 'normal', 'core');
}

function rt_page_layout_meta() {
	
	global $post;
    
	// Noncename needed to verify where the data originated
    echo '<input type="hidden" name="rt_page_layout_noncename" id="rt_page_layout_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	/* GLOBAL
	------------------------------------------------------------------------- */
	$page_layout = get_post_meta($post->ID, '_page_layout', true);
	if( $page_layout == 'Full-Width' ) $fw = 'checked="checked"';
	else if( $page_layout == 'Right Sidebar' ) $rs = 'checked="checked"';
   	
    // display it ---> ?><br>
	<input type="radio" name="_page_layout" value="Full-Width" <?php print $fw; ?> />
   <label for="_full_width"><i>Full-width</i></label><br><br>
	
	<input type="radio" name="_page_layout" value="Right Sidebar" <?php print $rs; ?> />
	<label for="_right_sidebar"><i>Right Sidebar</i></label>    
    
<?php }

/* save box data
------------------------------------------------------------------------- */
add_action('save_post', 'rt_save_page_layout', 1, 2);

function rt_save_page_layout($post_id, $post) {
	
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['rt_page_layout_noncename'], plugin_basename(__FILE__) )) {
    	return $post->ID;
    }
	
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ) ) return $post->ID;
	
	/* Page Layout
	------------------------------------------------------------------------- */
	$page_meta['_page_layout'] = $_POST['_page_layout'];
	
	/* update or add meta values
	------------------------------------------------------------------------- */
    foreach ($page_meta as $key => $value) { // Cycle through the $feature_meta
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
				
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } 
		else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }		
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
	
	
}
	
?>