import slick from 'slick-carousel/slick/slick';

function carousel() {
    if ($(window).width() > 767) {
        $('.hero-section .shape-layer').removeClass('bm-multiply');
        if($('.js-carousel').hasClass('slick-initialized')) {
            $('.js-carousel').slick('unslick');
        }
    } else {
        $('.hero-section .shape-layer').addClass('bm-multiply');
        if(! $('.js-carousel').hasClass('slick-initialized')) {
            $('.js-carousel').slick({
                arrows: false,
                draggable: false,
                touchMove: false,
                autoplay: true
            });
        }

    }
}
$(window).bind("load", function() {
    carousel();
});
$(window).on("orientationchange, resize", function(event) {
    carousel();
});