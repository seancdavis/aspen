<?php

add_action( 'init', 'rt_register_feature_type' );
function rt_register_feature_type() {
	
	// Custom labels for admin
	$labels = array(
		'name'               => _x( 'Features', 'post type general name' ),
		'singular_name'      => _x( 'Feature', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'feature' ),
		'add_new_item'       => __( 'Add New Feature' ),
		'edit_item'          => __( 'Edit Feature' ),
		'new_item'           => __( 'New Feature' ),
		'all_items'          => __( 'All Features' ),
		'view_item'          => __( 'View Feature' ),
		'search_items'       => __( 'Search Features' ),
		'not_found'          => __( 'No features found' ),
		'not_found_in_trash' => __( 'No features found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Features'
	);
	
	$args = array(
		'labels'        => $labels,
		'description'   => 'Store and maintain features for your site.',
		'public'        => true,
		'menu_position' => 20,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'   => true,
	);
	
	register_post_type( 'rt_feature', $args );
}


/* Register columns to "All Features" admin page
------------------------------------------------------------------ */
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
}

?>