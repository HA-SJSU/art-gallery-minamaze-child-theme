<?php
require_once('EventInterface.php');
/**
 * This creates a grid to show in the Archives page
 */
class EventGrid implements Event {
  private $html;
  private $time;
  private $singleEventFormat;

  /**
   *  This will initialize the class with a default grid
   * @param string $time This will choose the timeline for the event
   */
  public function __construct($time = "past") {
      $this->html = "";
      $this->time = strtolower($time);
      $this->singleEventFormat = <<< HTML

      <!-- Add the formated single event html here -->
      <div class="gallery_container">
        {has_image}
          <img class="gallery_img" href=#_EVENTIMAGE
        {/has_image}

        {no_image}
          <img class="event-images" href="http://events.ha.sjsu.edu/wp-content/uploads/2016/09/default_734x408_thumb.png">
        {/no_image}
          <div class="text-centered">
            #_EVENTNAME
          </div>
      </div>
HTML;
  }





  /**
   * This will return the event ids needed for extracting information
   * from EVENT MANAGER
   * @return array $ids Returns events ids of the selected
   */
  public function get_event_ids($time) {
    $ids = array();
    $events = EM_Events::get(
      array(
          'scope' => $time
      ));
      foreach($events as $key => $eventObjects) {
        $ids[] = $eventObjects -> post_id;
      }
    return $ids;
  }




  /**
   * Will return HTML format for the events
   * @return string returns $html in stirng form
   */
  public function get_event_html() {
    $this->form_grid_html();
    return $this->html;
  }





  /**
   * This will format the event and render through the Event Manager Plugin
   */
  private function form_single_events_html() {
    $ids = $this->get_event_ids($this->time);
    $totalEvents = count($ids);
    $singleEventsArray = array();
    //This will save the single events in an array with the information rendered from the Events Manager Plugin
    for( $counter = 0; $counter < $totalEvents; $counter++) {
      $currentID = $ids[$counter];
      $singleEventsArray[] = do_shortcode("[event post_id='$currentID']
        $this->singleEventFormat
      [/event]");
    }
    return $singleEventsArray;
  }


  /**
   * This will format the entire grid html
   */
  private function form_grid_html() : void {
    $eventsArray = $this->form_single_events_html();
    // If there is a need to encapsulate HTML with divs, etc. concantenate the string and set it to $html here
    $parentDiv = '<div class="archives_gallery">';
    $parentEndingDiv = '</div>';

    $totalImages = count($eventsArray);
    $galleryImages = "";

    if($totalImages !== 0){
      for( $imageCounter = 0; $imageCounter < $totalImages; $imageCounter++ ) {
        $galleryImages .= $eventsArray[$imageCounter];
      }
    }

    if($galleryImages === "") {
      $this->html = "";
    } else {
      $this->html = $parentDiv . $galleryImages . $parentEndingDiv;
    }
  }

}





?>
