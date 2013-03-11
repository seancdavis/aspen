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
	=CIRCLE CLICK
	=RESIZING CONTROL

*/

jQuery(document).ready(function($) {

	/* =SETUP
	---------------------------------------------- */
	// Variable Setup
	//counts number of features (requires class="feature-container")
	var featureCount = $(".feature-container").length;
	// finds starting point for positioning of circles
	var circleLeft = 52 - ((featureCount / 2) * 4);	
	// init feature position
	var position = 1;
	var previous = featureCount;
	var next = 2;
	// controls timing between clicks on control circles. init on page load
	var oldTime = new Date();
	var clickDiff = 0;
	var newTime = new Date();
	
	// creates and positions control circles
	for(i = 1; i < (featureCount + 1); i++) {				
		$("#feature-wrapper").prepend("<div id='feature-circle-" + i + "' class='feature-circle' style='left:" + circleLeft + "%'></div>");		
		circleLeft = circleLeft + 4;		
	}
	
	for(j = 1; j < (featureCount + 1); j++) {
		
		var height = $("#feature-container-" + j + " img").attr('height');
		var width = $("#feature-container-" + j + " img").attr('width');
		var ratio = width / height;
		height = 250;
		width = ratio * height;
		
		$("#feature-container-" + j + " img").attr('height', height);
		$("#feature-container-" + j + " img").attr('width', width);
		
	}

	// sets init selection as the first feature
	// class="feature-circle-selected" enables the control circle color to be controlled via CSS	
	$('#feature-circle-1').attr('class','feature-circle-selected');
	
	// <-- END SETUP
	
	
	/* =AUTO SLIDE
	---------------------------------------------- */	
	// sets the automatic slide only if the window is wider than 700px
	if(window.innerWidth > 700 /* if the window isn't as wide as this, the auto slide will not begin */ ) { 
		var featureInterval = setInterval(function() {autoSlide()},5000); // this number is the slide interval length (1/1000 sec)
	}
	
	function autoSlide() {
		
		// changes color of control circle		
		$(".feature-circle-selected").attr('class','feature-circle');
		$("#feature-circle-" + next).attr('class','feature-circle-selected');	
		
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
		$("#feature-container-" + position).css('left','100%'); // puts next feature in position (right side of screen)
		$("#feature-container-" + position).animate({left: '-1%'},1000); // slides next feature into screen
		$("#feature-container-" + previous).animate({left: '-101%',},1000); // slides previous feature out of screen (to left)
		
	} // <-- END AUTO SLIDE
	
	
	/* =CIRCLE CLICK
	---------------------------------------------- */
	$(".feature-circle").click(function() {
		
		var id = $(this).attr('id');		
		var id = id.substr(id.length - 1);
		
		clickSlide(id);
		
	});
	
	// this function is needed to ensure the first control circle can be clicked
	$(".feature-circle-selected").click(function() {
		
		var id = $(this).attr('id');		
		var id = id.substr(id.length - 1);
		
		clickSlide(id);
		
	});
	
	function clickSlide(id) {
		
		// control variable init
		var lastID = position;
		
		// calculates time since last click on a circle
		newTime = new Date();
		clickDiff = (newTime - oldTime) / 1000;
		
		// !IMPORTANT!
		// stops auto slide when control circle is clicked
		window.clearInterval(featureInterval);	
		
		// feature will slide IF:
			// 1) the control circle clicked is different than the current displayed feature
			// 2) time since last click is greater than 1 second (WARNING: changing this may result in undesired feature sliding)
		if(id != position && clickDiff > 1) {
			
			// changes color of control circles
			$(".feature-circle-selected").attr('class','feature-circle');
			$("#feature-circle-" + id).attr('class','feature-circle-selected');	
			
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
			$("#feature-container-" + id).css('left','100%');		
			$("#feature-container-" + id).animate({left: '-1%'},1000);
			$("#feature-container-" + lastID).animate({left: '-101%',},1000);
			
			// stores when click occured
			oldTime = newTime;	
		}
	} // <-- END CIRCLE CLICK
	
	
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
	} // <-- END RESIZING CONTROL

});
