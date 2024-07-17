$(document).ready(function() {
    $('#premierleague-tab').on("click", function() {
        if($(this).attr('data-load') != '1') {
            $.ajax({
                url: $('#premierleague').data('url'),
                type: 'GET',
                dataType: 'html',
            })
            .done(function(response) {
                $('div#premierleague').html(response);
                setTimeout(function(){
                    if(window.innerWidth <= 800) {
                        $('.isMobileDispNone').hide();
                        $('.isMobile').show();
                    } else {
                        $('.isMobile').hide();
                    }
                }, 100);
            })
            .fail(function(error) {
                console.log(error);
            })
        }
    });
});