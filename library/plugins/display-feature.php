<?php

/* Display Feature --- usually called from header.php
------------------------------------------------------------------------- */
add_action( 'display_feature', 'display_feature_content' );

function display_feature_content() {
	
	$feature_counter = 1; 
	
	// Default background colors
	$def_bkg_1 = rt_get_feature_option( 'rt_feat_bkg_1' );
	$def_bkg_2 = rt_get_feature_option( 'rt_feat_bkg_2' ); ?>
	
	<div id="feature-wrapper">
	
	<?php $loop = new WP_Query( array ( 'post_type' => 'rt_feature', 'orderby' => 'meta_value', 'order' => 'ASC', 'meta_key' => '_order', 'posts_per_page' => '100' ) );

		while ( $loop->have_posts() ) : $loop->the_post();			
			
			$disable_feature = get_post_meta( get_the_ID(), '_disable_feature', true );
			
			// feature must be active to be used
			if( $disable_feature == 0 ) {
				
				// get the background (meta) values for this post
				$this_bkg_1 = get_post_meta( get_the_ID(), '_background_1', true );
				$this_bkg_2 = get_post_meta( get_the_ID(), '_background_2', true );	
				
				// These really work together, but trigger the default if not meta value has been set
				if($this_bkg_1 == '') { $this_bkg_1 = $def_bkg_1; }
				if($this_bkg_2 == '') { $this_bkg_2 = $def_bkg_2; }				
				
				// toggle for whether to use gradient or not
				if( $this_bkg_2 == '#' ) {
					echo '<div id="feature-container-' . $feature_counter . '" class="feature-container" style="background-color:' . $this_bkg_1 . ';">';
				} 
				else {					
					echo '<div id="feature-container-' . $feature_counter . '" class="feature-container" style="background-color: ' . $this_bkg_1 . '; background-image: -webkit-gradient(linear, left top, left bottom, from(' . $this_bkg_1 . '), to(' . $this_bkg_2 . ')); background-image: -webkit-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . ');	background-image: -moz-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . ');	background-image: -ms-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . '); background-image: -o-linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . '); background-image: linear-gradient(top, ' . $this_bkg_1 . ', ' . $this_bkg_2 . '); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=' . $this_bkg_1 . ', endColorstr=' . $this_bkg_2 . ');">';					
				} ?>
                	
                    <?php the_post_thumbnail( 'full', array('class' => 'feature-image')); ?>
					
					<?php the_title( '<h1 class="feature-title">', '</h1>' ); ?>
					
						<?php the_content(); ?>
					
					<div class="call-to-action-container">
					
                    	<?php 
							$button_text = get_post_meta( get_the_ID(), '_button_text', true );
							$button_url = get_post_meta( get_the_ID(), '_button_url', true );
							$button_target = get_post_meta( get_the_ID(), '_button_target', true );
							
							echo '<a class="feature-link" target="' . $button_target . '" href="' . $button_url . '"><span class="call-to-action">' . $button_text . '</span></a>'; ?>
				
					</div>
					
				</div>
			
				<?php $feature_counter++;
			
			}
			
		endwhile; ?>
        
	</div>

<?php } ?>