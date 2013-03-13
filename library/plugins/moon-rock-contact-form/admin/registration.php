<?php

add_action( 'init', 'rt_register_mrcf' );

function rt_register_mrcf() {
	
	// Custom labels for admin
	$labels = array(
		'name'               => _x( 'Contact Form', 'post type general name' ),
		'singular_name'      => _x( 'Contact Form', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'message' ),
		'add_new_item'       => __( 'Add New Message' ),
		'edit_item'          => __( 'Edit Messages' ),
		'new_item'           => __( 'New Message' ),
		'all_items'          => __( 'All Messages' ),
		'view_item'          => __( 'View Messages' ),
		'search_items'       => __( 'Search Messages' ),
		'not_found'          => __( 'No messages found' ),
		'not_found_in_trash' => __( 'No messages found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Contact Form'
	);
	
	$args = array(
		'labels'        => $labels,
		'description'   => 'Enables you to build and display a contact form, and saves all entries on your site',
		'public'        => true,
		'menu_position' => 25,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'   => true,
	);
	
	register_post_type( 'rt_mrcf', $args );
}

/* Register columns to "All Features" admin page
------------------------------------------------------------------ */
/*
add_filter('manage_edit-rt_feature_columns', 'add_new_rt_feature_columns');

function add_new_rt_feature_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Feature Title' ),
		'active' => __( 'Status' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

/* Display correct data in custom columns on "All Features" admin page.
------------------------------------------------------------------ */
/*
add_action( 'manage_rt_feature_posts_custom_column', 'manage_rt_feature_columns', 10, 2 );

function manage_rt_feature_columns( $column, $post_id ) {
	
	global $post;

	switch( $column ) {

		case 'active' :

			$active = get_post_meta( $post_id, '_disable_feature', true );

			if ( empty( $active ) ) { echo __( 'Active' ); }
			else { echo __( 'Disabled' ); }

		break;

		default :
			break;
	}
}


/* Sort Columns on "All Features" admin page
------------------------------------------------------------------ */
/*
add_filter( 'manage_edit-rt_feature_sortable_columns', 'my_feature_sortable_columns' );

function my_feature_sortable_columns( $columns ) {

	$columns['active'] = 'active';

	return $columns;
}

// Only run customization on the 'edit.php' page in the admin.
add_action( 'load-edit.php', 'my_edit_rt_feature_load' );

function my_edit_rt_feature_load() {
	add_filter( 'request', 'my_sort_rt_feature' );
}

// Sort the data
function my_sort_rt_feature( $vars ) {
	
	// Check if we're viewing the 'rt_feature' post type
	if ( isset( $vars['post_type'] ) && 'rt_feature' == $vars['post_type'] ) {

		// Check if 'orderby' is set to 'active'.
		if ( isset( $vars['orderby'] ) && 'active' == $vars['orderby'] ) {

			// Merge the query vars with our custom variables.
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_disable_feature_key',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}*/

?>