 $(document).ready(function () {
    if($(window).width() < 768) {
       $(".auth-area").addClass("start-screen");
    }
    else{
        $(".auth-area").removeClass("start-screen");
    }
});

$(window).resize(function () {
    if ($(window).width() < 768) {
        $(".auth-area").addClass("start-screen");
    }
    else{
        $(".auth-area").removeClass("start-screen");
    }
});