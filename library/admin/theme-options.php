<?php
/**
 * Theme Options for Aspen Theme
 *
 */

/* Registration
-------------------------------------------------------------------------------- */
add_action('admin_menu', 'rt_register_settings');

function rt_register_settings() {
	add_theme_page('Custom rocktree Settings', 'Theme Options', 'manage_options', 'rt_theme_options', 'rt_options_page');
}


/* Set Default Values
-------------------------------------------------------------------------------- */
function rt_get_option( $option_name ) {
	
	$defaults = array(
		'rt_css' => '/* Add your custom CSS here: */',
		'rt_font' => 'default',
		'rt_logo' => '',
		'rt_logo_width' => '200',
		'rt_logo_height' => '200',
		'rt_facebook' => '',
		'rt_twitter' => '',
		'rt_linkedin' => '',
		'rt_pinterest' => '',
	);
	
	$options = get_option( 'rt_options' );
	
	if( $options[$option_name] == '' ) {
		return $defaults[$option_name];
	}
	else {
		return $options[$option_name];
	}
}


/* Theme Options Page
-------------------------------------------------------------------------------- */
function rt_options_page() { ?>
    
    <div>
    
        <h2>rocktree Theme Settings</h2>
        <p>Use these options to customize your site to fit your needs. To request new options, please email <a href="mailto:scdavis41@gmail.com">the theme designer</a>.</p>
		
		<?php if ($_GET['settings-updated']==true) { _e( '<div id="message" class="updated"><p>Settings updated.</p></div>' ); } ?>
        
        <form action="options.php" method="post">
        	
			<?php settings_fields('rt_options'); ?>
        	<?php do_settings_sections('rt_theme_options'); ?>
         	<?php submit_button(); ?>
        	
        </form>
	
    </div><?php
}


/* Settings Control
-------------------------------------------------------------------------------- */
add_action('admin_init', 'rt_admin_init'); // adds the settings

/**
 * Registration of each setting field and section
 *
 * add_setting_section() is the control for a group of fields
 *
 * add_settings_field() is the control for a field --> gets added for each field
 *
 */
function rt_admin_init(){
	/* Registers entire page of settings (rt_options)
	-------------------------------- */
	register_setting( 
		'rt_options',					// ref for all options
		'rt_options', 
		'rt_validate_options' 			// function that validates all options
	);
	
	/* Global Settings (rt_global)
	-------------------------------- */
	
	/* NOT READY TO RELEASE THESE OPTIONS YET, BUT DON'T WANT TO LOSE THEM
	
	add_settings_section(
		'rt_global', 					// ID
		'Global Settings',		 		// Title (what is displayed on the page)
		'rt_section_global',		 	// Callback (function that displays content)
		'rt_theme_options'				// Page (page on which to display the setting) 
	);	
	add_settings_field(
		'rt_css', 						// ID
		'Add Custom CSS', 				// Title (shown as the label on the page)
		'rt_field_css', 				// Callback (function that displays content)
		'rt_theme_options', 			// Page (page on which to display the content)
		'rt_global'						// Section (ref ID of section to attach field)
	);	
	add_settings_field('rt_font', 'Site Font', 'rt_field_font', 'rt_theme_options', 'rt_global');
	*/
	
	/* Header Settings (rt_header)
	-------------------------------- */
	add_settings_section( 'rt_header', 'Header Settings', 'rt_section_header', 'rt_theme_options' );	
	add_settings_field('rt_logo', 'Custom Logo (replaces site title)', 'rt_field_logo', 'rt_theme_options', 'rt_header');
	add_settings_field('rt_logo_width', 'Max. Logo Width', 'rt_field_logo_width', 'rt_theme_options', 'rt_header');
	add_settings_field('rt_logo_height', 'Max. Logo Height', 'rt_field_logo_height', 'rt_theme_options', 'rt_header');
	
	/* Social Settings (rt_social)
	-------------------------------- */
	add_settings_section( 'rt_social', 'Social Settings', 'rt_section_social', 'rt_theme_options' );	
	add_settings_field('rt_facebook', 'Facebook', 'rt_field_facebook', 'rt_theme_options', 'rt_social');
	add_settings_field('rt_twitter', 'Twitter', 'rt_field_twitter', 'rt_theme_options', 'rt_social');
	add_settings_field('rt_linkedin', 'LinkedIn', 'rt_field_linkedin', 'rt_theme_options', 'rt_social');
	add_settings_field('rt_pinterest', 'Pinterest', 'rt_field_pinterest', 'rt_theme_options', 'rt_social');
}

