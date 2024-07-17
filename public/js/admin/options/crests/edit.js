var AdminOptionsCrestsEdit = function() {
    var initFormValidations = function () {
        $('.js-crest-edit-form').validate(Global.buildValidateParams({
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
                            },
                            id: function()
                            {
                                return $("#crest_id").val();
                            }
                        }
                    }
                },
            },
            messages : {
                'name': {
                    remote: "Badge with this name already available",
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
    AdminOptionsCrestsEdit.init();
});
