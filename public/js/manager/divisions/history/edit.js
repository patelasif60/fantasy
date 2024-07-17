var ManagerHistoryUpdate = function() {

    var initFormValidations = function () {
        $('.js-history-update-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                },
                'season': {
                    required: true,
                },
            },
        }));
    };

    var initSelect2 = function() {
        $('.js-select2').select2({
            tags: true,
            minimumResultsForSearch: 1,
        });
    }

    return {
        init: function() {
            initFormValidations();
            initSelect2();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerHistoryUpdate.init();
});
