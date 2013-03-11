<?php
 
/* Load Necessary PHP Files
-------------------------------------------------------------------------------- */
add_action( 'rocktree_init', 'rocktree_load_functions' );

function rocktree_load_functions() {
	
	// Directory Constants
	define( 'RT_LIBRARY_DIR', get_template_directory() . '/library' );	
		 
	// admin
	require_once( RT_LIBRARY_DIR . '/admin/theme-options.php' );
	
	// content
	require_once( RT_LIBRARY_DIR . '/content/content.php' );
	require_once( RT_LIBRARY_DIR . '/content/sidebars.php' );
	
	// plugins
	require_once( RT_LIBRARY_DIR . '/plugins/features.php' );
	require_once( RT_LIBRARY_DIR . '/plugins/feature-options.php' );
	require_once( RT_LIBRARY_DIR . '/plugins/feature-meta.php' );
	require_once( RT_LIBRARY_DIR . '/plugins/display-feature.php' );
	require_once( RT_LIBRARY_DIR . '/plugins/feature-order.php' );	
	
	// widgets
	require_once( RT_LIBRARY_DIR . '/widgets/info-tile.php' );
	require_once( RT_LIBRARY_DIR . '/widgets/social-links.php' );
	
}

/* Registration
-------------------------------------------------------------------------------- */
add_action( 'rocktree_init', 'rocktree_registration' );

function rocktree_registration() {
 
	// Custom Menus
	add_action( 'init', 'register_my_menu' );
	 
	function register_my_menu() {
		register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
		register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
	}
	
	// Post Thumbnails
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 200, 200 ); // Normal post thumbnails
		add_image_size( 'blog-home-thumbnail', 200, 200 ); // Permalink thumbnail size 'blog-home-thumbnail' sets img class
	}
	
	// Enable post and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	//Enable multisite feature (WordPress 3.0)
	define('WP_ALLOW_MULTISITE', true);

}


/* Initialize Theme (hooks to functions above)
-------------------------------------------------------------------------------- */
do_action( 'rocktree_init' );



/*********************************************************************************/
/*********************************************************************************/



// WP Built-In Hooks --->

/* Scripts  & Stylea
-------------------------------------------------------------------------------- */
	
// Script that controls the feature slider
// NOTE: Only loads on front page.	
add_action('wp_enqueue_scripts', 'load_feature_script');	
function load_feature_script() {
	if( is_front_page() ) { 
		wp_enqueue_script( 'feature-slider', get_template_directory_uri() . '/library/js/feature-slider.js', array('jquery') );
		wp_enqueue_style( 'feature-slider', get_template_directory_uri() . '/library/css/features.css' ); 
	}
}

// Animation of main menu
add_action( 'wp_enqueue_scripts', 'load_main_menu_scripts' );	
function load_main_menu_scripts() {
	wp_enqueue_script('hover-control', get_template_directory_uri() . '/library/js/hover-control.js',array('jquery') );
	wp_enqueue_script('main-menu', get_template_directory_uri() . '/library/js/main-menu.js',array('jquery') );
}
	
// Admin scripts. These only run when on admin site.
// Currently these are only used for the feature plugin.
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );	
function load_custom_wp_admin_style() {
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic' );
	wp_enqueue_script( 'jquery-ui', 'http://code.jquery.com/ui/1.9.2/jquery-ui.js', array('jquery') );
	wp_enqueue_script( 'drag-drop', get_template_directory_uri() . '/library/js/drag-drop.js', array('jquery','jquery-ui') );
	wp_enqueue_script( 'farbtastic-feature-meta', get_template_directory_uri() . '/library/js/farbtastic-toggle.js', array('jquery', 'farbtastic') );	
	wp_enqueue_style( 'feature-order', get_template_directory_uri() . '/library/css/feature-order.css' );	
}	


/* Widgets 
-------------------------------------------------------------------------------- */
add_action( 'widgets_init', 'load_widgets' );

function load_widgets() {
	register_widget( 'Info_Tile' );
	register_widget( 'Social_Links' );
}

	
/* Length of the_excerpt
-------------------------------------------------------------------------------- */
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_trim_excerpt');

function custom_trim_excerpt($text) {
		
		// THIS NUMBER CONTROLS LENGTH OF EXCERPT
		$new_excerpt_length = 100;
		
		// Registers new length of excerpt
		global $post;
		if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$excerpt_length = $new_excerpt_length;
		$words = explode(' ', $text, $excerpt_length + 1);
			if (count($words) > $excerpt_length) {
				array_pop($words);
				array_push($words, '...');
				$text = implode(' ', $words);
			}
		}		
		return $text;
}

?>