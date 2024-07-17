var datatableSeason = '';
var datatableMonth = '';
var datatableWeek = '';
var LeagueStandingsInfo = function() {

    var initDatatableSeason = function() {
        datatableSeason = $('.js-table-filter-season').DataTable({
                ajax: $(".js-data-filter-tabs").data('url')+'?filter=season&linkedLeague='+Site.linkedLeague,
                // responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                scrollX: true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 2,
                    rightColumns: 3
                },
                columns: [
                {
                    data: 'league_position',
                    title: 'POS',
                    name: 'league_position',
                    width:'6%',
                    defaultContent: 1
                },
                {
                    data: 'teamName',
                    title: 'Team',
                    name: 'Team',
                    className: "text-left",
                    render: function(data,display,row) {
                        var url = route('manage.team.lineup', { division: row.divisionId, team:row.teamId });

                        return '<div><a href="'+url+'" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="'+url+'" class="player-name link-nostyle">'+row.first_name+' '+row.last_name+'</a></div>';
                    }
                },
                {
                    data: 'total_goal',
                    title: 'GLS',
                    name: 'total_goal',
                    visible: isShowColumn(Site.events.GOAL),
                    defaultContent: 0
                },
                {
                    data: 'total_assist',
                    title: 'ASS',
                    name: 'total_assist',
                    visible: isShowColumn(Site.events.ASSIST),
                    defaultContent: 0
                },
                {
                    data: 'total_clean_sheet',
                    title: 'CS',
                    name: 'total_clean_sheet',
                    visible: isShowColumn(Site.events.CLEAN_SHEET),
                    defaultContent: 0
                },
                {
                    data: 'total_conceded',
                    title: 'GA',
                    name: 'total_conceded',
                    visible: isShowColumn(Site.events.GOAL_CONCEDED),
                    defaultContent: 0
                },
                {
                    data: 'total_appearance',
                    title: 'GP',
                    name: 'total_appearance',
                    visible: isShowColumn(Site.events.APPEARANCE),
                    defaultContent: 0
                },
                {
                    data: 'total_club_win',
                    title: 'CW',
                    name: 'total_club_win',
                    visible: isShowColumn(Site.events.CLUB_WIN),
                    defaultContent: 0
                },
                {
                    data: 'total_yellow_card',
                    title: 'YC',
                    name: 'total_yellow_card',
                    visible: isShowColumn(Site.events.YELLOW_CARD),
                    defaultContent: 0
                },
                {
                    data: 'total_red_card',
                    title: 'RC',
                    name: 'total_red_card',
                    visible: isShowColumn(Site.events.RED_CARD),
                    defaultContent: 0
                },
                {
                    data: 'total_own_goal',
                    title: 'OG',
                    name: 'total_own_goal',
                    visible: isShowColumn(Site.events.OWN_GOAL),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_missed',
                    title: 'PM',
                    name: 'total_penalty_missed',
                    visible: isShowColumn(Site.events.PENALTY_MISSED),
                    defaultContent: 0
                },
                {
                    data: 'total_penalty_saved',
                    title: 'PS',
                    name: 'total_penalty_saved',
                    visible: isShowColumn(Site.events.PENALTY_SAVE),
                    defaultContent: 0
                },
                {
                    data: 'total_goalkeeper_save',
                    title: 'GS',
                    name: 'total_goalkeeper_save',
                    visible: isShowColumn(Site.events.GOALKEEPER_SAVE_X5),
                    defaultContent: 0
                },
                {
                    data: 'total_point_week',
                    title: 'WK',
                    name: 'total_point_week',
                    defaultContent: 0
                },
                {
                    data: 'total_point_month',
                    title: 'MTH',
                    name: 'total_point_month',
                    defaultContent: 0
                },
                {
                    data: 'total_point',
                    title: 'TOT',
                    name: 'total_point',
                    defaultContent: 0
                },
            ]
        });

        $( datatableSeason.table().header() ).addClass('thead-dark table-dark-header');
    };
    var initDatatableMonth = function() {
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-monthly') ) {
            datatableMonth = $('.js-table-filter-monthly').DataTable({
                    // responsive: true,
                    searching: false,
                    paging: false,
                    info: false,
                    ordering: false,
                    autoWidth:false,
                    scrollX: true,
                    scrollCollapse: true,
                    fixedColumns:   {
                        leftColumns: 2,
                        rightColumns: 1
                    },
                    columns: [
                    {
                        data: 'league_position',
                        title: 'Pos',
                        name: 'league_position',
                        defaultContent: 1
                    },
                    {
                        data: 'teamName',
                        title: 'Team',
                        name: 'Team',
                        className: "text-left",
                        render: function(data,display,row) {

                            var url = route('manage.team.lineup', { division: divisionId, team:row.teamId });

                            return '<div><a href="'+url+'" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="'+url+'" class="player-name link-nostyle">'+row.first_name+' '+row.last_name+'</a></div>';
                        }
                    },
                    {
                        data: 'total_goal',
                        title: 'GLS',
                        name: 'total_goal',
                        visible: isShowColumn(Site.events.GOAL),
                        defaultContent: 0
                    },
                    {
                        data: 'total_assist',
                        title: 'ASS',
                        name: 'total_assist',
                        visible: isShowColumn(Site.events.ASSIST),
                        defaultContent: 0
                    },
                    {
                        data: 'total_clean_sheet',
                        title: 'CS',
                        name: 'total_clean_sheet',
                        visible: isShowColumn(Site.events.CLEAN_SHEET),
                        defaultContent: 0
                    },
                    {
                        data: 'total_conceded',
                        title: 'GA',
                        name: 'total_conceded',
                        visible: isShowColumn(Site.events.GOAL_CONCEDED),
                        defaultContent: 0
                    },
                    {
                        data: 'total_appearance',
                        title: 'GP',
                        name: 'total_appearance',
                        visible: isShowColumn(Site.events.APPEARANCE),
                        defaultContent: 0
                    },
                    {
                        data: 'total_club_win',
                        title: 'CW',
                        name: 'total_club_win',
                        visible: isShowColumn(Site.events.CLUB_WIN),
                        defaultContent: 0
                    },
                    {
                        data: 'total_yellow_card',
                        title: 'YC',
                        name: 'total_yellow_card',
                        visible: isShowColumn(Site.events.YELLOW_CARD),
                        defaultContent: 0
                    },
                    {
                        data: 'total_red_card',
                        title: 'RC',
                        name: 'total_red_card',
                        visible: isShowColumn(Site.events.RED_CARD),
                        defaultContent: 0
                    },
                    {
                        data: 'total_own_goal',
                        title: 'OG',
                        name: 'total_own_goal',
                        visible: isShowColumn(Site.events.OWN_GOAL),
                        defaultContent: 0
                    },
                    {
                        data: 'total_penalty_missed',
                        title: 'PM',
                        name: 'total_penalty_missed',
                        visible: isShowColumn(Site.events.PENALTY_MISSED),
                        defaultContent: 0
                    },
                    {
                        data: 'total_penalty_saved',
                        title: 'PS',
                        name: 'total_penalty_saved',
                        visible: isShowColumn(Site.events.PENALTY_SAVE),
                        defaultContent: 0
                    },
                    {
                        data: 'total_goalkeeper_save',
                        title: 'GS',
                        name: 'total_goalkeeper_save',
                        visible: isShowColumn(Site.events.GOALKEEPER_SAVE_X5),
                        defaultContent: 0
                    },
                    {
                        data: 'total_point',
                        title: 'TOT',
                        name: 'total_point',
                        defaultContent: 0
                    },
                ],
            });
        }

        $( datatableMonth.table().header() ).addClass('thead-dark table-dark-header');
    };
    var initDatatableWeek = function() {
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-weekly') ) {
            datatableWeek = $('.js-table-filter-weekly').DataTable({
                    responsive: true,
                    searching: false,
                    paging: false,
                    info: false,
                    ordering: false,
                    autoWidth:false,
                    columns: [
                    {
                        data: 'league_position',
                        title: 'Pos',
                        name: 'league_position',
                        // className: "text-left",
                        defaultContent: 1
                    },
                    {
                        data: 'teamName',
                        title: 'Team',
                        name: 'Team',
                        className: "text-left",
                        render: function(data,display,row) {
                            var url = route('manage.team.lineup', { division: divisionId, team:row.teamId });

                            return '<div><a href="'+url+'" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="'+url+'" class="player-name link-nostyle">'+row.first_name+' '+row.last_name+'</a></div>';
                        }
                    },
                    {
                        data: 'total_goal',
                        title: 'GLS',
                        name: 'total_goal',
                        visible: isShowColumn(Site.events.GOAL),
                        defaultContent: 0
                    },
                    {
                        data: 'total_assist',
                        title: 'ASS',
                        name: 'total_assist',
                        visible: isShowColumn(Site.events.ASSIST),
                        defaultContent: 0
                    },
                    {
                        data: 'total_clean_sheet',
                        title: 'CS',
                        name: 'total_clean_sheet',
                        visible: isShowColumn(Site.events.CLEAN_SHEET),
                        defaultContent: 0
                    },
                    {
                        data: 'total_conceded',
                        title: 'GA',
                        name: 'total_conceded',
                        visible: isShowColumn(Site.events.GOAL_CONCEDED),
                        defaultContent: 0
                    },
                    {
                        data: 'total_appearance',
                        title: 'GP',
                        name: 'total_appearance',
                        visible: isShowColumn(Site.events.APPEARANCE),
                        defaultContent: 0
                    },
                    {
                        data: 'total_club_win',
                        title: 'CW',
                        name: 'total_club_win',
                        visible: isShowColumn(Site.events.CLUB_WIN),
                        defaultContent: 0
                    },
                    {
                        data: 'total_yellow_card',
                        title: 'YC',
                        name: 'total_yellow_card',
                        visible: isShowColumn(Site.events.YELLOW_CARD),
                        defaultContent: 0
                    },
                    {
                        data: 'total_red_card',
                        title: 'RC',
                        name: 'total_red_card',
                        visible: isShowColumn(Site.events.RED_CARD),
                        defaultContent: 0
                    },
                    {
                        data: 'total_own_goal',
                        title: 'OG',
                        name: 'total_own_goal',
                        visible: isShowColumn(Site.events.OWN_GOAL),
                        defaultContent: 0
                    },
                    {
                        data: 'total_penalty_missed',
                        title: 'PM',
                        name: 'total_penalty_missed',
                        visible: isShowColumn(Site.events.PENALTY_MISSED),
                        defaultContent: 0
                    },
                    {
                        data: 'total_penalty_saved',
                        title: 'PS',
                        name: 'total_penalty_saved',
                        visible: isShowColumn(Site.events.PENALTY_SAVE),
                        defaultContent: 0
                    },
                    {
                        data: 'total_goalkeeper_save',
                        title: 'GS',
                        name: 'total_goalkeeper_save',
                        visible: isShowColumn(Site.events.GOALKEEPER_SAVE_X5),
                        defaultContent: 0
                    },
                    {
                        data: 'total_point',
                        title: 'PTS',
                        name: 'total_point',
                        defaultContent: 0
                    },
                ],
            });

            $( datatableWeek.table().header() ).addClass('thead-dark table-dark-header');
        }
    }

    var initLeagueStandingsFilter = function() {

        $("#info-monthly-tab").click(function() {
            if($(this).attr('data-load') == '0') {
                var startDate = $(".is-active").closest($('.js-month-year-filter .js-month')).data('start-date');
                var endDate = $(".is-active").closest($('.js-month-year-filter .js-month')).data('end-date');
                getData(startDate,endDate,datatableMonth);
                $(this).attr('data-load',1);
            }
        });

        $(".js-month-year-filter > .js-month").click(function() {
            $(".js-month-year-filter .js-month a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            var startDate = $(this).data('start-date');
            var endDate = $(this).data('end-date');
            getData(startDate,endDate,datatableMonth);
        });

        $("#info-weekly-tab").click(function() {
            if($(this).attr('data-load') == '0') {
                var startDate = $(".is-active").closest($('.js-week-filter .js-week')).data('start-date');
                var endDate = $(".is-active").closest($('.js-week-filter .js-week')).data('end-date');
                getData(startDate,endDate,datatableWeek);
                $(this).attr('data-load',1);
            }
        });

        $(".js-week-filter > .js-week").click(function() {
            $(".js-week-filter .js-week a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            var startDate =  $(this).data('start-date');
            var endDate = $(this).data('end-date');
            getData(startDate,endDate,datatableWeek);
        });

    }

    var getData = function(startDate,endDate,dataTable) {

        if (typeof startDate !== typeof undefined) {
            setTimeout(function() {
                dataTable.ajax.url($(".js-data-filter-tabs").data('url')+'?linkedLeague='+Site.linkedLeague+'&startDate='+startDate+'&endDate='+endDate+'').load();
            }, 100)
        }

    }


    var initCarousel = function() {

        var startPositionMonth = isNaN(parseInt($('.js-month-link.is-active').data('number'))) ? 0 : parseInt($('.js-month-link.is-active').data('number'));

        $('.js-month-year-filter').owlCarousel({
                loop: false,
                margin: 1,
                nav: true,
                navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
                dots: false,
                mouseDrag: false,
                responsive: {
                    0: {
                        startPosition: startPositionMonth - 1,
                        items: 6
                    },
                    720: {
                        startPosition: startPositionMonth - 1,
                        items: 8
                    },
                    1140: {
                        startPosition: startPositionMonth - 1,
                        items: 9
                    }
                }
            });

            var startPositionWeek = isNaN(parseInt($('.js-week-link.is-active').data('number'))) ? 0 : parseInt($('.js-week-link.is-active').data('number'));

            $('.js-week-filter').owlCarousel({
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
    }

    var isShowColumn = function(event) {
        if(Site.columns[event] > 0) {

            return true;
        }
        return false;
    }

    return {
        init: function() {
            initLeagueStandingsFilter();
            initDatatableSeason();
            initDatatableMonth();
            initDatatableWeek();
            initCarousel();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    LeagueStandingsInfo.init();
});
