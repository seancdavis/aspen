<?php

/* Social Icons
------------------------------------------------------------------------ */
function rt_get_social_icons() {
	
	$social_icons = '';	
	$social_dir = get_template_directory_uri() . '/images/social-media/';
	if( has_social_icons() ) {
		$social_icons .= '<div id="social-icons-container" class="clearfix">';		
		if( rt_get_option('rt_email') != '' ) $social_icons .= '<a href="mailto:' . rt_get_option('rt_email') . '" target="_blank"><img src="' . $social_dir.'email-white.png" /></a>';
		if( rt_get_option('rt_facebook') != '' ) $social_icons .= '<a href="' . rt_get_option('rt_facebook') . '" target="_blank"><img src="' . $social_dir.'facebook-white.png" /></a>';		
		if( rt_get_option('rt_twitter') != '' ) $social_icons .= '<a href="' . rt_get_option('rt_twitter') . '" target="_blank"><img src="' . $social_dir.'twitter-white.png" /></a>';	
		if( rt_get_option('rt_linkedin') != '' ) $social_icons .= '<a href="' . rt_get_option('rt_linkedin') . '" target="_blank"><img src="' . $social_dir.'linkedin-white.png" /></a>';	
		if( rt_get_option('rt_pinterest') != '' ) $social_icons .= '<a href="' . rt_get_option('rt_pinterest') . '" target="_blank"><img src="' . $social_dir.'pinterest-white.png" /></a>';		
		$social_icons .= '</div>';		
	}
	return $social_icons;
}

function has_social_icons() {
	if( rt_get_option('rt_email') == '' && rt_get_option('rt_facebook') == '' && rt_get_option('rt_twitter') == '' && rt_get_option('rt_linkedin') == '' && rt_get_option('rt_pinterest') == '' ) {
		return false;
	}
	else return true;
}

?>