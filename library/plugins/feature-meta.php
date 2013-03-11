<?php

/* Register Meta Boxes
------------------------------------------------------------------------- */
add_action( 'add_meta_boxes', 'add_features_metaboxes' );

function add_features_metaboxes() {
    add_meta_box('rt_feature_button_metabox', 'Call To Action Button', 'rt_feature_button', 'rt_feature', 'normal', 'core');
	add_meta_box('rt_feature_background_metabox', 'Change Feature Background', 'rt_feature_background', 'rt_feature', 'side', 'core');
	add_meta_box('rt_disable_feature_metabox', 'Disable (Hide) Feature', 'rt_disable_feature', 'rt_feature', 'side', 'high');
	add_meta_box('rt_feature_order_metabox', 'Order', 'rt_feature_order', 'rt_feature', 'side', 'low');
}


/***************************************************************************/
/***************************************************************************/


/* Display Call To Action Buttons Box
------------------------------------------------------------------------- */
function rt_feature_button() {
    
	global $post;
    
	// Noncename needed to verify where the data originated
    echo '<input type="hidden" name="rt_feature_button_noncename" id="rt_feature_button_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
	// Get the location data if its already been entered
    $button_text = get_post_meta($post->ID, '_button_text', true);
	$button_url = get_post_meta($post->ID, '_button_url', true);
	$button_target = get_post_meta($post->ID, '_button_target', true);
	
	// Control for showing if $button_target checkbox should be checked or not.
	$checked = '';
	if($button_target == 1) {$checked = 'checked="checked"';}
   
    // Display the content within the meta box
	echo '<p>Button Text:</p>';
    echo '<input type="text" name="_button_text" value="' . $button_text  . '" class="widefat" />';
	echo '<p>URL: (<i>where clicking the button takes the user</i>)</p>';
    echo '<input type="text" name="_button_url" value="' . $button_url . '" class="widefat" />';	
	echo '<p><input type="checkbox" name="_button_target" value="1" ' . $checked . ' /><span style="margin-left: 10px;">Open link in new window</span></p>';
	
}

/* save box data
------------------------------------------------------------------------- */
add_action('save_post', 'rt_save_feature_button_meta', 1, 2);

