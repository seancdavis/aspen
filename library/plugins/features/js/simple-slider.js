/*
Title: Feature Slider jQuery Plugin
Author: Sean C. Davis
Author URI: http://thepolymathlab.com

Version: 1.0
Date: 12/2/2012

TABLE OF CONTENTS
-------------------
	=SETUP
	=AUTO SLIDE
	=arrow CLICK
	=counter CLICK
	=RESIZING CONTROL

*/

jQuery(document).ready(function($) {

	/* =SETUP
	---------------------------------------------- */
	
	// slider settings
	var sliderType = 'together';
	if( $('#slide-type-control').length > 0 ) {
		var imgSlide = new Array();
		$('.img-slide').each(function(){ imgSlide.push( $(this).attr('value') ); });
		var textSlide = new Array();
		$('.text-slide').each(function(){ textSlide.push( $(this).attr('value') ); });
		$('#slide-type-control').remove();
		sliderType = 'separate';
	}
	
	// Variable Setup
	//counts number of features (requires class="feature-container")
	var featureCount = $(".feature-container").length;	
	// init feature position
	var position = 1;
	var previous = featureCount;
	var next = 2;
	// controls timing between clicks on control counters. init on page load
	var oldTime = new Date();
	var clickDiff = 0;
	var newTime = new Date();
	
	// Not sure if I still need this image resizing or not. needs further testing before deleting.
	/*for(j = 1; j < (featureCount + 1); j++) {
		
		var height = $("#feature-container-" + j + " img").attr('height');
		var width = $("#feature-container-" + j + " img").attr('width');
		var ratio = width / height;
		height = 250;
		width = ratio * height;
		
		$("#feature-container-" + j + " img").attr('height', height);
		$("#feature-container-" + j + " img").attr('width', width);
		
	}*/

	// sets init selection as the first feature
	// class="feature-counter-selected" enables the control counter color to be controlled via CSS	
	$('#feature-counter-1').addClass('feature-counter-selected');
	
	// <-- END SETUP
	
	
	/* =AUTO SLIDE
	---------------------------------------------- */	
	// sets the automatic slide only if the window is wider than 700px
	if(window.innerWidth > 768 /* if the window isn't as wide as this, the auto slide will not begin */ ) { 
		var featureInterval = setInterval(function() {autoSlide()},3000); // this number is the slide interval length (1/1000 sec)
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
		
		$("#feature-container-" + position).css('z-index','20');
		$("#feature-container-" + previous).css('z-index','10');
		
		// sliding animation
		$("#feature-container-" + position).css('left','102%'); // puts next feature in position (right side of screen)
		$("#feature-container-" + position).animate({left: '0%'},1000); // slides next feature into screen
		$("#feature-container-" + previous).animate({left: '-102%',},1000); // slides previous feature out of screen (to left)
		setTimeout(function(){ $("#feature-container-" + previous).css('left', '101%') },1050);
		
	} // <-- END AUTO SLIDE
	
	
	/* =arrow CLICK
	---------------------------------------------- */
	$("#feature-move-right").click(function() {
		
		if( position == featureCount ) {			
			slideLeft(1);			
		}
		else {
			slideLeft(next);
		}
		
	});
	
	$("#feature-move-left").click(function() {
		
		if( position == 1 ) {			
			slideRight(featureCount);			
		}
		else {
			slideRight(previous);
		}
		
	});
	
	/* =counter CLICK
	---------------------------------------------- */
	$(".feature-counter").click(function() {
		
		var id = $(this).attr('id');		
		var id = id.substr(id.length - 1);
		
		slideLeft(id);
		
	});
	
	// this function is needed to ensure the first control counter can be clicked
	$(".feature-counter-selected").click(function() {
		
		var id = $(this).attr('id');		
		var id = id.substr(id.length - 1);
		
		slideLeft(id);
		
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
			
			$("#feature-container-" + id).css('z-index','20');
			$("#feature-container-" + lastID).css('z-index','10');
			
			// animates the feature sliding
			$("#feature-container-" + id).css('left','102%');		
			$("#feature-container-" + id).animate({left: '0%'},1000);
			$("#feature-container-" + lastID).animate({left: '-102%',},1000);
			setTimeout(function(){ $("#feature-container-" + lastID).css('left', '101%') },1050);
			
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
			
			$("#feature-container-" + id).css('z-index','20');
			$("#feature-container-" + lastID).css('z-index','10');
			
			// animates the feature sliding
			$("#feature-container-" + id).css('left','-102%');		
			$("#feature-container-" + id).animate({left: '0%'},1000);
			$("#feature-container-" + lastID).animate({left: '102%',},1000);
			setTimeout(function(){ $("#feature-container-" + lastID).css('left', '101%') },1050);
			
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
				$("#feature-container-" + j).css('left','0');	
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
				if( j == 1 ) $("#feature-container-" + j).css('left','0');
				else $("#feature-container-" + j).css('left','100%');	
			}
		}
	} // <-- END RESIZING CONTROL

});
