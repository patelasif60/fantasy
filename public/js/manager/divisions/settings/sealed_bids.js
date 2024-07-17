var ManagerDivisionsUpdate = function() {

    var initFormValidations = function () {
        $('.js-division-update-form').validate(Global.buildValidateParams({
            rules: {
                'seal_bids_budget': {
                    number: true,
                    min: 0,
                    max: 1000
                },
                'seal_bid_increment': {
                    number: true,
                    min: 0,
                    max: 10
                },
                'seal_bid_minimum': {
                    number: true,
                },
                'max_seal_bids_per_team_per_round': {
                    number: true,
                },
            }
        }));
    };

    var initDTpicker = function(){
        $('.js-datetimepicker').datetimepicker();
    }

    var initSelect2 = function(){
        $('.js-select2').select2();
    }

    return {
        init: function() {
            initFormValidations();
            initDTpicker();
            initSelect2();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionsUpdate.init();
});
