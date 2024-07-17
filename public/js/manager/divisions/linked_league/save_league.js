var SaveLinkedLeague = function() {

    var initFormValidations = function () {
        $('.js-save-league-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true               
                }
            },
            messages: {
                'name': "Linked league name is required",
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
    SaveLinkedLeague.init();
});
