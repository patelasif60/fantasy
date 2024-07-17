var datatableSeason = '';
var datatableMonth = '';
var datatableWeek = '';
if(Site.userIsChairman) {
    var managerEmailClass = "text-left";
}  else {
    var managerEmailClass = "d-none text-left";
}
var LeagueStandingsInfo = function() {

    var initDatatableSeason = function() {
        datatableSeason = $('.js-table-filter-season').DataTable({
                ajax: $(".js-data-filter-tabs").data('url')+'?filter=season',
                // responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                scrollX: true,
                scrollCollapse: true,

                columns: [
                {
                    data: 'league_position',
                    title: 'POS',
                    name: 'league_position',
                    width: isMobileScreen() ? '4%' : '6%',
                    defaultContent: 1,
                    render: function(data,display,row) {

                        return '<strong class="text-dark">'+row.league_position+'</strong>';
                    }
                },
                {
                    data: 'teamName',
                    title: 'Team',
                    name: 'Team',
                    className: "text-left",
                    width: isMobileScreen() ? '10%' : '',
                    render: function(data,display,row) {
                        var url = route('manage.team.lineup', { division: divisionId, team:row.teamId });

                        var checkMobileScreen = '';
                        if(isMobileScreen()) {
                           checkMobileScreen = 'd-none';
                           data = textLimit(data);
                        }

                        return '<div class="d-flex align-items-center"><div class="league-crest league-info-crest '+checkMobileScreen+'"><img src="'+row.crest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="'+url+'" class="link-nostyle small">'+row.first_name+' '+row.last_name+'</a></div></div></div>';
                    }
                },
                {
                    data: 'leagueTitle',
                    title: '',
                    name: 'leagueTitle',
                    className: "text-center",
                    defaultContent: '',
                    visible: !isMobileScreen(),
                    render: function(data,display,row) {
                        var checkMobileScreen = isMobileScreen() ? 'd-none' : '';
                        var name = row.first_name+' '+row.last_name;
                        name = name.toLowerCase();
                        name = name.trim();
                        var count = (row.teamId in Site.leagueTitle && Site.leagueTitle[row.teamId] > 0) ? Site.leagueTitle[row.teamId] : 0;
                        count = (name in Site.leagueTitleName && Site.leagueTitleName[name] > 0) ? (count + Site.leagueTitleName[name]) : count;

                        if(count > 0) {
                            return '<div class="'+checkMobileScreen+'"><div class="league-info-crest"><img src="'+Site.imgUrl+"/lt"+count+'.png"/></div></div>';
                        }
                    }
                },
                {
                    data: 'halloffame',
                    title: '',
                    name: 'Halloffame',
                    className: "text-center",
                    defaultContent: '',
                    visible: !isMobileScreen(),
                    render: function(data,display,row) {
                        
                        var checkMobileScreen = isMobileScreen() ? 'd-none' : '';

                        if(row.teamId in Site.hallFameData){
                            return '<img class="'+checkMobileScreen+'" src="'+Site.imgUrl+"/motm"+Site.hallFameData[row.teamId]+'.png"/>';
                        }
                    }
                },
                {
                    data: 'manager_email',
                    title: 'Email',
                    name: 'manager_email',
                    visible: !isMobileScreen(),
                    className: managerEmailClass,
                    render: function(data,display,row) {
                        return '<div class="text-left"><a href="mailto:'+data+'" class="text-dark link-nostyle"><strong>'+'<i class="fas fa-envelope"></i>'+'</strong></a></div>';
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
                    visible: isShowColumn(Site.events.APPEARANCE) && !isMobileScreen(),
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
                    visible: !isMobileScreen(),
                    defaultContent: 0
                },
                {
                    data: 'total_point',
                    title: 'TOT',
                    name: 'total_point',
                    defaultContent: 0,
                    render: function(data,display,row) {

                        return '<strong class="text-dark">'+row.total_point+'</strong>';
                    }
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

                    columns: [
                    {
                        data: 'league_position',
                        title: 'Pos',
                        name: 'league_position',
                        width: isMobileScreen() ? '4%' : '6%',
                        defaultContent: 1,
                        render: function(data,display,row) {

                            return '<strong class="text-dark">'+row.league_position+'</strong>';
                        }
                    },
                    {
                        data: 'teamName',
                        title: 'Team',
                        name: 'Team',
                        className: "text-left",
                        width: isMobileScreen() ? '10%' : '',
                        render: function(data,display,row) {

                            var url = route('manage.team.lineup', { division: divisionId, team:row.teamId });

                            var checkMobileScreen = '';
                            if(isMobileScreen()) {
                               checkMobileScreen = 'd-none';
                               data = textLimit(data);
                            }

                            return '<div class="d-flex align-items-center"><div class="league-crest '+checkMobileScreen+'"><img src="'+row.crest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="'+url+'" class="link-nostyle small">'+row.first_name+' '+row.last_name+'</a></div></div></div>';
                        }
                    },
                    {
                        data: 'manager_email',
                        title: 'Email',
                        name: 'manager_email',
                        visible: !isMobileScreen(),
                        className: managerEmailClass,
                        render: function(data,display,row) {
                            return '<div class="text-left"><a href="mailto:'+data+'" class="text-dark link-nostyle"><strong>'+'<i class="fas fa-envelope"></i>'+'</strong></a></div>';
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
                        defaultContent: 0,
                        render: function(data,display,row) {

                            return '<strong class="text-dark">'+row.total_point+'</strong>';
                        }
                    },
                ],
            });
        }

        $( datatableMonth.table().header() ).addClass('thead-dark table-dark-header');
    };
    var initDatatableWeek = function() {
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-weekly') ) {
            datatableWeek = $('.js-table-filter-weekly').DataTable({
                    //responsive: true,
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
                        width: isMobileScreen() ? '4%' : '6%',
                        defaultContent: 1,
                        render: function(data,display,row) {

                            return '<strong class="text-dark">'+row.league_position+'</strong>';
                        }
                    },
                    {
                        data: 'teamName',
                        title: 'Team',
                        name: 'Team',
                        className: "text-left",
                        width: isMobileScreen() ? '10%' : '',
                        render: function(data,display,row) {
                            var url = route('manage.team.lineup', { division: divisionId, team:row.teamId });

                            var checkMobileScreen = '';
                            if(isMobileScreen()) {
                               checkMobileScreen = 'd-none';
                               data = textLimit(data);
                            }

                            return '<div class="d-flex align-items-center"><div class="league-crest '+checkMobileScreen+'"><img src="'+row.crest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="'+url+'" class="link-nostyle small">'+row.first_name+' '+row.last_name+'</a></div></div></div>';
                        }
                    },
                    {
                        data: 'manager_email',
                        title: 'Email',
                        name: 'manager_email',
                        visible: !isMobileScreen(),
                        className: managerEmailClass,
                        render: function(data,display,row) {
                            return '<div class="text-left"><a href="mailto:'+data+'" class="text-dark link-nostyle"><strong>'+'<i class="fas fa-envelope"></i>'+'</strong></a></div>';
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
                getData(startDate,endDate,datatableMonth,'month');
                $(this).attr('data-load',1);
            }
        });

        $(".js-month-year-filter > .js-month").click(function() {
            $(".js-month-year-filter .js-month a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            var startDate = $(this).data('start-date');
            var endDate = $(this).data('end-date');
            getData(startDate,endDate,datatableMonth,'month');
        });

        $("#info-weekly-tab").click(function() {
            if($(this).attr('data-load') == '0') {
                var startDate = $(".is-active").closest($('.js-week-filter .js-week')).data('start-date');
                var endDate = $(".is-active").closest($('.js-week-filter .js-week')).data('end-date');
                getData(startDate,endDate,datatableWeek,'week');
                $(this).attr('data-load',1);
            }
        });

        $(".js-week-filter > .js-week").click(function() {
            $(".js-week-filter .js-week a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            var startDate =  $(this).data('start-date');
            var endDate = $(this).data('end-date');
            getData(startDate,endDate,datatableWeek,'week');
        });

    }

    var getData = function(startDate,endDate,dataTable,filter) {

        if (typeof startDate !== typeof undefined) {
            setTimeout(function() {
                dataTable.ajax.url($(".js-data-filter-tabs").data('url')+'?startDate='+startDate+'&endDate='+endDate+'&filter='+filter).load();
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

    var isMobileScreen = function() {
        if(window.innerWidth <= 800) {
            return true;
        }

        return false;
    };

    var textLimit = function(text) {
        var result = text;
        if(text.length > 20) {
            var count = 17;
            result = text.slice(0, count) + (text.length > count ? "..." : "");
        }

        return result;
    };

    var textTruncate = function() {

        $(".js-plus-icon").click(function() {
            var closest = $(this).closest(".league-message");
            closest.find('.js-plus-icon').addClass('d-none');
            closest.find('.js-minus-icon').removeClass('d-none');
            closest.find('.js-content-message').removeClass('text-truncate');
        });

        $(".js-minus-icon").click(function() {
            var closest = $(this).closest(".league-message");
            closest.find('.js-plus-icon').removeClass('d-none');
            closest.find('.js-minus-icon').addClass('d-none');
            closest.find('.js-content-message').addClass('text-truncate');
        });
    };

    return {
        init: function() {
            initLeagueStandingsFilter();
            initDatatableSeason();
            initDatatableMonth();
            initDatatableWeek();
            initCarousel();
            textTruncate();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    LeagueStandingsInfo.init();
});
