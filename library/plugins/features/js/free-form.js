/*

*/

jQuery(document).ready(function($) {

	/* =SETUP
	---------------------------------------------- */	
	// Variable Setup
	//counts number of features (requires class="feature-container")
	var featureCount = $(".feature-content").length;	
	// init feature position
	var position = 1;
	var previous = featureCount;
	var next = 2;
	// controls timing between clicks on control counters. init on page load
	var oldTime = new Date();
	var clickDiff = 0;
	var newTime = new Date();
	
	var contentTop = '175px';
	var imgTop = '50px';
	
	var autoToggle = 'on';

	// sets init selection as the first feature
	// class="feature-counter-selected" enables the control counter color to be controlled via CSS	
	$('#feature-counter-1').addClass('feature-counter-selected');
	
	// <-- END SETUP
	
	
	/* =AUTO SLIDE
	---------------------------------------------- */	
	// sets the automatic slide only if the window is wider than 700px
	if(window.innerWidth > 768 /* if the window isn't as wide as this, the auto slide will not begin */ ) { 
		var featureInterval = setInterval(function() {autoSlide()},4500); // this number is the slide interval length (1/1000 sec)
	}
	else {
		for(j = 1; j < featureCount + 1; j++) {
			$("#feature-content-" + j).css({
				'top':'0',
				'left':'0',
				'position':'relative',
			});	
		}
	}
	
	function autoSlide() {
		
		// changes color of control counter		
		$(".feature-counter-selected").removeClass('feature-counter-selected');
		$("#feature-counter-" + next).addClass('feature-counter-selected');	
		
		// control variables to help slide the correct feature
		if(position == featureCount) {
			position = 1;
			previous++;
			next++;
		}
		else if(position == 1) {
			position++;
			next++;
			previous = 1;
		}
		else if(position == featureCount - 1) {
			position++;
			next = 1;
			previous++;
		}
		else {
			position++;
			next++;
			previous++;
		}
		
		// sliding animation
		// positioning
		$("#feature-content-" + position).css('top','400px'); // puts next feature in position (right side of screen)
		$("#feature-content-" + previous).animate({
				top: '-200px',
			}, {
				duration: 500,
				specialEasing: {
					top: 'easeInBack'
				}
			}
		);
		var imgHeight = $("#feature-img-" + position).height();
		$("#feature-img-" + position).css('top','-' + imgHeight + 'px');
		$("#feature-img-" + previous).animate({
				top: '400px',
			}, {
				duration: 500,
				specialEasing: {
					top: 'easeInBack'
				}
			}
		);
		setTimeout(function(){
			$("#feature-content-" + position).animate({
					top: contentTop
				}, {
					duration: 500,
					specialEasing: {
						top: 'easeOutBack'
					}
				}
			);
			$("#feature-img-" + position).animate({
					top: imgTop
				}, {
					duration: 500,
					specialEasing: {
						top: 'easeOutBack'
					}
				}
			);
		}, 500);
		
		
	} // <-- END AUTO SLIDE
	
	
	/* =arrow CLICK
	---------------------------------------------- */
	$("#feature-move-right").click(function() {
		
		if( autoToggle == 'on' ) {
			setTimeout(function(){ 
				slideLeft(next);
			}, 400);
			autoToggle = 'off';	
		}
		else slideLeft(next);
		
	});
	
	$("#feature-move-left").click(function() {
		
		if( autoToggle == 'on' ) {
			setTimeout(function(){
				slideRight(previous);
			}, 400);
			autoToggle = 'off';	
		}
		else slideRight(previous);
		
	});
	
	/* =counter CLICK
	---------------------------------------------- */
	$(".feature-counter").click(function() {
		
		var id = $(this).attr('id');		
		var id = id.substr(id.length - 1);
		
		if( autoToggle == 'on' ) {
			setTimeout(function(){
				slideLeft(id);
			}, 400);
			autoToggle = 'off';	
		}
		else slideLeft(id);
		
	});
	
	function slideLeft(id) {
		id = parseInt(id);
		// control variable init
		var lastID = position;
		
		// calculates time since last click on a counter
		newTime = new Date();
		clickDiff = (newTime - oldTime) / 1000;
		
		// !IMPORTANT!
		// stops auto slide when control counter is clicked
		window.clearInterval(featureInterval);	
		
		// feature will slide IF:
			// 1) the control counter clicked is different than the current displayed feature
			// 2) time since last click is greater than 1 second (WARNING: changing this may result in undesired feature sliding)
		if(id != position && clickDiff > 1) {
			
			// changes color of control counters
			$(".feature-counter-selected").removeClass('feature-counter-selected');
			$("#feature-counter-" + id).addClass('feature-counter-selected');	
			
			// controls order of features
			if(id == featureCount) {
				position = id;
				next = 1;
				previous = position - 1;
			}
			else if(id == 1) {
				position = 1;
				next = 2;
				previous = featureCount;
			}
			else {
				position = id;
				next = position + 1;
				previous = position - 1;
			}
			
			// sliding animation
			// positioning
			$("#feature-content-" + position).css('top','400px'); // puts next feature in position (right side of screen)
			$("#feature-content-" + lastID).animate({
					top: '-200px',
				}, {
					duration: 500,
					specialEasing: {
						top: 'easeInBack'
					}
				}
			);
			var imgHeight = $("#feature-img-" + position).height();
			$("#feature-img-" + position).css('top','-' + imgHeight + 'px');
			$("#feature-img-" + lastID).animate({
					top: '400px',
				}, {
					duration: 500,
					specialEasing: {
						top: 'easeInBack'
					}
				}
			);
			setTimeout(function(){
				$("#feature-content-" + position).animate({
						top: contentTop
					}, {
						duration: 500,
						specialEasing: {
							top: 'easeOutBack'
						}
					}
				);
				$("#feature-img-" + position).animate({
						top: imgTop
					}, {
						duration: 500,
						specialEasing: {
							top: 'easeOutBack'
						}
					}
				);
			}, 500);
			
			// stores when click occured
			oldTime = newTime;	
		}
	}
	
	function slideRight(id) {
		id = parseInt(id);
		// control variable init
		var lastID = position;
		
		// calculates time since last click on a counter
		newTime = new Date();
		clickDiff = (newTime - oldTime) / 1000;
		
		// !IMPORTANT!
		// stops auto slide when control counter is clicked
		window.clearInterval(featureInterval);	
		
		// feature will slide IF:
			// 1) the control counter clicked is different than the current displayed feature
			// 2) time since last click is greater than 1 second (WARNING: changing this may result in undesired feature sliding)
		if(id != position && clickDiff > 1) {
			
			// changes color of control counters
			$(".feature-counter-selected").removeClass('feature-counter-selected');
			$("#feature-counter-" + id).addClass('feature-counter-selected');	
			
			// controls order of features
			if(id == 1) {
				position = id;
				next = 2;
				previous = featureCount;
			}
			else if(id == featureCount) {
				position = id;
				next = 1;
				previous = position - 1;
			}
			else {
				position = id;
				next = position + 1;
				previous = position - 1;
			}
			
			// sliding animation
			// positioning
			$("#feature-content-" + position).css('top','400px'); // puts next feature in position (right side of screen)
			$("#feature-content-" + lastID).animate({
					top: '-200px',
				}, {
					duration: 500,
					specialEasing: {
						top: 'easeInBack'
					}
				}
			);
			var imgHeight = $("#feature-img-" + position).height();
			$("#feature-img-" + position).css('top','-' + imgHeight + 'px');
			$("#feature-img-" + lastID).animate({
					top: '400px',
				}, {
					duration: 500,
					specialEasing: {
						top: 'easeInBack'
					}
				}
			);
			setTimeout(function(){
				$("#feature-content-" + position).animate({
						top: contentTop
					}, {
						duration: 500,
						specialEasing: {
							top: 'easeOutBack'
						}
					}
				);
				$("#feature-img-" + position).animate({
						top: imgTop
					}, {
						duration: 500,
						specialEasing: {
							top: 'easeOutBack'
						}
					}
				);
			}, 500);
			
			// stores when click occured
			oldTime = newTime;	
		}
	}
	
	
	/* =RESIZING CONTROL
	---------------------------------------------- */	
	// if window is resized to less than 700px wide after auto slide has begun to run, this resets everything and kills slide functionality and displays all features on the page.
	window.onresize = function() {
		if(window.innerWidth <= 768) {
			window.clearInterval(featureInterval);
			
			for(j = 1; j < featureCount + 1; j++) {
				$("#feature-content-" + j).css({
					'top':'0',
					'left':'0',
					'position':'relative',
				});	
			}
		}
		else {
			window.clearInterval(featureInterval);
			
			$(".feature-counter-selected").removeClass('feature-counter-selected');
			$("#feature-counter-1").addClass('feature-counter-selected');
			
			previous = featureCount;
			position = 1;
			next = 2;
			
			for(j = 1; j < featureCount + 1; j++) {
				if( j == 1 ) $("#feature-content-" + j).css('top',contentTop);
				else $("#feature-content-" + j).css('top','400px');
				$("#feature-content-" + j).css('left','10%');	
			}
		}
	} // <-- END RESIZING CONTROL

});
