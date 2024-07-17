var AdminPasswordUpdate = function() {

    var initFormValidations = function () {
        $('.js-password-update-form').validate(Global.buildValidateParams({
            rules: {
                current_password : {
                    required: true,
                },
                password : {
                    required: true,
                    minlength :6
                },
                password_confirmation : {
                    required: true,
                    minlength : 6,
                    equalTo : "#password"
                }
            }
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
    AdminPasswordUpdate.init();
});
