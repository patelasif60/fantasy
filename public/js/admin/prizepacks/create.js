var AdminPrizePacksCreate = function() {
    var initFormValidations = function () {
        $('.js-prize-pack-create-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    maxlength: 255
                },
                'price': {
                    number: true,
                    min: 0
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
    AdminPrizePacksCreate.init();
});
