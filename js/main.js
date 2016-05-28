//# OF MAST SLIDES
var MAST_CYCLE_TIME = 3700;

function cycleMastSlides() {
	var mast_imgs = $('.masthead-img');

	for(var i = 0; i < mast_imgs.size(); ++i) {
		if(mast_imgs.eq(i).hasClass('show-masthead-img')) {
			var nextmast = (i+1)%mast_imgs.size();
			mast_imgs.eq(i).removeClass('show-masthead-img');
			mast_imgs.eq(nextmast).addClass('show-masthead-img');
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