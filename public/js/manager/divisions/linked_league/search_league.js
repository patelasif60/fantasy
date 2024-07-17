var ManagerDivisionSearch = function() {

    var initFormValidations = function () {
        $('.js-search-league-form').validate(Global.buildValidateParams({
            rules: {
                'search_league': {
                    required: true               
                }
            },
            messages: {
                'search_league': "Either a League Name or ID is required",
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
    ManagerDivisionSearch.init();
});
