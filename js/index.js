"use strict";
function cycleMastSlides() {
  var mast_imgs = $('.masthead-img');
  var quotes = $('.quote');

  for(var i = 0; i < mast_imgs.size(); ++i) {
    // is this mast active?
    if(mast_imgs.eq(i).hasClass('show-masthead-img')) {
      var nextmast = (i+1)%mast_imgs.size();
      // hide it
      mast_imgs.eq(i).removeClass('show-masthead-img');
      quotes.eq(i).removeClass('show-quote');
      // show next mast
      mast_imgs.eq(nextmast).addClass('show-masthead-img');
      quotes.eq(nextmast).addClass('show-quote');
      break;
    }
  }
  setTimeout(function() {cycleMastSlides();}, indexConfig.MastSlideShow.CycleTime);
}

$(document).ready(function() {
    setTimeout(cycleMastSlides, indexConfig.MastSlideShow.CycleTime);
});