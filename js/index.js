function cycleMastSlides() {
  var mast_imgs = $('.'+indexConfig.MastSlideShow.MastImgClass);
  var quotes = $('.'+indexConfig.MastSlideShow.QuoteClass);

  for(var i = 0; i < mast_imgs.size(); ++i) {
    if(mast_imgs.eq(i).hasClass(indexConfig.MastSlideShow.ImgToggleClass)) {
      var nextmast = (i+1)%mast_imgs.size();
      mast_imgs.eq(i).removeClass(indexConfig.MastSlideShow.ImgToggleClass);
      quotes.eq(i).removeClass(indexConfig.MastSlideShow.QuoteToggleClass);
      mast_imgs.eq(nextmast).addClass(indexConfig.MastSlideShow.ImgToggleClass);
      quotes.eq(nextmast).addClass(indexConfig.MastSlideShow.QuoteToggleClass);
      break;
    }
  }
  setTimeout(function() {cycleMastSlides();}, indexConfig.MastSlideShow.CycleTime);
}

$(document).ready(
  function() {
    setTimeout(function() {cycleMastSlides();}, indexConfig.MastSlideShow.CycleTime);
  }
);