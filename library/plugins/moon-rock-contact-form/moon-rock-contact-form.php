<?php

// Include all necessary files.
define( 'RT_MRCF', get_template_directory() . '/library/plugins/moon-rock-contact-form' );
require_once( RT_MRCF . '/admin/registration.php' );
require_once( RT_MRCF . '/admin/options.php' );	
require_once( RT_MRCF . '/content/display-form.php' );
require_once( RT_MRCF . '/widget/widgets.php' );


if( $_GET['page'] == 'rt_mrcf_options' ) add_action( 'admin_enqueue_scripts', 'load_rt_mrcf_admin_scripts' );	
function load_rt_mrcf_admin_scripts() {
	$rt_mrcf_dir = get_template_directory_uri() . '/library/plugins/moon-rock-contact-form';
	wp_enqueue_script( 'feature-options', $rt_mrcf_dir . '/admin/options.js', array('jquery') );	
}

?>