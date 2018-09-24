<?php
class EventGrid {
  private $html;
  private $time;
  private $singleEventFormat;

  /**
   *  This will initialize the class with a default grid
   * @param string $time This will choose the timeline for the event
   */
  public function __construct($time = "past") {
      $html = "";
      $this->time = strtolower($time);
  }



  /**
   * This will set the event format for a single event
   */
  private function set_event_format() {
    $singleEventFormat = <<< HTML

HTML;
  }



  /**
   * This will return the event ids needed for extracting information
   * from EVENT MANAGER
   * @return array Returns events ids of the selected
   */
  public function get_event_ids() {
    $pastArray = array();
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
   * This will format the event
   */
  private function form_event_html() : void {
    $totalEvents = count($ids);
    $singleEventsArray = array();
    //This will save the single events in an array with the information rendered from the Events Manager Plugin
    for( $counter = 0; $counter < $totalEvents; $counter++) {
      $currentID = $ids[$counter];
      $singleEventsArray[] = do_shortcode("[event post_id='$currentID']
        $singleEventFormat
      [/event]");
    }

    // If there is a need to encapsulate HTML with divs, etc. concantenate the string and set it to $html here


  }



  /**
   * Will return HTML format for the events
   * @return string returns $html in stirng form
   */
  public function get_event_html() {
    return $html;
  }

}





?>
