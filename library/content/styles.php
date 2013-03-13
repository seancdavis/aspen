<?php

// returns <link> tag for sent font. Used for fonts hosted on the web.
function rt_get_font_link($font){
	
	switch($font) {
		case 'Open Sans':
		return "<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>";
		break;
	
		case 'Arvo':
		return "<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>";
		break;
	
		case 'Lato':
		return "<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>";
		break;
	
		case 'Vollkorn':
		return "<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>";
		break;
	
		case 'Ubuntu':
		return "<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>";
		break;
	
		case 'PT Sans':
		return "<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>";
		break;
	
		case 'Droid Sans':
		return "<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>";
		break;
	}	
}

	
?>