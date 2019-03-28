<?php
/**
 * Art Gallery Child of Minamaze: Customizer
 * This requires the ag_customizer.js to work 
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


  //This will add the section called Art Gallery Front Page Modificiations inside the customizable sidebar, but to show up you need at least 1 setting and control
  $wp_customize->add_section('art_gallery_options',array(
      'title' => __('Art Gallery Front Page Modifications','SJSU Art Gallery'),
      'description' => 'Modify the front page with feature images.',
      'active_callback' => 'is_front_page'
    ));

    //This give the option to display which sections
    $wp_customize->add_setting('ag_front_page_display_options', array(
      'default' => 'Slideshow',
      'type' => 'option'
    ));

    $wp_customize->add_setting('ag_front_page_featuring_text', array(
      'default' => 'Current Exhibitions',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
      'transport' => 'postMessage'
    ));

    //This will add the image setting inside the customizable sidebar
    $wp_customize->add_setting('nt_exhibition_featured_image_upload', array(
      'default' => 'http://events.ha.sjsu.edu/wp-content/uploads/2016/09/default_734x408_thumb.png',
      'transport' => 'postMessage' //This will refresh the page instead of just that section in the live css
    ));

    //This will add the small text bar setting inside the customizable sidebar
    $wp_customize->add_setting('nt_exhibit_name', array(
      'default' => 'Natalie and Thompson',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
      'transport' => 'postMessage' //This will refresh the page instead of just that section in the live css
    ));

    //This will add the small text bar setting inside the customizable sidebar
    $wp_customize->add_setting('nt_title', array(
      'default' => 'Title',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
      'transport' => 'postMessage' //This will refresh the page instead of just that section in the live css
    ));


    //This will add the textarea setting inside the customizable sidebar
    $wp_customize->add_setting('nt_caption', array(
      'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in neque lorem. Morbi a ligula lectus. Mauris sit amet varius lorem, non ultricies nisi. Vestibulum vel accumsan mi. Sed ut magna sed massa hendrerit molestie ut eu ipsum. Nam faucibus lorem quis eleifend laoreet. Nunc erat risus, laoreet vitae tempor nec, placerat molestie arcu. Vivamus vel libero massa. Fusce aliquam eros nec libero faucibus dignissim. Praesent molestie suscipit velit non pellentesque. Praesent quis eleifend sapien. Donec ligula enim, tincidunt egestas sollicitudin vitae, pellentesque eu lectus. Nunc blandit, tortor at luctus luctus, eros turpis aliquet massa, id faucibus orci purus a eros. Ut fringilla tortor vitae purus laoreet vulputate.',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
      'transport' => 'postMessage' //This will refresh the page instead of just that section in the live css
    ));

    $wp_customize->add_setting('ag_front_page_featuring_mas', array(
      'default' => 'Featuring Master Students',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
      'transport' => 'postMessage'
    ));

    $wp_customize->add_setting('ag_front_page_flipbook', array(
      'default' => '<iframe src="https://cdn.flipsnack.com/widget/v2/widget.html?hash=fd194ktos" width="100%" height="930" seamless="seamless" scrolling="no" frameBorder="0" allowFullScreen></iframe>'
    ));
    



    $wp_customize->add_control(new WP_Customize_control($wp_customize,'ag_front_page_display_options', array(
      'label' => __('Feature Natalie and Thompson Events?', 'SJSU Art Gallery'),
      'default' => 'All',
      'section' => 'art_gallery_options',
      'settings' => 'ag_front_page_display_options',
      'type' => 'radio',
      'choices' => array(
        'Featured' => __('Featured Event'),
        'Slideshow' => __('Slideshow'),
        'Masters' => __('Master Students'),
        'Featured&Slideshow' => __('Featured Event and Slideshow'),
        'Slideshow&Masters' => __('Slideshow and Masters'),
        'Masters&Featured' => __('Featured Event and Masters'),
        'All' => __('All')
      )
    )));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'ag_front_page_featuring_text',array(
      'label' => __('Featured Event', 'SJSU Art Gallery'),
      'section' => 'art_gallery_options',
      'settings' => 'ag_front_page_featuring_text',
    )));


    //This will add the image controls inside the customizable sidebar
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'nt_exhibition_featured_image_upload',array(
      'description' => 'Upload the Natalie and Thompson Gallery image to feature on the front page.',
      'section' => 'art_gallery_options',
      'settings' => 'nt_exhibition_featured_image_upload'
    )));
    
    //This will add the textarea controls inside the customizable sidebar
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'nt_exhibit_name',array(
      'description' => esc_html__("Enter the exhibit's name below."),
      'section' => 'art_gallery_options',
      'settings' => 'nt_exhibit_name',
      'type' => 'text'
    )));


    //This will add the textarea controls inside the customizable sidebar
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'nt_title',array(
      'description' => esc_html__('Place the title of the exhibit below here.'),
      'section' => 'art_gallery_options',
      'settings' => 'nt_title',
      'type' => 'text'
    )));
    
    //This will add the textarea controls inside the customizable sidebar
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'nt_caption',array(
      'description' => esc_html__('Input the caption into the textarea to display on the front page.'),
      'section' => 'art_gallery_options',
      'settings' => 'nt_caption',
      'type' => 'textarea'
    )));
    
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'ag_front_page_featuring_mas',array(
      'label' => __('Master Student Work', 'SJSU Art Gallery'),
      'section' => 'art_gallery_options',
      'settings' => 'ag_front_page_featuring_mas',
      'type' => 'text'
    )));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'ag_front_page_flipbook',array(
      'description' => esc_html__('Add the embedded Flipsnack, embedded pdf, etc. here. Do not put malicious urls here please. HTML can be placed here.'),
      'section' => 'art_gallery_options',
      'settings' => 'ag_front_page_flipbook',
      'type' => 'textarea'
    )));
    
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
        get_stylesheet_directory_uri(). '/js/ag_customizer.js', //Point to the file
        array( 'jquery', 'customize-preview'), //Define dependencies
        '', //Define a version (OPTIONAL)
        true //Put script in the footer?
    );
}
add_action('customize_preview_init', 'ag_customizer_live_preview');




?>