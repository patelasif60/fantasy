var AdminFixturesCreate = function() {

    var initFormValidations = function () {
        $('.js-fixture-create-form').validate(Global.buildValidateParams({
            rules: {
                'season': {
                    required: true,
                },
                'competition': {
                    required: true,
                },
                'home_club': {
                    required: true,
                    notEqualTo:'#filter-away-club'
                },
                'away_club': {
                    required: true,
                     notEqualTo:'#filter-home-club'
                },
                'date': {
                    required: true,
                },
                'time': {
                    required: true,
                },
                'api_id': {
                    required: true,
                },
            },
             messages: {
                'home_club': {
                   notEqualTo:'Please select a value different from away team', 
                },
                'away_club': {
                   notEqualTo:'Please select a value different from home team', 
                }

             }
        }));
    };
    
    var initDTpicker = function(){
        $form = $('.js-fixture-create-form');
        $form.find("input[name='date']").datetimepicker();
        $form.find("input[name='time']").datetimepicker();
    }

    return {
        init: function() {
            initFormValidations();
            initDTpicker();
            Global.select2Options({
                "options": [
                    {
                      "id": '#filter-season',
                      "placeholder": "Select a season"
                    },
                    {
                      "id": '#filter-competition',
                      "placeholder": "Select a competition",
                      "allowClear": true
                    },
                    {
                      "id": '#filter-home-club',
                       "placeholder": "Select a club",
                       "allowClear": true
                    }
                    ,
                    {
                      "id": '#filter-away-club',
                       "placeholder": "Select a club",
                       "allowClear": true
                    }
                  ],
            });
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminFixturesCreate.init();
});