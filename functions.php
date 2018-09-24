<?php
  require_once('shortcodes.php');
  require_once('Event-Grid-Class.php');

  /**
   * This allows the child theme to be intialized as well as loop through all the parent theme's css files
   * to properly add the child theme style
   */
  function my_theme_enqueue_styles() : void {

      $parent_style = 'minamaze-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

      wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
      wp_enqueue_style( 'child-style',
          get_stylesheet_directory_uri() . '/style.css',
          array( $parent_style ),
          wp_get_theme()->get('Version')
      );
  }
  add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );



  /**
   * This will load the scripts at the header
   */
  function ha_custom_javascripts() : void {
  		echo '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">';
  		echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>';
  	  echo '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/js/ha-custom.js"></script>' . "\n";
      echo '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/js/test.js"></script>' . "\n";
  	}
  add_action( 'wp_head', 'ha_custom_javascripts' );


  /**
   * This will load the scripts at the footer
   */
  function footer_javascripts() : void {
    //get_stylesheet_directory_uri() gets the directory of the childtheme at the root
    echo '<script src="' . get_stylesheet_directory_uri() . '/js/event-grid.js"></script>' . "\n";
    if( is_front_page() or thinkup_check_ishome()) {
      echo '<script src="' . get_stylesheet_directory_uri() . '/js/event-slideshow.js"></script>' . "\n";
    }
  }
  add_action( 'wp_footer', 'footer_javascripts' );





/*
========================================================================================================================================================================
FUNCTIONS USED FOR THE SITE






========================================================================================================================================================================
*/

/**
  * This will return the array of past events
  */
function get_past_event_ids() {
  $pastArray = array();
  $events = EM_Events::get(
    array(
        'scope'=>'past'
    ));
    foreach($events as $key => $eventObjects) {
      $ids[] = $eventObjects -> post_id;
    }
  return $ids;
}




/**
  * Returns an array of at most 3 future event sets if there are any
  * @return array $ids
  */
function get_future_event_ids(){
  $ids = array();
  $studentIDS = array();
  $thompsonIDS = array();
  $tuesdayIDS = array();
  $student = EM_Events::get(
    array(
      'scope'=>'future',
      'order' => 'ASC',
      'limit' => 6,
      'category' => 'student-exhibition'
  ));

  foreach($student as $key => $eventObjects) {
      $studentIDS[]=$eventObjects -> post_id;
  }

  $thompson = EM_Events::get(
    array(
      'scope'=>'future',
      'order' => 'ASC',
      'limit' => 3,
      'category' => 'thompson-gallery'
    ));

  foreach($thompson as $key => $eventObjects) {
      $thompsonIDS[]= $eventObjects -> post_id;
  }

  $tuesday = EM_Events::get(
    array(
      'scope'=>'future',
      'order' => 'ASC',
      'limit' => 3,
      'category' => 'tuesday-night-lecture'
    ));

  foreach($tuesday as $key => $eventObjects) {
      $tuesdayIDS[]= $eventObjects -> post_id;
  }


  $ids[0] = $thompsonIDS;
  $ids[1] = $tuesdayIDS;
  $ids[2] = $studentIDS;
  return $ids;
}


