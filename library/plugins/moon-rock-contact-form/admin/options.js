jQuery(document).ready(function($) {		
	if( $('#rt-email-notification').val() == 'Off' ) {
		$('.email-options').css('color','#CCC');
		$('.email-options').attr('disabled','disabled');
	}
	else {
		$('.email-options').css('color','#000');
	}
	
	$('#rt-email-notification').change(function(){
		if( $(this).val() == 'Off' ) {
			$('.email-options').css('color','#CCC');
			$('.email-options').attr('disabled','disabled');
		}
		else {
			$('.email-options').css('color','#000');
			$('.email-options').attr('disabled',false);
		}
	});
	
	$('#submit').click(function(){
		$('.email-options').attr('disabled',false);
	});
});