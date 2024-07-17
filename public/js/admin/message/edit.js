var AdminMessageCreate = function() {
    var initFormValidations = function () {
        $('.js-message-edit-form').validate(Global.buildValidateParams({
            rules: {
                'key': {
                    required: true,
                },
                'content': {
                    required: true,
                }
            },
        }));
    };

    return {
        init: function() {
            initFormValidations();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminMessageCreate.init();
});
