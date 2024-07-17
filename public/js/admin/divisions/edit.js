var AdminDivisionsCreate = function() {
    var initFormValidations = function () {
        $('.js-division-edit-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    maxlength: 255
                },
                'chairman_id': {
                   required: {
                        depends: function(element) {
                            return $('#social_id').val() == 0 ? true : false;
                        }
                    }
                },
                'package_id': {
                    required: true,
                },
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
                    min: 0
                },
                'max_seal_bids_per_team_per_round': {
                    number: true,
                    min: 0
                },
                'default_squad_size': {
                    number: true,
                    min: 11,
                    max: 18
                },
                'default_max_player_each_club': {
                    number: true,
                    min: 1
                },
                'season_free_agent_transfer_limit': {
                    number: true,
                    min: 0
                },
                'monthly_free_agent_transfer_limit': {
                    number: true,
                    min: 0
                }
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

    var initDTpicker = function(){
        $form = $('.js-division-edit-form');
        $form.find("input[name='first_seal_bid_deadline']").datetimepicker();
        $form.find("input[name='auction_date']").datetimepicker();
    }

    var championsTeamSelect = function(){
        $('#champions_league_team').on('change', function() {
             if($(this).val()){
                $("#europa_league_team_1").select2('destroy');
                $("#europa_league_team_2").select2('destroy');
                $("#europa_league_team_1 option, #europa_league_team_2 option").removeAttr('disabled');
                $("#europa_league_team_1 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
                $("#europa_league_team_2 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
                if($('#europa_league_team_1').val()){
                     $("#europa_league_team_2 option[value=" + $("#europa_league_team_1").val() + "]").attr('disabled','disabled');
                }
                if($('#europa_league_team_2').val()){
                    $("#europa_league_team_1 option[value=" + $("#europa_league_team_2").val() + "]").attr('disabled','disabled');
                }

                $("#europa_league_team_1").select2();
                $("#europa_league_team_2").select2();
            }
        });
    };
    var europeanTeamOneSelect = function(){
        $('#europa_league_team_1').on('change', function() {
            if($(this).val()){
                $("#champions_league_team").select2('destroy');
                $("#europa_league_team_2").select2('destroy');
                $("#champions_league_team option, #europa_league_team_2 option").removeAttr('disabled');
                $("#champions_league_team option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
                $("#europa_league_team_2 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
                if($('#champions_league_team').val()){
                     $("#europa_league_team_2 option[value=" + $("#champions_league_team").val() + "]").attr('disabled','disabled');
                }
                if($('#europa_league_team_2').val()){
                    $("#champions_league_team option[value=" + $("#europa_league_team_2").val() + "]").attr('disabled','disabled');
                }

                $("#champions_league_team").select2();
                $("#europa_league_team_2").select2();
            }
        });
    };
    var europeanTeamTwoSelect = function(){
        $('#europa_league_team_2').on('change', function() {
            if($(this).val()){
                $("#champions_league_team").select2('destroy');
                $("#europa_league_team_1").select2('destroy');
                $("#champions_league_team option, #europa_league_team_1 option").removeAttr('disabled');
                $("#champions_league_team option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
                $("#europa_league_team_1 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
                if($('#champions_league_team').val()){
                     $("#europa_league_team_1 option[value=" + $("#champions_league_team").val() + "]").attr('disabled','disabled');
                }
                if($('#europa_league_team_1').val()){
                    $("#champions_league_team option[value=" + $("#europa_league_team_1").val() + "]").attr('disabled','disabled');
                }

                $("#champions_league_team").select2();
                $("#europa_league_team_1").select2();
            }
        });
    };
    return {
        init: function() {
            initFormValidations();
            initDTpicker();
            championsTeamSelect();
            europeanTeamOneSelect();
            europeanTeamTwoSelect();
            // $("#package_id").select2();
            Global.select2Options({
                "options": [
                    {
                      "id": '#chairman_id',
                      "placeholder": "Please select",
                      "minimumInputLength": 3,
                      "ajax" : {
                        url: route('admin.users.search'),
                        data: function (params) {
                          params.term = $.trim(params.term).replace(/ /g, '+')
                          var query = {
                            search: params.term.replace(/ /g, '+')
                          }
                          return query;
                        },
                        processResults: function (data) {
                          return {
                            results: data
                          }
                        }
                      }
                    },
                    {
                      "id": '#co_chairman_id',
                      "placeholder": "Please select",
                      "minimumInputLength": 3,
                      "ajax" : {
                        url: route('admin.users.search'),
                        data: function (params) {
                          params.term = $.trim(params.term).replace(/ /g, '+')
                          var query = {
                            search: params.term.replace(/ /g, '+')
                          }
                          return query;
                        },
                        processResults: function (data) {
                          return {
                            results: data
                          }
                        }
                      }
                    },
                    {
                      "id": '#parent_division_id',
                      "placeholder": "No parent division",
                      "allowClear": true
                    },
                    {
                      "id": '#filter-season',
                    }
                  ],
            });
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminDivisionsCreate.init();
});
$(document).on('change', '#package_id', function () {
    if($('option:selected', this).data('league-type') == 'No'){
      $('#chairman_id').attr('disabled','disabled');
      $('#co_chairman_id').attr('disabled','disabled');
      $('#parent_division_id').attr('disabled','disabled');
      $('#social_id').val($('option:selected', this).data('default-id'));
      $('#auction_types').val('Online sealed bids');
      $('#auction_types').trigger('change');
      $('#auction_types').attr('disabled','disabled');
      $('.chairman_id #select2-chairman_id-container').text($('option:selected', this).data('default-name'));
  }
    else{
      $('#chairman_id').removeAttr('disabled');
      $('#co_chairman_id').removeAttr('disabled');
      $('#auction_types').removeAttr('disabled','disabled')
      $('#parent_division_id').removeAttr('disabled');
      $('#social_id').val(0);
      //$('#chairman_id').val(null);
      //$('.chairman_id #select2-chairman_id-container').text('Please select');
    }
});
