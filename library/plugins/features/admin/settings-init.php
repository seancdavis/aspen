<?php

add_action('admin_menu', 'rt_register_feature_settings');
function rt_register_feature_settings() {
	add_submenu_page('edit.php?post_type=rt_feature', 'Feature Settings', 'Settings', 'manage_options', 'rt_feature_settings', 'rt_features_page');
}

add_action('admin_init', 'rt_feature_admin_init');
function rt_feature_admin_init(){	
	global $rt_feat_settings;
	register_setting( 'rt_features', 'rt_features', 'rt_validate_feat_options' );
	foreach ($rt_feat_settings as $sections => $section) {
		add_settings_section($sections, '', 'feat_settings_section', $sections);
		foreach($section as $field) {
			add_settings_field($field['name'], $field['label'], 'feat_' . $field['type'] . '_field', $sections, $sections, array($field['name'], $field['before'], $field['after']) );
		}
	}	
}

?>