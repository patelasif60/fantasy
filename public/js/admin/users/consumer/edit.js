var AdminConsumerAdminUpdate = function() {

    var initFormValidations = function() {
        $('.js-consumer-update-form').validate(Global.buildValidateParams({
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
                        url: route('admin.users.email.validate', { user: Site.user }),
                        type: "get",
                    }
                },
                'username': {
                    remote: {
                        url: route('admin.users.username.validate', { user: Site.user }),
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

    var initHijackUserFeature = function() {
        var copyPasswordButton = $('.js-single-use-password-copy');
        var passwordInput = $('.js-single-use-password-value');
        var hijackConsumerModal = $('#modal-hijack-consumer');
        var hijackConsumerModalResult = $('#modal-hijack-consumer-result');

        new ClipboardJS('.js-single-use-password-copy')
            .on('success', function(e) {
                e.clearSelection();
                copyPasswordButton.tooltip('show');
            });

        $('button.js-hijack-consumer').on('click', function(e) {
            e.preventDefault();
            $.post($(this).data('url'))
                .done(function(data) {
                    hijackConsumerModal.modal('hide');
                    passwordInput.val(data);
                    hijackConsumerModalResult.modal('show');
                })
                .fail(function(error) {
                    sweet.error('Error', 'Password could not be generated at this time. Please try again later.');
                });
            });
            copyPasswordButton.parent().on('mouseleave', function() {
                copyPasswordButton.tooltip('hide');
            });
            hijackConsumerModalResult.on('hidden.bs.modal', function (e) {
                passwordInput.val('');
            });
        }

    return {
        init: function() {
            initFormValidations();
            initAvatarImageUpload();
            initHijackUserFeature();
            Codebase.helpers(['datepicker']);
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminConsumerAdminUpdate.init();
});
