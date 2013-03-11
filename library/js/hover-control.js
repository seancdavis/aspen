// adds hover effects to WordPress menus
jQuery(document).ready(function($) {
	
	$(".main-menu ul").hover(function() {
		$(this).parent().attr('id', 'main-menu-parent_hover');
	},
	function() {
		$(this).parent().attr('id', 'main-menu-parent_no-hover');		
	});
	
	$('.main-menu li').hover(function() {
		if( $(this).parent().attr('class') != 'sub-menu' ) {
			$(this).children( 'ul' ).slideDown(500);
		}
	}, 
	function() {
		$(this).children( 'ul' ).hide();
	});
	
});