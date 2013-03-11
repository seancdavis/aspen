/* 
when main menu is shown as dropdown, 
this makes a selection of a menu item act as a click on a link.
*/

jQuery(document).ready(function($){
	
	$('#main-menu-small').change(function() {		
		window.open( $(this).attr('value'), '_self' );
	});
		
}); 