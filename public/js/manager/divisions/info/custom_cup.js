var datatableMatches = '';
var lastRound = false;

var ProCupInfo = function() {
    var initDatatableMatches = function() {
        var groupColumn = 0;
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-pro-cup') ) {
            var phase = $(".is-active").closest($('.js-phases-filter .js-phases')).data('phase');
            if (typeof phase == typeof undefined) {
                $('.js-phases-filter .js-phases:last a').addClass('is-active');
                phase = $(".is-active").closest($('.js-phases-filter .js-phases')).data('phase');
            }
            datatableMatches = $('.js-table-filter-pro-cup').DataTable({
                    ajax: $(".js-data-filter-tabs").data('url')+'?round='+phase,
                    responsive: true,
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
                                    '<tr class="group"><td colspan="4" class="text-dark"><strong class="h6">Matches will take place '+group+'</strong></td></tr>'
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
                        data: 'home_team_name',
                        title: '',
                        name: 'home_team_name',
                        className: "text-left",
                        width:'40%',
                        render: function(data,display,row) {

                            var url = row.home_team_id != '' ? route('manage.team.lineup', { division: divisionId, team:row.home_team_id }) : 'javascript:void(0);';
                            var checkMobileScreen = isMobileScreen() ? 'd-none' : '';

                            return '<div class="d-flex align-items-center"><div class="league-crest league-info-crest '+checkMobileScreen+'"><img src="'+row.home_crest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="'+url+'" class="link-nostyle small">'+row.home_manager+'</a></div></div></div>';
                        }
                    },
                    {
                        data: 'home_points',
                        title: '',
                        name: 'home_points',
                        width:'10%',
                        defaultContent: '-',
                        render: function(data,display,row) {
                            if(Number.isInteger(row.home_points) && Number.isInteger(row.away_points)) {
                                if(row.winner === row.home_team_id) {

                                    return '<strong>'+data+'</strong>';
                                }
                            }

                            return data;
                        }
                    },
                    {
                        data: 'away_points',
                        title: '',
                        name: 'away_points',
                        width:'10%',
                        defaultContent: '-',
                        render: function(data,display,row) {
                            if(Number.isInteger(row.home_points) && Number.isInteger(row.away_points)) {
                                if(row.winner === row.away_team_id) {

                                    return '<strong>'+data+'</strong>';
                                }
                            }

                            return data;
                        }
                    },
                    {
                        data: 'away_team_name',
                        title: '',
                        name: 'away_team_name',
                        className: "text-left",
                        width:'40%',
                        defaultContent: "",
                        render: function(data,display,row) {

                            displayFinalResult(row);

                            var isAway = false;
                            if(row.home_team_id == '' && row.away_team_id == '') {
                                isAway = true;
                            } else {
                                if (row.away_team_id == '') {
                                    return 'Bye';
                                } else {
                                    isAway = true;
                                }
                            }

                            if(isAway) {

                                var url = row.away_team_id != '' ? route('manage.team.lineup', { division: divisionId, team:row.away_team_id }) : 'javascript:void(0);';
                                var checkMobileScreen = isMobileScreen() ? 'd-none' : '';

                                return '<div class="d-flex align-items-center"><div class="league-crest league-info-crest '+checkMobileScreen+'"><img src="'+row.away_crest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="'+url+'" class="link-nostyle small">'+row.away_manager+'</a></div></div></div>';
                            }
                        }
                    },
                ],
            });
        }
    };

    $(".js-phases-filter > .js-phases").click(function() {
        $(".js-phases-filter .js-phases a").removeClass('is-active');
        $(this).find($('a')).addClass('is-active');
        var phase = $(this).data('phase');
        lastRound = $(this).data('round') === 'final' ? true : false;
        getData(phase);
    });

    var getData = function(phase) {
        if (typeof phase !== typeof undefined) {
            datatableMatches.ajax.url($(".js-data-filter-tabs").data('url')+'?round='+phase).load();
        }
    }

    var initCarousel = function() {

        var startPositionRound = isNaN(parseInt($('.js-round-link.is-active').data('number'))) ? 0 : parseInt($('.js-round-link.is-active').data('number'));

        $('.js-owl-carousel-phases-info ').owlCarousel({
                loop: false,
                margin: 1,
                nav: true,
                navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
                dots: false,
                mouseDrag: false,
                responsive: {
                    0: {
                        startPosition: startPositionRound - 1,
                        items: 6
                    },
                    720: {
                        startPosition: startPositionRound - 1,
                        items: 8
                    },
                    1140: {
                        startPosition: startPositionRound - 1,
                        items: 9
                    }
                }
            });
    };

    var isMobileScreen = function() {
        if(window.innerWidth <= 800) {
            return true;
        }

        return false;
    }

    var displayFinalResult = function(row) {
        if(lastRound) {
            if(Number.isInteger(row.home_points) && Number.isInteger(row.away_points) && Number.isInteger(row.winner)) {
                if(row.winner === row.home_team_id) {
                    $('.js-winners strong').html(row.home_team_name);
                    $('.js-runners-up strong').html(row.away_team_name);
                } else {
                    $('.js-winners strong').html(row.away_team_name);
                    $('.js-runners-up strong').html(row.home_team_name);
                }
                $('.js-result').removeClass('d-none');
            }
        } else {
            $('.js-result').addClass('d-none');
        }
    }

    return {
        init: function() {
            initDatatableMatches();
            initCarousel();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ProCupInfo.init();
});
