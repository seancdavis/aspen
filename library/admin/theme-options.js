// adds hover effects to WordPress menus
jQuery(document).ready(function($) {	
	// we hide from here in case the js file doesn't load, the user can still access the settings
	$('.rt-settings-section').hide();
	var this_focus = $('#rt-hidden-options-control').val();
	$('#' + this_focus).show();
	$('.' + this_focus).attr('id','rt-options-menu_hover');
	$('#rt-options-menu-control').val(this_focus);
	$('#rt-submit-options').show();
	$('#rt-options-menu').show();
	var control = this_focus;
	// click control
	$('#rt-options-menu li').click(function(){
		var id = $(this).attr('class');
		if( id != control ) {
			$('#rt-options-menu-control').val(id);
			$('.rt-settings-section').fadeOut(500);
			$('.' + control).attr('id','rt-options-menu_no-hover');
			$('.' + id).attr('id','rt-options-menu_hover');
			setTimeout(function(){
				$('#' + id).fadeIn(500);
				$('#rt-submit-options').fadeIn(500);
			},500);
			control = id;
		}	
	});	
	// upload logo control
	$('#rt-logo-button').click(function() {
	 formfield = $('#rt-logo').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false;
	});
	window.send_to_editor = function(html) {
	 imgurl = $('img',html).attr('src');
	 $('#rt-logo').val(imgurl);
	 $('#rt-logo-preview').attr('src',imgurl)
	 $('#rt-logo-preview').show();
	 tb_remove();
	}
	// controls max height and width of logo (and changes dynamically on options page)
	$('#rt-logo-width').keyup(function(){
		$('#rt-logo-preview').css('max-width',$(this).val() + 'px');
	});
	$('#rt-logo-height').keyup(function(){
		$('#rt-logo-preview').css('max-height',$(this).val() + 'px');
	});
	// removes logo
	$('#rt-remove-logo').click(function(){		
		$('#rt-logo').attr('value','');
		$('#rt-logo-preview').fadeOut(500);
	});
});
