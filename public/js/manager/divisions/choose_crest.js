var ManagerChooseCrest = function() {

    var initChooseCrestFormValidations = function () {
        $('.js-choose-crest-form').validate(Global.buildValidateParams({
            rules: {
                'crest_id': {
                    required: function(element) {

                        return $("input[name='fileuploader-list-crest']").val() === '' || $("input[name='fileuploader-list-crest']").val() == '[]';
                    }
                },
                'fileuploader-list-crest': {
                    required: function(element) {
                        if (! $('input[name=crest_id]', '.js-choose-crest-form').is(':checked') ) {

                            return true;
                        }

                        return false;
                    }
                }
            },
            messages: {
		        'crest_id': {
		            required: "Select team crest or upload your own crest",
		        },
		        'fileuploader-list-crest': {
		            required: "Select team crest or upload your own crest",
		        }
		    },
        }));
    };

    var initOwnCrestImageUpload = function() {
        $('#crest').fileuploader(Global.buildImageCropParams({
            ratio: '1:1',
            minWidth: 250,
            minHeight: 250,
            showGrid: true
        }));
    }

    var initSelectCrestDefault = function() {
        $(".js-crest-default-images-radio").click(function () {
            var api = $.fileuploader.getInstance('#crest');
            if(!api.isEmpty()) {
                api.remove(api.getFileList()[0]);
            }
        });
    }

    return {
        init: function() {
            initChooseCrestFormValidations();
            initOwnCrestImageUpload();
            initSelectCrestDefault();
        },
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerChooseCrest.init();
});

var onCroperImageLoad = function() {
    $('.js-crest-default-images-radio').prop( "checked", false );
    $('.js-create-team').prop("disabled", false);
}
