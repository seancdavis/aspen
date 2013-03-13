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
		'rt_options_menu_control' => 'rt-global-options',
		'rt_css' => '/* Add your custom CSS here: */',
		'rt_headings_font' => 'Helvetica',
		'rt_body_font' => 'Helvetica',
		'rt_logo' => '',
		'rt_logo_width' => '200',
		'rt_logo_height' => '200',
		'rt_email' => '',
		'rt_facebook' => '',
		'rt_twitter' => '',
		'rt_linkedin' => '',
		'rt_pinterest' => '',
		'rt_blog_view' => 'the_excerpt',
		'rt_blog_excerpt_length' => '100',
		'rt_blog_readmore_text' => 'Read More...'
	);
	
	$options = get_option( 'rt_options' );
	
	if( $options[$option_name] == '' ) {
		return $defaults[$option_name];
	}
	else {
		return $options[$option_name];
	}
}

// checkboxes
function rt_get_chk_option( $option_name ) {
	
	$defaults = array(
		'rt_blog_author' => 1,
		'rt_blog_date' => 1,
		'rt_blog_comments' => 1,
		'rt_blog_category' => 1,
		'rt_blog_tags' => 1
	);
	
	$options = get_option( 'rt_options' );
	
	if( isset( $options[$option_name] ) ) {
		return $options[$option_name];
	}
	else {
		return $defaults[$option_name];
	}
}


/* Theme Options Page
-------------------------------------------------------------------------------- */
function rt_options_page() { ?>
    
    <div>
    	
        <h2>rocktree Theme Settings</h2>
        <p>Use these options to customize your site to fit your needs. To request new options, please email <a href="mailto:scdavis41@gmail.com">the theme designer</a>.</p>
		
		<form action="options.php" method="post">
			
			<?php if( $_GET['settings-updated']==true ) { ?>
				<div id="message" class="updated"><p>Settings updated.</p></div>
				<input id="rt-hidden-options-control" type="text" hidden="hidden" value="<?php print rt_get_option( 'rt_options_menu_control' ); ?>" />
			<?php }
			else { ?>
				<input id="rt-hidden-options-control" type="text" hidden="hidden" value="rt-global-options" />
			<?php } ?>
			
			<input id='rt-options-menu-control' name='rt_options[rt_options_menu_control]' size='60' type='text' value="<?php print rt_get_option( 'rt_options_menu_control' ); ?>" hidden="hidden" />
						
			<ul id="rt-options-menu">
				<li class="rt-global-options">Global</li>
				<li class="rt-headings-options">Logo</li>
				<li class="rt-blog-options">Blog/News</li>
				<li class="rt-social-options">Social</li>
			</ul>
			
			<?php settings_fields('rt_options'); ?>
			<div class="rt-settings-section" id="rt-global-options"><?php do_settings_sections('rt_global_options'); ?></div>
			<div class="rt-settings-section" id="rt-headings-options"><?php do_settings_sections('rt_headings_options'); ?></div>
			<div class="rt-settings-section" id="rt-blog-options"><?php do_settings_sections('rt_blog_options'); ?></div>
			<div class="rt-settings-section" id="rt-social-options"><?php do_settings_sections('rt_social_options'); ?></div>			
         	<div class="rt-settings-section" id="rt-submit-options"><?php submit_button( 'Save All Theme Options' ); ?></div>
        	
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
	add_settings_section(
		'rt_global', 					// ID
		'Global Settings',		 		// Title (what is displayed on the page)
		'rt_section_global',		 	// Callback (function that displays content)
		'rt_global_options'				// Page (page on which to display the setting) 
	);	
	add_settings_field(
		'rt_css', 						// ID
		'Add Custom CSS', 				// Title (shown as the label on the page)
		'rt_field_css', 				// Callback (function that displays content)
		'rt_global_options', 			// Page (page on which to display the content)
		'rt_global'						// Section (ref ID of section to attach field)
	);	
	add_settings_field('rt_headings_font', 'Header Font', 'rt_field_headings_font', 'rt_global_options', 'rt_global');
	add_settings_field('rt_body_font', 'Body Font', 'rt_field_body_font', 'rt_global_options', 'rt_global');
	
	/* Header Settings (rt_headings)
	-------------------------------- */
	add_settings_section( 'rt_headings', 'Header Settings', 'rt_section_headings', 'rt_headings_options' );	
	add_settings_field('rt_logo', 'Custom Logo (replaces site title)', 'rt_field_logo', 'rt_headings_options', 'rt_headings');
	add_settings_field('rt_logo_width', 'Max. Logo Width', 'rt_field_logo_width', 'rt_headings_options', 'rt_headings');
	add_settings_field('rt_logo_height', 'Max. Logo Height', 'rt_field_logo_height', 'rt_headings_options', 'rt_headings');
	
	/* Blog/News Settings (rt_blog)
	-------------------------------- */
	add_settings_section( 'rt_blog', 'Blog/News Settings', 'rt_section_blog', 'rt_blog_options' );	
	add_settings_field('rt_blog_meta', 'Display Post Meta', 'rt_field_blog_meta', 'rt_blog_options', 'rt_blog');
	add_settings_field('rt_blog_view', 'Blog Page View', 'rt_field_blog_view', 'rt_blog_options', 'rt_blog');
	add_settings_field('rt_blog_excerpt_length', 'Blog Excerpt Length', 'rt_field_blog_excerpt_length', 'rt_blog_options', 'rt_blog');
	add_settings_field('rt_blog_readmore_text', 'Read More Link Text', 'rt_field_blog_readmore_text', 'rt_blog_options', 'rt_blog');
	
	/* Social Settings (rt_social)
	-------------------------------- */
	add_settings_section( 'rt_social', 'Social Settings', 'rt_section_social', 'rt_social_options' );
	add_settings_field('rt_email', 'Email', 'rt_field_email', 'rt_social_options', 'rt_social');	
	add_settings_field('rt_facebook', 'Facebook', 'rt_field_facebook', 'rt_social_options', 'rt_social');
	add_settings_field('rt_twitter', 'Twitter', 'rt_field_twitter', 'rt_social_options', 'rt_social');
	add_settings_field('rt_linkedin', 'LinkedIn', 'rt_field_linkedin', 'rt_social_options', 'rt_social');
	add_settings_field('rt_pinterest', 'Pinterest', 'rt_field_pinterest', 'rt_social_options', 'rt_social');
}

