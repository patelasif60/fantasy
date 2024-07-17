var divisionPlayersDatatable = '';
var MorePlayers = function() {

    var initDivisionPlayersDataTable = function () {
        divisionPlayersDatatable = $('table.manager-teams-list-table').DataTable({
            ajax: {
                url: $('table.manager-teams-list-table').data('url'),
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
            fixedColumns:   {
                leftColumns: 4,
                rightColumns: 4
            },
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
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.CLUB_WIN)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_yellow_card',
                    title: 'YC',
                    name: 'total_yellow_card',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.YELLOW_CARD)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_red_card',
                    title: 'RC',
                    name: 'total_red_card',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.RED_CARD)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_own_goal',
                    title: 'OG',
                    name: 'total_own_goal',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.OWN_GOAL)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_missed',
                    title: 'PM',
                    name: 'total_penalty_missed',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.PENALTY_MISSED)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_saved',
                    title: 'PS',
                    name: 'total_penalty_saved',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
                    visible: isShowColumn(Site.events.PENALTY_SAVE)  && !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_goalkeeper_save',
                    title: '5GS',
                    name: 'total_goalkeeper_save',
                    className: 'text-center',
                    "orderSequence": [ "desc", "asc" ],
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

    var initInsOutPlayersDataTable = function () {
        initInsOutPlayersDataTable = $('table.manager-ins-out-table').DataTable({
            ajax: {
                url: $('table.manager-ins-out-table').data('url'),
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
            bInfo: false,
            //stateSave: true,
            fixedColumns:   {
                leftColumns: 4,
                rightColumns: 4
            },
            'order':[],
            "orderFixed": {
                "post": [[ 0, 'desc' ],[ 1, 'desc' ]]
            },
           initComplete: function(settings, json) {
                select2();
            },
            columns: [
                 {
                    data: 'dtstr',
                    name: 'year',
                    visible: false,
                    "orderSequence": [ "desc", "asc" ]
                },
                 {
                    data: 'last_name',
                    name: 'last_name',
                    visible: false,
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'TransferDate',
                    title: 'Date',
                    name: 'TransferDate',
                    orderData: [0],
                },
                {
                    data: 'position',
                    title: 'Pos',
                    name: 'position',
                    "orderSequence": [ "desc", "asc" ],
                    width:'6%',
                    render: function(data,display,row) {
                        return '<span class="custom-badge custom-badge-lg is-square is-'+row.position.toLowerCase()+'">'+row.position+'</span>';
                    }

                },
                {
                    data: 'player',
                    title: 'player',
                    name: 'player',
                    orderData: [1],
                     render: function(data,display,row) {
                        return '<div class="player-tshirt icon-18 '+row.inshortcode+'_player mr-1"></div>'+row.player;
                    }
                },
                {
                    data: 'outfrom',
                    title: 'OUT',
                    name: 'outfrom',
                    defaultContent: '-',
                    render: function(data,display,row) {
                        if(row.outfrom == null){
                            return ' ';
                        }
                        if(row.is_active==0){

                            return '<div class="player-tshirt icon-18 '+row.outshortcode+'_player mr-1"></div>'+row.outfrom;
                        }
                        if(row.outfrom == row.infrom)
                        {
                            return ' ';
                        }
                        return '<div class="player-tshirt icon-18 '+row.outshortcode+'_player mr-1"></div>'+row.outfrom;
                    }
                },
                {
                    data: 'infrom',
                    title: 'In',
                    name: 'infrom',
                    defaultContent: '-',
                    render: function(data,display,row) {
                        if(row.is_active==0){
                            if(row.outfrom == row.infrom)
                            {
                                return ' ';
                            }
                        }
                        return '<div class="player-tshirt icon-18 '+row.inshortcode+'_player mr-1"></div>'+row.infrom;
                    }
                },
            ]
        });
        $( initInsOutPlayersDataTable.table().header() ).addClass('thead-dark table-dark-header');
    };

    var initPlayerFilters = function () {
        $(document).on('change','.js-player-filter-form select',function(e){
            e.preventDefault();
            initHallOfFameDataTable.ajax.reload();
            divisionPlayersDatatable.ajax.reload();
            initInsOutPlayersDataTable.ajax.reload();
        });
    };
     
    var readDivisionPlayersFilters = function() {
        var $form = $('.js-player-filter-form');
        return {
            position: $form.find("select[name='position']").val() || null,
            club: $form.find("select[name='club']").val() || null,
            division_id: $('#division_id').val() || null,
            season: $form.find("select[name='season']").val() || null,
        };
    };

    var playerDetailPopup = function() {

        $(document).on("click",".js-player-details",function() {

            var id = $(this).data('id');

            if (typeof id === 'undefined') {
                return false;
            }

            console.log($(this));

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

    var playerTabClick = function() {
        $('#players-tab').click(".js-player-details", function() {

            $('#DataTables_Table_0_info').removeClass('d-none')
            $('#DataTables_Table_3_info').addClass('d-none')
            $('.js-player-data').removeClass('d-none')
            $('#DataTables_Table_1_info').addClass('d-none')
            $('.js-ins-outs').addClass('d-none')

            if($(this).attr('data-load') == '0') {
                initDivisionPlayersDataTable();
                initInsOutPlayersDataTable();
                $(this).attr('data-load',1);
                initHallOfFameDataTable();
            }
            $('.js-posotion-filter').removeClass('d-none')
            $('.js-seson-filter').addClass('d-none')
            $('.js-overall-history').addClass('d-none')
            $('.js-temp-injuries').addClass('d-none')
            $('#filter-club').removeClass('d-none')
            $('.js-table-one').removeClass('d-none')

        });
    };
    var initHallOfFameDataTable = function () {
        initHallOfFameDataTable = $('table.manager-overall-history').DataTable({
            ajax: {
                url: $('table.manager-overall-history').data('url'),
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
                "processing" : ""
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
            bInfo: false,
            //stateSave: true,
            fixedColumns:   {
                leftColumns: 4,
                rightColumns: 4
            },
            'order':[[ 11, 'desc' ],[ 5, 'desc' ],[ 1, 'asc' ],[ 0, 'asc' ],[ 6, 'desc' ],[ 7, 'desc' ],[ 8, 'desc' ],[ 9, 'desc' ],[ 10, 'desc' ]],
            "orderFixed": {
                "post": [[ 5, 'desc' ],[ 11, 'desc' ],[ 1, 'asc' ],[ 0, 'asc' ]]
            },
           initComplete: function(settings, json) {
                select2();
            },
            columns: [
                 {
                    data: 'first_name',
                    name: 'first_name',
                    visible: false,
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'last_name',
                    name: 'last_name',
                    visible: false,
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'position',
                    title: 'POS',
                    name: 'position',
                    width:'5%',
                    render: function(data,display,row) {
                        var cls = row.position ? row.position.toLowerCase() : '';
                        return '<span class="custom-badge custom-badge-lg is-square is-'+cls+'">'+row.position+'</span>';
                    }
                },
                {
                    data: 'player',
                    title: 'player',
                    name: 'player',
                    orderData: [1],
                    render: function(data,display,row) {
                        return ' <div class="player-wrapper js-player-details cursor-pointer" data-id="'+row.pid+'" data-name="'+row.first_name+' '+row.last_name+'" data-club="'+row.cname+'">'+row.player+'</div>';
                    }
                },
                {
                    data: 'clubs',
                    title: 'club',
                    name: 'clubs',
                    defaultContent: '-',
                     render: function(data,display,row) {
                       //return '<div class="player-tshirt icon-18 '+row.clubs_short_code+'_player mr-1"></div>'+row.short_name;
                       return row.short_name;
                    }
                },
                {
                    data: 'Season',
                    title: 'Season',
                    name: 'Season',
                    defaultContent: '-',
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'played',
                    title: 'PLD',
                    name: 'played',
                    defaultContent: '-',
                    "orderSequence": [ "desc", "asc" ],
                },
                 {
                    data: 'goal',
                    title: 'GLS',
                    name: 'goal',
                    defaultContent: '-',
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'assist',
                    title: 'ASS',
                    name: 'assist',
                    defaultContent: '-',
                    "orderSequence": [ "desc", "asc" ],
                },
                {

                    data: 'clean_sheet',
                    title: 'CS',
                    name: 'clean_sheet',
                    defaultContent: '-',
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'goal_conceded',
                    title: 'GA',
                    name: 'goal_conceded',
                    defaultContent: '-',
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: '',
                    title: 'TOT',
                    name: '',
                    defaultContent: '-',
                    "orderSequence": [ "desc", "asc" ],
                    render: function(data,display,row) {
                        return eval(row.total)
                        //return eval(row.appearance) + eval(row.goal) + eval(row.assist) + eval(row.goal_conceded)+ eval(row.clean_sheet);
                    }
                },
            ]
        });
        $( initHallOfFameDataTable.table().header() ).addClass('thead-dark table-dark-header');
    };
    var initInsOut = function () {
        $(document).on('click','.js-insout-btn',function(e){
            $('.js-table-one').removeClass('d-none')
            $('#DataTables_Table_0_info').addClass('d-none')
            $('.js-player-data').addClass('d-none')
            $('.js-overall-history').addClass('d-none')
            $('.js-temp-injuries').addClass('d-none')
            $('#DataTables_Table_1_info').removeClass('d-none')
            $('.js-ins-outs').removeClass('d-none')
            $('.js-posotion-filter').removeClass('d-none')
            $('.js-seson-filter').addClass('d-none')
            $('#DataTables_Table_3_info').addClass('d-none')
            $('#filter-club').removeClass('d-none')

        });
    };
     var overallhistory = function () {
        $(document).on('click','.js-overall-history-btn',function(e){
            $('.js-table-one').removeClass('d-none')
            $('.js-player-data').addClass('d-none')
            $('#DataTables_Table_0_info').addClass('d-none')
            $('.js-ins-outs').addClass('d-none')
            $('.js-temp-injuries').addClass('d-none')
            $('.js-posotion-filter').addClass('d-none')
            $('.js-seson-filter').removeClass('d-none')
            $('.js-overall-history').removeClass('d-none')
            $('#DataTables_Table_3_info').addClass('d-none')
            $('#filter-club').removeClass('d-none')
        });
    };
    var injuries = function () {
        $(document).on('click','.js-injuries-btn',function(e){
            $('.js-table-one').addClass('d-none')
            $('#DataTables_Table_0_info').addClass('d-none')
            $('.js-player-data').addClass('d-none')
            $('.js-overall-history').addClass('d-none')
            $('.js-ins-outs').addClass('d-none')
            $('.js-posotion-filter').addClass('d-none')
            $('.js-seson-filter').addClass('d-none')
            $('#filter-club').addClass('d-none')
            $('.js-temp-injuries').removeClass('d-none')
            $('#DataTables_Table_3_info').removeClass('d-none')
        });
    };

    var initCarousel = function () {
        var startPositionWeek = isNaN(parseInt($('.js-owl-carousel-date-info .is-active').attr('data-number'))) ? 0 : parseInt($('.js-owl-carousel-date-info .is-active').attr('data-number'));

        $('.js-owl-carousel-date-info').owlCarousel({
            loop: false,
            margin: 1,
            nav: true,
            navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
            dots: false,
            mouseDrag: false,
            responsive: {
                0: {
                    startPosition: startPositionWeek - 1,
                    items: 6
                },
                720: {
                    startPosition: startPositionWeek - 1,
                    items: 8
                },
                1140: {
                    startPosition: startPositionWeek - 1,
                    items: 9
                }
            }
        });

        $('.jsGameWeekHandler').on('click', function(){
            $('a.jsGameWeekHandler').removeClass('is-active');
            $(this).addClass('is-active');
            let dataUrl = $(this).attr('data-url');
            $.ajax({
                type: "POST",
                url: dataUrl,
                dataType: 'html',
                success: function(response) {
                    $('div.matchDetails').html(response);
                },
            });
        });

        $('body').on('click', '.jsGetFixtureStats', function(){
            let dataUrl = $(this).attr('data-href');
            $('#matchDetailsModal').modal('show');
            $('#matchDetailsModal div.modal-body').html('<div class="text-center"><i class="fas fa-cog fa-spin"></i> Fetching data...</div>');
            $.ajax({
                type: "POST",
                url: dataUrl,
                dataType: 'html',
                success: function(response) {
                    $('#matchDetailsModal div.modal-body').html(response);
                },
            });
        });
    }

    return {
        init: function() {
            overallhistory();
            injuries();
            playerDetailPopup();
            initPlayerFilters();
            playerTabClick();
            initInsOut();
            initCarousel();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    MorePlayers.init();
});
document.addEventListener('DOMContentLoaded', function() {
      $(".nav-link").removeClass('disabled');
});