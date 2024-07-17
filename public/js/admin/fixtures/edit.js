var AdminFixturesEdit = function() {

    var initFormValidations = function () {
        $('.js-fixture-edit-form').validate(Global.buildValidateParams({
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
                messages: {
                    'home_club': {
                       notEqualTo:'Please select a value different from away team', 
                    },
                    'away_club': {
                       notEqualTo:'Please select a value different from home team', 
                    }
                }
            },
        }));
    };
    
    var initDTpicker = function(){
        $form = $('.js-fixture-edit-form');
        $form.find("input[name='date']").datetimepicker();
        $form.find("input[name='time']").datetimepicker();
    }

    return {
        init: function() {
            initFormValidations();
            initDTpicker();
            Codebase.helpers(['datepicker','core-tab']);
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


var FixtureEventsList = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        fixtureEventsTable = $('table.admin-fixture-event-list-table').DataTable({
            ajax: {
                url: $('table.admin-fixture-event-list-table').data('url'),
                method: 'post',
            },
            columns: [
                {
                    data: 'id',
                    title: 'ID',
                    name: 'id',
                },
                {
                    data: 'club',
                    title: "Club",
                    name: 'club',
                    sortable: false,
                    render:function(data){
                            return data.name;
                    }
                },
                {
                    data: 'event_type',
                    title: "Event",
                    render:function(data, type, row, meta){
                        if (data.name == 'Goal' || data.name == 'Own Goal') {
                            var event = data.name + ': ';
                            $.each(row.details, function( index, value ) {
                                if (value.field == 'scorer' || value.field == 'own_scorer') {
                                    event += value.player.first_name + ' ' + value.player.last_name;
                                }
                                if (value.field == 'assist' || value.field == 'own_assist' || value.field == 'assist2' || value.field == 'assist3' || value.field == 'assist4') {
                                    event += ', Assist: ' + value.player.first_name + ' ' + value.player.last_name;
                                }
                            });
                            return event;
                        } else if(data.name == 'Substitution') {
                            var event = data.name;
                            $.each(row.details, function( index, value ) {
                                if (value.field == 'player_off_sub') {
                                    event += ': Player Off - ' + value.player.first_name + ' ' + value.player.last_name;
                                }
                                if (value.field == 'player_on_sub') {
                                    event += ', Player On - ' + value.player.first_name + ' ' + value.player.last_name;
                                }
                            });
                            return event;
                        } else if(data.name == 'Yellow card') {
                            var event = data.name + ': Player - ';
                            $.each(row.details, function( index, value ) {
                                if (value.field == 'player_off_yellow') {
                                    event += value.player.first_name + ' ' + value.player.last_name;
                                }
                            });
                            return event;
                        } else if(data.name == 'Red card') {
                            var event = data.name + ': Player Off - ';
                            $.each(row.details, function( index, value ) {
                                if (value.field == 'player_off_red') {
                                    event += value.player.first_name + ' ' + value.player.last_name;
                                }
                            });
                            return event;
                        } else {
                            return data.name;
                        }
                    }
                },
                {
                    data: 'half',
                    title: "Half",
                    name: 'half',
                    render: function(data, type, row, meta ) {
                        if(typeof Site.half_types[data] != typeof undefined ){
                            return Site.half_types[data];
                        }
                        return '';
                    }
                },
                {
                    data: 'minute',
                    title: "Minutes",
                    name: 'minute'
                },   
                {
                    data: 'second',
                    title: "Seconds",
                    name: 'second'
                },      
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data, type, row, meta ) {                                          
                        return Global.buildModalEditAction(route('admin.fixture.event.edit', { fixture:row.fixture_id, event: data })) +
                            Global.buildDeleteAction(route('admin.fixture.event.destroy', { event: data }));
                    }
                }
            ],
        });
    };

    return {
        init: function () {
            initDataTable();
        },
        resetDatatable: function(){
            fixtureEventsTable.draw();
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminFixturesEdit.init();
    FixtureEventsList.init();
});