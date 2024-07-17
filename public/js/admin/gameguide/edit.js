var AdminGameGuideCreate = function() {
    var initFormValidations = function () {
        $('.js-gameguide-edit-form').validate(Global.buildValidateParams({
            rules: {
                'section': {
                    required: true,
                }
            },
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
    AdminGameGuideCreate.init();
});
