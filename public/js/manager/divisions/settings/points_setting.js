var ManagerDivisionsUpdate = function() {

    var initFormValidations = function () {
        $('.js-division-update-form').validate(Global.buildValidateParams({
            rules: {
                'pre_season_auction_budget': {
                    number: true,
                    min: 0,
                    max: 1000
                },
                'pre_season_auction_bid_increment': {
                    number: true,
                    min: 0,
                    max: 10
                },
            }
        }));

        $('.events-points').each(function() {
            $(this).rules("add", {
                number: true,
                min: -10,
                max: 10
            });
        });
    };


    var pointsChange = function(){
       $('.events-points').change(function() {
            
            if(!$.isNumeric($(this).val()))
            {
                sweet.error('Error !','Please enter a valid number.');
            }
            if($(this).val() > 10)
            {
                sweet.error('Error !','Please enter a value less than or equal to 10.');
            }
            if($(this).val() < -10)
            {
                sweet.error('Error !','Please enter a value greater than or equal to -10.');
            }

            
        });
    }
    return {
        init: function() {
            initFormValidations();
            pointsChange();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionsUpdate.init();
});
