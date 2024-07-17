var AdminProfileUpdate = function() {

    var initFormValidations = function () {
        $('.js-profile-update-form').validate(Global.buildValidateParams({
            rules: {
                'first_name': {
                    required: true,
                },
                'last_name': {
                    required: true,
                },
                'email': {
                    required: true,
                    email: true,
                },
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
    AdminProfileUpdate.init();
});
