var ManagerPreAuction = function() {

	var initLeagueRules = function () {
		$('.show-league-rules-data').on('click', function() {
		    $.get({
		        url: $(this).data('url'),
		        success: function(response){
		            $('#modal-create-edit-box').html(response);
		        	$('#modal-create-edit-box').modal('show');
		        }
		    });
    	});
	};

	var initInviteFriends = function () {
		$('.show-invite-friends-data').on('click', function() {
		    $.get({
		        url: $(this).data('url'),
		        success: function(response){
		            $('#modal-create-edit-box').html(response);
		        	$('#modal-create-edit-box').modal('show');
		        }
		    });
    	});
	};

	return {
        init: function() {
            initLeagueRules();
            initInviteFriends();
        }
    };

}();

// Initialize when page loads
jQuery(function() {
	 ManagerPreAuction.init();
});

$(document).on("click", ".copy-invite-code", function(event){
    
    var textArea = document.createElement("textarea");
    textArea.value = $('#invite_code').text();
    document.body.appendChild(textArea);
    textArea.select();
    textArea.focus();
    document.execCommand("Copy");
    textArea.remove();
    alert("Copied the URL: " + $("#invite_code").text());
});

$(document).on("click", "#shareCode", function(event){
    $url   = $(this).attr('data-url');
    $text  = $(this).attr('data-text');
    $title = $(this).attr('data-title');

    if(typeof navigator.share === 'undefined') {
        //$(this).attr('data-toggle', 'modal');
       // $(this).attr('data-target', '#shareModal');
       $(".share-via").removeClass("d-none");
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

