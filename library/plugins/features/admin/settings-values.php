<?php 

global $rt_feat_settings;

$rt_feat_settings = array(
	'throw_me_away' => array(), // my foreach loop was not picking up first key here. This keeps it running.
	'feat_global_settings' => array(
		'feature_type' => array(
			'name' => 'feature_type',
			'label' => 'Feature Type:',
			'type' => 'radio',
			'default' => 'simple-slider',
			'choices' => array('simple-slider', 'free-form'),
			'choice_labels' => array('Simple Slider (entire feature slides)', 'Free Form (text and featured image move separately)'),
			'before' => '<p><i>Determines the type of animation for your feature</i></p>'
		),
		'slider_width' => array(
			'name' => 'slider_width',
			'label' => 'Feature Width:',
			'type' => 'radio',
			'default' => 'standard',
			'choices' => array('standard', 'full-width'),
			'choice_labels' => array('Standard (80% width)', 'Full Width')
		),
		'bkg_type' => array(
			'name' => 'bkg_type',
			'label' => 'Background Type:',
			'type' => 'radio',
			'default' => 'color',
			'choices' => array('color','gradient','transparent'),
			'choice_labels' => array('Solid Color', 'Gradient', 'Transparent (no background color)')
		),
		'bkg_color' => array(
			'name' => 'bkg_color',
			'label' => 'Background Color:',
			'type' => 'color',
			'default' => '#fff',
			'after' => '<p><i>Please note: this is the color of the background behind the features. It is the full width of the window. If you have chosen the Full Width option, individual feature background colors will cover this color.</i></p>'
		),
	),
	'feat_content_settings' => array(
		'bkg_color_lock' => array(
			'name' => 'bkg_color_lock',
			'label' => 'Lock Individual Background Colors:',
			'type' => 'checkbox',
			'default' => false,
			'choice_labels' => '<img width="20" src ="'.get_template_directory_uri().'/images/icons/locked.png'.'" />',
			'after' => '<p><i>With the simple slider, you are able to color the background of each feature (controlled from the edit feature page). This enables you to lock that option, so all features reflect the background color of the feature container. <b>This does not affect you unless using simple slider.</b></i></p>'
		),
		'text_display' => array (
			'name' => 'text_display',
			'label' => 'Text Display Type:',
			'type' => 'radio',
			'default' => 'flat',
			'choices' => array('flat', 'box', 'none'),
			'choice_labels' => array('Normal', 'Box (displays content and call to action button in box with background-color option)', 'No Content')
		),
		'box_bkg_color' => array(
			'name' => 'box_bkg_color',
			'label' => 'Box Background Color (if necessary):',
			'type' => 'color',
			'default' => '#000',
			'after' => '<p><i>Only applies to <b>Box Text Display Type</b>.</i></p>'
		),
		'text_color' => array(
			'name' => 'text_color',
			'label' => 'Text Color:',
			'type' => 'color',
			'default' => '#fff',
			'after' => '<p><i>Please note: this does not color the button text. See below for Button Text option.</i></p>'
		),
		'linked_content' => array(
			'name' => 'linked_content',
			'label' => 'Linked Content:',
			'type' => 'radio',
			'default' => 'none',
			'choices' => array('content', 'button', 'none'),
			'choice_labels' => array('Entire feature is a link', 'Call to Action Button', 'No linked content'),
			'after' => '<p><i>Please note: Call to action buttons must be enabled here if you wish to use them on any feature (though they are not required on every feature if you select here). The text and URL of each button is controlled when editing or adding a feature. </i></p>'
		),
		'button_bkg_color' => array(
			'name' => 'button_bkg_color',
			'label' => 'Button Background Color:',
			'type' => 'color',
			'default' => '#000',
			'after' => '<p><i>This should be the main background color you wish to use. The gradient and hover effects are figured out for you.</i><p>'
		),
		'button_text_color' => array(
			'name' => 'button_text_color',
			'label' => 'Button Text Color:',
			'type' => 'color',
			'default' => '#fff',
			'after' => '<div id="preview-button_text_color"><a class="call-to-action">Click to Preview</a></div><p style="clear:both;"><i>Please note: This preview is meant as a color comparison. Gradients and hover effects are not shown here.</i></p>'
		)
	),
	'feat_slider_settings' => array(
		'counter_type' => array(
			'name' => 'counter_type',
			'label' => 'Feature Counter Type:',
			'type' => 'radio',
			'default' => 'circles',
			'choices' => array('circles', 'numbers', 'none'),
			'choice_labels' => array('Circles', 'Numbers', 'No Counters'),
			'after' => '<p><i>Show the number of features and enable users to jump to a particular feature</i></p>'
		),
		'inactive_counter_color' => array(
			'name' => 'inactive_counter_color',
			'label' => 'Counter Background Color - <b>STANDARD</b>:',
			'type' => 'color',
			'default' => '#fff'
		),
		'active_counter_color' => array(
			'name' => 'active_counter_color',
			'label' => 'Counter Background Color - <b>ACTIVE</b>:',
			'type' => 'color',
			'default' => '#000',
			'after' => '<p><i>The background color of the counter corresponding to the feature currently being displayed.</i></p>'
		),
		'hover_counter_color' => array(
			'name' => 'hover_counter_color',
			'label' => 'Counter Background Color - <b>HOVER EFFECT</b>:',
			'type' => 'color',
			'default' => '#000'
		),
		'counter_text_color' => array(
			'name' => 'counter_text_color',
			'label' => 'Counter Text Color (if necessary):',
			'type' => 'color',
			'default' => '#000',
			'after' => '<p><i>Only applies if you have selected Numbers counter type.</i></p>'
		),
		'counter_border_color' => array(
			'name' => 'counter_border_color',
			'label' => 'Counter <b>Border</b> Color',
			'type' => 'color',
			'default' => '#ccc',
		),
		'arrows_type' => array(
			'name' => 'arrows_type',
			'label' => 'Arrows Type',
			'type' => 'radio',
			'default' => 'small',
			'choices' => array('small', 'full-height', 'none'),
			'choice_labels' => array('Normal', 'Full Height', 'No Arrows'),
			'after' => '<p><i>Arrows enable your visitors to toggle through your features one at a time. The type here refers to the height of the backgorund. </i></p>'
		),
		'arrows_color' => array(
			'name' => 'arrows_color',
			'label' => 'Arrows Color',
			'type' => 'radio',
			'default' => 'white',
			'choices' => array('white', 'grey', 'black'),
			'choice_labels' => array('White', 'Grey (50%)', 'Black'),
			'after' => '<p><i>Color of the arrow itself. These are the only options since the arrow in an image.</i></p>'
		),
		'arrows_bkg_color' => array(
			'name' => 'arrows_bkg_color',
			'label' => 'Arrows Background Color',
			'type' => 'color',
			'default' => '',
			'after' => '<p><i>Leaving this blank will make the background transparent.</p><p>Please note: if you chose Full Height, your background will be semi-transparent.</i></p>'
		),
		'arrows_hover_color' => array(
			'name' => 'arrows_hover_color',
			'label' => 'Arrows Hover Effect',
			'type' => 'color',
			'default' => '#000',
			'after'=> '<p><i>Changes the <b>background</b> of the arrow on hover.</i></p>'
		),
	)
);

function get_feat_option_value( $option_name ) {
	$current_options = get_option('rt_features');
	// first if statement is a catch to help control navigation of settings page
	if( $option_name == 'feat_nav_control' ) {
		if( $current_options[$option_name] == '' ) '';		
		else return $current_options[$option_name];
	}
	else {
		global $rt_feat_settings;
		foreach ($rt_feat_settings as $sections) {
			foreach($sections as $section) {
				if( $section['name'] == $option_name ) $default = $section['default'];
			}
		}
		if( $current_options[$option_name] == '' ) return $default;
		else return $current_options[$option_name];
	}
}

function get_feat_option_choices( $option_name ) {
	global $rt_feat_settings;
	foreach ($rt_feat_settings as $sections) {
		foreach($sections as $section) {
			if( $section['name'] == $option_name ) $choices = $section['choices'];
		}
	}
	return $choices;
}

function get_feat_option_labels( $option_name ) {
	global $rt_feat_settings;
	foreach ($rt_feat_settings as $sections) {
		foreach($sections as $section) {
			if( $section['name'] == $option_name && $section['choice_labels'] == '' ) $choices = $section['label']; 
			else if( $section['name'] == $option_name ) $choices = $section['choice_labels'];
		}
	}
	return $choices;
}

?>