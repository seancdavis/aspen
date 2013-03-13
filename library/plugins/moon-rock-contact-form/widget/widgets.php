<?php

add_action( 'widgets_init', 'load_mrcf_widget' );

function load_mrcf_widget() {
	register_widget( 'Contact_Form' );
}

class Contact_Form extends WP_Widget {

	function Contact_Form() {
		$widget_ops = array( 'classname' => 'mrcf', 'description' => __('Displays your contact form according to your settings.', 'mrcf') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'mrcf' );
		$this->WP_Widget( 'mrcf', __('Contact Form', 'mrcf'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title ) echo '<h2>' . $title . '</h2>';
		display_mrcf();
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	function form( $instance ) { ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>All options here are set from the Contact Form setttings. Click "Save" and adjust settings accordingly (<a href="<?php echo get_bloginfo('wpurl') . "/wp-admin/edit.php?post_type=rt_mrcf&page=rt_mrcf_options"; ?>">Click here for settings</a>).</p>
	<?php }
}

?>