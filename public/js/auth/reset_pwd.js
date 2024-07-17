var RegisterUser = function() {

    var initFormValidations = function () {
        $('.js-reset-form').validate(Global.buildValidateParams({
            rules: {
                'email': {
                    required: true,
                    email: true,
                },
                'password': {
                    required: true,
                    minlength: 6,
                },
                'password_confirmation': {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
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
    RegisterUser.init();
});

$(document).ready(function(){
	$('.js-reset-form input').on('focusout keyup', function(){
		if($('.js-reset-form').valid())
        {
            $('.js-reset-form button[type=submit]').removeAttr('disabled');
        }
        else
        {
            $('.js-reset-form button[type=submit]').attr('disabled', true);
        }
	});
});

