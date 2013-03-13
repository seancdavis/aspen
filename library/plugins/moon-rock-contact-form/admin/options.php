<?php

/* Registration
-------------------------------------------------------------------------------- */
add_action('admin_menu', 'rt_register_mrcf_settings');

function rt_register_mrcf_settings() {
	add_submenu_page('edit.php?post_type=rt_mrcf', 'Contact Form Settings', 'Settings', 'manage_options', 'rt_mrcf_options', 'rt_mrcf_page');
}

/* Set Default Values and return option value
-------------------------------------------------------------------------------- */
function rt_get_mrcf_option( $option_name ) {	
	$defaults = array(
		'email_notification' => 'Off',
		'to' => 'you@yourdomain.com',
	);	
	$options = get_option( 'rt_mrcf' );	
	if( $options[$option_name] == '' ) return $defaults[$option_name];
	else return $options[$option_name];
}


/* Display theme Options Page
-------------------------------------------------------------------------------- */
function rt_mrcf_page() { ?>
    
    <div>
    
        <h1>Contact Form Settings</h1>
		
		<?php if ($_GET['settings-updated']==true) _e( '<div id="message" class="updated"><p>Settings updated.</p></div>' ); ?>
        
        <form action="options.php" method="post">
        	
			<?php settings_fields('rt_mrcf'); ?>
			<div class="rt-option-section" id="email-options"><?php do_settings_sections('rt_mrcf_email_options'); ?></div>
         	<?php submit_button(); ?>
        	
        </form>
	
    </div><?php
}


/* Settings Control
-------------------------------------------------------------------------------- */
add_action('admin_init', 'rt_mrcf_admin_init');
 
function rt_mrcf_admin_init(){
	
	/* Registers entire page of settings (rt_mrcf)
	-------------------------------- */
	register_setting( 'rt_mrcf', 'rt_mrcf', 'rt_validate_mrcf_options' );
	
	/* Register Section (rt_mrcf_email)
	-------------------------------- */
	add_settings_section( 'rt_mrcf_email', 'Email Settings', 'rt_mrcf_email_section', 'rt_mrcf_email_options' );	
	add_settings_field('rt_mrcf_email_notification', 'Email Notifications:', 'rt_mrcf_email_notification', 'rt_mrcf_email_options', 'rt_mrcf_email');
	add_settings_field('rt_mrcf_to', 'Send Email To:', 'rt_mrcf_to', 'rt_mrcf_email_options', 'rt_mrcf_email');
	
}

/* Display Settings on Page
-------------------------------------------------- */


/* rt_email_email
-------------------------------- */
function rt_mrcf_email_section() {
	echo '<p>Choose the type of feature you would like to display. The options below will change based on your choice.</p>';
}

function rt_mrcf_email_notification() {	
	$notifications = array('On', 'Off');	
	echo '<select id="rt-email-notification" name="rt_mrcf[email_notification]">';	
	foreach( $notifications as $notification ) {
		$selected = '';
		if( rt_get_mrcf_option( 'email_notification' ) == $notification ) $selected = "selected='selected'";		
		echo '<option value="' . $notification . '" ' . $selected . '>' . $notification . '</option>';
	}	
	echo '</select>';
}

function rt_mrcf_to() { ?>
	<input class="email-options" type="text" size="30" name="rt_mrcf[to]" value="<?php echo rt_get_mrcf_option('to'); ?>">
<?php }

/* Validate Options (and save settings)
-------------------------------------------------------------------------------- */

function rt_validate_mrcf_options($input) {		
	return $input;
} 

?>