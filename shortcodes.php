<?php
require_once('layout/EventGridClass.php');
require_once('layout/EventSlideshowClass.php');
require_once('layout/EventInfo.php');
/*
========================================================================================================================================================================
SHORTCODES USED FOR THE SITE
========================================================================================================================================================================
*/


/**
 * This will return the html for the event slideshow for the event_slideshow shortcode
 * @return string $html will return the html for the slideshow
 */
function display_event_slideshow( $atts, $content = null ) {
  $a = shortcode_atts( array(
    'time' => 'future',
    'order' => 'ASC',
    'orderby' => 'event_start_date'
  ), $atts, 'event_slideshow');
  $slideshow = new EventSlideshow($a['time'],$a['order'],$a['event_start_date']);
  $html = $slideshow -> get_event_html();
  return $html;
}

add_shortcode("event_slideshow","display_event_slideshow");




/**
* This will return the html for the event grid for the event_gallery shortcode
* @return string $html will return the html for the gallery
 */
function display_event_grid( $atts, $content = null ) {
  $a = shortcode_atts( array(
    'time' => 'future',
    'order' => 'DESC',
    'orderby' => 'event_start_date'
  ), $atts, 'event_slideshow');
  $grid = new EventGrid($a['time'],$a['order'],$a['event_start_date']);
  $html = $grid -> get_event_html();
  return $html;
}

add_shortcode("event_gallery","display_event_grid");



/**
 * This will return the html for the event slideshow for the event_slideshow shortcode
 * @return string $html will return the html for the slideshow
 */
function display_event_slides( $atts, $content = null ) {
  $a = shortcode_atts( array(
    'time' => 'future',
    'order' => 'ASC',
    'orderby' => 'event_start_date'
  ), $atts, 'event_slides');
  $slideshow = new EventInfo($a['time'],$a['order'],$a['event_start_date']);
  $json = $slideshow -> getJSON();
  return $json;
}

add_shortcode("event_slides","display_event_slides");


?>
