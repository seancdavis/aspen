<?php
	
add_shortcode( 'column', 'build_column_shortcode' );

function build_column_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'col' => '1-2',
		'new_line' => false
	), $atts ) );
 
	if( $new_line == false ) return '<div class="col-' . esc_attr($col) . ' rt-col">' . do_shortcode($content) . '</div>';
	else return '<div class="col-' . esc_attr($col) . ' rt-col" style="clear:both;">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'tile', 'build_tile_shortcode' );

function build_tile_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'normal',
		'col' => '1-2',
		'url' => '',
		'newline' => ''
	), $atts ) );
	
	if( $newline == true ) $newline = 'style="clear:both;"';
	
	switch($type) {
		
		case 'icon' :
			return '<div class="tile-' . esc_attr($col) . ' rt-tile rt-tile-icon" '.$newline.'>' . do_shortcode($content) . '</div>';
			break;
			
		case 'thumb' || 'thumbnail' :
			if( $url != '' ) return '<a href="' . $url . '"><div class="tile-' . esc_attr($col) . ' rt-tile rt-tile-thumb" '.$newline.'>' . do_shortcode($content) . '</div></a>';
			else return '<div class="tile-' . esc_attr($col) . ' rt-tile rt-tile-thumb" '.$newline.'>' . do_shortcode($content) . '</div>';
			break;
			
		case 'normal' :
			return '<div class="tile-' . esc_attr($col) . ' rt-tile">' . do_shortcode($content) . '</div>';
			break;
			
		default :
			return '<div class="rt-error">Error: Incorrect argument for type=""</div> ' . do_shortcode($content);
			
	}		
}
	
?>