function rt_save_feature_button_meta($post_id, $post) {
	
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['rt_feature_button_noncename'], plugin_basename(__FILE__) )) {
    	return $post->ID;
    }
	
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
	
    // Put data in an array once authenticated (and sanitize as needed)
    $feature_meta['_button_text'] = sanitize_text_field( $_POST['_button_text'] );
	$feature_meta['_button_url'] = sanitize_text_field( $_POST['_button_url'] );
	$feature_meta['_button_target'] = $_POST['_button_target'];
	
	// update info
    foreach ($feature_meta as $key => $value) { // Cycle through the $feature_meta
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


/***************************************************************************/
/***************************************************************************/


/* Change Background Color
------------------------------------------------------------------------- */
function rt_feature_background() {
    
	global $post;
    
	// Noncename needed to verify where the data originated
    echo '<input type="hidden" name="rt_feature_background_noncename" id="rt_feature_background_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
	// Get the location data if its already been entered
    $background_1 = get_post_meta($post->ID, '_background_1', true); 
	$background_2 = get_post_meta($post->ID, '_background_2', true); 
	
	// This needs to be the default color from the plugin settings !!!!!!!!!!
	if($background_1 == ''){ $background_1 = rt_get_feature_option( 'rt_feat_bkg_1' ); }
	if($background_2 == ''){ $background_2 = rt_get_feature_option( 'rt_feat_bkg_2' ); }
	   
    // Display the content within the meta box
	echo '<label for="background_1"> Background Color: <input style="background-color:' . $background_1 . '" type="text" id="rt-farb-input-1" name="_background_1" value="' . $background_1 . '" /></label>';
	echo '<p><i>This value defaults to the value in your theme settings.</i></p>';
	echo '<div id="rt-farb-1"></div>';
	
	echo '<hr><label for="background_2"> Gradient (optional): <input style="background-color:' . $background_2 . '" type="text" id="rt-farb-input-2" name="_background_2" value="' . $background_2 . '" /></label>';
	echo '<p><strong><i>Please note: Choosing a value here will make your background a gradient. It will appear as the bottom color and will blend at 50%. Leaving it blank will display a solid background.</i></strong></p>';
	echo '<div id="rt-farb-2"></div>';
	
}

/* save the meta data (read functions above for more explanation)
------------------------------------------------------------------------- */
add_action('save_post', 'rt_save_feature_background_meta', 1, 2);

function rt_save_feature_background_meta($post_id, $post) {
	
    if ( !wp_verify_nonce( $_POST['rt_feature_background_noncename'], plugin_basename(__FILE__) )) {
    	return $post->ID;
    }
	
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
	
    $feature_meta['_background_1'] = sanitize_text_field( $_POST['_background_1'] );
	$feature_meta['_background_2'] = sanitize_text_field( $_POST['_background_2'] );	
	
    foreach ($feature_meta as $key => $value) {
        if( $post->post_type == 'revision' ) return; 
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		
        if(get_post_meta($post->ID, $key, FALSE)) { 
            update_post_meta($post->ID, $key, $value);
        } 
		else { 
            add_post_meta($post->ID, $key, $value);
        }
		
        if(!$value) delete_post_meta($post->ID, $key); 
    }
	
}


/***************************************************************************/
/***************************************************************************/


/* Disable Feature
------------------------------------------------------------------------- */
function rt_disable_feature() {
    
	global $post;
    
    echo '<input type="hidden" name="rt_disable_feature_noncename" id="rt_disable_feature_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    $disable_feature = get_post_meta($post->ID, '_disable_feature', true);
	
	// Control for showing if checkbox should be checked or not.
	$checked = '';
	if($disable_feature == 1) {$checked = 'checked="checked"';}
   
	echo '<p><input type="checkbox" name="_disable_feature" value="1" ' . $checked . ' /></p>';
	echo '<p><i>Once published, the feature is active by default. Checking the box below will disable the feature, even if published.</i></p>';
	
}

/* save the meta data (read functions above for more explanation)
------------------------------------------------------------------------- */
add_action('save_post', 'rt_save_disable_feature_meta', 1, 2);

function rt_save_disable_feature_meta($post_id, $post) {
	
    if ( !wp_verify_nonce( $_POST['rt_disable_feature_noncename'], plugin_basename(__FILE__) )) {
    	return $post->ID;
    }
	
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
	
    $feature_meta['_disable_feature'] = $_POST['_disable_feature'];
	
	// This is used to sort the table on "All Features" admin page
	if( $feature_meta['_disable_feature'] == '') { $feature_meta['_disable_feature_key'] = 'Active'; }
	else { $feature_meta['_disable_feature_key'] = 'Disabled'; }
	
    foreach ($feature_meta as $key => $value) { 
        if( $post->post_type == 'revision' ) return;
        $value = implode(',', (array)$value); 
		
        if(get_post_meta($post->ID, $key, FALSE)) { update_post_meta($post->ID, $key, $value); } 
		else { add_post_meta($post->ID, $key, $value); }
		
        if(!$value) delete_post_meta($post->ID, $key); 
    }
	
}


/***************************************************************************/
/***************************************************************************/


/* Feature Order
------------------------------------------------------------------------- */
function rt_feature_order() {
    
	global $post;
    
	// Noncename needed to verify where the data originated
    echo '<input type="hidden" name="rt_feature_order_noncename" id="rt_feature_button_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    $order = get_post_meta($post->ID, '_order', true);
	
	if($order == '') {$order = 100;}
   
    // Display the content within the meta box
	echo '<p>Feature Order:&nbsp;&nbsp;<input type="text" size="3" name="_order" value="' . $order  . '" />&nbsp;&nbsp;(default is 20)</p>';
	echo '<p><i>Note: This controls the order in which the features are displayed. This can be more easily controlled from the Re-Order Features page (under Features).</i></p>';
	
}

/* save the data
------------------------------------------------------------------------- */
add_action('save_post', 'rt_save_feature_order_meta', 1, 2);

function rt_save_feature_order_meta($post_id, $post) {
	
    if ( !wp_verify_nonce( $_POST['rt_feature_order_noncename'], plugin_basename(__FILE__) )) {
    	return $post->ID;
    }
	
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;	
	
    $feature_meta['_order'] = sanitize_text_field( $_POST['_order'] );
	
	if( $feature_meta['_order'] < 10 ) { $feature_meta['_order'] = '0' . $feature_meta['_order']; }
	
    foreach ($feature_meta as $key => $value) { 
        if( $post->post_type == 'revision' ) return;
        $value = implode(',', (array)$value);
		
        if(get_post_meta($post->ID, $key, FALSE)) { update_post_meta($post->ID, $key, $value); } 
		else { add_post_meta($post->ID, $key, $value); }
		
        if(!$value) delete_post_meta($post->ID, $key);
    }
	
}

?>