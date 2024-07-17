var Global = function() {
    var setGlobalPlugin = function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        if ($.fn.select2) {
            $.fn.select2.defaults.set("minimumResultsForSearch", "Infinity");
        }

        window.sweet = {
            alert: swal.mixin({
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary mr-3',
                cancelButtonClass: 'btn btn-secondary',
                inputClass: 'form-control',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
            }),
            success: swal.mixin({
                toast: true,
                position: 'top',
                type: 'success',
                title: 'Success! ',
                showConfirmButton: false,
                timer: 5000
            }),
            error: swal.mixin({
                toast: true,
                position: 'top',
                type: 'error',
                title: 'Error! ',
                showConfirmButton: false,
                timer: 5000
            }),
        };

    };

    var hideFlashMessages = function() {
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        $('div.js-custom-flash').delay(3000).fadeOut(350);
    }

    // Global config variables
    var messages = {
        data: {
            saved: {
                success: 'Details have been saved successfully.',
                error: 'Details could not be saved at this time. Please try again later.'
            },
            updated: {
                success: 'Details have been updated successfully.',
                error: 'Details could not be updated at this time. Please try again later.'
            }
        }
    };

    var buildValidateParams = function(options) {
        var defaultOptions = {
            ignore: [],
            errorClass: 'invalid-feedback animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                $(e).parents('.form-group').append(error);
            },
            highlight: function(e) {
                $(e).closest('.form-group').removeClass('is-invalid').addClass('is-invalid');
            },
            unhighlight: function (e) {
                $(e).closest('.form-group').removeClass('is-invalid').removeClass('is-invalid');
            },
            success: function(e) {
                $(e).closest('.form-group').removeClass('is-invalid');
                $(e).remove();
            }
        };
        return $.extend({}, defaultOptions, options || {})

    };

	var prepareAjaxFormValidationMessage = function(jsonErr){
		var keys = Object.keys(jsonErr);
		var messages = [];
        var ul = $('<ul/>',{class:"list-unstyled text-left"});

		for(var i=0;i<keys.length; i++)
		{
			messages = messages.concat(jsonErr[keys[i]]);
		}

        $.each(messages,function(index,message){
            $('<li />').text(message).appendTo(ul);
        });

        return ul.wrap('div').parent().html();;
	}

    var initConfirmationOnDelete = function() {
        $('body').on('click', '.delete-confirmation-button', function(event) {
            event.preventDefault();
            var deleteUrl = $(this).attr('href');
            sweet.alert({
                title: 'Are you sure?',
                text: 'This information will be permanently deleted!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                html: false,
            }).then(function(result) {
                if (result.value) {
                    submitDeleteResourceForm(deleteUrl);
                }
            });
        });
    };

    var initConfirmationOnClose = function() {
        $('body').on('click', '.close-auction-confirmation-button', function(event) {
            event.preventDefault();
            var deleteUrl = $(this).data('url');
            sweet.alert({
                title: 'Are you sure?',
                text: 'All teams will be notified!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                html: false,
            }).then(function(result) {
                if (result.value) {
                    $('.close-auction-confirmation-button').attr("disabled", true);
                    submitDeleteResourceForm(deleteUrl,'delete');
                }
            });
        });
    };

    var submitDeleteResourceForm = function(deleteUrl, method) {
        if(method === undefined) {
          method = 'POST';
        }
        
        $('<form>', {
            'method': method,
            'action': deleteUrl,
            'target': '_top'
        })
        .append($('<input>', {
            'name': '_token',
            'value': $('meta[name="csrf-token"]').attr('content'),
            'type': 'hidden'
        }))
        .append($('<input>', {
            'name': '_method',
            'value': 'DELETE',
            'type': 'hidden'
        }))
        .hide().appendTo("body").submit();
    }

    var initModalButton = function(){
        $(document).on('click','.open_modal_box',function(event){
            event.preventDefault();
            var url = $(this).attr('href');
            $.post({
                url:url,
                success:function(response){
                    $('#modal-box').html(response);
                    $('#modal-box').modal('toggle');
                    $('#modal-box').find('button[type="submit"]').on("click",function(){
                        var form = $(this).data("form");
                        $(form).submit();
                    });
                }
            });
        });
    }

    var configureDataTables = function() {
        $.extend(true, $.fn.dataTable.defaults, {
            dom: '<"top"><"row"<"col-xl-12 d-flex justify-content-end"rfB>><"table-responsive"t><"row"<"col-sm-3"i><"col-sm-6 text-center mt-10"l><"col-sm-3"p>>',
            language: { "infoFiltered": "" },
            pageLength: 25,
            serverSide: true,
            processing: false,
            searching: false,
            ordering: false,
            // order: [[ 0, 'desc'],]
        });

        $.extend($.fn.dataTable.ext.classes, {
            sWrapper: "dataTables_wrapper dt-bootstrap4",
            sFilterInput: "form-control aaa"
        });

        $.fn.dataTable.ext.errMode = function( settings, helpPage, message ) {
            sweet.error('Error!', 'There was an error while processing. Please try again later.');
        };
    };

    var select2Options = function(params){

        // Init Select2 (with .js-select2 class)
        $('.js-select2:not(.js-select2-enabled)').each(function(){
            var el = $(this);

            // Add .js-select2-enabled class to tag it as activated
            el.addClass('js-select2-enabled');

            // Init
            el.select2();
        });

        if(params){
            $.each(params.options, function(key, value){
                var identifier = value.id;
                delete value.id;
                $(identifier).select2(value);
                $(identifier).on('change', function () {
                   if( $.isFunction( $.fn.valid ) ) {
                        $(this).valid();
                    }
                });
            });
        }

        // $('.js-select2').on('change', function () {
        //     if( $.isFunction( $.fn.valid ) ) {
        //         $(this).valid();
        //     }
        // });
    };

    var buildImageCropParams = function(cropper) {
        cropper = cropper || {
            ratio: '1:1',
            minWidth: 250,
            minHeight: 250,
            showGrid: true
        };

        return {
            limit: 1,
            extensions: ['jpg', 'jpeg', 'png', 'gif', 'svg'],
            changeInput: ' ',
            theme: 'thumbnails',
            enableApi: true,
            addMore: false,
            thumbnails: {
                box: '<div class="fileuploader-items">' +
                '<ul class="fileuploader-items-list">' +
                '<li class="fileuploader-thumbnails-input"><button type="button" class="btn btn-secondary btn-block">Upload Your Own Icon</button></li>' +
                '</ul>' +
                '</div>',
                item: '<li class="fileuploader-item file-has-popup">' +
                '<div class="fileuploader-item-inner">' +
                '<div class="type-holder">${extension}</div>' +
                '<div class="actions-holder">' +
                '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                '</div>' +
                '<div class="thumbnail-holder">' +
                '${image}' +
                '<span class="fileuploader-action-popup"></span>' +
                '</div>' +
                '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                '<div class="progress-holder">${progressBar}</div>' +
                '</div>' +
                '</li>',
                item2: '<li class="fileuploader-item file-has-popup">' +
                '<div class="fileuploader-item-inner">' +
                '<div class="type-holder">${extension}</div>' +
                '<div class="actions-holder">' +
                '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="${captions.download}" download><i></i></a>' +
                '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                '</div>' +
                '<div class="thumbnail-holder">' +
                '${image}' +
                '<span class="fileuploader-action-popup"></span>' +
                '</div>' +
                '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                '<div class="progress-holder">${progressBar}</div>' +
                '</div>' +
                '</li>',
                startImageRenderer: true,
                canvasImage: false,
                _selectors: {
                    list: '.fileuploader-items-list',
                    item: '.fileuploader-item',
                    start: '.fileuploader-action-start',
                    retry: '.fileuploader-action-retry',
                    remove: '.fileuploader-action-remove',
                    rotate: '.fileuploader-action-rotate',
                },
                onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
                    // image size and ratio?

                    if (item.reader.node && item.reader.width < cropper.minWidth  && item.reader.height < cropper.minHeight) {
                        sweet.alert({
                            title: "Image information!",
                            text: 'Image must be at least '+cropper.minWidth+'px × '+cropper.minHeight+'px',
                            type: 'warning'
                        });

                        var api = $.fileuploader.getInstance(inputEl);
                        api.remove(item);
                    } else {
                        if (item.choosed) {
                            item.popup.open();
                            item.editor.cropper();
                        }
                    }

                    if($('.fileuploader-popup').length){

                        $('.fileuploader-popup-tools > li:nth-child(1) > a').show();
                        $('.fileuploader-popup-tools > li:nth-child(2) > a').show();
                    }

                },
                onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {


                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));

                    plusInput.insertAfter(item.html)[api.getOptions().limit && api.getFiles().length >= api.getOptions().limit ? 'hide' : 'show']();

                    if (item.format == 'image') {
                        item.html.find('.fileuploader-item-icon').hide();
                    }
                },
                onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));

                    html.children().animate({ 'opacity': 0 }, 200, function() {
                        setTimeout(function() {
                            html.remove();

                            if (api.getFiles().length - 1 < api.getOptions().limit) {
                                plusInput.show();
                            }
                        }, 100);
                    });

                },
                popup: {
                    // popup append to container {String, jQuery Object}
                    container: 'body',

                    // enable arrows {Boolean}
                    arrows: true,

                    // loop the arrows {Boolean}
                    loop: true,

                    // popup HTML {String, Function}
                    template: function(data) {
                        return '<div class="fileuploader-popup-preview">' +
                            '<a class="fileuploader-popup-move" data-action="prev"></a>' +
                            '<div class="fileuploader-popup-node ${format}">${reader.node}</div>' +
                            '<div class="fileuploader-popup-content">' +
                            '<ul class="fileuploader-popup-meta d-none d-md-block">' +
                            '<li>' +
                            '<span>${captions.name}:</span>' +
                            '<h5>${name}</h5>' +
                            '</li>' +
                            '<li>' +
                            '<span>${captions.type}:</span>' +
                            '<h5>${extension.toUpperCase()}</h5>' +
                            '</li>' +
                            '<li>' +
                            '<span>${captions.size}:</span>' +
                            '<h5>${size2}</h5>' +
                            '</li>' +
                            (data.reader && data.reader.width ? '<li>' +
                                    '<span>${captions.dimensions}:</span>' +
                                    '<h5>${reader.width}x${reader.height}px</h5>' +
                                    '</li>' : ''
                            ) +
                            (data.reader && data.reader.duration ? '<li>' +
                                    '<span>${captions.duration}:</span>' +
                                    '<h5>${reader.duration2}</h5>' +
                                    '</li>' : ''
                            ) +
                            '</ul>' +
                            '<ul class="fileuploader-popup-tools">' +
                            (data.format == 'image' && data.editor ? (data.editor.cropper ? '<li>' +
                                    '<a data-action="crop" style="display:none;">' +
                                    '<i></i>' +
                                    '<span>${captions.crop}</span>' +
                                    '</a>' +
                                    '</li>' : '') +
                                    (data.editor.rotate ? '<li>' +
                                        '<a data-action="rotate-cw" style="display:none;">' +
                                        '<i></i>' +
                                        '<span>${captions.rotate}</span>' +
                                        '</a>' +
                                        '</li>' : '') : ''
                            ) +
                            '<li>' +
                            '<a data-action="remove">' +
                            '<i></i>' +
                            '<span>${captions.remove}</span>' +
                            '</a>' +
                            '</li>' +
                            '</ul>' +
                            '<div class="fileuploader-popup-buttons">' +
                            '<button type="button" class="btn btn-secondary mr-3" data-action="cancel">${captions.cancel}</button>' +
                            '<button type="button" class="btn btn-primary" data-action="save">${captions.confirm}</button>' +
                            '</div>' +
                            '</div>' +
                            '<a class="fileuploader-popup-move" data-action="next"></a>' +
                            '</div>';
                    },

                    // Callback fired after creating the popup
                    // we will trigger by default buttons with custom actions
                    onShow: function(item) {
                        item.popup.html.on('click', '[data-action="prev"]', function(e) {
                            item.popup.move('prev');
                        }).on('click', '[data-action="next"]', function(e) {
                            item.popup.move('next');
                        }).on('click', '[data-action="rotate-cw"]', function(e) {
                            if (item.editor)
                                item.editor.rotate();
                        }).on('click', '[data-action="remove"]', function(e) {
                            item.popup.close();
                            item.remove();
                        }).on('click', '[data-action="cancel"]', function(e) {
                            item.popup.close();
                        }).on('click', '[data-action="save"]', function(e) {
                            setTimeout(function() {
                                $('body').css({
                                    overflow: '',
                                    width: ''
                                });
                            }, 500);
                            if (item.editor)
                                item.editor.save();
                            if (item.popup.close)
                                item.popup.close();
                        });

                        item.popup.html.on('click', '[data-action="crop"]', function(e) {
                            if (item.editor)
                                item.editor.cropper();
                        });
                    },
                    // Callback fired after closing the popup
                    onHide: null
                },
            },
            dragDrop: {
                container: '.fileuploader-thumbnails-input'
            },
            editor: {
                cropper: cropper,
            },
            afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                plusInput.on('click', function() {
                    api.open();
                });


            },
            onSelect: function(item, listEl, parentEl, newInputEl, inputEl) {

                if (typeof onCroperImageLoad !== 'undefined' && typeof onCroperImageLoad === "function") {
                    onCroperImageLoad();
                }
            },

            dialogs: {
                alert: function(text) {
                    return sweet.alert({
                        title: 'Warning!',
                        text: text,
                        type: 'warning',
                    });
                },
                confirm: function(text, callback) {
                    sweet.alert({
                        title: 'Are you sure?',
                        text: text,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        html: false,
                    }).then(function(result) {
                        if (result.value) {
                            callback();
                        } else {
                            return null;
                        }
                    });
                }
            },
        };
    };
    var configureDataTables = function() {
        $.extend(true, $.fn.dataTable.defaults, {
            dom: '<"top"><"row"<"col-xl-12 d-flex justify-content-end"rfB>><"table-responsive"t><"row"<"col-sm-3"i><"col-sm-6 text-center mt-10"l><"col-sm-3"p>>',
            language: { "infoFiltered": "" },
            pageLength: 25,
            serverSide: true,
            processing: false,
            searching: false,
            order: [[ 0, 'desc'],]
        });

        $.extend($.fn.dataTable.ext.classes, {
            sWrapper: "dataTables_wrapper dt-bootstrap4",
            sFilterInput: "form-control aaa"
        });

        $.fn.dataTable.ext.errMode = function( settings, helpPage, message ) {
            sweet.error('Error!', 'There was an error while processing. Please try again later.');
        };
    };

    var initCarouselGlobalLeagues = function() {
        if($("div").hasClass( "js-owl-carousel-leagues-global" )) {
            $('.js-owl-carousel-leagues-global').owlCarousel({
                loop: false,
                margin: 1,
                nav: true,
                // center:true,
                navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
                dots: false,
                responsive: {
                    0: {
                        items: 7
                    },
                    720: {
                        items: 10
                    },
                    1140: {
                        items: 10
                    }
                }
            });

            $('.js-has-dropdown-division').click(function() {
                $('.js-division-swapping').slideToggle('100');
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
            });
       }
    }

    var appendUnreadMessageCountAfterLogin = function () {
        if(window.FantasyLeague){
            var divisionId = window.FantasyLeague.division_id || null;
            if (divisionId) {
                getUnreadMessageCount(divisionId);
            }
        }

    }

    var appendUnreadMessageCountAfterEvent = function () {
        if(window.FantasyLeague){
            var divisionId = window.FantasyLeague.division_id || null;
            var currentRoute = window.FantasyLeague.currentRoute || null;
            if (divisionId && currentRoute != 'manage.chat.index') {
                window.echo.private('league.messages.' + divisionId)
                    .listen('LeagueMessageReceived', function(e) {
                        getUnreadMessageCount(divisionId);
                });
            }
        }
    }
    
    var getUnreadMessageCount = function (divisionId) {
        $.get({
            url: route('manage.league.chat.unread', { division: divisionId }),
            dataType:'json',
            success:function(response) {
                displayMessageUnreadCount(response);
            }
        }).fail(function(response) {
            console.log('Error while getting count');
        });
    }

    var displayMessageUnreadCount = function(response) {

        if(response.status == true && response.unread) {
            $('.feed-chat-count').addClass('is-unread');
            $('.feed-chat-count span').html(response.unread);
        } else {
            $('.feed-chat-count').removeClass('is-unread');
        }

        if($( "div" ).hasClass( "js-data-chat-feed-area" )) {
            if(response.status == true && response.chatUnread) {
                $('.js-chat-span-tab').html(response.chatUnread);
            } else {
                $('.js-chat-span-tab').html('');
            }

            if(response.status == true && response.feedUnread) {
                $('.js-feed-span-tab').html(response.feedUnread);
            } else {
                $('.js-feed-span-tab').html('');
            }
        }
    }

    var clearLiveOfflineLocalStorage= function() {
        if( typeof window.FantasyLeague !== 'undefined' || window.FantasyLeague === null ) {
            var currentRoute = window.FantasyLeague.currentRoute;
            
            if(currentRoute != 'manage.auction.division.team') {
                localStorage.removeItem('offlineAuctionFilters');
            }
        }
    };

    var clearTransferLocalStorage= function() {
        var currentRoute = window.FantasyLeague.currentRoute;
        if(currentRoute != 'manage.transfer.transfer_players') {
            localStorage.removeItem('liveOfflinePosition');
            localStorage.removeItem('liveOfflineClub');
            localStorage.removeItem('liveOfflinePlayer');
            localStorage.removeItem('liveOfflineBoughtPlayers');
        }
    }

    var clearSealBidAuctionLocalStorage= function() {
        if( typeof window.FantasyLeague !== 'undefined' || window.FantasyLeague === null ) {
            var currentRoute = window.FantasyLeague.currentRoute;
            
            if(currentRoute != 'manage.auction.online.sealed.bid.teams') {
                localStorage.removeItem('auctionFilters');
            }

            if(currentRoute != 'manage.transfer.sealed.bid.team') {
                localStorage.removeItem('transferFilters');
            }
        }
    }

    var get_player_name = function(nameType, firstName, lastName){
    /**
     * Formats the name first name last name based on nameType.
     *
     * param  string nameType, firstName, lastName
     * nameType can be fullName, lastName, firstNameFirstCharAndFullLastName
     * return string
     */
        var playerName = '';
        var firstName = typeof firstName !== 'undefined' ? firstName : '';
        var lastName = typeof lastName !== 'undefined' ? lastName : '';

        if (nameType == 'fullName') {

            if(firstName){

                playerName = firstName.charAt(0).toUpperCase() + firstName.slice(1);
            }

            if(lastName){

                var lastName = lastName.charAt(0).toUpperCase() + lastName.slice(1);
                playerName = playerName ? playerName+' '+lastName : lastName;
            }

        }else if(nameType == 'lastName') {

            if(lastName){

                playerName = lastName.charAt(0).toUpperCase() + lastName.slice(1);
            }

        }else if(nameType == 'firstNameFirstCharAndFullLastName') {
            if(firstName){

                playerName = firstName.charAt(0).toUpperCase();
            }

            if(lastName){

                var lastName = lastName.charAt(0).toUpperCase() + lastName.slice(1);
                playerName = playerName ? playerName+'. '+lastName : lastName;
            }
        }

        return playerName;
    }

    var check_number_is_divisible = function(divisibleNumber, dividingNumber){
    /**
     * Get divisiblen number and dividing number, check is divisible or not.
     *
     * param  number $divisibleNumber, $dividingNumber
     * return boolean
     */
        // if(!Number.isInteger(dividingNumber))
        // {
        //    var reminder = parseFloat(divisibleNumber / dividingNumber);
        //    if(!Number.isInteger(reminder)) {
        //         return false;
        //    }

        //    return true;
        // }

        if(parseFloat(dividingNumber) === 0 || parseFloat(divisibleNumber) === 0) {

            return true;
        }

        var mod = Math.round( Math.round(divisibleNumber * 100000) % Math.round(dividingNumber * 100000) ) / 100000;
        
        return ((mod == 0) ? true : false);
    }

    return {
        init: function () {
            setGlobalPlugin();
            hideFlashMessages();
            initModalButton();
            initCarouselGlobalLeagues();
            appendUnreadMessageCountAfterLogin();
            appendUnreadMessageCountAfterEvent();
            initConfirmationOnDelete();
            initConfirmationOnClose();
            clearLiveOfflineLocalStorage();
            clearSealBidAuctionLocalStorage();
        },
        configureDataTables: configureDataTables,
        messages: messages,
        buildValidateParams: buildValidateParams,
        prepareAjaxFormValidationMessage: prepareAjaxFormValidationMessage,
        select2Options:select2Options,
        buildImageCropParams: buildImageCropParams,
        configureDataTables: configureDataTables,
        get_player_name : get_player_name,
        check_number_is_divisible : check_number_is_divisible,
        getUnreadMessageCount:getUnreadMessageCount,
    };

}();

// Initialize when page loads
jQuery(function() {
    Global.init();
});
