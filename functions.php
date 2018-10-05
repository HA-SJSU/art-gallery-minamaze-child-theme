<?php
  require_once('shortcodes.php');
  require_once('layout/EventGridClass.php');

  /**
   * This allows the child theme to be intialized as well as loop through all the parent theme's css files
   * to properly add the child theme style
   */
  function my_theme_enqueue_styles() : void {

      $parent_style = 'minamaze-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

      wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
      wp_enqueue_style( 'child-style',
          get_stylesheet_directory_uri() . '/style.css',
          array( $parent_style ),
          wp_get_theme()->get('Version')
      );
  }
  add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );



  /**
   * This will load the scripts at the header
   */
  function ha_custom_javascripts() : void {
  		echo '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">';
  		echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>';
  	  echo '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/js/ha-custom.js"></script>' . "\n";
  	}
  add_action( 'wp_head', 'ha_custom_javascripts' );


  /**
   * This will load the scripts at the footer
   */
  function footer_javascripts() : void {
    //get_stylesheet_directory_uri() gets the directory of the childtheme at the root
    echo '<script src="' . get_stylesheet_directory_uri() . '/js/event-grid.js"></script>' . "\n";
    if( is_front_page() or thinkup_check_ishome()) {
      echo '<script src="' . get_stylesheet_directory_uri() . '/js/event-slideshow.js"></script>' . "\n";
    }
  }
  add_action( 'wp_footer', 'footer_javascripts' );





/*
========================================================================================================================================================================
FUNCTIONS USED FOR THE SITE






========================================================================================================================================================================
*/

/**
 * This will display the social media buttons on the pre header of the site without using the ThinkUP fcunctions from the parent theme
 */
function social_media_buttons(): void {
  echo '<div id="pre-header-social"><ul>';
 			/* Facebook settings */
 				echo '<li class="social facebook"><a href="https://www.facebook.com/sjsugallery" data-tip="bottom" data-original-title="Facebook" target="_blank">',
 					 '<i class="fa fa-facebook"></i>',
 					 '</a></li>';

      /* Instagram button */
      echo '<li class="social instagram"><a href="https://www.instagram.com/sjsugallery/" data-tip="bottom" data-original-title="Instagram" target="_blank">',
         '<i class="fa fa-instagram"></i>',
         '</a></li>';

 			/* Twitter settings */
 				echo '<li class="social twitter"><a href="https://www.twitter.com/sjsugallery" data-tip="bottom" data-original-title="Twitter" target="_blank">',
 					 '<i class="fa fa-twitter"></i>',
 					 '</a></li>';

 			/* Flickr settings */
 				echo '<li class="social flickr"><a href="https://www.flickr.com/photos/sjsugallery" data-tip="bottom" data-original-title="Flickr" target="_blank">',
 					 '<i class="fa fa-flickr"></i>',
 					 '</a></li>';

 		echo	'</ul></div>';
}


  /**
   * This will display the pdf on the home page, fill in the correct id - original 1829
   * @param  integer $id THis is the page/post id for where the pdf page is in the Gallery Minamaze Theme
   */
  function display_pdf( $id = 1829 ) : void {
    $post = get_post($id);
    $content = $post->post_content;
    echo do_shortcode($content);
  }





?>
