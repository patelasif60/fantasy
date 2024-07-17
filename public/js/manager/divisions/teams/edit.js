var ManagerTeamsUpdate = function() {
    var initFormValidations = function () {
        $('.js-teams-update-form').validate(Global.buildValidateParams({
            rules: {
                name: {
                    required: true,
                },
                'crest_id': {
                    required: function(element) {
                        return $("input[name='fileuploader-list-crest']").val() === '' || $("input[name='fileuploader-list-crest']").val() == '[]';
                    }
                },
                'fileuploader-list-crest': {
                    required: function(element) {
                        return $("#crest_id").val() === "";
                    }
                }
            },
            messages: {
		        'crest_id': {
		            required: "Select team badge or upload your own badge",
		        },
		        'fileuploader-list-crest': {
		            required: "Select team badge or upload your own badge",
		        }
		    },
        }));
    };

    var crest_template = function(option) {
        if(option.text == 'Please select')
            return option.text;
        else {

            var imgUrl = '';
            if(typeof(option.element) == 'object') {
                imgUrl = '<img style="width:20px;" class="mb-1" src="' + option.element.dataset.img + '"> ';
            }

            return imgUrl + option.text;
        }
    }

    var initSelect2 = function(){
        $('.js-select2').select2();

        $("#crest_id").select2({
            templateSelection: crest_template,
            templateResult: crest_template,
            escapeMarkup: function(m) { return m; }
        });
    }

    var initOwnCrestImageUpload = function() {
        $('#crest').fileuploader(Global.buildImageCropParams({
            ratio: '1:1',
            minWidth: 250,
            minHeight: 250,
            showGrid: true
        }));
    }

    var initSelectCrestDefault = function() {
        $('#crest_id').on('select2:select', function (e) {
          var api = $.fileuploader.getInstance('#crest');
            if(!api.isEmpty()) {
                api.remove(api.getFileList()[0]);
            }
        });
    };

    var initCrestSlider = function () {
        $('.team-carousel .owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
            dots: true,
            mouseDrag: false,
            autoplay: false,
            responsive: {
                0: {
                    items: 1
                },
                720: {
                    items: 1
                },
                1140: {
                    items: 1
                }
            }
        });
    };

    return {
        init: function() {
            initFormValidations();
            initSelect2();
            initSelectCrestDefault();
            initOwnCrestImageUpload();
            initCrestSlider();
        },
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerTeamsUpdate.init();
});

var onCroperImageLoad = function() {
    $('#crest_id').val('').trigger('change');
}
