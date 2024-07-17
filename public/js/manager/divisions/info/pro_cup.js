var datatableMatches = '';

var ProCupInfo = function() {
    var initDatatableMatches = function() {
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-pro-cup') ) {
            var phase = $(".is-active").closest($('.js-phases-filter .js-phases')).data('phase');
            datatableMatches = $('.js-table-filter-pro-cup').DataTable({
                    ajax: $(".js-data-filter-tabs").data('url')+'?phase='+phase,
                    responsive: true,
                    searching: false,
                    paging: false,
                    info: false,
                    ordering: false,
                    autoWidth:false,
                    columns: [
                    {
                        data: 'home_team_name',
                        title: '',
                        name: 'home_team_name',
                        className: "text-left",
                        width:'40%',
                        render: function(data,display,row) {
                            return '<div><a href="javascript:void(0);" class="team-name link-nostyle">'+row.home_team_name+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.home_manager+'</a></div>';
                        }
                    },
                    {
                        data: 'home_points',
                        title: '',
                        name: 'home_points',
                        width:'10%',
                        defaultContent: '-'
                    },
                    {
                        data: 'away_points',
                        title: '',
                        name: 'away_points',
                        width:'10%',
                        defaultContent: '-'
                    },
                    {
                        data: 'away_team_name',
                        title: '',
                        name: 'away_team_name',
                        className: "text-left",
                        width:'40%',
                        defaultContent: "",
                        render: function(data,display,row) {

                            if (row.home_points == null && row.away_points == null && row.home_team_id != '' && row.away_team_id != '' )
                            {
                                $('.js-match-info').html("Matches will take place in the week of "+row.gameweek)
                            }else
                            {
                                $('.js-match-info').html("");
                            }

                            if (row.away_team_id == '')
                            {
                                return 'Bye';
                            }else
                            {
                                return '<div><a href="javascript:void(0);" class="team-name link-nostyle">'+row.away_team_name+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.away_manager+'</a></div>';
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
        getData(phase);
    });

    var getData = function(phase) {
        if (typeof phase !== typeof undefined) {
            datatableMatches.ajax.url($(".js-data-filter-tabs").data('url')+'?phase='+phase).load();
        }
    }

    var initCarousel = function() {
        $('.js-owl-carousel-phases-info ').owlCarousel({
                loop: false,
                margin: 1,
                nav: true,
                navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
                dots: false,
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
            initDatatableMatches();
            initCarousel();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ProCupInfo.init();
});
