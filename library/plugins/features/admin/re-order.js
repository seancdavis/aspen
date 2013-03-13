// This script controls the data as features are dragged and dropped.
jQuery(document).ready(function($) {
	var currentURL = window.location.pathname;
  	// counts active features
	var activeFeatures = $('#sortable-features').children().length; 
	var thisID = 0;
	var thisPosition = 0;
	var newValue = '';
  
	$("#sortable-features").sortable({ 
		cursor: 'move',
		update : function () { 
		
			$('#results').html('');
		
			var results = $('#sortable-features').sortable('toArray');
			
			for( thisFeature = 0; thisFeature < activeFeatures; thisFeature++ ) {
				
				if( results[thisFeature].substr(9,1) == '_' ) {					
					thisPosition = results[thisFeature].substr(8,1);
				}
				else {
					thisPosition = results[thisFeature].substr(8,2);
				}
				
				if( thisPosition.substr(1,1) == '' ) {
					thisID = results[thisFeature].substr(10);
				}
				else {
					thisID = results[thisFeature].substr(11);
				}
				
				if( (thisFeature + 1) < 10 ) {	
					
					newValue = thisFeature + 1;
					
					$('#input_' + thisID).attr('value', '0' + newValue); 
				}
				else {
					$('#input_' + thisID).attr('value',(thisFeature + 1));
				}
				
			}
		
		} 
	});
	
});