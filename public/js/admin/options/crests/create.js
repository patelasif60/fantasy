var AdminOptionsCrestsCreate = function() {
    var initFormValidations = function () {
        $('.js-crest-create-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    remote : {
                        url: Site.crest_check_url,
                        type: "post",
                        data: {
                            name: function()
                            {
                                return $("#name").val();
                            }
                        }
                    }
                },
            },
            messages : {
                'name': {
                    remote: "The name has already been taken.",
                }
            }
        }));
    };

    var initCrestImageUpload = function() {
        $('#crest').fileuploader(Global.buildImageCropParams());
    }
    return {
        init: function() {
            initFormValidations();
            initCrestImageUpload();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminOptionsCrestsCreate.init();
});
