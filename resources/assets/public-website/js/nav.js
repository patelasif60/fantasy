$(document).ready(function() {

    function setToggle() {
        $('#FL-Menu').on('show.bs.collapse', function() {
            $('.navbar').addClass("is-open");
            $('body').addClass("overflow-hidden");
        });

        $('#FL-Menu').on('hide.bs.collapse', function() {
            $('.navbar').removeClass("is-open");
            $('body').removeClass("overflow-hidden");
        });
    };
    setToggle();

    function imgDrag() {
        $('img').attr("draggable", "false");
    };
    imgDrag();

    $(function() {
        //caches a jQuery object containing the header element
        var header = $(".navbar");
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();

            if (scroll >= 100) {
                header.addClass("sticky-logo");
            } else {
                header.removeClass("sticky-logo");
            }
        });
    });
});
