<?php

/* Registration
-------------------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', 'load_feature_script');	
function load_feature_script() {
	$feature_type = get_feat_option_value('feature_type');
	if( is_front_page() ) {
		wp_enqueue_style( 'feature-fw', get_template_directory_uri() . '/library/plugins/features/css/style.css' );
		switch( $feature_type ) {
			case 'simple-slider' :
				wp_enqueue_script( 'feature-fw', get_template_directory_uri() . '/library/plugins/features/js/simple-slider.js', array('jquery') );
				break;
			case 'free-form' :
				wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/library/plugins/features/js/jquery.easing.1.3.js', array('jquery') );
				wp_enqueue_script( 'feature-fw', get_template_directory_uri() . '/library/plugins/features/js/free-form.js', array('jquery', 'jquery-easing') );
				break;
		}
	}	
}

/* Display Feature
------------------------------------------------------------------------- */
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function rgb2hex($rgb) {
   $hex = "#";
   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
   return $hex; // returns the hex value including the number sign (#)
}

function lighten_color($hex, $percent) {
	$rgb = hex2rgb($hex);
	for( $i = 0; $i < 3; $i++ ) $new_color[$i] = ceil( $rgb[$i] + ( (255 - $rgb[$i]) * ($percent / 100) ) );
	$hex = rgb2hex( array($new_color[0], $new_color[1], $new_color[2]) );
	return $hex;	
}

function darken_color($hex, $percent) {
	$rgb = hex2rgb($hex);
	for( $i = 0; $i < 3; $i++ ) $new_color[$i] = ceil( $rgb[$i] - ( (255 - $rgb[$i]) * ($percent / 100) ) );
	$hex = rgb2hex( array($new_color[0], $new_color[1], $new_color[2]) );
	return $hex;	
}

function get_css_gradient($bottom_color, $top_color = '') {
	if( $top_color == '' ) $top_color = lighten_color($bottom_color, '40');
	$gradient .= 'background-color: ' . $top_color . '; ';
	$gradient .= 'background: -webkit-gradient(linear, left top, left bottom, from('.$top_color.'), to('.$bottom_color.') );';
	$gradient .= 'background: -webkit-linear-gradient(top, '.$top_color.', '.$bottom_color.');';
	$gradient .= 'background: -moz-linear-gradient(top, '.$top_color.', '.$bottom_color.');';
	$gradient .= 'background: -ms-linear-gradient(top, '.$top_color.', '.$bottom_color.');';
	$gradient .= 'background: -o-linear-gradient(top, '.$top_color.', '.$bottom_color.');';
	$gradient .= 'background: linear-gradient(top, '.$top_color.', '.$bottom_color.');';
	$gradient .= 'filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='.$top_color.', endColorstr='.$bottom_color.', GradientType=0);';
	return $gradient;
}

function get_feat_css() {
	
	// define all option variables
	$feature_type = get_feat_option_value('feature_type');
	$free_form_feat = 'free-form';
	$slider_width = get_feat_option_value('slider_width');
	$bkg_type = get_feat_option_value('bkg_type');
	$bkg_color = get_feat_option_value('bkg_color');
	$box_bkg_color = hex2rgb( get_feat_option_value('box_bkg_color') );
	$text_color = get_feat_option_value('text_color');
	$button_bkg = get_feat_option_value('button_bkg_color');
	if( $button_bkg == '#000' || $button_bkg == '#000000' ) $button_bkg = lighten_color($button_bkg, '1');
	$button_bkg_gradient = lighten_color($button_bkg, '20');
	$button_text = get_feat_option_value('button_text_color');
	$slide_group = get_feat_option_value('slide_group');
	$inactive_bkg = get_feat_option_value('inactive_counter_color');
	$active_bkg = get_feat_option_value('active_counter_color');
	$hover_bkg = get_feat_option_value('hover_counter_color');
	$counter_border = get_feat_option_value('counter_border_color');
	$counter_text = get_feat_option_value('counter_text_color');
	$arrows_type = get_feat_option_value('arrows_type');
	$arrows_color = get_feat_option_value('arrows_color'); 
	$arrows_bkg = get_feat_option_value('arrows_bkg_color');
	$arrows_hover = get_feat_option_value('arrows_hover_color'); ?>

	<style type="text/css">	
		#feature-wrapper { <?php
			if( $bkg_type == 'gradient' ) echo get_css_gradient($bkg_color);
			else if( $bkg_type == 'color' ) : ?>background-color: <?php echo get_feat_option_value('bkg_color'); ?>;<?php endif; ?>
			color: <?php echo $text_color; ?>;
		}
		#feature-container {
			width:<?php if( $slider_width == 'standard' ) echo '80%'; else echo '100%'; ?>
		}
		.feature-image {
			<?php if( $feature_type == $free_form_feat ) : ?>
				position: absolute;
				right: 10%;
				bottom: 400px;	
			<?php endif; ?>
		}
		#feature-img-1 {
			top: 50px;
		}
		.feature-content {
			<?php if( $feature_type == $free_form_feat ) : ?>
				position: absolute;
				left: 10%;
				top: 400px;
			<?php endif; ?>
		}
		#feature-content-1 {
			top: 175px;
		}
		.feature-text-display-box {
			background-color: rgb( <?php echo $box_bkg_color[0].','.$box_bkg_color[1].','.$box_bkg_color[2]; ?>);
			background-color: rgba( <?php echo $box_bkg_color[0].','.$box_bkg_color[1].','.$box_bkg_color[2].', 0.7'; ?>);
		}
		.call-to-action {
			<?php echo get_css_gradient( $button_bkg, $button_bkg_gradient ); ?>
			color: <?php echo $button_text; ?> !important;	
			<?php if( $feature_type == $free_form_feat ) : ?>
    			line-height: 40px;
    			font-size: 12px;
    			padding: 10px;
    		<?php endif; ?>		
		}
		.call-to-action:hover {
			<?php echo get_css_gradient( $button_bkg_gradient, $button_bkg ); ?>
		}
		.feature-counter {
			background-color: <?php echo $inactive_bkg; ?>;
			color: <?php echo $counter_text; ?>;
			border: 3px solid <?php echo $counter_border; ?>;
		}
		.feature-counter:hover {
			background-color: <?php echo $hover_bkg; ?>;
		}
		.feature-counter-selected {
			background-color: <?php echo $active_bkg; ?>;
		}
		.feature-counter-selected:hover {
			background-color: <?php echo $active_bkg; ?>;
		}
		.feature-arrow {
			background-color: <?php echo $arrows_bkg; ?>;
			<?php if( $slider_width == 'full-width' ) echo 'width: 5%;'; ?>			
		}
		.feature-arrow:hover {
			background-color: <?php echo $arrows_hover; ?>;			
		}
		#feature-move-left {
			background-image: url(<?php echo get_template_directory_uri() . '/images/icons/arrow-left-'.$arrows_color.'.png'; ?>);
		}
		#feature-move-right {
			background-image: url(<?php echo get_template_directory_uri() . '/images/icons/arrow-right-'.$arrows_color.'.png'; ?>);
		}
	</style>
