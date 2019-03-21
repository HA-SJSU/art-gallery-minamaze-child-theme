( function ($) {

    wp.customize('nt_exhibition_featured_image_upload', function(value){
        value.bind( function(newval){
            $('#nt-featured-img').attr("src",newval);
        });
    });


} )(jQuery);