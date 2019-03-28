( function ($) {


    front_page_live_preview();
    
    
    /**
     * Custom JavaScript to provide live preview of Front Page
     */
    function front_page_live_preview(){
        wp.customize('ag_front_page_featuring_text', function(value){
            value.bind( function(newval){
                $('#ag-front-page-featuring-text').html(newval);
            });
        });
        
        wp.customize('nt_exhibition_featured_image_upload', function(value){
            value.bind( function(newval){
                $('#nt-featured-img').attr("src",newval);
            });
        });
    
        wp.customize('nt_exhibit_name', function(value){
            value.bind( function(newval){
                $('#nt-exhibit-name').html(newval);
            });
        });
    
        wp.customize('nt_title', function(value){
            value.bind( function(newval){
                $('#nt-title').html(newval);
            });
        });
    
        wp.customize('nt_caption', function(value){
            value.bind( function(newval){
                $('#nt-caption').html(newval);
            });
        });

        wp.customize('ag_front_page_featuring_mas', function(value){
            value.bind( function(newval){
                $('#ag-front-page-featuring-mas').html(newval);
            });
        });
        
        
    }

} )(jQuery);
