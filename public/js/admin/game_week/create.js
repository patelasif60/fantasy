var AdminGameWeeksCreate = function() {
    var initFormValidations = function () {
        $('.js-game-week-form-create').validate(Global.buildValidateParams({
            rules: {
                'number': {
                    required: true,
                    number:true,
                },
                'start': {
                    required: true,
                },
                'end': {
                    required: true,
                },
            },
        }));
    };

    return {
        init: function() {
            initFormValidations();
            $(".js-select2").select2({ width: '100%' });
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminGameWeeksCreate.init();
});
