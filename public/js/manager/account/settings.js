var ManagerAccountUpdate = function() {

    var initFormValidations = function() {
         jQuery.validator.addMethod(
            "dateFormat",
            function(value, element) {
                // put your own logic here, this is just a (crappy) example
                if(!value){
                    return true;
                }
                return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
            },
            "Please enter a date in the format DD/MM/YYYY."
        );
        $('.js-user-account-form').validate(Global.buildValidateParams({
            rules: {
                'first_name': {
                    required: true,
                },
                'last_name': {
                    required: true,
                },
                'dob': {
                    dateFormat: true
                },
                'email': {
                    required: true,
                    email: true,
                    remote: {
                        url: route('manage.account.email.validate', { user: Site.user }),
                        type: "get",
                    }
                },
                'username': {
                    remote: {
                        url: route('manage.account.username.validate', { user: Site.user }),
                        type: "get",
                    }
                },
            },
            messages: {
                email: {
                    remote: "Email already exist."
                },
                username: {
                    remote: "Name already exist."
                }
            }
        }));
    };

    var initAvatarImageUpload = function() {
        $('#avatar').fileuploader(Global.buildImageCropParams());
    };

    var initSelect2 = function() {
        $('.country-code-select2').select2();
        $('.club-select2').select2();
    };

    return {
        init: function() {
            initSelect2();
            initFormValidations();
            initAvatarImageUpload();
            $('.dob-datetimepicker').datetimepicker();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerAccountUpdate.init();
});
