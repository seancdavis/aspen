<?php

/* 
 * Returns the name of the section id. 
 * ---------------------------------------------------------------
 * This is built 100% on the foundation of feat_{id}_settings.
 * The settings page will look super weird if this isn't followed.
 * 
 */
function get_feat_section_name($id) {
	$name = substr( $id, 5, strlen( $id ) - 14 );
	$name = strtoupper( substr($name, 0, 1) ) . substr($name, 1);	
	return $name;
}

function rt_features_page() { ?>
    
    <div>
    
        <h1>Feature Settings</h1>
        
		<?php if ($_GET['settings-updated']==true) { _e( '<div id="message" class="updated"><p>Settings updated.</p></div>' ); } ?>
        
        <form action="options.php" method="post">    
        	<input hidden type="text" id="feat_nav_control" name="rt_features[feat_nav_control]" value="<?php if( $_GET['settings-updated'] == true ) echo get_feat_option_value('feat_nav_control'); ?>" />
        	<?php global $rt_feat_settings;
			$tab_control = 1;
			settings_fields('rt_features');
        	do_settings_sections('feat_settings_setup');
			foreach ($rt_feat_settings as $sections) {
				$name = get_feat_section_name( key($rt_feat_settings) ); ?>					
				<a class="feature-settings-tab <?php if( $tab_control == 1 ) echo 'feature-settings-tab-selected'; ?>" id="tab_<?php echo key($rt_feat_settings); ?>"><?php echo $name; ?></a><?php
				$tab_control++; 
			}
			$tab_control = 1;
    		foreach ($rt_feat_settings as $sections) {    			    			
    			$name = get_feat_section_name( key($rt_feat_settings) ); ?>					
				<div class="feature-settings-section <?php if( $tab_control == 1 ) echo 'feature-settings-section-selected'; ?>" id="<?php echo key($rt_feat_settings); ?>">
					<h2><?php echo $name; ?></h2>
					<?php do_settings_sections( key($rt_feat_settings) ); ?>
				</div><?php 
				$tab_control++;
			}			
			submit_button(); ?>
        	
        </form>
	
    </div><?php
}

function feat_settings_section() {}

function feat_text_field( $args ) {
	echo $args[1]; // before content
	$option_name = $args[0];
	$current_option = get_feat_option_value($option_name);
	?><input id="<?php echo $option_name; ?>" type="text" name="rt_features[<?php echo $option_name; ?>]" value="<?php echo $current_option; ?>" ><?php
	echo $args[2]; // after content
}


function feat_radio_field( $args ) {
	echo $args[1]; // before content
	$option_name = $args[0];
	$options = get_feat_option_choices($option_name);
	$labels = get_feat_option_labels($option_name);
	$current_option = get_feat_option_value($option_name);	
	for( $i = 0; $i < count($options); $i++ ) {
		?><input id="radio-<?php echo $options[$i]; ?>" type="radio" name="rt_features[<?php echo $option_name; ?>]" value="<?php echo $options[$i]; ?>" <?php if($current_option == $options[$i]) echo 'checked="checked"'; ?>>
		<label for="radio-<?php echo $options[$i]; ?>"><?php if( is_array($labels) ) echo $labels[$i]; else echo $options[$i]; ?></label><br><?php
	}
	echo $args[2]; // after content
}

function feat_checkbox_field( $args ) {
	echo $args[1]; // before content
	$option_name = $args[0];
	$current_option = get_feat_option_value($option_name);
	$label = get_feat_option_labels($option_name);
	?><input id="checkbox-<?php echo $option_name; ?>" value=true type="checkbox" name="rt_features[<?php echo $option_name; ?>]" <?php if( $current_option == true ) echo 'checked="checked"';?> >
	<label for="checkbox-<?php echo $option_name; ?>" id="label-<?php echo $option_name; ?>"><?php echo $label; ?></label><?php
	echo $args[2]; // after content
}

function feat_color_field( $args ) {
	echo $args[1]; // before content
	$option_name = $args[0];
	?><input id="color-<?php echo $option_name; ?>" class="feat-color" name="rt_features[<?php echo $option_name; ?>]" size="40" type="text" value="<?php echo get_feat_option_value($option_name); ?>"><?php
	echo $args[2]; // after content
}

function rt_validate_feat_options($input) {
	//$input['std_rt_feat_bkg'] = sanitize_text_field($input['std_rt_feat_bkg']);	
	$_GET['feat_nav_control'];	
	return $input;
}

?>