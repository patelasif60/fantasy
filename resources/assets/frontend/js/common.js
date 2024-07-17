document.addEventListener('DOMContentLoaded', function() {
    lazyload();
});

$(document).ready(function() {
    function setHeight() {
        let HeaderHeight = $('.header').height();
        let FooterHeight = $('.footer').outerHeight();
        let windowHeight = $(window).innerHeight();
        let viewPortHeight = document.documentElement.clientHeight;
        let containerHeight = viewPortHeight - (HeaderHeight + 30);
        let containerHeightFoot = viewPortHeight - (HeaderHeight + FooterHeight + 30);
        let ElementHeight = windowHeight;
        if (ElementHeight > 0) {
            // $('.body').css('min-height', ElementHeight).css('padding-top', HeaderHeight).css('padding-bottom', FooterHeight);
            // $('.body').css({ 'min-height': 'calc(100vh - ' + HeaderHeight+ 'px)' }).css('padding-top', HeaderHeight).css('padding-bottom', FooterHeight);
            $('.container-wrapper').css('min-height', containerHeight);
            if ($('.footer').length) {
                $('.body').css('padding-top', HeaderHeight + 15).css('padding-bottom', FooterHeight + 15);
                $('.container-wrapper').css({ 'min-height': 'calc(100vh - ' + (HeaderHeight + FooterHeight + 30) + 'px)' });
            } else {
                $('.body').css('padding-top', HeaderHeight).css('padding-bottom', FooterHeight);
                $('.container-wrapper').css({ 'min-height': 'calc(100vh - ' + HeaderHeight + 15 + 'px)' });
            }
        } else {}
    };
    setHeight();

    $(window).resize(function() {
        setHeight();
    });

    function imgDrag() {
        $('img').attr("draggable", "false");
    };
    imgDrag();

    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(".navbar-toggler").click(function(e) {
        e.preventDefault();
        $(this).toggleClass('is-opened');
        $("#sidebar-wrapper").toggleClass("toggled");
    });

    function Polygon() {
        if ($(window).width() > 767) {
            let SCHeight = $('.sidebar-container').outerHeight();
            let CSSPolygon = "polygon(0 0, " + SCHeight + "px 0, " + SCHeight + "px " + (SCHeight + 150) + "px, 0" + " " + (SCHeight + 60) + "px)";

            $(function() {
                $('#sidebar-wrapper').height(SCHeight + 100);
                $('#sidebar-wrapper').css("-webkit-clip-path", CSSPolygon);
                $('#sidebar-wrapper').css("clip-path", CSSPolygon);
            });
        } else {
            $("#sidebar-wrapper").css("height", "calc(100vh)");
        }
    }
    $(window).bind("load", function() {
        Polygon();
    });
    $(window).on("orientationchange, resize", function(event) {
        Polygon();
    });
});
