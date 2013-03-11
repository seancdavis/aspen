<?php

class Social_Links extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Social_Links() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'social-links', 'description' => __('Displays icons and text for your social media accounts.', 'social-links') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'social-links' );

		/* Create the widget. */
		$this->WP_Widget( 'social-links', __('Social Media', 'social-links'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$facebook_link = $instance['facebook_link'];
		$facebook_text = $instance['facebook_text'];
		$twitter_link = $instance['twitter_link'];
		$twitter_text = $instance['twitter_text'];
		$linkedin_link = $instance['linkedin_link'];
		$linkedin_text = $instance['linkedin_text'];
		$pinterest_link = $instance['pinterest_link'];
		$pinterest_text = $instance['pinterest_text'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $facebook_link ) {
			echo '<a class="social-link" href="' . $facebook_link . '" target="_blank"><img class="social-widget-img" src="' . get_template_directory_uri() . '/images/facebook-32.png" /><span class="social-widget-text">' . $facebook_text . '</span></a><br>';
		}
		
		if ( $twitter_link ) {
			echo '<a class="social-link" href="' . $twitter_link . '" target="_blank"><img class="social-widget-img" src="' . get_template_directory_uri() . '/images/twitter-32.png" /><span class="social-widget-text">' . $twitter_text . '</span></a><br>';
		}
		
		if ( $linkedin_link ) {
			echo '<a class="social-link" href="' . $linkedin_link . '" target="_blank"><img class="social-widget-img" src="' . get_template_directory_uri() . '/images/linkedin-32.png" /><span class="social-widget-text">' . $linkedin_text . '</span></a><br>';
		}
		
		if ( $pinterest_link ) {
			echo '<a class="social-link" href="' . $pinterest_link . '" target="_blank"><img class="social-widget-img" src="' . get_template_directory_uri() . '/images/pinterest-32.png" /><span class="social-widget-text">' . $pinterest_text . '</span></a><br>';
		}
		

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
		$instance['facebook_link'] = strip_tags( $new_instance['facebook_link'] );
		$instance['facebook_text'] = strip_tags( $new_instance['facebook_text'] );
		$instance['twitter_link'] = strip_tags( $new_instance['twitter_link'] );
		$instance['twitter_text'] = strip_tags( $new_instance['twitter_text'] );
		$instance['linkedin_link'] = strip_tags( $new_instance['linkedin_link'] );
		$instance['linkedin_text'] = strip_tags( $new_instance['linkedin_text'] );
		$instance['pinterest_link'] = strip_tags( $new_instance['pinterest_link'] );
		$instance['pinterest_text'] = strip_tags( $new_instance['pinterest_text'] );		

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => 'Stay Connected',
			'facebook_link' => '',
			'facebook_text' => 'Facebook',
			'twitter_link' => '',
			'twitter_text' => 'Twitter',
			'linkedin_link' => '',
			'linkedin_text' => 'LinkedIn',
			'pinterest_link' => '',
			'pinterest_text' => 'Pinterest'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Facebook -->
		<p>
			<h3>Facebook</h3>
			<label for="<?php echo $this->get_field_id( 'facebook_link' ); ?>"><?php echo 'URL:' ?></label>
			<input id="<?php echo $this->get_field_id( 'facebook_link' ); ?>" name="<?php echo $this->get_field_name( 'facebook_link' ); ?>" value="<?php echo $instance['facebook_link']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id( 'facebook_text' ); ?>"><?php echo 'Text to Display:' ?></label>
			<input id="<?php echo $this->get_field_id( 'facebook_text' ); ?>" name="<?php echo $this->get_field_name( 'facebook_text' ); ?>" value="<?php echo $instance['facebook_text']; ?>" style="width:100%;" />
		</p>
		
		<!-- Twitter -->
		<p>
			<h3>Twitter</h3>
			<label for="<?php echo $this->get_field_id( 'twitter_link' ); ?>"><?php echo 'URL:' ?></label>
			<input id="<?php echo $this->get_field_id( 'twitter_link' ); ?>" name="<?php echo $this->get_field_name( 'twitter_link' ); ?>" value="<?php echo $instance['twitter_link']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id( 'twitter_text' ); ?>"><?php echo 'Text to Display:' ?></label>
			<input id="<?php echo $this->get_field_id( 'twitter_text' ); ?>" name="<?php echo $this->get_field_name( 'twitter_text' ); ?>" value="<?php echo $instance['twitter_text']; ?>" style="width:100%;" />
		</p>
		
		<!-- LinkedIn -->
		<p>
			<h3>LinkedIn</h3>
			<label for="<?php echo $this->get_field_id( 'linkedin_link' ); ?>"><?php echo 'URL:' ?></label>
			<input id="<?php echo $this->get_field_id( 'linkedin_link' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_link' ); ?>" value="<?php echo $instance['linkedin_link']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id( 'linkedin_text' ); ?>"><?php echo 'Text to Display:' ?></label>
			<input id="<?php echo $this->get_field_id( 'linkedin_text' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_text' ); ?>" value="<?php echo $instance['linkedin_text']; ?>" style="width:100%;" />
		</p>
		
		<!-- Pinterest -->
		<p>
			<h3>Pinterest</h3>
			<label for="<?php echo $this->get_field_id( 'pinterest_link' ); ?>"><?php echo 'URL:' ?></label>
			<input id="<?php echo $this->get_field_id( 'pinterest_link' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_link' ); ?>" value="<?php echo $instance['pinterest_link']; ?>" style="width:100%;" />
			<label for="<?php echo $this->get_field_id( 'pinterest_text' ); ?>"><?php echo 'Text to Display:' ?></label>
			<input id="<?php echo $this->get_field_id( 'pinterest_text' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_text' ); ?>" value="<?php echo $instance['pinterest_text']; ?>" style="width:100%;" />
		</p>

		

	<?php
	}
}

?>