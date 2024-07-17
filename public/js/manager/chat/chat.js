var ChatDetails = function() {

    var messageBtnClick = function() {
        $('#btnMessage').click(function(e) {
            e.preventDefault();
            saveMessage();

        });
    };

    var messageBtnEnter = function() {
        $('#btnMessage').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                saveMessage();
            }
        });
    };

    var saveMessage = function() {
        if ($('#message').val()) {
            $('#btnMessage').attr('disabled', true);
            $.post({
                url: route('manage.chat.store', { division: window.FantasyLeague.division_id }),
                dataType: 'json',
                data: { message: $('#message').val() },
                success: function(response) {
                    if (response.status == 'success') {
                        buildChatHtml(response.chatData);
                        $('#message').val('');
                        if ($('.no-message').length) {
                            $('.no-message').hide();
                        }
                    }
                    $('#btnMessage').attr('disabled', false);
                }
            }).fail(function(response) {
                $('#btnMessage').attr('disabled', false);
                console.log('Error while sending message');
            });
        }
    }

    var getCurrenttime = function() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        hours = hours < 10 ? '0' + hours : hours;
        return hours + ':' + minutes + ' ' + ampm;
    }

    var bindMessageEvents = function() {
        var divisionId = window.FantasyLeague.division_id;
        window.echo.private('league.messages.' + divisionId)
            .listen('LeagueMessageReceived', function(e) {
                var chatClass = 'message-reciever';
                if (e.chat.sender_id == 'System') {
                    chatClass = 'message-system';
                }

                if (e.chat.sender_id != Site.user.consumer.id) {

                    var data = {
                        messageClass : chatClass,
                        first_name : e.chat.consumer.user.first_name,
                        last_name : e.chat.consumer.user.last_name,
                        id : e.chat.id,
                        message : e.chat.message,
                        created_at : e.chat.created_at,
                    };

                    $.get({
                        url: route('manage.league.chat.new.message', { division: divisionId }),
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            if (response.status == 'success') {
                                buildChatHtml(response.chatData);
                            }
                        }
                    }).fail(function(response) {
                        console.log('Error while getting message');
                    });
                }

                updateUnreadMessage(divisionId);
            });
    }

    var updateUnreadMessage = function(divisionId) {
        $.get({
            url: route('manage.chat.read.count', { division: divisionId }),
            dataType: 'json',
            success: function(response) {}
        }).fail(function(response) {
            console.log('Error updating read count');
        });
    }

    var updateUnreadMessageOnPageLoad = function() {
        updateUnreadMessage(Site.divisionID);
        setTimeout(function(){ Global.getUnreadMessageCount(Site.divisionID); }, 5000);
    }

    var setScrollHeight = function() {
        if ($('.chat-wrapper').length) {
            $('#chatWindow').animate({scrollTop: $("#chatWindow")[0].scrollHeight});
        }
    }

    var getChatMessages = function() {

        if ($('.nextPageUrl:first').val()) {
            $('#chatWindow').scroll(function() {
                if ($('#chatWindow').scrollTop() == 0) {
                    $('#loader').show();
                    $.get({
                        url: $('.nextPageUrl:first').val(),
                        dataType: 'json',
                        data: {},
                        success: function(response) {
                            $('#loader').hide();
                            $('#chatWindow').prepend(response.data);
                            $('#chatWindow').scrollTop(30);
                        }
                    }).fail(function(response) {
                        $('#loader').hide();
                        console.log('Error while getting message');
                    });
                }
            });
        }
    }

    var buildChatHtml = function(html) {
        $('#chatWindow').append(html);
        setScrollHeight();
    }

    var removeChat = function() {
        $(document).on("click",".js-delete-message",function() {
            var $this = $(this);
            sweet.alert({
                title: 'Delete chat',
                text: 'Are you sure you want to delete chat?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                html: false,
            }).then(function(result) {
                if(result.value) {
                    $.post({
                        url: route('manage.chat.delete', { division: window.FantasyLeague.division_id, chat : $this.data('id') }),
                        dataType: 'json',
                        data: {},
                        success: function(response) {
                            if (response.status == 'success') {
                                var $target = $this.parent().closest('.js-chat-block');
                                $target.hide('slow', function(){ $target.remove(); });
                            }
                        }
                    }).fail(function(response) {
                        console.log('Error while removing message');
                    });
                }
            });
        });
    }

    return {
        init: function() {
            updateUnreadMessageOnPageLoad();
            messageBtnClick();
            messageBtnEnter();
            getCurrenttime();
            setScrollHeight();
            getChatMessages();
            bindMessageEvents();
            removeChat();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ChatDetails.init();
});
