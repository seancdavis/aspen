// pulls the footer (and footer widget) to the bottom of the page if content does not fill full height

jQuery(document).ready(function($) {
	if( $('.rt-social-icon').length > 0 ) {
		$('.rt-social-icon').tooltip({
			position: {
			my: "center+20 bottom+40",
	        //at: "center top",
	        using: function( position, feedback ) {
	          $( this ).css( position );
	          $( "<div>" )
	            .addClass( "arrow" )
	            .appendTo( this );
	        }
	      }
		});
	}
	
});