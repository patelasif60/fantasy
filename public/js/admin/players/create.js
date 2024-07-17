var AdminPlayersCreate = function() {

    var initFormValidations = function () {
        $('.js-player-create-form').validate(Global.buildValidateParams({
            rules: {
                'last_name': {
                    required: true,
                },
                'api_id': {
                    required: true,
                },
            },
        }));
    };

    var initPlayerImageUpload = function() {
        $('#player_image').fileuploader(Global.buildImageCropParams({
            ratio: '32:13',
            minWidth: 640,
            minHeight: 260,
            showGrid: true
        }));
    }

    return {
        init: function() {
            initFormValidations();
            initPlayerImageUpload();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminPlayersCreate.init();
});
