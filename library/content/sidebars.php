<?php

// registers widgets
if (function_exists('register_sidebar')) {
	
	register_sidebar(array(
		'name'=> 'Right Sidebar',
		'id' => 'right-sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar(array(
		'name'=> 'Footer Sidebar',
		'id' => 'footer-widget',
		'before_widget' => '<div class="footer-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="footer-widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar(array(
		'name'=> 'Front Widget',
		'id' => 'front-widget',
		'before_widget' => '<div class="front-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="front-widget-title">',
		'after_title' => '</h2>',
	));

}

?>