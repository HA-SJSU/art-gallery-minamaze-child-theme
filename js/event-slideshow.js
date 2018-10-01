

function nextSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }

  if(slides != null) {
    slides[slideIndex-1].style.display = "block";
  }
}

/**
 * This will change the slide depending on the size of the screen
 * @return {[type]} [description]
 */
function responsiveSlideshow(){
  jQuery(document).ready(function($){
    if($(window).width() < 620) {      // let parentNodeArray = document.getElementsByClassName("slideshow-container");
      let events = document.getElementsByClassName("upcoming-event-section");
      $(".mySlides").contents().unwrap();
      $(".upcoming-event-section").wrap("<div class='mySlides fade'></div>");
      $(".upcoming-event-section").removeClass("one-third-event");
      let slideIndex = 1;
      showSlides(slideIndex);
    } else {

    }
  });
}



let slideIndex = 1;
showSlides(slideIndex);// Next/previous controls
responsiveSlideshow();
jQuery(document).ready(function($){
  $(window).resize(responsiveSlideshow);
})
