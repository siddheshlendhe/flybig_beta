(function($) {
    jQuery(document).ready(function() {
       jQuery('.lite-slide-wrap').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay:true
        });


    });
})(jQuery);