/* Global Settings Callback Functions (rt_global) 
-------------------------------------------------- */
function rt_section_global() {
	_e( '<p>These general settings will help you style your site.</p>' );
}

function rt_field_css() {
	_e( "<textarea id='rt_logo' name='rt_options[rt_css]' style='width: 300px; height: 200px;'>" . rt_get_option( 'rt_css' ) . "</textarea>" );
}

function rt_field_headings_font() {
	$rt_headings_fonts = array(
		'Arial',
		'Arvo',
		'Georgia',
		'Helvetica',
		'Lato',
		'Open Sans',
		'PT Sans',		
		'sans serif',
		'serif',
		'Tahoma',		
		'Times New Roman',
		'Ubuntu',
		'Verdana',
		'Vollkorn'
	);
	
	_e( "<select id='rt_font' name='rt_options[rt_headings_font]'>" );
	
	foreach( $rt_headings_fonts as $rt_headings_font ) {
		$selected = '';
		if( rt_get_option( 'rt_headings_font' ) == $rt_headings_font ) { $selected = "selected='selected'"; }
		
		_e( "<option value='" . $rt_headings_font . "' " . $selected . ">" . $rt_headings_font . "</option>" );
	}
	
	_e( "</select>" );
}

function rt_field_body_font() {
	$rt_body_fonts = array(
		'Arial',
		'Arvo',
		'Georgia',
		'Helvetica',
		'Lato',
		'Open Sans',
		'PT Sans',		
		'sans serif',
		'serif',
		'Tahoma',		
		'Times New Roman',
		'Ubuntu',
		'Verdana',
		'Vollkorn'
	);
	
	_e( "<select id='rt_font' name='rt_options[rt_body_font]'>" );
	
	foreach( $rt_body_fonts as $rt_body_font ) {
		$selected = '';
		if( rt_get_option( 'rt_body_font' ) == $rt_body_font ) { $selected = "selected='selected'"; }
		
		_e( "<option value='" . $rt_body_font . "' " . $selected . ">" . $rt_body_font . "</option>" );
	}
	
	_e( "</select>" );
}

/* Header Settings Callback Functions (rt_headings) 
-------------------------------------------------- */
function rt_section_headings() {
	_e( '<p>This section will help customize your site&#39;s headings.</p>' );
}

function rt_field_logo() {	?>
	<input id="rt-logo" hidden='hidden' type="text" size="36" value="<?php print rt_get_option( 'rt_logo' ); ?>" name="rt_options[rt_logo]" value="" />
	<img id="rt-logo-preview" src="<?php print rt_get_option( 'rt_logo' ); ?>" style="max-width:<?php print rt_get_option( 'rt_logo_width' ); ?>px;max-height:<?php print rt_get_option( 'rt_logo_height' ); ?>px;" />
	<br />
	<input id="rt-logo-button" type="button" value="Upload Image" class="button-secondary" />
	&nbsp;&nbsp;<a id="rt-remove-logo">Remove Logo</a>
	
	<?php
}

function rt_field_logo_width() {
	_e( "<input id='rt-logo-width' name='rt_options[rt_logo_width]' size='3' type='text' value='" . rt_get_option( 'rt_logo_width' ) . "' />" );
	_e ( '<span>&nbsp;px</span>' );		
}

function rt_field_logo_height() {
	_e( "<input id='rt-logo-height' name='rt_options[rt_logo_height]' size='3' type='text' value='" . rt_get_option( 'rt_logo_height' ) . "' />" );
	_e ( '<span>&nbsp;px</span>' );		
}

/* Blog/News Settings
-------------------------------------------------- */
function rt_section_blog() {	
    echo '<p>This information is shown by default on your blog/news pages. Uncheck the boxes for the items you wish to hide.</p>';    
}

