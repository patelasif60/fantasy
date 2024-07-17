var AdminUsersAdminUpdate = function() {

    var initFormValidations = function () {
        $('.js-admin-update-form').validate(Global.buildValidateParams({
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
                    remote: {
                        url: route('admin.users.email.validate', {user: Site.user}),
                        type: "get",
                    }
                },
                'role': {
                    required: true,
                }
            },
            messages: {
                email: {
                    remote: "Email already exist."
                }
            }
        }));
    };

    return {
        init: function() {
            initFormValidations();
            Global.select2Options();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminUsersAdminUpdate.init();
});
