<?php

/**
 * This will return the JSON format to grab for easier access such as the making slideshows, cards, etc.
 */
class EventInfo {
    private $time;
    private $order;
    private $orderby;

    /**
     * Undocumented function
     *
     * @param string $time
     * @param string $order
     * @param string $orderby
     * @return void
     */
    public function __construct($time = "future",$order ="DESC", $orderby="event_start_date"){
        $this->time = strtolower($time);
        $this->order = $order;
        $this->orderby = $orderby;
    }


    /**
     * 
     * This will return the JSON format of the data of EM_Events
     *
     * @return void
     */
    public function getJSON(){
        return $this->fetchInfo();
    }



    /**
     * This will fetch information and turn it into JSON
     *
     * @return array
     */
    private function fetchInfo() : String {
        $ids = array();
        $eventsInfo = EM_Events::get(
        array(
            'scope' => $this->time,
            'order' => $this->order,
            'orderby' => $this->orderby,
            'limit' => 15
        ));
        

        $eventJson = $this->toJSON($eventsInfo);
        return $eventJson;
    }


    /**
     * Return information event title, link, time, and image in JSON format
     *
     * @return void
     */
    private function toJSON($eventArray){
        $eventJson = json_encode($eventArray);
        return $eventJson;
    }


    
    






}











?>