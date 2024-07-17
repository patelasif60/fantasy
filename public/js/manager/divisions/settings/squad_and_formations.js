var ManagerDivisionsUpdate = function() {

    var initFormValidations = function () {
        $('.js-division-update-form').validate(Global.buildValidateParams({
            rules: {
                'default_squad_size': {
                    number: true,
                    min: 11,
                    max: 18
                },
                'default_max_player_each_club': {
                    number: true,
                    min: function() {
                        if(Site.isPostAuctionState){
                            return Site.defaultMaxPlayerEachClub;
                        }

                        return true;
                    }
                },
                'available_formations[]': {
                    minlength: 1,
                    required:true
                },
            },
            messages: {
                    default_max_player_each_club: {
                        min : jQuery.validator.format("After auction, Club quota can only be increased."),
                    },
                    "available_formations[]": "Please select at least one formation."
            }
        }));
    };

    var initSelect2 = function(){
        $('.js-select2').select2();
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
    ManagerDivisionsUpdate.init();
});
