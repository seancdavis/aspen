<?php

/* Register Meta Box
------------------------------------------------------------------------- */
add_action( 'add_meta_boxes', 'add_feature_metabox' );
function add_feature_metabox() {
    add_meta_box('rt_feature_metabox', 'Custom Settings', 'rt_feature_options', 'rt_feature', 'normal', 'core');
}

add_action( 'admin_enqueue_scripts', 'load_meta_scripts' );	
function load_meta_scripts() {
	$rt_feat_dir = get_template_directory_uri() . '/library/plugins/features';
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'feature-settings', $rt_feat_dir . '/admin/settings.js', array('jquery', 'farbtastic', 'wp-color-picker') );	
}

/* Display Meta Boxes on Post Edit Page
 * 
 * Should really consider making meta values dynamic like settings
------------------------------------------------------------------------- */
function rt_feature_options() {
    
	global $post;
    
	// Noncename needed to verify where the data originated
    echo '<input type="hidden" name="rt_feature_options_noncename" id="rt_feature_options_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
  	
	/* DISABLE FEATURE
	------------------------------------------------------------------------- */
	$disable_feature = get_post_meta($post->ID, '_disable_feature', true);	
	$disable_feature_checked = ''; // Control for showing if checkbox should be checked or not.
	if($disable_feature == 1) $disable_feature_checked = 'checked="checked"'; ?>    
    <h4 class="feature-sub-title">Deactivate Feature</h4>
	<input type="checkbox" name="_disable_feature" value="1" <?php print $disable_feature_checked; ?> />
    <label for="_disable_feature"><i>Once published, the feature is active by default. Checking the box below will disable the feature, even if published.</i></label><?php
	
	
	/* BUTTON AND LINKS
	------------------------------------------------------------------------- */
	$button_text = get_post_meta($post->ID, '_button_text', true); 
	$linked_content = get_post_meta($post->ID, '_linked_content', true);
	$link_new_window = get_post_meta($post->ID, '_link_new_window', true);
	$opt_linked_content = get_feat_option_value('linked_content'); 
	if( $opt_linked_content == 'content') { ?><h4 class="feature-sub-title">Link to Site Content</h4><?php }
	else if( $opt_linked_content == 'button' ) { ?>
		<h4 class="feature-sub-title">Call to Action Button</h4>
		<label for="_button_text">Text: </label>
		<input type="text" name="_button_text" value="<?php print $button_text; ?>" size="50"><br><br>
	<?php }
	if( $opt_linked_content == 'content' || $opt_linked_content == 'button' ) { ?>
		    <label for="_linked_content">URL:</label>
			<input id="_linked_content" type="text" name="_linked_content" value="<?php echo $linked_content; ?>" size="50" />
		    <input type="checkbox" name="_link_new_window" value="1" <?php if($link_new_window == 1) echo 'checked="checked"'; ?> />
			<label for="_link_new_window">Open link in new window</label>
	<?php }	
	
	// loop existing pages and posts
	$loop = new WP_Query( array ( 'post_type' => array( 'post', 'page' ), 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => 100 ) ); ?>
	<p class="show-existing-content-list">Or click to choose from existing content...</p>
	<uL class="existing-content-list"><?php
		while ( $loop->have_posts() ) : $loop->the_post(); ?>		
			<li id="<?php echo get_permalink(); ?>" class="existing-content-item">
				<span class="existing-content-link-title"><?php echo the_title(); ?></span>
				<span class="existing-content-post-type"><?php echo strtoupper( get_post_type() ); ?></span>
			</li><?php
			// the_title( '<li id="'.get_permalink().'">', ' ('.get_post_type().')</li>' );
		endwhile; ?>
	</ul><?php
	
	/* BACKGROUND COLOR
	------------------------------------------------------------------------- */
	$bkg_color = get_post_meta($post->ID, '_bkg_color', true); 
	if( get_feat_option_value('bkg_color_lock') == false ) : ?>
		<h4 class="feature-sub-title">Background Color</h4>
		<input class="feat-color" name="_bkg_color" size="40" type="text" value="<?php echo $bkg_color; ?>">
	<?php endif;		
}

/* save box data
------------------------------------------------------------------------- */
add_action('save_post', 'rt_save_feature_options_meta', 1, 2);

function rt_save_feature_options_meta($post_id, $post) {
	
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['rt_feature_options_noncename'], plugin_basename(__FILE__) )) {
    	return $post->ID;
    }
	
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ) ) return $post->ID;
	
	$feature_meta['_disable_feature'] = $_POST['_disable_feature'];
	// This is used to sort the table on "All Features" admin page
	if( $feature_meta['_disable_feature'] == '') $feature_meta['_disable_feature_key'] = 'Active'; 
	else $feature_meta['_disable_feature_key'] = 'Disabled';
	$feature_meta['_linked_content'] = sanitize_text_field( $_POST['_linked_content'] );
	$feature_meta['_link_new_window'] = $_POST['_link_new_window'];
	$feature_meta['_bkg_color'] = sanitize_text_field( $_POST['_bkg_color'] );
	$feature_meta['_button_text'] = sanitize_text_field( $_POST['_button_text'] );
	
	$feature_order = get_post_meta($post->ID, '_order', true);
	if( $feature_order == '' ) $feature_order = 20;
	$feature_meta['_order'] = $feature_order;
	
	
	/* update or add meta values
	------------------------------------------------------------------------- */
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

?>