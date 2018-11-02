

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
 */
function responsiveSlideshow(){
  jQuery(document).ready(function($){
    if($(window).width() < 768) {
      $(".mySlides").contents().unwrap();
      $(".upcoming-event-section").wrap("<div class='mySlides fade'></div>");
      $(".upcoming-event-section").removeClass("one-third-event");
      showSlides(slideIndex);
    } else {
      let mySlidesDiv = document.getElementsByClassName("mySlides fade");
      if(mySlidesDiv.length >= 3) {
          $(".upcoming-event-section").addClass("one-third-event");
          $(".mySlides").contents().unwrap();
          let events = document.getElementsByClassName("upcoming-event-section");
          eventsLength = events.length;

          let counter = 1;
          let arrayOfHtml = [];
          let innerHtml = "";
          for(let i=0; i < eventsLength; i++,counter++) {
            let formatHTML = "<div class='one-third-event upcoming-event-section'>" + events[i].innerHTML + "</div>";
            innerHtml += formatHTML;
            if(counter % 3 == 0) {
              arrayOfHtml.push(innerHtml);
              innerHtml="";
            }
          }
          if(innerHtml != "")
            arrayOfHtml.push(innerHtml); //This will pick up any left over divs if it's not an even set of 3
          let length = arrayOfHtml.length;
          for(let i = 0;i < length; i++){
            $("<div class='mySlides fade'></div>").insertBefore(".back");
          }
          $(".upcoming-event-section").remove();
          $(".mySlides").each(function(index,value){
            $(this).wrapInner(arrayOfHtml[index]);
          });
          showSlides(slideIndex);
      }
    }
  });
}



let slideIndex = 1;
showSlides(slideIndex);// Next/previous controls
responsiveSlideshow();
jQuery(document).ready(function($){
  slideIndex = 1;
  // $(window).resize(responsiveSlideshow());
  $(window).resize(function() {
    responsiveSlideshow();
  });
})
