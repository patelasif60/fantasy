var RegisterUser = function() {

    var initFormValidations = function () {
        $('.js-register-form').validate(Global.buildValidateParams({
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
                'password': {
                    required: true,
                    minlength: 6,
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
    $('.js-register-form button[type=submit]').attr('disabled', true);
	$('.js-register-form input').on('keyup', function(){
		if($('.js-register-form').valid())
        {
            $('.js-register-form button[type=submit]').removeClass('btn-gray').addClass('btn-primary');
            $('.js-register-form button[type=submit]').removeAttr('disabled');
        }
        else
        {
            $('.js-register-form button[type=submit]').removeClass('btn-primary').addClass('btn-gray');
            $('.js-register-form button[type=submit]').attr('disabled', true);
        }
	});
});

