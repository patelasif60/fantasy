var AdminUsersAdminCreate = function() {

    var initFormValidations = function () {
        $('.js-admin-create-form').validate(Global.buildValidateParams({
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
                        url: route('admin.users.email.validate'),
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
    AdminUsersAdminCreate.init();
});