<?php }

function get_feat_bkg_color() {
	if( get_feat_option_value('bkg_color_lock') == false ) {
		$feat_bkg = 'background-color:'.get_post_meta( get_the_ID(), '_bkg_color', true ).';';
	}
	return $feat_bkg;
}

add_action( 'display_rt_feature', 'display_rt_feature' );
function display_rt_feature() {
	
	$feature_type = get_feat_option_value('feature_type');
	$simple_feature = 'simple-slider';
	get_feat_css(); ?>		
	<div id="feature-wrapper">
    	<div id="feature-container"><?php
	
		/* FEATURES LOOP
		----------------------------------------------------------------- */
		$feature_counter = 1;
		$loop = new WP_Query( array ( 'post_type' => 'rt_feature', 'orderby' => 'meta_value', 'order' => 'ASC', 'meta_key' => '_order', 'posts_per_page' => '10' ) );
		while ( $loop->have_posts() ) : $loop->the_post();			
			if( get_post_meta( get_the_ID(), '_disable_feature', true ) == 0 ) : // feature must be active to be used 
				$href = get_post_meta( get_the_ID(), '_linked_content', true ); ?>				
				<?php if( $feature_type == $simple_feature ) : ?><div id="feature-container-<?php echo $feature_counter; ?>" class="feature-container" style="<?php echo get_feat_bkg_color(); ?>" ><?php endif;  
					the_post_thumbnail( 'full', array('class' => 'feature-image', 'id' => 'feature-img-'.$feature_counter ) ); ?>					
					<div id="feature-content-<?php echo $feature_counter; ?>" class="feature-text-display-<?php echo get_feat_option_value('text_display'); ?> feature-content"><?php
						the_title( '<h1 class="feature-title">', '</h1>' );
						the_content();
						// call to action button					
						if( get_feat_option_value('linked_content') == 'button' && $href != '' ) :
							if( get_post_meta( get_the_ID(), '_link_new_window', true ) == true ) $target = '_blank'; else $target ='_self';
							$button_text = get_post_meta( get_the_ID(), '_button_text', true ); ?>
							<a class="call-to-action rt-button" href="<?php echo $href; ?>" target="<?php echo $target; ?>">
								<?php echo $button_text; ?>
							</a>
						<?php endif; ?>
					</div><?php					
				if( $feature_type == $simple_feature ) : ?></div> <!-- END .feature-container --><?php endif;
			$feature_counter++;		
			endif;
		endwhile; // <-- END features loop
		
		/* COUNTERS
		----------------------------------------------------------------- */
		$counter_type = get_feat_option_value('counter_type');
		if( $counter_type != 'none' ) :
			if( $counter_type == 'circles' ) $left_control = 50 - ( ( $feature_counter / 2 ) * 4 );
			else $left_control = 4;
			for( $i = 1; $i < $feature_counter; $i++ ) { ?>
				<div id="feature-counter-<?php echo $i; ?>" class="feature-counter <?php echo $counter_type; ?>-counter" style="left:<?php echo $left_control; ?>%;"><?php if( $counter_type == 'numbers' ) echo $i; ?></div>
				<?php $left_control = $left_control + 4;
			}
		endif;
		
		/* ARROWS
		----------------------------------------------------------------- */	
		$arrows_type = get_feat_option_value('arrows_type'); 
		if( $arrows_type != 'none' ) : ?>
			<div class="feature-arrow feature-arrow-<?php echo $arrows_type; ?>" id="feature-move-left"></div>
			<div class="feature-arrow feature-arrow-<?php echo $arrows_type; ?>" id="feature-move-right"></div>
		<?php endif; ?>
		
		</div> <!-- END #feature-container -->
	</div> <!-- END .feature-wrapper -->
	 
<?php } 

?>