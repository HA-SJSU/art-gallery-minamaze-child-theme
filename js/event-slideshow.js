let slideIndex = 1;
showSlides(slideIndex);// Next/previous controls

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
    if(screen.availWidth < 618) {
      let parentNode = getElementsByClassName("slideshow-container");
      let childNode = getElementsByClassName("")
      // $(".slideshow-container").hide();
    }
  });
}
