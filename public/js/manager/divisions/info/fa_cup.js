var datatableStandings = '';
var datatableRounds = '';
var FaCupInfo = function() {

    var initDatatableStandings = function() {
        datatableStandings = $('.js-table-filter-standings').DataTable({
                ajax: $(".js-data-filter-tabs").data('url'),
                // responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                scrollX: true,
                scrollCollapse: true,
                // fixedColumns:   {
                //     leftColumns: 2,
                //     rightColumns: 1
                // },
                // 'order':[[15,'desc'], [2,'desc'], [3,'desc']],
                columns: [
                {
                    data: 'league_position',
                    title: 'POS',
                    name: 'league_position',
                    defaultContent: 1
                },
                {
                    data: 'teamName',
                    title: 'Team',
                    name: 'Team',
                    className: "text-left",
                    // render: function(data,display,row) {
                    //     var url = route('manage.team.lineup', { division: divisionId, team:row.teamId });

                    //     return '<div><a href="'+url+'" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="'+url+'" class="player-name link-nostyle">'+row.first_name+' '+row.last_name+'</a></div>';
                    // }
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
                    data: 'club_win',
                    title: 'CW',
                    name: 'club_win',
                    visible: isShowColumn(Site.events.CLUB_WIN),
                    defaultContent: 0
                },
                {
                    data: 'yellow_card',
                    title: 'YC',
                    name: 'yellow_card',
                    visible: isShowColumn(Site.events.YELLOW_CARD),
                    defaultContent: 0
                },
                {
                    data: 'red_card',
                    title: 'RC',
                    name: 'red_card',
                    visible: isShowColumn(Site.events.RED_CARD),
                    defaultContent: 0
                },
                {
                    data: 'own_goal',
                    title: 'OG',
                    name: 'own_goal',
                    visible: isShowColumn(Site.events.OWN_GOAL),
                    defaultContent: 0
                },
                {
                    data: 'penalty_missed',
                    title: 'PM',
                    name: 'penalty_missed',
                    visible: isShowColumn(Site.events.PENALTY_MISSED),
                    defaultContent: 0
                },
                {
                    data: 'penalty_saved',
                    title: 'PS',
                    name: 'penalty_saved',
                    visible: isShowColumn(Site.events.PENALTY_SAVE),
                    defaultContent: 0
                },
                {
                    data: 'goalkeeper_save',
                    title: 'GS',
                    name: 'goalkeeper_save',
                    visible: isShowColumn(Site.events.GOALKEEPER_SAVE_X5),
                    defaultContent: 0
                },
                {
                    data: 'round_total',
                    title: 'RND',
                    name: 'round_total',
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

        $( datatableStandings.table().header() ).addClass('thead-dark table-dark-header');
    };
    var initDatatableRounds = function() {
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-rounds') ) {
            datatableRounds = $('.js-table-filter-rounds').DataTable({
                    responsive: true,
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
                        title: 'POS',
                        name: 'league_position',
                        defaultContent: 1
                    },
                    {
                        data: 'teamName',
                        title: 'Team',
                        name: 'Team',
                        className: "text-left",
                        // render: function(data,display,row) {
                        //     var url = route('manage.team.lineup', { division: divisionId, team:row.teamId });

                        //     return '<div><a href="'+url+'" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="'+url+'" class="player-name link-nostyle">'+row.first_name+' '+row.last_name+'</a></div>';
                        // }
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
                        data: 'club_win',
                        title: 'CW',
                        name: 'club_win',
                        visible: isShowColumn(Site.events.CLUB_WIN),
                        defaultContent: 0
                    },
                    {
                        data: 'yellow_card',
                        title: 'YC',
                        name: 'yellow_card',
                        visible: isShowColumn(Site.events.YELLOW_CARD),
                        defaultContent: 0
                    },
                    {
                        data: 'red_card',
                        title: 'RC',
                        name: 'red_card',
                        visible: isShowColumn(Site.events.RED_CARD),
                        defaultContent: 0
                    },
                    {
                        data: 'own_goal',
                        title: 'OG',
                        name: 'own_goal',
                        visible: isShowColumn(Site.events.OWN_GOAL),
                        defaultContent: 0
                    },
                    {
                        data: 'penalty_missed',
                        title: 'PM',
                        name: 'penalty_missed',
                        visible: isShowColumn(Site.events.PENALTY_MISSED),
                        defaultContent: 0
                    },
                    {
                        data: 'penalty_saved',
                        title: 'PS',
                        name: 'penalty_saved',
                        visible: isShowColumn(Site.events.PENALTY_SAVE),
                        defaultContent: 0
                    },
                    {
                        data: 'goalkeeper_save',
                        title: 'GS',
                        name: 'goalkeeper_save',
                        visible: isShowColumn(Site.events.GOALKEEPER_SAVE_X5),
                        defaultContent: 0
                    },
                    // {
                    //     data: 'round_total',
                    //     title: 'RND',
                    //     name: 'round_total',
                    //     defaultContent: 0
                    // },
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

        $( datatableRounds.table().header() ).addClass('thead-dark table-dark-header');
    };

    var initLeagueStandingsFilter = function() {

        $("#info-rounds-tab").click(function() {
            if($(this).attr('data-load') == '0') {
                var round = $(".is-active").closest($('.js-round-filter .js-round')).data('round');
                var played = $(".is-active").closest($('.js-round-filter .js-round')).data('round-played');
                getData(round, played);
                $(this).attr('data-load',1);
            }
        });

        $(".js-round-filter > .js-round").click(function() {
            $(".js-round-filter .js-round a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            var round = $(this).data('round');
            var played = $(this).data('round-played');
            getData(round, played);
        });

    }

    var textLimit = function(text) {

        if(window.innerWidth <= 800) {
            var count = 12;
            var result = text.slice(0, count) + (text.length > count ? "..." : "");

            return result;
        } else {
            return text;
        }
    };

    var getData = function(round, played) {
        if (typeof round !== typeof undefined) {
            setTimeout(function() {
                datatableRounds.ajax.url($(".js-data-filter-tabs").data('url')+'?round='+round+'&played='+played+'').load();
            }, 100)
        }
    }

    var isMobileScreen = function() {
        if(window.innerWidth <= 800) {
            return true;
        }

        return false;
    };

    var isShowColumn = function(event) {
        if(Site.columns[event] > 0) {

            return true;
        }
        return false;
    }


    var initCarousel = function() {
        $('.js-owl-carousel-round').owlCarousel({
                loop: false,
                margin: 1,
                nav: true,
                navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
                dots: false,
                mouseDrag: false,
                responsive: {
                    0: {
                        items: 6
                    },
                    720: {
                        items: 10
                    },
                    1140: {
                        items: 9
                    }
                }
            });
    }

    return {
        init: function() {
            initLeagueStandingsFilter();
            initDatatableStandings();
            initDatatableRounds();
            initCarousel();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    FaCupInfo.init();
});