function rt_field_blog_meta() {
	
	?>	
	<input type="checkbox" name="rt_options[rt_blog_author]" value="<?php print rt_get_chk_option( 'rt_blog_author' ); ?>" <?php if( rt_get_chk_option( 'rt_blog_author' ) == 1 ) print 'checked="checked"'; ?> / >&nbsp;&nbsp;<label for="rt_options[rt_blog_author]">Author</label>
	
	<br><input type="checkbox" name="rt_options[rt_blog_date]" value="<?php print rt_get_chk_option( 'rt_blog_date' ); ?>" <?php if( rt_get_chk_option( 'rt_blog_date' ) == 1 ) print 'checked="checked"'; ?> / >&nbsp;&nbsp;<label for="rt_options[rt_blog_date]">Date</label>
	
	<br><input type="checkbox" name="rt_options[rt_blog_comments]" value="<?php print rt_get_chk_option( 'rt_blog_comments' ); ?>" <?php if( rt_get_chk_option( 'rt_blog_comments' ) == 1 ) print 'checked="checked"'; ?> / >&nbsp;&nbsp;<label for="rt_options[rt_blog_comments]">Comments</label>
	
	<br><input type="checkbox" name="rt_options[rt_blog_category]" value="<?php print rt_get_chk_option( 'rt_blog_category' ); ?>" <?php if( rt_get_chk_option( 'rt_blog_category' ) == 1 ) print 'checked="checked"'; ?> / >&nbsp;&nbsp;<label for="rt_options[rt_blog_category]">Category</label>
	
	<br><input type="checkbox" name="rt_options[rt_blog_tags]" value="<?php print rt_get_chk_option( 'rt_blog_tags' ); ?>" <?php if( rt_get_chk_option( 'rt_blog_tags' ) == 1 ) print 'checked="checked"'; ?> / >&nbsp;&nbsp;<label for="rt_options[rt_blog_tags]">Tags</label>
	
	<p><i>Note: These only control whether the metadata is <strong>displayed</strong>. It does not turn the features/functionality on or off.</i></p>
	

<?php
}

function rt_field_blog_view() {
	$view = rt_get_option( 'rt_blog_view' ); ?>
	
	<input type="radio" label="Full Posts" name="rt_options[rt_blog_view]" value="the_content" <?php if( $view == 'the_content' ) print 'checked="checked"'; ?> />
   <label for="_full_width">Full Posts</label><br>
	
	<input id="rt-the-excerpt-option" type="radio" name="rt_options[rt_blog_view]" value="the_excerpt" <?php if( $view == 'the_excerpt' ) print 'checked="checked"'; ?> />
	<label for="_right_sidebar">Post Excerpts</label>
	<p><i>Note: This controls whether the full posts or an excerpt of the post is shown on any page that contains more than 1 post.</i></p>
<?php
}

function rt_field_blog_excerpt_length() { ?>
	<input id="rt-blog-excerpt-length" name='rt_options[rt_blog_excerpt_length]' size='5' type='text' value="<?php print rt_get_option( 'rt_blog_excerpt_length' ); ?>" />&nbsp;&nbsp;<label>(words)</label>
<?php 
}

function rt_field_blog_readmore_text() { ?>
	<input name='rt_options[rt_blog_readmore_text]' size='40' type='text' value="<?php print rt_get_option( 'rt_blog_readmore_text' ); ?>" />
<?php
}

/* Social Settings Callback Functions (rt_social) 
-------------------------------------------------- */
function rt_section_social() {
	_e( '<p>Insert the URL of your social sites to show social icons linked to your profiles.</p>' );
}

function rt_field_email() {
	?><input id='rt_email' name='rt_options[rt_email]' size='60' type='text' value="<?php echo rt_get_option( 'rt_email' ); ?>" /><?php	
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
	
	// this isn't working --> can't get checkboxes to stay checked.
	$chks = array(
		'rt_blog_author',
		'rt_blog_comments',
		'rt_blog_date',
		'rt_blog_category',
		'rt_blog_tags'
		);
	
	foreach( $chks as $chk ) {		
		if( isset( $input[$chk] ) ) {
			$input[$chk] = 1;
		}
		else {
			$input[$chk] = 0;
		}
	}
	
	// Blog/News Settings
	$input['rt_blog_excerpt_length'] = sanitize_text_field( $input['rt_blog_excerpt_length'] );
	$input['rt_blog_readmore_text'] = sanitize_text_field( $input['rt_blog_readmore_text'] );
		
	
	// Social Settings
	$input['rt_email'] = sanitize_text_field( $input['rt_email'] );
	$input['rt_facebook'] = sanitize_text_field( $input['rt_facebook'] );
	$input['rt_twitter'] = sanitize_text_field( $input['rt_twitter'] );
	$input['rt_linkedin'] = sanitize_text_field( $input['rt_linkedin'] );
	$input['rt_pinterest'] = sanitize_text_field( $input['rt_pinterest'] );
	
	return $input;
}

?>