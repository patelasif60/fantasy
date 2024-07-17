var ManagerDivisionInvite = function() {

    var initShareCode = function () {
        $("#shareCode").on('click', function(eventShare){
            $url   = $(this).attr('data-url');
            $text  = $(this).attr('data-text');
            $title = $(this).attr('data-title');

            if(typeof navigator.share === 'undefined') {
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#shareModal');
            } else {
                // Share it!
                navigator.share({
                  title: $title,
                  text: $text,
                  url: $url
                });

                eventShare.preventDefault();
            }
        });
       
    };

    var initCopyCode = function () {
        $('.copy-invite-code').on('click', function()
        {
            var textArea = document.createElement("textarea");
            textArea.value = $('#invite_code').text();
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();
            sweet.success("Copied the URL: " + $("#invite_code").text());
        });
    };

    var manageInviteBackClick = function () {
        history.pushState(null, null, window.location.pathname);
        window.addEventListener('popstate', function(event) {
            window.location.assign($('.invite-manager-back').attr('href'));
        });
    };

    return {
        init: function() {
            initShareCode();
            initCopyCode();
            manageInviteBackClick();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionInvite.init();
});