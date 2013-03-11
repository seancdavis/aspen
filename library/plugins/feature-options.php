<?php

/**
 * Feature Settings
 *
 */

/* Registration
-------------------------------------------------------------------------------- */
add_action('admin_menu', 'rt_register_feature_settings');

function rt_register_feature_settings() {
	add_submenu_page('edit.php?post_type=rt_feature', 'Feature Settings', 'Settings', 'manage_options', 'rt_feature_options', 'rt_features_page');
}

/* Set Default Values and return option value
-------------------------------------------------------------------------------- */
function rt_get_feature_option( $option_name ) {
	
	$defaults = array(
		'rt_feat_bkg_1' => '#ccc',
		'rt_feat_bkg_2' => '#'
	);
	
	$options = get_option( 'rt_features' );
	
	if( $options[$option_name] == '' ) {
		return $defaults[$option_name];
	}
	else {
		return $options[$option_name];
	}
}


/* Display theme Options Page
-------------------------------------------------------------------------------- */
function rt_features_page() { ?>
    
    <div>
    
        <h1>Feature Options</h1>
		
		<?php if ($_GET['settings-updated']==true) { _e( '<div id="message" class="updated"><p>Settings updated.</p></div>' ); } ?>
        
        <form action="options.php" method="post">
        	
			<?php settings_fields('rt_features'); ?>
        	<?php do_settings_sections('rt_feature_options'); ?>
         	<?php submit_button(); ?>
        	
        </form>
	
    </div><?php
}


/* Settings Control
-------------------------------------------------------------------------------- */
add_action('admin_init', 'rt_feature_admin_init');

/**
 * Registration of each setting field and section
 */
 
function rt_feature_admin_init(){
	
	/* Registers entire page of settings (rt_features)
	-------------------------------- */
	register_setting( 'rt_features', 'rt_features', 'rt_validate_feat_options' );
	
	/* Register Section (rt_feature_default_background)
	-------------------------------- */
	add_settings_section( 'rt_feat_bkg', 'Background Colors', 'rt_feat_section_bkg', 'rt_feature_options' );	
	add_settings_field('rt_feat_bkg_1', 'Background Color:', 'rt_feat_field_bkg_1', 'rt_feature_options', 'rt_feat_bkg');
	add_settings_field('rt_feat_bkg_2', 'Secondary (Gradient) Color (optional):', 'rt_feat_field_bkg_2', 'rt_feature_options', 'rt_feat_bkg');
	
}

/* Default Background Settings Callback Functions (rt_default_background) --- what gets displayed on the page
-------------------------------------------------- */
// Section heading
function rt_feat_section_bkg() {
	echo '<p>You can set the default background color for your slider here. The colors can be changed for each feature on the Add/Edit Feature page.</p>';
}

// Field 1
function rt_feat_field_bkg_1() {
	echo '<p><i>Click in the box to make color wheel appear.</i></p>';
	echo "<input style='background-color: " . rt_get_feature_option( 'rt_feature_default_background_1' ) . ";' id='rt-farb-input-1' name='rt_features[rt_feat_bkg_1]' size='40' type='text' value='" . rt_get_feature_option( 'rt_feat_bkg_1' ) . "' />";	
	echo '<p><i>Please only use <a href="http://www.w3schools.com/html/html_colors.asp" target="_blank">HEX values</a>.</i></p>';
	echo '<div id="rt-farb-1"></div>'; // container for color wheel
}

// Field 2
function rt_feat_field_bkg_2() {
	echo "<input style='background-color: " . rt_get_feature_option( 'rt_feature_default_background_2' ) . ";' id='rt-farb-input-2' name='rt_features[rt_feat_bkg_2]' size='40' type='text' value='" . rt_get_feature_option( 'rt_feat_bkg_2' ) . "' />";
	echo '<p><i>Please only use <a href="http://www.w3schools.com/html/html_colors.asp" target="_blank">HEX values</a>.</i></p>';
	echo '<div id="rt-farb-2"></div>'; // container for color wheel
	echo '<p style="width: 400px;"><strong>Please note: The secondary color will be used as a gradient for your sliders. If you fill this out, all of your features will have a gradient by default. This color will appear on the bottom of the section.</strong></p>';
	
	// Displays preview of background
	echo '<h4>Preview (save to view preview)</h4>';
	
	$this_bkg_1 = rt_get_feature_option( 'rt_feat_bkg_1' );
	$this_bkg_2 = rt_get_feature_option( 'rt_feat_bkg_2' );
	
	if( $this_bkg_2 == '#' ) {
		echo '<div id="bkg_preview" style="height: 100px; width: 200px; background-color:' . $this_bkg_1 . ';"></div>';
	} 
	else {					
		echo '<div id="bkg_preview" style="height: 100px; width: 200px; background-color: ' . $this_bkg_1 . '; background-image: -webkit-gradient(linear, left top, left bottom, from(' . $this_bkg_1 . '), to(' . $this_bkg_2 . ')); background-image: -webkit-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . ');	background-image: -moz-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . ');	background-image: -ms-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . '); background-image: -o-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . '); background-image: linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . '); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=' . $this_bkg_1 . ', endColorstr=' . $this_bkg_2 . ');"></div>';					
	}
	
}

/* Validate Options (and save settings)
-------------------------------------------------------------------------------- */
function rt_validate_feat_options($input) {	

	$input['rt_feat_bkg_1'] = sanitize_text_field($input['rt_feat_bkg_1']);
	$input['rt_feat_bkg_2'] = sanitize_text_field($input['rt_feat_bkg_2']);
	
	$default_bkg_1 = rt_get_feature_option('rt_feat_bkg_1');
	$default_bkg_2 = rt_get_feature_option('rt_feat_bkg_2');
	
	// We also have to update post meta for those features that had the default value
	$loop = new WP_Query( array ( 'post_type' => 'rt_feature' ) );

		while ( $loop->have_posts() ) : $loop->the_post();	
		
			$old_bkg_1 = get_post_meta( get_the_ID(), '_background_1', true );
			$old_bkg_2 = get_post_meta( get_the_ID(), '_background_2', true );
			
			if( $old_bkg_1 == $default_bkg_1 ) { update_post_meta( get_the_ID(), '_background_1', $input['rt_feat_bkg_1'] ); }
			if( $old_bkg_2 == $default_bkg_2 ) { update_post_meta( get_the_ID(), '_background_2', $input['rt_feat_bkg_2'] ); }
			
		endwhile;
		
	return $input;
}

?>