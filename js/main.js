//# OF MAST SLIDES
var MAST_SLIDES = 2;
var MAST_CYCLE_TIME = 7000;

function cycleMastSlides() {
	var mast = $('.masthead');
	for(var i = 0; i < MAST_SLIDES; ++i) {
		var thismast = 'mast' + (i+1).toString();
		var nextmast = 'mast' + ((i+1)%MAST_SLIDES + 1).toString();
		if(mast.hasClass(thismast)) {
			mast.removeClass(thismast).addClass(nextmast);
			break;
		}
	}
	setTimeout(function() {cycleMastSlides();}, MAST_CYCLE_TIME);
}


$(document).ready(
	function() {
		setTimeout(function() {cycleMastSlides();}, MAST_CYCLE_TIME);
	}
);