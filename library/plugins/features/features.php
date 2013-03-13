<?php

// Include all necessary files.
require_once( plugin_dir_path( __FILE__ ) . '/admin/registration.php' );
require_once( plugin_dir_path( __FILE__ ) . '/admin/settings-content.php' );
require_once( plugin_dir_path( __FILE__ ) . '/admin/settings-values.php' );
require_once( plugin_dir_path( __FILE__ ) . '/admin/settings-init.php' );
require_once( plugin_dir_path( __FILE__ ) . '/admin/meta.php' );
require_once( plugin_dir_path( __FILE__ ) . '/content/display-feature.php' );
require_once( plugin_dir_path( __FILE__ ) . '/admin/re-order.php' );		

// load OPTIONS scrips
if( $_GET['page'] == 'rt_feature_settings' ) add_action( 'admin_enqueue_scripts', 'load_rt_feat_option_admin_scripts' );	
function load_rt_feat_option_admin_scripts() {
	$rt_feat_dir = get_template_directory_uri() . '/library/plugins/features';
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'feature-settings', $rt_feat_dir . '/admin/settings.js', array('jquery', 'farbtastic', 'wp-color-picker') );	
	wp_enqueue_style( 'feature-settings', $rt_feat_dir . '/admin/settings.css' );
}

// load REORDER OPTIONS scripts
if( $_GET['page'] == 'rt_feature_order_options' ) add_action( 'admin_enqueue_scripts', 'load_rt_feat_reorder_options' );	
function load_rt_feat_reorder_options() {
	$rt_feat_dir = get_template_directory_uri() . '/library/plugins/features';
	wp_enqueue_script( 'jquery-ui', 'http://code.jquery.com/ui/1.9.2/jquery-ui.js', array('jquery') );
	wp_enqueue_script( 're-order', $rt_feat_dir . '/admin/re-order.js', array('jquery','jquery-ui') );
	wp_enqueue_style( 'feature-order', $rt_feat_dir . '/admin/re-order.css' );
}

// Load POST META scripts
if( $_GET['action'] == 'edit' ) add_action( 'admin_enqueue_scripts', 'load_feat_meta' );	
function load_feat_meta() {
	$rt_feat_dir = get_template_directory_uri() . '/library/plugins/features';
	wp_enqueue_style( 'feature-meta', $rt_feat_dir . '/admin/meta.css' );
	wp_enqueue_script('feature-meta', $rt_feat_dir . '/admin/meta.js', array('jquery') );
}

?>