<?php
require_once('layout/EventGridClass.php');
require_once('layout/EventSlideshowClass.php');
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
    'time' => 'future'
  ), $atts, 'event_slideshow');
  $slideshow = new EventSlideshow($a['time']);
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
    'time' => 'future'
  ), $atts, 'event_slideshow');
  $grid = new EventGrid($a['time']);
  $html = $grid -> get_event_html();
  return $html;
}

add_shortcode("event_gallery","display_event_grid");

?>
