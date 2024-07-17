var ManagerContactus = function() {
	var initFormValidations = function () {
        $('.js-contact-form').validate(Global.buildValidateParams({
            rules: {
                'sender' : {
                    required : true
                },
                'subject' : {
                    required : true
                },
                'comments' : {
                    required : true
                },
            }
        }));
    };

    return {
        init: function() {
            initFormValidations();
        }
    };
}();

jQuery(function() {
    ManagerContactus.init();
});