<?php

class Twitter_Feed extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Twitter_Feed() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'twitter-feed', 'description' => __('Displays a custom feed for the Twitter account of your choosing.', 'twitter-feed') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitter-feed' );

		/* Create the widget. */
		$this->WP_Widget( 'twitter-feed', __('Twitter Feed', 'twitter-feed'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$handle = $instance['handle'];
		$tweets = $instance['tweets'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		if ( $handle ) {
			
			?>
			<img id="twitter-feed-icon" src="<?php echo get_template_directory_uri() . '/images/social-media/twitter-white.png'; ?>">
			<h2 id="twitter-feed-title"><a href="http://twitter.com/<?php echo $handle; ?>" target="_blank">@<?php echo $handle; ?></a></h2>			
			<ul id="twitter_update_list"></ul>
			
			<?php load_twitter_scripts( $handle, $tweets );
			
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
		$instance['handle'] = strip_tags( $new_instance['handle'] );
		$instance['tweets'] = strip_tags( $new_instance['tweets'] );	

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
			'handle' => 'thepolymathlab',
			'tweets' => '3'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Handle & Tweets -->
		<p>
			<label>Twitter Handle:&nbsp;@</label>
			<input id="<?php echo $this->get_field_id( 'handle' ); ?>" name="<?php echo $this->get_field_name( 'handle' ); ?>" value="<?php echo $instance['handle']; ?>" size="20" />
			<br><br>
			<label>Number of tweets to display:&nbsp;</label>
			<input id="<?php echo $this->get_field_id( 'tweets' ); ?>" name="<?php echo $this->get_field_name( 'tweets' ); ?>" value="<?php echo $instance['tweets']; ?>" size="3" />
		</p>
				

	<?php
	}
}

function load_twitter_scripts( $handle, $tweets ) {
	wp_enqueue_script( 'twitter-blogger', get_template_directory_uri() . '/library/js/twitter-blogger.js', array('jquery') );
	wp_enqueue_script( 'twitter-blogger-feed', 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=' . $handle . '&include_rts=1&callback=twitterCallback2&count=' . $tweets, array('jquery') );
}

?>