/* Global Settings Callback Functions (rt_global) 
-------------------------------------------------- */
function rt_section_global() {
	_e( '<p>These general settings will help you style your site.</p>' );
}

function rt_field_css() {
	_e( "<textarea id='rt_logo' name='rt_options[rt_css]' style='width: 300px; height: 200px;'>" . rt_get_option( 'rt_css' ) . "</textarea>" );
}

function rt_field_font() {
	$rt_fonts = array(
		'',
		'Times New Roman',
		'Verdana',
		'Georgia'
	);
	
	_e( "<select id='rt_font' name='rt_options[rt_font]'>" );
	
	foreach( $rt_fonts as $rt_font ) {
		$selected = '';
		if( rt_get_option( 'rt_font' ) == $rt_font ) { $selected = "selected='selected'"; }
		
		_e( "<option value='" . $rt_font . "' " . $selected . ">" . $rt_font . "</option>" );
	}
	
	_e( "</select>" );
}

/* Header Settings Callback Functions (rt_header) 
-------------------------------------------------- */
function rt_section_header() {
	_e( '<p>This section will help customize your site&#39;s header.</p>' );
}

function rt_field_logo() {	
	_e( '<textarea id="rt_logo" name="rt_options[rt_logo]" style="width: 300px; height: 100px;">' . rt_get_option( 'rt_logo' ) . '</textarea><span style="margin-left: 20px">' );
	_e( '<span style="margin-left: 20px">' );
	if( rt_get_option( 'rt_logo' ) != '' ) { 
		_e( '<img src="' . rt_get_option( 'rt_logo' ) . '" height="100">' ); 
	}
	else {
		_e( '(Preview will appear here after settings are saved.)' );
	}
	_e ( '</span><br><span><i>Enter URL of your logo.</i></span>' );		
}

function rt_field_logo_width() {
	_e( "<input id='rt_logo_width' name='rt_options[rt_logo_width]' size='3' type='text' value='" . rt_get_option( 'rt_logo_width' ) . "' />" );
	_e ( '<span>&nbsp;px</span>' );		
}

function rt_field_logo_height() {
	_e( "<input id='rt_logo_width' name='rt_options[rt_logo_height]' size='3' type='text' value='" . rt_get_option( 'rt_logo_height' ) . "' />" );
	_e ( '<span>&nbsp;px</span>' );		
}

/* Social Settings Callback Functions (rt_social) 
-------------------------------------------------- */
function rt_section_social() {
	_e( '<p>Insert the URL of your social sites to show icons in the top right corner of your site.</p>' );
}

function rt_field_facebook() {
	_e( "<input id='rt_facebook' name='rt_options[rt_facebook]' size='60' type='text' value='" . rt_get_option( 'rt_facebook' ) . "' />" );	
}

function rt_field_twitter() {
	_e( "<input id='rt_twitter' name='rt_options[rt_twitter]' size='60' type='text' value='" . rt_get_option( 'rt_twitter' ) . "' />" );	
}

function rt_field_linkedin() {
	_e( "<input id='rt_linkedin' name='rt_options[rt_linkedin]' size='60' type='text' value='" . rt_get_option( 'rt_linkedin' ) . "' />" );	
}

function rt_field_pinterest() {
	_e( "<input id='rt_pinterest' name='rt_options[rt_pinterest]' size='60' type='text' value='" . rt_get_option( 'rt_pinterest' ) . "' />" );	
}

/* Validates Options (and save settings)
-------------------------------------------------------------------------------- */
function rt_validate_options($input) {	
	
	// Global Settings
	$input['rt_css'] = sanitize_text_field( $input['rt_css'] );
	 
	// Header Settings
	$input['rt_logo'] = sanitize_text_field( $input['rt_logo'] );
	$input['rt_logo_width'] = sanitize_text_field( $input['rt_logo_width'] );
	$input['rt_logo_height'] = sanitize_text_field( $input['rt_logo_height'] );
	
	// Social Settings
	$input['rt_facebook'] = sanitize_text_field( $input['rt_facebook'] );
	$input['rt_twitter'] = sanitize_text_field( $input['rt_twitter'] );
	$input['rt_linkedin'] = sanitize_text_field( $input['rt_linkedin'] );
	$input['rt_pinterest'] = sanitize_text_field( $input['rt_pinterest'] );
	
	return $input;
}

?>