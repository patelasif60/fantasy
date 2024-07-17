var AdminConsumerAdminCreate = function() {

    var initFormValidations = function() {
        $('.js-consumer-create-form').validate(Global.buildValidateParams({
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
                'username': {
                    remote: {
                        url: route('admin.users.username.validate'),
                        type: "get",
                    }
                },
                'dob': {
                    required: true,
                },
                'address_1': {
                    required: true,
                },
                'post_code': {
                    required: true,
                },
            },
            messages: {
                email: {
                    remote: "Email already exist."
                },
                username: {
                    remote: "Username already exist."
                }
            }
        }));
    };

    var initAvatarImageUpload = function() {
        $('#avatar').fileuploader(Global.buildImageCropParams());
    }

    return {
        init: function() {
            initFormValidations();
            initAvatarImageUpload();
            Codebase.helpers(['datepicker']);
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminConsumerAdminCreate.init();
});
