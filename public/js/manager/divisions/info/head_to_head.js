var datatableStandings = '';
var datatableMatches = '';
var HeadToHeadInfo = function() {

    var initDatatableStandings = function() {

        datatableStandings = $('.js-table-filter-standings').DataTable({
                ajax: $(".js-data-filter-tabs").data('url'),
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
                    defaultContent: 1,
                    width:'10%'
                },
                {
                    data: 'teamName',
                    title: 'Team',
                    name: 'teamName',
                    className: "text-left",
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
                    data: 'plays',
                    title: 'P',
                    name: 'plays',
                    defaultContent: 0
                },
                {
                    data: 'wins',
                    title: 'W',
                    name: 'wins',
                    defaultContent: 0
                },
                {
                    data: 'draws',
                    title: 'D',
                    name: 'draws',
                    defaultContent: 0
                },
                {
                    data: 'loses',
                    title: 'L',
                    name: 'loses',
                    defaultContent: 0
                },
                {
                    data: 'points_for',
                    title: 'F',
                    name: 'points_for',
                    defaultContent: 0
                },
                {
                    data: 'points_against',
                    title: 'A',
                    name: 'points_against',
                    defaultContent: 0
                },
                {
                    data: 'points_diff',
                    title: 'Diff',
                    name: 'points_diff',
                    defaultContent: 1,
                    width:'10%',
                    visible:false
                },
                {
                    data: 'team_points',
                    title: 'PTS',
                    name: 'team_points',
                    defaultContent: 0
                },
            ],
        });

        $( datatableStandings.table().header() ).addClass('thead-dark table-dark-header');
    };

    var initDatatableMatches = function() {
        var groupColumn = 0;
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-matches') ) {
            datatableMatches = $('.js-table-filter-matches').DataTable({
                    //responsive: true,
                    searching: false,
                    paging: false,
                    info: false,
                    ordering: false,
                    autoWidth:false,
                    "columnDefs": [
                        { "visible": false, "targets": groupColumn }
                    ],
                    drawCallback: function ( settings ) {
                        var api = this.api();
                        var rows = api.rows( {page:'current'} ).nodes();
                        var last = null;
             
                        api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                    '<tr class="group"><td colspan="5" class="text-dark"><strong class="h6">Gameweek - '+group+'</strong></td></tr>'
                                );
             
                                last = group;
                            }
                        } );
                    },
                    columns: [
                    {
                        data: 'gameweek',
                        title: 'gameweek',
                        name: 'gameweek',
                        defaultContent: '-',
                        visible:false
                    },
                    {
                        data: 'homeTeam',
                        title: '',
                        name: 'homeTeam',
                        className: "text-left",
                        width:'20%',
                        render: function(data,display,row) {

                            var url = route('manage.team.lineup', { division: divisionId, team:row.homeTeamId });

                            var checkMobileScreen = '';
                            if(isMobileScreen()) {
                               checkMobileScreen = 'd-none';
                               data = textLimit(data);
                            }

                            return '<div class="d-flex align-items-center"><div class="league-crest league-info-crest '+checkMobileScreen+'"><img src="'+row.homeCrest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="'+url+'" class="link-nostyle small">'+row.homeFirstName+' '+row.homeLastName+'</a></div></div></div>';

                        }
                    },
                    {
                        data: 'homePoints',
                        title: '',
                        name: 'homePoints',
                        width:'5%',
                        defaultContent: '-',
                    },
                    {
                        data: 'awayPoints',
                        title: '',
                        name: 'awayPoints',
                        width:'5%',
                        defaultContent: '-',
                    },
                    {
                        data: 'awayTeam',
                        title: '',
                        name: 'awayTeam',
                        className: "text-left",
                        width:'30%',
                        render: function(data,display,row) {

                            var url = route('manage.team.lineup', { division: divisionId, team:row.awayTeamId });

                            var checkMobileScreen = '';
                            if(isMobileScreen()) {
                               checkMobileScreen = 'd-none';
                               data = textLimit(data);
                            }

                            return '<div class="d-flex align-items-center"><div class="league-crest league-info-crest '+checkMobileScreen+'"><img src="'+row.awayCrest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="'+url+'" class="link-nostyle small">'+row.awayFirstName+' '+row.awayLastName+'</a></div></div></div>';
                        }
                    },
                ],
            });
        }
    };

    var initLeagueStandingsFilter = function() {

        $("#info-matches-tab").click(function() {
            if($(this).attr('data-load') == '0') {
                var id = $(".is-active").closest($('.js-matches-filter .js-matches')).data('id');
                getData(id,datatableMatches);
                $(this).attr('data-load',1);
            }
        });

        $(".js-matches-filter > .js-matches").click(function() {
            $(".js-matches-filter .js-matches a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            var id =  $(this).data('id');
            getData(id, datatableMatches);
        });

    }

    var getData = function(id, dataTable) {
        if (typeof id !== typeof undefined) {
            dataTable.ajax.url($(".js-data-filter-tabs").data('url')+'?filter=matches&id='+id+'').load();
        }
    }


    var initCarousel = function() {

        var startPosition = isNaN(parseInt($('.js-gameweek-link.is-active').data('number'))) ? 0 : parseInt($('.js-gameweek-link.is-active').data('number'));

        $('.js-owl-carousel-date-info').owlCarousel({
                loop: false,
                margin: 1,
                nav: true,
                navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
                dots: false,
                mouseDrag: false,
                responsive: {
                    0: {
                        startPosition: startPosition - 1,
                        items: 6
                    },
                    720: {
                        startPosition: startPosition - 1,
                        items: 8
                    },
                    1140: {
                        startPosition: startPosition - 1,
                        items: 9
                    }
                }
            });
    }

    var isMobileScreen = function() {
        if(window.innerWidth <= 800) {
            return true;
        }

        return false;
    }

    var textLimit = function(text) {

        var count = 12;
        var result = text.slice(0, count) + (text.length > count ? "..." : "");

        return result;
    };

    return {
        init: function() {
            initLeagueStandingsFilter();
            initDatatableStandings();
            initDatatableMatches();
            initCarousel();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    HeadToHeadInfo.init();
});
