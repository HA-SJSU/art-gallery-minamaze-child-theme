<?php
require_once('EventInterface.php');

class EventGrid implements Event {
  private $html;
  private $time;
  private $singleEventFormat;
  private $order;


  public function __construct($time = "past",$order ="DESC", $orderby="event_start_date") {
      $this->html = "";
      $this->time = strtolower($time);
      $this->order = $order;
      $this->orderby = $orderby;
      $this->singleEventFormat = <<< HTML

      <div class="gallery__box" onclick=window.open("#_EVENTURL")>
        <div class="gallery__imgBox">
          {has_image}
            <img class="gallery__image" src="#_EVENTIMAGEURL">
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


  public function get_event_ids($time,$order,$orderby) {
    $ids = array();
    $events = EM_Events::get(
      array(
          'scope' => $time,
          'order' => $order,
          'orderby' => $orderby
      ));
      foreach($events as $key => $eventObjects) {
        $ids[] = $eventObjects -> post_id;
      }
    return $ids;
  }



  public function get_gallery_array() {
    $galleryArray = $this->form_single_events_html();
    return $galleryArray;
  }





  private function form_single_events_html() {
    $ids = $this->get_event_ids($this->time, $this->order, $this->orderby);
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






  public function get_event_html() {
    $this->form_grid_html();
    return $this->html;
  }




  private function form_grid_html() : void {


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
