<?php
class EventGrid {
  private $html;
  private $time;
  private $format;

  public function __construct($time = "past") {
      $html = "";
      $this->time = strtolower($time);
  }

  /**
   * This will return the event ids needed for extracting information
   * from EVENT MANAGER
   * @return array Returns events ids
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
   * @return [type] [description]
   */
  public function form_event_html() : void {

  }

  /**
   * Will return HTML format for the events
   * @return [type] [description]
   */
  public function get_event_html() {
    return $html;
  }



}





?>
