function cycleMastSlides() {
  var mast_imgs = $('.'+indexConfig.mastSlideShow.mastheadImgClass);

  for(var i = 0; i < mast_imgs.size(); ++i) {
    if(mast_imgs.eq(i).hasClass(indexConfig.mastSlideShow.imgVisibilityToggleClass)) {
      var nextmast = (i+1)%mast_imgs.size();
      mast_imgs.eq(i).removeClass(indexConfig.mastSlideShow.imgVisibilityToggleClass);
      mast_imgs.eq(nextmast).addClass(indexConfig.mastSlideShow.imgVisibilityToggleClass);
      break;
    }
  }
  setTimeout(function() {cycleMastSlides();}, indexConfig.mastSlideShow.MAST_CYCLE_TIME);
}

$(document).ready(
  function() {
    setTimeout(function() {cycleMastSlides();}, indexConfig.mastSlideShow.MAST_CYCLE_TIME);
  }
);