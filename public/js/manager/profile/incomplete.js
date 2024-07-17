var ManagerProfileUpdate = function() {

    var initFormValidations = function() {
        $('.js-profile-update-form').validate(Global.buildValidateParams({
            rules: {
                'first_name': {
                    required: true,
                },
                'last_name': {
                    required: true,
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
    ManagerProfileUpdate.init();
});