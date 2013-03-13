<?php

add_shortcode( 'mrcf', 'display_mrcf' );

function display_mrcf( $atts ) {	
	extract( shortcode_atts( array(
		'some_att' => '',
	), $atts ) );
	// These aren't working becacuse we changed the names.
	$email = $_POST['rt_mrcf_email'];
	$topic = $_POST['rt_mrcf_topic'];
	$msg = $_POST['rt_mrcf_msg'];
	
	// Create post object
	if( $msg != '' ) :
		$new_msg = array(
		  'post_title'    => $topic,
		  'post_content'  => $msg,
		  'post_status'   => 'publish',
		  'post_author'   => $email,
		  'post_type' => 'rt_mrcf'
		);
		
		$error_msg = 'Error submitting form.';
		
		// Insert the post into the database
		wp_insert_post( $new_msg, $error_msg ); ?>
		<div class="rt-success"><span>&#x2713;</span>Message submitted successfully. We will be in touch soon.</div>
		<?php 
		if( rt_get_mrcf_option('email_notification') == 'On' ) {
			$to = rt_get_mrcf_option('to');
			$subject = bloginfo('name') . ': ' . $topic;
			$from = $email;
			$headers = "From:" . $from;
			mail($to,$subject,$msg,$headers); 
		}
		
	endif; ?>
	
	<form class="rt-mrcf" name="rt_mrcf" method="post">
		<label class="rt-mrcf-email">Your Email Address*</label>&nbsp;<input id="Enter your email address." name="rt_mrcf_email" class="rt-mrcf-input required email" type="text" value="Enter your email address." size="30">
		<label class="rt-mrcf-topic">Topic*</label>&nbsp;<input id="What is your message about?" name="rt_mrcf_topic" class="required rt-mrcf-input" type="text" value="What is your message about?" size="30">
		<label class="rt-mrcf-msg">Message*</label>&nbsp;<textarea id="Have a question or request? Enter it here..." class="required rt-mrcf-input" type="text" name="rt_mrcf_msg">Have a question or request? Enter it here...</textarea>
		<label class="rt-mrcf-required">*Required fields</label>
		<input type="submit" value="Send Message" class="rt-mrcf-submit">
	</form>
	
<?php }

?>