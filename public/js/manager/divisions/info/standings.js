var datatableSeason = '';
var datatableMonth = '';
var datatableWeek = '';
var activeTab = 'season';
var startDt = '';
var endDt = '';
var LeagueStandings = function() {

    var initDatatableSeason = function() {
        if ( ! $.fn.DataTable.isDataTable( '.js-table-filter-season' ) ) {
            datatableSeason = $('.js-table-filter-season').DataTable({
                    ajax: {
                        url: $(".js-table-filter-season").data('url'),
                        method: 'post',
                        data: function (d) {
                            $.each(readFilters(), function (key, value) {
                                if (value !== null) {
                                    d[key] = value;
                                }
                            });
                        }
                    },
                    searching: false,
                    paging: true,
                    pageLength: 100,
                    info: false,
                    ordering: false,
                    autoWidth:false,
                    scrollX: true,
                    scrollCollapse: true,
                    serverSide: true,
                    processing: false,
                    lengthMenu: [[100, 500], [100, 500]],
                    language:{
                        "lengthMenu": "Show _MENU_ teams",
                    },
                    columns: [
                    {
                        data: 'position',
                        title: 'POS',
                        name: 'position',
                        width:'6%',
                        class:'6%',
                        defaultContent: 1,
                        render: function(data,display,row) {

                            return '<strong class="text-dark">'+row.position+'</strong>';
                        }
                    },
                    {
                        data: 'name',
                        title: 'Team',
                        name: 'name',
                        className: "text-left",
                        render: function(data,display,row) {

                            return '<div class="d-flex align-items-center js-team-details" data-id="'+row.id+'" data-name="'+row.name+'"><a href="javascript:void(0);" class="text-dark link-nostyle"><strong>'+row.name+'</strong></a></div><div><a href="javascript:void(0);" class="link-nostyle small">'+row.first_name+' '+row.last_name+'</a></div></div></div>';
                        }
                    },
                    {
                        data: 'total',
                        title: 'TOT',
                        name: 'total',
                        defaultContent: 0
                    },
                    {
                        data: 'league_size',
                        title: 'League Size',
                        name: 'league_size',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'squad_size',
                        title: 'Squad Size',
                        name: 'squad_size',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'transfers',
                        title: 'XFERS',
                        name: 'transfers',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'weekend_changes',
                        title: 'W/E CHANGES',
                        name: 'weekend_changes',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'ranking_points',
                        title: 'RANK PTS',
                        name: 'ranking_points',
                        defaultContent: 0
                    },
                ]
            });

            $( datatableSeason.table().header() ).addClass('thead-dark table-dark-header');
        }
    };

    var initDatatableMonth = function() {
        if ( ! $.fn.DataTable.isDataTable( '.js-table-filter-monthly' ) ) {

            datatableMonth = $('.js-table-filter-monthly').DataTable({
                    ajax: {
                        url: $(".js-table-filter-monthly").data('url'),
                        method: 'post',
                        data: function (d) {
                            $.each(readFilters(), function (key, value) {
                                if (value !== null) {
                                    d[key] = value;
                                }
                            });
                        }
                    },
                    searching: false,
                    paging: true,
                    pageLength: 100,
                    info: false,
                    ordering: false,
                    autoWidth:false,
                    scrollX: true,
                    scrollCollapse: true,
                    serverSide: true,
                    processing: false,
                    lengthMenu: [[100, 100], [100, 100]],
                    language:{
                        "lengthMenu": "Show _MENU_ teams",
                    },
                    columns: [
                    {
                        data: 'position',
                        title: 'POS',
                        name: 'position',
                        width:'6%',
                        class:'6%',
                        defaultContent: 1,
                        render: function(data,display,row) {

                            return '<strong class="text-dark">'+row.position+'</strong>';
                        }
                    },
                    {
                        data: 'name',
                        title: 'Team',
                        name: 'name',
                        className: "text-left",
                        render: function(data,display,row) {

                            return '<div class="d-flex align-items-center js-team-details" data-id="'+row.id+'" data-name="'+row.name+'"><a href="javascript:void(0);" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="javascript:void(0);" class="link-nostyle small">'+row.first_name+' '+row.last_name+'</a></div></div></div>';
                        }
                    },
                    {
                        data: 'total',
                        title: 'TOT',
                        name: 'total',
                        defaultContent: 0
                    },
                    {
                        data: 'league_size',
                        title: 'League Size',
                        name: 'league_size',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'squad_size',
                        title: 'Squad Size',
                        name: 'squad_size',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'transfers',
                        title: 'XFERS',
                        name: 'transfers',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'weekend_changes',
                        title: 'W/E CHANGES',
                        name: 'weekend_changes',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'ranking_points',
                        title: 'RANK PTS',
                        name: 'ranking_points',
                        defaultContent: 0
                    },
                ]
            });

            $( datatableMonth.table().header() ).addClass('thead-dark table-dark-header');
        }
    };

    var initDatatableWeek = function() {

        if ( ! $.fn.DataTable.isDataTable( '.js-table-filter-weekly' ) ) {
                datatableWeek = $('.js-table-filter-weekly').DataTable({
                    ajax: {
                        url: $(".js-table-filter-weekly").data('url'),
                        method: 'post',
                        data: function (d) {
                            $.each(readFilters(), function (key, value) {
                                if (value !== null) {
                                    d[key] = value;
                                }
                            });
                        }
                    },
                    searching: false,
                    paging: true,
                    pageLength: 100,
                    info: false,
                    ordering: false,
                    autoWidth:false,
                    scrollX: true,
                    scrollCollapse: true,
                    serverSide: true,
                    processing: false,
                    lengthMenu: [[100, 100], [100, 100]],
                    language:{
                        "lengthMenu": "Show _MENU_ teams",
                    },
                    columns: [
                    {
                        data: 'position',
                        title: 'POS',
                        name: 'position',
                        width:'6%',
                        class:'6%',
                        defaultContent: 1,
                        render: function(data,display,row) {

                            return '<strong class="text-dark">'+row.position+'</strong>';
                        }
                    },
                    {
                        data: 'name',
                        title: 'Team',
                        name: 'name',
                        className: "text-left",
                        render: function(data,display,row) {

                            return '<div class="d-flex align-items-center js-team-details" data-id="'+row.id+'" data-name="'+row.name+'"><a href="javascript:void(0);" class="text-dark link-nostyle"><strong>'+data+'</strong></a></div><div><a href="javascript:void(0);" class="link-nostyle small">'+row.first_name+' '+row.last_name+'</a></div></div></div>';
                        }
                    },
                    {
                        data: 'total',
                        title: 'TOT',
                        name: 'total',
                        defaultContent: 0
                    },
                    {
                        data: 'league_size',
                        title: 'League Size',
                        name: 'league_size',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'squad_size',
                        title: 'Squad Size',
                        name: 'squad_size',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'transfers',
                        title: 'XFERS',
                        name: 'transfers',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'weekend_changes',
                        title: 'W/E CHANGES',
                        name: 'weekend_changes',
                        defaultContent: 0,
                        visible: !isMobileScreen()
                    },
                    {
                        data: 'ranking_points',
                        title: 'RANK PTS',
                        name: 'ranking_points',
                        defaultContent: 0
                    },
                ]
            });

            $( datatableWeek.table().header() ).addClass('thead-dark table-dark-header');
        }
    };

    var getData = function(startDate,endDate,dataTable) {

        if (typeof startDate !== typeof undefined) {
            setTimeout(function() {
                dataTable.ajax.url($(".js-data-filter-tabs").data('url')+'?startDate='+startDate+'&endDate='+endDate+'').load();
            }, 100)
        }

    }

    var initLeagueStandingsFilter = function() {

        $("#info-season-tab").click(function() {
            activeTab = 'season';
            startDt = '';
            endDt = '';
            initFilter();
        });

        $("#info-monthly-tab").click(function() {
            activeTab = 'month';
            startDt = $(".is-active").closest($('.js-month-year-filter .js-month')).data('start-date');
            endDt = $(".is-active").closest($('.js-month-year-filter .js-month')).data('end-date');
            initFilter();
        });

        $(".js-month-year-filter > .js-month").click(function() {
            $(".js-month-year-filter .js-month a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            startDt = $(this).data('start-date');
            endDt = $(this).data('end-date');
            initFilter();
        });

        $("#info-weekly-tab").click(function() {
            activeTab = 'week';
            startDt = $(".is-active").closest($('.js-week-filter .js-week')).data('start-date');
            endDt = $(".is-active").closest($('.js-week-filter .js-week')).data('end-date');
            initFilter();
        });

        $(".js-week-filter > .js-week").click(function() {
            $(".js-week-filter .js-week a").removeClass('is-active');
            $(this).find($('a')).addClass('is-active');
            startDt =  $(this).data('start-date');
            endDt = $(this).data('end-date');
            initFilter();
        });
    }

    var readFilters = function() {
        return {
            package: $('#package').val() || null,
            activeTab: activeTab || null,
            startDt: startDt || null,
            endDt: endDt || null,
        };
    };

    var initPackageFilters = function () {
        $(document).on('change','#package',function(e){
            e.preventDefault();
            initFilter();
        });
    };

    var initFilter = function() {
        if(activeTab == 'month') {
            datatableMonth.ajax.reload();
        } else if(activeTab == 'week') {
            datatableWeek.ajax.reload();
        } else {
            datatableSeason.ajax.reload();
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

    var select2 = function() {
        $('.js-select2').select2();
    };

    var isMobileScreen = function() {

        var status = window.innerWidth <= 800 ? true : false;

        return status;
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
            initLeagueStandingsFilter();
            initDatatableSeason();
            initDatatableMonth();
            initDatatableWeek();
            initCarousel();
            initPackageFilters();
            select2();
            teamDetailPopup();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    LeagueStandings.init();
});
