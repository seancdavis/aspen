<?php

class Info_Tile extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Info_Tile() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'info-tile', 'description' => __('An image and description of a product or service.', 'info-tile') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'info-tile' );

		/* Create the widget. */
		$this->WP_Widget( 'info-tile', __('Info Tile', 'info-tile'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$img = $instance['img'];
		$text = $instance['text'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings if one was input. */
		if ( $img )
			echo '<img class="info-tile-img" src="' . $img . '">';

		/* If show sex was selected, display the user's sex. */
		if ( $text )
			echo '<p>' . $text . '</p>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['img'] = strip_tags( $new_instance['img'] );
		$instance['text'] = strip_tags( $new_instance['text'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('My Blog', 'info'), 'img' => 'http://thepolymathlab.com/wp-content/uploads/2012/11/The-Polymath-Lab-Logo1.png', 'text' => 'Come check out The Polymath Lab!' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'img' ); ?>"><?php _e('Image URL:', 'img'); ?></label>
			<input id="<?php echo $this->get_field_id( 'img' ); ?>" name="<?php echo $this->get_field_name( 'img' ); ?>" value="<?php echo $instance['img']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e('Text:', 'img'); ?></label>
			<input id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" value="<?php echo $instance['text']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>