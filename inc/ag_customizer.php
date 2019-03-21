<?php
/**
 * Art Gallery Child of Minamaze: Customizer
 *
 * @package WordPress
 * @since 1.0.0
 */




/**
 * This will allow user to upload imagesto the main event box
 * Add postMessage support for site title and description for the Theme Customizer.
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function art_gallery_customize_register( $wp_customize ){
    //Abort if selective refresh is not available
    if( ! isset( $wp_customize-> selective_refresh ) ){
        return;
    }



  //This will add the section called Art Gallery Front Page Modificiations inside the customizable sidebar  
  $wp_customize->add_section('art_gallery_options',array(
      'title' => __('Art Gallery Front Page Modifications','Art Gallery'),
      'description' => 'Modify the front page with feature images.'
    ));


    //This will add the image setting inside the customizable sidebar
    $wp_customize->add_setting('nt_exhibition_featured_image_upload', array(
      'default' => 'http://events.ha.sjsu.edu/wp-content/uploads/2016/09/default_734x408_thumb.png',
      'transport' => 'postMessage' //This will refresh the page instead of just that section in the live css
    ));

    
    
    //This will add the textarea setting inside the customizable sidebar
    $wp_customize->add_setting('nt_caption', array(
      'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in neque lorem. Morbi a ligula lectus. Mauris sit amet varius lorem, non ultricies nisi. Vestibulum vel accumsan mi. Sed ut magna sed massa hendrerit molestie ut eu ipsum. Nam faucibus lorem quis eleifend laoreet. Nunc erat risus, laoreet vitae tempor nec, placerat molestie arcu. Vivamus vel libero massa. Fusce aliquam eros nec libero faucibus dignissim. Praesent molestie suscipit velit non pellentesque. Praesent quis eleifend sapien. Donec ligula enim, tincidunt egestas sollicitudin vitae, pellentesque eu lectus. Nunc blandit, tortor at luctus luctus, eros turpis aliquet massa, id faucibus orci purus a eros. Ut fringilla tortor vitae purus laoreet vulputate.',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
      'transport' => 'postMessage' //This will refresh the page instead of just that section in the live css
    ));

    //This will add the image controls inside the customizable sidebar
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'nt_exhibition_featured_image_upload',array(
      'label' => __('Featured Event', 'Art Gallery'),
      'description' => 'Upload the Natalie and Thompson Gallery image to feature on the front page.',
      'section' => 'art_gallery_options',
      'settings' => 'nt_exhibition_featured_image_upload'
    )));
    
    
    //This will add the textarea controls inside the customizable sidebar
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'nt_caption',array(
      'description' => esc_html__('Input the caption into the textarea to display on the front page.'),
      'section' => 'art_gallery_options',
      'settings' => 'nt_caption',
      'type' => 'textarea'
    )));
    
    $wp_customize->get_setting('nt_exhibition_featured_image_upload')-> transport = 'postMessage';
    $wp_customize->get_setting('nt_caption')-> transport = 'postMessage';
}


add_action( 'customize_register', 'art_gallery_customize_register');


/**
 * This will provide a live view of the customizer API
 *
 * @return void
 */
function ag_customizer_live_preview() {
    wp_enqueue_script(
        'ag_theme_customizer', // give the script an ID
        get_stylesheet_directory(). '/js/customizer.js', //Point to the file
        array( 'jquery', 'customize-preview'), //Define dependencies
        '', //Define a version (OPTIONAL)
        true //Put script in the footer?
    );
}
add_action('customize_preview_init', 'ag_customizer_live_preview');




?>