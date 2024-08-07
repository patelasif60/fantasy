var datatableGroupTwo = '';
var datatableGroupTwo = '';
var EUROPA_LEAGUE = Site.EUROPA_LEAGUE
var division = Site.division;

var LeagueStandingsInfoTwo = function() {

    var initDatatableMatchTwo = function() {
        var groupColumn = 0;
        if (! $.fn.DataTable.isDataTable( 'js-table-match-two') ) {
            var phase = $('.is-active').closest('.js-match-two').data('phase');
            var group = $('.is-active').closest('.js-match-two').data('group');
            datatableMatchTwo = $('.js-table-match-two').DataTable({
                ajax: $(".js-data-filter-tabs-two").data('url')+'?competition='+EUROPA_LEAGUE+'&phase='+phase+'&group='+group+'&team='+Site.europaTeamTwo,
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                language: {
                  emptyTable: "You have been awarded a Bye for this knockout stage."
                },
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
                            if (row.team_id == '')
                            {
                                return 'You have been awarded a Bye for the group stage';

                            }else
                            {
                                return '<div class="js-team-details" data-id="'+row.home+'" data-name="'+row.home_team_name+'"><a href="#" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.home_manager+'</a></div>';
                            }
                        }
                    },
                    {
                        data: 'home_points',
                        title: '',
                        name: 'home_points',
                        defaultContent: '-',
                        width:'10%',
                        render: function(data,display,row) {

                            if(!row.group && row.home_points > row.away_points){
                                return '<strong class="text-dark">'+row.home_points+'</strong>';
                            }
                            return row.home_points;

                        }
                    },
                    {
                        data: 'away_points',
                        title: '',
                        name: 'away_points',
                        defaultContent: '-',
                        width:'10%',
                        render: function(data,display,row) {

                            if(!row.group && row.away_points > row.home_points){
                                return '<strong class="text-dark">'+row.away_points+'</strong>';
                            }
                            return row.away_points;

                        }
                    },
                    {
                        data: 'away_team_name',
                        title: '',
                        name: 'away_team_name',
                        className: "text-left",
                        width:'40%',
                        render: function(data,display,row) {
                            return '<div class="js-team-details" data-id="'+row.away+'" data-name="'+row.away_team_name+'"><a href="#" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.away_manager+'</a></div>';
                        }
                    },
                ],
            });

            $( datatableMatchTwo.table().header() ).addClass('thead-dark table-dark-header');
        }


    };
    var initDatatableGroupTwo = function() {
        if (! $.fn.DataTable.isDataTable( 'js-group-filter-two') ) {
            var group = $('.js-match-filter-two .js-match-two').data('group');

            datatableGroupTwo = $('.js-group-filter-two').DataTable({
                ajax: $("#info-group-tab-two").data('url')+'?competition='+EUROPA_LEAGUE+'&group='+group,
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                language: {
                  emptyTable: "You have been awarded a Bye for the group stage."
                },
                columns: [
                {
                        data: 'team_name',
                        title: '',
                        name: 'team_name',
                        className: "text-left",
                        render: function(data,display,row) {
                            return '<div class="js-team-details" data-id="'+row.team_id+'" data-name="'+row.team_name+'"><a href="#" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.manager_name+'</a></div>';
                        }
                    },
                    {
                        data: 'played',
                        title: 'P',
                        name: 'played',
                        defaultContent: 0,
                    },
                    {
                        data: 'win',
                        title: 'W',
                        name: 'win',
                        defaultContent: 0,
                    },
                    {
                        data: 'draw',
                        title: 'D',
                        name: 'draw',
                        defaultContent: 0,
                    },
                    {
                        data: 'loss',
                        title: 'L',
                        name: 'loss',
                        defaultContent: 0,
                    },
                    {
                        data: 'PF',
                        title: 'F',
                        name: 'PF',
                        defaultContent: 0,
                    },
                    {
                        data: 'PA',
                        title: 'A',
                        name: 'PA',
                        defaultContent: 0,
                    },
                    {
                        data: 'points',
                        title: 'PTS',
                        name: 'points',
                        defaultContent: '-',
                    },

                ],

        });

            $( datatableGroupTwo.table().header() ).addClass('thead-dark table-dark-header');
        }
    }

    var initLeagueStandingsFilterTwo = function() {

         $("#info-match-tab-two").click(function() {
            var phase = $('.js-match-filter-two .is_default').data('phase');
            var group = $('.js-match-filter-two .is_default').data('group');
            $(".js-match-filter-two .js-match-two a").removeClass('is-active');
            $('.js-match-filter-two .is_default').find($('a')).addClass('is-active');
            getDataTwo(phase,group,datatableMatchTwo);
        });

        $(".js-match-filter-two > .js-match-two").click(function() {
            $(".js-match-filter-two .js-match-two a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            var phase = $(this).data('phase');
            var group = $(this).data('group');
            getDataTwo(phase,group,datatableMatchTwo);
        });
    }

    var getDataTwo = function(phase,group,dataTable) {
        dataTable.ajax.url($(".js-data-filter-tabs-two").data('url')+'?competition='+EUROPA_LEAGUE+'&phase='+phase+'&group='+group+'&team='+Site.europaTeamTwo+'').load();
    }


    var initCarouselTwo = function() {
        $('.js-owl-carousel-date-info-two').owlCarousel({
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


    var teamDetailPopup = function() {
        $(document).on("click",".js-team-details",function() {
            var id = $(this).data('id');

            if (typeof id === 'undefined') {
                return false;
            }
            $('#js_team_details_modal').find($('.modal-body')).html('<div><p class="text-center mt-5"><i class="fas fa-spinner fa-spin fa-4x"></i></p><p class="text-center">Fetching Team Details...</p></div>');
            $('.js-team-name').html($(this).data('name'));
            $('#js_team_details_modal').modal('show');
            $.ajax({
                url: $('#js_team_details_modal').data('url')+'?team_id='+id,
                type: 'GET',
                dataType: 'html',
            })
            .done(function(response) {
                $('#js_team_details_modal').find($('.modal-body')).html(response);
            })
            .fail(function(error) {
            })
        });
    };

    return {
        init: function() {
            initLeagueStandingsFilterTwo();
            initDatatableMatchTwo();
            initDatatableGroupTwo();
            initCarouselTwo();
            teamDetailPopup();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    LeagueStandingsInfoTwo.init();
});
