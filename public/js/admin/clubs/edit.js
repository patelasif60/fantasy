var AdminClubsCreate = function() {
    var initFormValidations = function () {
        $('.js-club-edit-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                },
                'api_id': {
                    required: true,
                },
                'short_name': {
                    required: true,
                },
                'short_code': {
                    required: true,
                },
            },
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
    AdminClubsCreate.init();
});
