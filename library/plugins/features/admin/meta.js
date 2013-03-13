jQuery(document).ready(function($){
	if( $('.existing-content-list').length > 0 ) {
		$('.show-existing-content-list').toggle(function(){
			$('.existing-content-list').slideDown();
			$('.show-existing-content-list').html('Hide existing content list');
		}, function() {
			$('.existing-content-list').slideUp();
			$('.show-existing-content-list').html('Show existing content list');
		});
		$('.existing-content-item').click(function(){
			$('.existing-content-item').removeClass('existing-content-item-selected');
			$('#_linked_content').attr( 'value', '' );
			$('#_linked_content').attr( 'value',$(this).attr('id') );
			$(this).addClass('existing-content-item-selected');
		});
	}
});
