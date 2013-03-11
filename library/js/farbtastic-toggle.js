// controls animation and display of farbtastic color wheel on admin pages
jQuery(document).ready(function($) {
	
	if( $('#rt-farb-1').length != 0) { // only runs if this ID exists on the page
		$('#rt-farb-1').hide();
    	$('#rt-farb-1').farbtastic("#rt-farb-input-1");
    	$("#rt-farb-input-1").click(function(){$('#rt-farb-1').slideToggle()});
	
		$('#rt-farb-2').hide();
		$('#rt-farb-2').farbtastic("#rt-farb-input-2");
		$("#rt-farb-input-2").click(function(){$('#rt-farb-2').slideToggle()});
	}
		
});