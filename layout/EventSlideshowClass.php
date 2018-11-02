<?php
require_once('EventInterface.php');
/**
 * This creates a slideshow to show on the front page, there must not be two slideshows or else the JavaScript
 * will not function correctly.
 */
class EventSlideshow implements Event {
  private $html;
  private $time;
  private $singleEventFormat;

  /**
   * This will initialize the class with a default slideshow
   * @param string $time Accepts 'past' or 'future', refer to the Event Manager Documentation here:
   * https://wp-events-plugin.com/documentation/event-search-attributes/
   */
  public function __construct($time = "future",$order) {
      $this->$html = "";
      $this->order ="";
      switch($time) {
        case 'future':
          $this->time = $time;
          break;
        case 'past':
          $this->time = $time;
          break;
        case preg_match('[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-1][0-9]
        ,[0-9][0-9]/[0-9][0-9]/[0-9][0-9][0-9][0-9]'):
          $this->time = $time;
          break;
        default:
          $this->time = 'future';
      }
      $this->time = $time;
      $this->singleEventFormat = <<< HTML
        <div class="one-third-event upcoming-event-section">
          <a target="_blank" href="#_EVENTPAGEURL" alt="This goes to a new page for the #_EVENTNAME event">
            {has_image}
            <img class="event-images" src="#_EVENTIMAGEURL">
            {/has_image}

            {no_image}
            <img class="event-images" src="http://events.ha.sjsu.edu/wp-content/uploads/2016/09/default_734x408_thumb.png">
            {/no_image}

            <h4 title="#_EVENTNAME" id="event-descriptions">
              #_EVENTDATES<br>
              #_EVENTNAME
            </h4>
          </a>
        </div>
HTML;

  }





  /**
   * This will return the event ids needed for extracting information
   * from EVENT MANAGER
   * @param string $time Accepts 'past' or 'future', refer to the Event Manager Documentation here:
   * https://wp-events-plugin.com/documentation/event-search-attributes/
   * @return array $ids Return event ids from all categories
   */
  public function get_event_ids($time,$order) {
    $ids = array();
    $studentIDS = array();
    $thompsonIDS = array();
    $tuesdayIDS = array();
    $student = EM_Events::get(
      array(
        'scope'=> $time,
        'order' => $order,
        'limit' => 6,
        'category' => 'student-exhibition'
    ));


    foreach($student as $key => $eventObjects) {
        $studentIDS[]=$eventObjects -> post_id;
    }

    $thompson = EM_Events::get(
      array(
        'scope'=> $time,
        'order' => $order,
        'limit' => 3,
        'category' => 'thompson-gallery'
      ));

    foreach($thompson as $key => $eventObjects) {
        $thompsonIDS[]= $eventObjects -> post_id;
    }

    $tuesday = EM_Events::get(
      array(
        'scope'=> $time,
        'order' => $order,
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
  * Will return HTML format for the events
  * @return string This will return the html
  */
  public function get_event_html() {
    $this-> form_slideshow_html();
    return $this->html;
  }




  /**
   * This will get all the single events html into an array
   * @return array $eventsArray has all the html of the formatted single events
   */
  private function form_single_events_html() {
    $eventsArray = array();
    $ids = $this->get_event_ids($this->time, $this->order);
    //This loop checks for 9 events
    for( $counter = 0; $counter < 3; $counter++ ) {
        for($innerCounter = 0 ; $innerCounter < 3; $innerCounter++) {
            if(!empty($ids[$innerCounter][$counter])) { //this will check if the category has the event
              $currentID = $ids[$innerCounter][$counter];
              $eventsArray[] = do_shortcode("[event post_id='$currentID']
                $this->singleEventFormat
              [/event]");
            }
        }
    }

    //If there are still extra slots in the slideshow, put student exhibitions in for the rest
    $currentStudentEvent = 3;
    while(count($eventsArray) < 9) {
      $currentID = $ids[2][$currentStudentEvent];
      $eventsArray[] = do_shortcode("[event post_id='$currentID']
        $this->singleEventFormat
        [/event]");
      $currentStudentEvent++;
    }
    return $eventsArray;
  }




  /**
   * This will format theslideshow html
   *
   * @return void
   */
  private function form_slideshow_html() : void {
    $startingDiv = "<div class='slideshow-container'>";
    $mySlides ="<div class='mySlides fade'>";
    $endOf_mySlides = "</div>";
    $button = '<a class="back" onclick="nextSlides(-1)">&#10094;</a>
    <a class="forward" onclick="nextSlides(1)">&#10095;</a>';
    $endingdivs ="</div>";

    $eventsArray = $this->form_single_events_html(); //This will hold the single events HTML that is formatted in set_event_format()
    $totalEvents = count($eventsArray);
    $slideshowEvents = array(); //has 3 events in one slide
    $set=""; //This is just holding concantenated event html
    if($totalEvents !== 0){
      for(  $setCounter = 1, $eventCounter = 0; $eventCounter < $totalEvents; $eventCounter++,$setCounter++ ) {
        $set .= $eventsArray[$eventCounter];
        if($setCounter % 3 === 0) { //After every 3 single events the set will be added into the array for later concatenation
          $slideshowEvents[] = $set;
          $set =""; //Resetted after 3 single events
          $setCounter = 0; //Reset counter to 0 because it'll add 1
        } else if($setCounter % 3 !== 0 && $eventCounter == $totalEvents-1){
          $slideshowEvents[] = $set; //If there are unevent events, place it into a new array
        }
      }
    } else {
        $slideshowEvents[] = $set; //Set it to empty
    }

    if($slideshowEvents[0] === "") {
      $this->html = "";
    } else {
      $totalSlides = count($slideshowEvents);
      for($slidesCounter = 0; $slidesCounter < $totalSlides; $slidesCounter++ ){
        if(!empty($slideshowEvents[$slidesCounter])) {
          $addedHTML = $mySlides . $slideshowEvents[$slidesCounter] . $endOf_mySlides;
          $eventsHTML .= $addedHTML;
        }
      }
      $this->html = $startingDiv . $eventsHTML . $button . $endingdivs;
    }
  }
}

?>