/**
* This will get all the events in an organized matter
* @param eventHTML is the html for each individual event on the slides
* @param ids are the future ids
* @return eventsArray hTML of the events
*/
function get_Events_HTML($eventHTML,$ids) {
  $eventsArray = array();
  //This loop checks for 9 events
  for( $counter = 0; $counter < 3; $counter++ ) {
      for($innerCounter = 0 ; $innerCounter < 3; $innerCounter++) {
          if(!empty($ids[$innerCounter][$counter])) { //this will check if the category has the event
            $currentID = $ids[$innerCounter][$counter];
            $eventsArray[] = do_shortcode("[event post_id='$currentID']
              $eventHTML
            [/event]");
          }
      }
  }
  //If there are still extra slots in the slideshow, put student exhibitions in for the rest
  $currentStudentEvent = 3;
  while(count($eventsArray) < 9) {
    $currentID = $ids[2][$currentStudentEvent];
    $eventsArray[] = do_shortcode("[event post_id='$currentID']
      $eventHTML
      [/event]");
    $currentStudentEvent++;
  }
  return $eventsArray;
}

/**
  * Displays the upcoming events on the front page
  *
  */
function upcoming_events() : void {
$startingdivs = <<< HTML
  <div class='slideshow-container'>
    <h1><i>UPCOMING EVENTS & EXHIBITIONS</i></h1>
HTML;
$eventsHTML ="";
$mySlidesSection ="<div class='mySlides fade'>";
$eventHTML = <<< HTML
    <div class="one-third-event upcoming-event-section">
      <a target="_blank" href=#_EVENTPAGEURL>
        {has_image}
        <img class="event-images" href=#_EVENTIMAGE
        {/has_image}

        {no_image}
        <img class="event-images" src="http://events.ha.sjsu.edu/wp-content/uploads/2016/09/default_734x408_thumb.png">
        {/no_image}

        {has_category_student-exhibition}
        <h4 id="event-category" class="upcoming-events-font">Student Exhibition<br>
        {/has_category_student-exhibition}

        {has_category_thompson-gallery}
        <h4 id="event-category" class="upcoming-events-font">Natalie & James Thompson Gallery<br>
        {/has_category_thompson-gallery}

        {has_category_tuesday-night-lecture}
        <h4 id="event-category" class="upcoming-events-font">Tuesday Night Lecture<br>
        {/has_category_tuesday-night-lecture}
        #_EVENTDATES<br>
        #_EVENTNAME</h4>
      </a>
        <!-- <a target="_blank" href=#_EVENTPAGEURL>#_EVENTNAME</a></h4> -->
    </div>
HTML;
$endOfmySlidesSection = "</div>";
$button = <<< HTML
    <a class="back" onclick="nextSlides(-1)">&#10094;</a>
    <a class="forward" onclick="nextSlides(1)">&#10095;</a>
HTML;
$endingdivs ="</div>";


  $eventsArray=array(); //This will hold the event htmls inside the $eventHTML
  $ids = get_future_event_ids();
  $eventsArray = get_Events_HTML($eventHTML,$ids);
  $totalEvents = count($eventsArray);
  $slideshowEvents = array(); //has 3 events in one slide
  $set = "";
  if($totalEvents !== 0){
    for(  $setCounter = 1, $eventCounter = 0; $eventCounter < $totalEvents; $eventCounter++,$setCounter++ ) {
      $set .= $eventsArray[$eventCounter];
      if($setCounter % 3 === 0) {
        $slideshowEvents[] = $set;
        $set ="";
        $setCounter = 0;
      } else if($setCounter % 3 !== 0 && $eventCounter == $totalEvents-1){
        $slideshowEvents[] = $set;
      }
    }
  } else {
      $slideshowEvents[] = $set;
  }


  if($slideshowEvents[0] === "") {
    echo "No event";
  } else {
    $totalSlides = count($slideshowEvents);
    for($slidesCounter = 0; $slidesCounter < $totalSlides; $slidesCounter++ ){
      if(!empty($slideshowEvents[$slidesCounter])) {
        $addedHTML = $mySlidesSection . $slideshowEvents[$slidesCounter] . $endOfmySlidesSection;
        $eventsHTML .= $addedHTML;
      }
    }

  $html = $startingdivs . $eventsHTML . $button . $endingdivs;
  echo $html;
  }
}


/**
 * This will display the social media buttons on the pre header of the site without using the ThinkUP fcunctions from the parent theme
 */
function social_media_buttons(): void {
  echo '<div id="pre-header-social"><ul>';

 			/* Facebook settings */
 				echo '<li class="social facebook"><a href="https://www.facebook.com/sjsugallery" data-tip="bottom" data-original-title="Facebook" target="_blank">',
 					 '<i class="fa fa-facebook"></i>',
 					 '</a></li>';

      /* Instagram button */
      echo '<li class="social instagram"><a href="https://www.instagram.com/sjsugallery/" data-tip="bottom" data-original-title="Instagram" target="_blank">',
         '<i class="fa fa-instagram"></i>',
         '</a></li>';

 			/* Twitter settings */
 				echo '<li class="social twitter"><a href="https://www.twitter.com/sjsugallery" data-tip="bottom" data-original-title="Twitter" target="_blank">',
 					 '<i class="fa fa-twitter"></i>',
 					 '</a></li>';

 			/* Flickr settings */
 				echo '<li class="social flickr"><a href="https://www.flickr.com/photos/sjsugallery" data-tip="bottom" data-original-title="Flickr" target="_blank">',
 					 '<i class="fa fa-flickr"></i>',
 					 '</a></li>';

 		echo	'</ul></div>';
}






?>
