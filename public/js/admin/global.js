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
                confirmButtonClass: 'btn btn-lg btn-noborder btn-hero btn-primary m-5',
                cancelButtonClass: 'btn btn-lg btn-noborder btn-hero btn-alt-secondary m-5',
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

    var submitDeleteResourceForm = function(deleteUrl) {
        $('<form>', {
            'method': 'POST',
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

    var bindBootstrapFileInput = function() {
        $('.custom-file-input').on('change', function() {
            var $this = $(this);
            var files = this.files;

            if(files.length > 0) {
                $this.closest('.custom-file').find('.custom-file-control').html(files[0].name);
            }
        });
    }

    var hideFlashMessages = function() {
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    }

    var initModalButton = function(){
        $(document).on('click','.fetch_create_edit_modal',function(){
            var url = $(this).attr('href');
            $.get({
                url:url,
                success:function(response){
                    $('#modal-create-edit-box').html(response);
                    // $('#modal-create-edit-box').modal('toggle');
                    $('#modal-create-edit-box').modal({'backdrop' : 'static'});
					$('#modal-create-edit-box').find('button[type="submit"]').on("click",function(){
						var form = $(this).data("form");
						$(form).submit();
					});
                }
            });
        });
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

    var buildEditAction = function(link) {
        return $('<a/>', {
            html: '<i class="fa fa-pencil"></i>',
            href: link || 'javascript:void(0)',
            title: 'Edit',
            class: 'btn btn-sm btn-circle btn-alt-info mr-5 mb-5',
        }).wrap('div').parent().html();
    };

    var buildModalEditAction = function(link) {
        return $('<button/>', {
            html: '<i class="fa fa-pencil"></i>',
            type: 'button',
            title: 'Edit',
            href: link || 'javascript:void(0)',
            class: 'btn btn-sm btn-circle btn-alt-info mr-5 mb-5 fetch_create_edit_modal',
        }).wrap('div').parent().html();
    };

    var buildDeleteAction = function(link) {
        return $('<a/>', {
            html: '<i class="fa fa-trash"></i>',
            href: link || 'javascript:void(0)',
            title: 'Delete',
            class: 'btn btn-sm btn-circle btn-alt-danger mr-5 mb-5 delete-confirmation-button',
        }).wrap('div').parent().html();
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
                '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
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
                            '<ul class="fileuploader-popup-meta">' +
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
                            '<a class="fileuploader-popup-button" data-action="cancel">${captions.cancel}</a>' +
                            '<a class="fileuploader-popup-button button-success" data-action="save">${captions.confirm}</a>' +
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
                cropper: cropper
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

        $('.js-select2').on('change', function () {
            if( $.isFunction( $.fn.valid ) ) {
                $(this).valid();
            }
        });
    }

    var shortPlayerPosition = function(position){
        return position.substr(position.lastIndexOf('(') + 1 ).slice(0,-1);
    }
    return {
        init: function () {
            setGlobalPlugin();
            initConfirmationOnDelete();
            bindBootstrapFileInput();
            hideFlashMessages();
            initModalButton();
        },
        configureDataTables: configureDataTables,
        messages: messages,
        buildValidateParams: buildValidateParams,
        buildEditAction: buildEditAction,
        buildModalEditAction:buildModalEditAction,
        buildDeleteAction: buildDeleteAction,
        prepareAjaxFormValidationMessage: prepareAjaxFormValidationMessage,
        buildImageCropParams: buildImageCropParams,
        select2Options:select2Options,
        shortPlayerPosition:shortPlayerPosition,
    };

}();

// Initialize when page loads
jQuery(function() {
    Global.init();
});
