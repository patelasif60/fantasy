var divisionPlayersDatatable = '';
var FreeAgentTransfers = function() {

    var initDivisionPlayersDataTable = function () {
        divisionPlayersDatatable = $('.js-table-filter-free-agents').DataTable({
            ajax: {
                url: $('.js-table-filter-free-agents').data('url'),
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
             //responsive: true,
            ordering: true,
            searching: false,
            serverSide: false,
            processing: true,
            pageLength: 25,
            autoWidth: false,
            //scrollY: '52vh',
            scrollCollapse: true,
            //scrollX: true,
            paging: false,
            //stateSave: true,
            // fixedColumns:   {
            //     leftColumns: 4,
            //     rightColumns: 4
            // },
            'order':[[16,'desc']],
            "orderFixed": {
                "post": [[ 1, 'asc' ], [ 19, 'asc' ], [ 18, 'asc' ]]
            },
            initComplete: function(settings, json) {
                select2();
            },
            columns: [
                {
                    data: 'position',
                    title: 'Player',
                    name: 'position',
                    orderData: [ 18, 17 ],
                },
                {
                    data: 'club_name',
                    title: "Club",
                    name: 'club_name',
                    className: 'text-center',
                },
                {
                    data: 'total_game_played',
                    title: "PLD",
                    name: 'total_game_played',
                    defaultContent: '0',
                    className: 'text-center',
                    // orderData: [ 2, 10, 9, 8 ],
                    // "orderFixed": {
                    //     "post": [[ 10, 'asc' ], [ 11, 'asc' ], [ 9, 'asc' ], [ 8, 'asc' ]]
                    // },
                    "orderSequence": [ "desc", "asc" ],
                    //visible: !isMobileScreen(),
                },
                {
                    data: 'total_goal',
                    title: "GLS",
                    name: 'total_goal',
                    defaultContent: '0',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.GOAL) && !isMobileScreen(),
                },
                {
                    data: 'total_assist',
                    title: "ASS",
                    name: 'total_assist',
                    defaultContent: '0',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.ASSIST) && !isMobileScreen(),
                },
                {
                    data: 'total_clean_sheet',
                    title: "CS",
                    name: 'total_clean_sheet',
                    className: 'text-center',
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.CLEAN_SHEET) && !isMobileScreen(),
                },
                {
                    data: 'total_goal_against',
                    title: "GA",
                    name: 'total_goal_against',
                    className: 'text-center',
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.GOAL_CONCEDED) && !isMobileScreen(),
                },
                {
                    data: 'total_club_win',
                    title: 'W',
                    name: 'total_club_win',
                    className: 'text-center',
                    visible: isShowColumn(Site.events.CLUB_WIN)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_yellow_card',
                    title: 'YC',
                    name: 'total_yellow_card',
                    className: 'text-center',
                    visible: isShowColumn(Site.events.YELLOW_CARD)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_red_card',
                    title: 'RC',
                    name: 'total_red_card',
                    className: 'text-center',
                    visible: isShowColumn(Site.events.RED_CARD)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_own_goal',
                    title: 'OG',
                    name: 'total_own_goal',
                    className: 'text-center',
                    visible: isShowColumn(Site.events.OWN_GOAL)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_missed',
                    title: 'PM',
                    name: 'total_penalty_missed',
                    className: 'text-center',
                    visible: isShowColumn(Site.events.PENALTY_MISSED)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_saved',
                    title: 'PS',
                    name: 'total_penalty_saved',
                    className: 'text-center',
                    visible: isShowColumn(Site.events.PENALTY_SAVE)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_goalkeeper_save',
                    title: '5GS',
                    name: 'total_goalkeeper_save',
                    className: 'text-center',
                    visible: isShowColumn(Site.events.GOALKEEPER_SAVE_X5)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'weekPoint',
                    title: "WK",
                    name: 'weekPoint',
                    className: 'text-center',
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ]
                },
                {
                    data: 'monthPoint',
                    title: "MTH",
                    name: 'monthPoint',
                    className: 'text-center',
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ]
                },
                {
                    data: 'total',
                    title: "TOT",
                    name: 'total',
                    className: 'text-center',
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ]
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

    var getPositionShortCode = function(mystring) {
        if(mystring === undefined) {
          mystring = null;
        }
        var matches = mystring.match(/\((.*?)\)/);
        if (matches) {
            return matches[1];
        }
        return '';
    }

    var select2 = function() {
        $('.js-select2').select2();
    };

    var isShowColumn = function(event) {
        if(Site.columns[event] > 0) {

            return true;
        }
        return false;
    }

    var isMobileScreen = function() {

        if(window.innerWidth <= 800) {
            return true;
        }

        return false;
    }

    var playerDetailPopup = function() {
        $(document).on("click",".js-player-details",function() {
            var id = $(this).data('id');
            if (typeof id === 'undefined') {
                return false;
            }
            $('.js-player-name').html($(this).data('name')+'&nbsp;<small>('+$(this).data('club')+')</small>');
            $('#js_player_details_modal').modal('show');


            $('#js_player_details_modal').find($('.modal-body')).html('<div class="p-2">Getting data...</div>');

            $.ajax({
                url: $('#js_player_details_modal').data('url')+'?player_id='+id,
                type: 'GET',
                dataType: 'html',
            })
            .done(function(response) {
                $('#js_player_details_modal').find($('.modal-body')).html(response);
            })
            .fail(function(error) {
            })
        });
    };

    return {
        init: function() {
            initDivisionPlayersDataTable();
            initPlayerFilters();
            playerDetailPopup();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    FreeAgentTransfers.init();
});
