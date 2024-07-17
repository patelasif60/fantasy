var AdminPackagesCreate = function() {

    var initFormValidations = function () {
        $('.js-package-create-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    maxlength: 255
                },
                'price': {
                    required: true,
                    number: true,
                    min: 0,
                    max: 100
                },
                'minimum_teams': {
                    required: true,
                    number: true,
                    min: 1,
                    max: 16
                },
                'maximum_teams': {
                    required: true,
                    number: true,
                    min: 1,
                    max: 16
                },
                'max_free_places': {
                    required: true,
                    number: true,
                },
                'pre_season_auction_budget': {
                    required: true,
                    number: true,
                    min: 0,
                    max: 1000
                },
                'pre_season_auction_bid_increment': {
                    required: true,
                    number: true,
                    min: 0,
                    max: 10
                },
                'seal_bids_budget': {
                    required: true,
                    number: true,
                    min: 0,
                    max: 1000
                },
                'seal_bid_increment': {
                    required: true,
                    number: true,
                    min: 0,
                    max: 10
                },
                'seal_bid_minimum': {
                    required: true,
                    number: true,
                    min: 0
                },
                'max_seal_bids_per_team_per_round': {
                    required: true,
                    number: true,
                    min: 0
                },
                'default_squad_size': {
                    required: true,
                    number: true,
                    min: 11,
                    max: 18
                },
                'default_max_player_each_club': {
                    required: true,
                    number: true,
                    min: 1
                },
                'season_free_agent_transfer_limit': {
                    required: true,
                    number: true,
                    min: 0
                },
                'monthly_free_agent_transfer_limit': {
                    required: true,
                    number: true,
                    min: 0
                },
                'auction_types[]': {
                    required: true,
                },
                "available_formations[]": {
                    require_from_group: [1, ".formation-group"]
                }
                ,
                "money_back_types[]": {
                    require_from_group: [1, ".money-back-group"]
                }
            },
            messages: {
                'available_formations[]': {
                    required: 'Choose at least one formation.'
                },
                "money_back_types[]": {
                    required: 'Choose at least one money back type.'
                }
            },
        }));

        $('.events-points').each(function() {
            $(this).rules("add", {
                required: true,
                number: true,
                min: -10,
                max: 10
            });
        });
    };

    var initDTpicker = function(){
        $form = $('.js-package-create-form');
        $form.find("input[name='first_seal_bid_deadline']").datetimepicker();
    }

    var postivePointWarning = function(){
        $('.positivePoint').on('change', function(e) {

            var obj = $(this).closest('.parentDiv').find('.warningMessage');

            if(!isNaN($(this).val()) && $(this).val() < 0){
                obj.html('Note: This field should have non-negative score');
                obj.show();
            }else{
                obj.hide();
            }
        });
    }

    var negativePointWarning = function(){
        $('.negativePoint').on('change', function(e) {

            var obj = $(this).closest('.parentDiv').find('.warningMessage');
            if(!isNaN($(this).val()) && $(this).val() > 0){
                obj.html('Note: This field should have non-positive score');
                obj.show();
            }else{
                obj.hide();
            }

        });
    }

    var defaultPrizePackValues = function() {
        $('#prize_packs').on('change', function(e) {
            var selectedPrizePacks = $(this).select2('data');
            $('#default_prize_pack').empty().append('<option selected="selected" value="">Select Prize Pack</option>');
            $.each(selectedPrizePacks, function(key, value) {
                if (!$('#default_prize_pack').find("option[value='" + value.id + "']").length) {
                    var data = {
                        id: value.id,
                        text: value.text
                    };
                    var newOption = new Option(data.text, data.id);
                    $('#default_prize_pack').append(newOption);
                }
            });
        });
    }

    return {
        init: function() {
            initFormValidations();
            Global.select2Options();
            initDTpicker();
            postivePointWarning();
            negativePointWarning();
            defaultPrizePackValues();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminPackagesCreate.init();
});
