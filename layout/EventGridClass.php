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

      <div class="gallery__box" onclick=window.open("#_EVENTURL")>
        <div class="gallery__imgBox">
          {has_image}
            <img class="gallery__image" href=#_EVENTIMAGE
          {/has_image}

          {no_image}
            <img class="gallery__image" src="http://events.ha.sjsu.edu/wp-content/uploads/2016/09/default_734x408_thumb.png">
          {/no_image}
        </div>
        <div class="gallery__details">
          <div class="gallery__details__content">
            <p>
              #_EVENTNAME
            </p>
            <p>
              #_EVENTDATES
            </p>
          </div>  
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
  public function get_gallery_array() {
    $galleryArray = $this->form_single_events_html();
    return $galleryArray;
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
   * Will return HTML format for the events
   * @return string returns $html in stirng form
   */
  public function get_event_html() {
    $this->form_grid_html();
    return $this->html;
  }

  /**
   * This will format the entire grid html
   */
  private function form_grid_html() : void {

    // If there is a need to encapsulate HTML with divs, etc. 
    // concantenate the string and set it to $html here
    $galleryDiv = '<div id="gallery" class="gallery">';
    $galleryEndingDiv = '</div>';

    $paginationDiv = '<div class="gallery_center">
                          <a id="paginate" onclick="selectedImages(-1)" class="gallery_paginate">‹</a>
                          <a id="paginate" onclick="selectedImages(1)" class="gallery_paginate">›</a>';
    $paginationEndDiv = '</div>';

    $this->html = $galleryDiv . $galleryEndingDiv . $paginationDiv . $paginationEndDiv;

  }
}
?>
