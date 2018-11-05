<?php
interface Event {
  public function get_event_ids($time,$order,$orderby);
  public function get_event_html();
}


?>
