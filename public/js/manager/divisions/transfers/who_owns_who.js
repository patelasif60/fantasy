var divisionPlayersDatatable = '';
var WhoOwnsWhoPlayers = function() {
	var initDivisionPlayersDataTable = function () {
        divisionPlayersDatatable = $('.js-table-filter-who-owns-who-players').DataTable({
            ajax: {
                url: $('.js-table-filter-who-owns-who-players').data('url'),
                method: 'post',
                data: function (d) {
                    $.each(readDivisionPlayersFilters(), function (key, value) {
                        if (value !== null) {
                            d[key] = value;
                        }
                    });
                }
            },
            dom: '<"top"><"row"<"col-xl-12 d-flex justify-content-end mb-25"rfB>><"table-responsive"t><"row"<"col-sm-3"i><"col-sm-6 text-center"l><"col-sm-3"p>>',
            language: {
                "infoFiltered": "",
                "processing" : "Loading..."
            },
            ordering: true,
            searching: false,
            serverSide: false,
            processing: true,
            pageLength: 25,
            autoWidth: false,
            scrollY: '52vh',
            scrollCollapse: true,
            scrollX: true,
            paging: false,
            stateSave: false,
            fixedColumns:   {
                leftColumns: 4,
                rightColumns: 4
            },
            'order':[],
            "orderFixed": {
                "post": [[3, 'asc'], [2, 'asc'], [ 19, 'asc' ], [ 1, 'asc' ], [18, 'asc'], [17, 'asc']]
            },
            initComplete: function(settings, json) {
                select2();
            },
            columns: [
                {
                    data: 'position',
                    title: 'Player',
                    name: 'position',
                    orderData: [ 17, 16 ]
                },
                {
                    data: 'club_name',
                    title: "Club",
                    name: 'club_name',
                },
                {
                    data: 'team_name',
                    title: "Team Name",
                    name: 'team_name',
                    defaultContent: '',
                    className: 'text-left',
                    "orderSequence": [ "desc", "asc" ]
                },
                {
                    data: 'team_manager_name',
                    title: 'Manager Name',
                    name: 'team_manager_name',
                    defaultContent: '',
                    className: 'text-left'
                },
                {
                    data: 'bought_price',
                    title: '£M',
                    name: 'bought_price',
                    defaultContent: '0.00',
                },
                {
                    data: 'total_game_played',
                    title: "PLD",
                    name: 'total_game_played',
                    defaultContent: '0',
                    className: 'text-right text-right-padding',
                    /*orderData: [ 2, 10, 9, 8 ],
                    "orderFixed": {
                        "post": [[ 10, 'asc' ], [ 11, 'asc' ], [ 9, 'asc' ], [ 8, 'asc' ]]
                    },*/
                    "orderSequence": [ "desc", "asc" ]
                },
                {
                    data: 'total_goal',
                    title: "GLS",
                    name: 'total_goal',
                    defaultContent: '0',
                    className: 'text-right text-right-padding',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.GOAL),
                },
                {
                    data: 'total_assist',
                    title: "ASS",
                    name: 'total_assist',
                    defaultContent: '0',
                    className: 'text-right text-right-padding',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.ASSIST),
                },
                {
                    data: 'total_clean_sheet',
                    title: "CS",
                    name: 'total_clean_sheet',
                    className: 'text-right text-right-padding',
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.CLEAN_SHEET),
                },
                {
                    data: 'total_goal_against',
                    title: "GA",
                    name: 'total_goal_against',
                    className: 'text-right text-right-padding',
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.GOAL_CONCEDED),
                },
                {
                    data: 'total_yellow_card',
                    title: 'YC',
                    name: 'total_yellow_card',
                    className: 'text-right text-right-padding',
                    visible: isShowColumn(Site.events.YELLOW_CARD),
                    defaultContent: 0
                },
                {
                    data: 'total_red_card',
                    title: 'RC',
                    name: 'total_red_card',
                    className: 'text-right text-right-padding',
                    visible: isShowColumn(Site.events.RED_CARD),
                    defaultContent: 0
                },
                {
                    data: 'total_own_goal',
                    title: 'OG',
                    name: 'total_own_goal',
                    className: 'text-right text-right-padding',
                    visible: isShowColumn(Site.events.OWN_GOAL),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_missed',
                    title: 'PM',
                    name: 'total_penalty_missed',
                    className: 'text-right text-right-padding',
                    visible: isShowColumn(Site.events.PENALTY_MISSED),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_saved',
                    title: 'PS',
                    name: 'total_penalty_saved',
                    className: 'text-right text-right-padding',
                    visible: isShowColumn(Site.events.PENALTY_SAVE),
                    defaultContent: 0
                },
                {
                    data: 'total_goalkeeper_save',
                    title: '5GS',
                    name: 'total_goalkeeper_save',
                    className: 'text-right text-right-padding',
                    visible: isShowColumn(Site.events.GOALKEEPER_SAVE_X5),
                    defaultContent: 0
                },
                {
                    data: 'total',
                    title: "TOT",
                    name: 'total',
                    className: 'text-right text-right-padding',
                    "orderSequence": [ "desc", "asc" ],
                    defaultContent: '0',
                },
                {
                    data: 'player_first_name',
                    name: 'player_first_name',
                    visible: false,
                },
                {
                    data: 'player_last_name',
                    name: 'player_last_name',
                    visible: false,
                },
                {
                    data: 'positionOrder',
                    name: 'positionOrder',
                    visible: false,
                }
            ]
        });
        $( divisionPlayersDatatable.table().header() ).addClass('thead-dark table-dark-header');
    };

    var initPlayerFilters = function () {
        $(document).on('change','.js-player-filter-form select',function(e){
            e.preventDefault();
            divisionPlayersDatatable.ajax.reload();
        });
    };

    var readDivisionPlayersFilters = function() {
        var $form = $('.js-player-filter-form');
        return {
            position: $form.find("select[name='position']").val() || null,
            club: $form.find("select[name='club']").val() || null,
            division_id: $('#division_id').val() || null,
        };
    };

	var select2 = function() {
        $('.js-select2').select2();
    };

    var isShowColumn = function(event) {
        if(Site.columns[event] > 0) {

            return true;
        }
        return false;
    }

    return {
        init: function() {
        	initDivisionPlayersDataTable();
            initPlayerFilters();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    WhoOwnsWhoPlayers.init();
});