var ManagerProfileUpdate = function() {

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
            // responsive: true,
            ordering: false,
            searching: false,
            serverSide: true,
            processing: true,
            pageLength: 25,
            autoWidth: false,
            scrollY: 400,
            scrollX: true,
            scroller: {
                loadingIndicator: true
            },
            stateSave: true,
            columns: [
                {
                    data: 'position',
                    title: 'Player',
                    name: 'position',
                },
                {
                    data: 'team_manager_name',
                    title: 'Team',
                    name: 'team_manager_name',
                },
                {
                    data: 'transfer_value',
                    title: "&pound;M",
                    name: 'transfer_value',
                    defaultContent: '0',
                },
                {
                    data: 'appearance',
                    title: "PLD",
                    name: 'appearance',
                    defaultContent: '0',
                },
                {
                    data: 'goal',
                    title: "GLS",
                    name: 'goal',
                    defaultContent: '0',
                },
                {
                    data: 'assist',
                    title: "ASS",
                    name: 'assist',
                    defaultContent: '0',
                },
                {
                    data: 'clean_sheet',
                    title: "CS",
                    name: 'clean_sheet',
                    defaultContent: '0',
                },
                {
                    data: 'conceded',
                    title: "GA",
                    name: 'conceded',
                    defaultContent: '0',
                },
                {
                    data: 'week_points',
                    title: "WK",
                    name: 'week_points',
                    defaultContent: '0',
                },
                {
                    data: 'total',
                    title: "TOT",
                    name: 'total',
                    defaultContent: '0',
                },
                {
                    data: 'next_fixture',
                    title: 'Next fixture',
                    name: 'next_fixture',
                    className: "text-center",
                    render: function(data,display,row) {
                        if(data == null) {
                            return "-";
                        } else {
                            return '<a href="javascript:void(0);" class="team-name link-nostyle">'+data.short_code+' ('+data.type+')</a> <br> <a href="javascript:void(0);" class="player-name link-nostyle small">'+data.str_date+' '+ data.time+'</a>';
                        }
                    }
                }
            ],
        });
        $( divisionPlayersDatatable.table().header() ).addClass('thead-dark table-dark-header');
    };

    var initDivisionTeamPlayersDataTable = function () {
        TeamsDatatable = $('table.leaguereport-teams-list-table').DataTable({
            ajax: {
                url: $('table.leaguereport-teams-list-table').data('url'),
                method: 'post',
                data: function (d) {
                    $.each(readTeamPlayersFilters(), function (key, value) {
                        if (value !== null) {
                            d[key] = value;
                        }
                    });
                }
            },
            dom: '<"top"><"row"<"col-xl-12 d-flex justify-content-end mb-25"rfB>><"table-responsive"t><"row"<"col-sm-3"i><"col-sm-6 text-center"l><"col-sm-3"p>>',
            language: {
                "loadingRecords": "&nbsp;",
                "processing" : "Loading..."
            },
            // responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
            searching: false,
            paging:   false,
            ordering: false,
            info:     false,
            // scrollX: true,
            // scrollCollapse: true,
            // fixedColumns:   {
            //     leftColumns: 3,
            //     rightColumns: 4
            // },
            columns: [
                {
                    data: 'position',
                    title: 'Player',
                    name: 'position',
                },
                {
                    data: 'transfer_value',
                    title: "&pound;M",
                    name: 'transfer_value',
                    defaultContent: '0',
                },
                {
                    data: 'appearance',
                    title: "PLD",
                    name: 'appearance',
                    defaultContent: '0',
                },
                {
                    data: 'goal',
                    title: "GLS",
                    name: 'goal',
                    defaultContent: '0',
                },
                {
                    data: 'assist',
                    title: "ASS",
                    name: 'assist',
                    defaultContent: '0',
                },
                {
                    data: 'clean_sheet',
                    title: "CS",
                    name: 'clean_sheet',
                    defaultContent: '0',
                },
                {
                    data: 'conceded',
                    title: "GA",
                    name: 'conceded',
                    defaultContent: '0',
                },
                {
                    data: 'week_points',
                    title: "WK",
                    name: 'week_points',
                    defaultContent: '0',
                },
                {
                    data: 'total',
                    title: "TOT",
                    name: 'total',
                    defaultContent: '0',
                },
                {
                    data: 'next_fixture',
                    title: 'Next fixture',
                    name: 'next_fixture',
                    className: "text-center",
                    render: function(data,display,row) {
                        if(data == null) {
                            return "-";
                        } else {
                            return '<a href="javascript:void(0);" class="team-name link-nostyle">'+data.short_code+' ('+data.type+')</a> <br> <a href="javascript:void(0);" class="player-name link-nostyle small">'+data.str_date+' '+ data.time+'</a>';
                        }
                    }
                },
                {
                    data: 'next_fixture',
                    title: 'Team',
                    name: 'team',
                    className: "text-center",
                    render: function(data,display,row) {
                        if(data == null) {
                            return "-";
                        } else {
                            if(data.in_lineup == "in") {
                                return '<span class="text-primary"><i class="fas fa-check"></i></span>';
                            } else {
                                return '<span class="text-dark"><i class="fas fa-times"></i></span>';
                            }
                        }
                    }
                },
            ],
        });
        $( TeamsDatatable.table().header() ).addClass('thead-dark table-dark-header');
    };

    var initPlayerFilters = function () {
        $(document).on('change','.js-player-filter-form',function(e){
            e.preventDefault();
            divisionPlayersDatatable.draw();
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

    var readTeamPlayersFilters = function() {
        return {
            division_id: $('#division_id').val() || null,
            team_id: $('#team_id').val() || null,
        };
    };

    var initForm = function() {
        $(document).on('click','.get-division-detail',function(){
            var me = $(this);
            $url = $(this).attr("data-url");
            $container = $(this).attr("tab-container");
            $.get({
                url:$url,
                async:false,
                dataType:'html',
                success:function(response){

                   $($container).html(response);
                    if($container == '.players-container'){
                        initDivisionPlayersDataTable();
                    }else if($container == '.teams-container'){
                        if(me.hasClass('sliding-crest'))
                        { // not call on page load event call
                            $('#leaguereports-teams .is-small >a.active-crest').removeClass("active-crest");
                            me.addClass('active-crest');
                        }
                        initDivisionTeamPlayersDataTable();
                    }
                }
            }).fail(function(response) {

            });
        });
    };

    var sendEmailReport = function (){
        $('#sendEmail').on('click', function() {
            $("#fadeMe").removeClass('d-none');
            $("#fadeMe").fadeIn("fast");
            $("#fadeMe").fadeOut(5000);
             $(this).prop('disabled', true);
             $.post({
                url:$(this).attr('data-url'),
                type:'POST',
                success:function(response){
                    $('#sendEmail').removeAttr('disabled');
                }
            }).fail(function(response) {
                $('#sendEmail').removeAttr('disabled');
                if(typeof response.responseJSON.errors != 'undefined' ){
                    sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
                }
            });
        });
    }

    return {
        init: function() {
            initForm();
            initPlayerFilters();
            sendEmailReport();
            $('.js-owl-carousel-division-crest').owlCarousel({
                loop: false,
                margin: 10,
                nav: true,
                navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
                dots: false,
                mouseDrag: false,
                responsive: {
                    0: {
                        items: 7
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
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerProfileUpdate.init();
    function SlimScroll(){
        if ($(window).width() > 991) {
            let ContentHeight = $('.js-left-pitch-area').height();
            $('.scrollbar').mCustomScrollbar({
                scrollButtons:{enable:true},
                theme:"light-thick",
                scrollbarPosition:"outside",
                mouseWheel:{ enable: true }
            });

            $(function(){
                $('.player-data').height(ContentHeight);
            });
        } else {
            $('scrollbar').mCustomScrollbar("destroy");
        }
    }
    $(window).bind("load", function() {
        SlimScroll();
        $('.player-position-select2').select2();
    });
    $(window).on("orientationchange, resize", function(event) {
        SlimScroll();
    });

    $('.player-carousel').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
        dots: false,
        mouseDrag: false,
        responsive: {
            0: {
                items: 4
            },
            500: {
                items: 5
            },
            991: {
                items: 4
            }
        }
    });

    $('.js-owl-carousel-date-info').owlCarousel({
        loop: false,
        margin: 1,
        nav: true,
        navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
        dots: false,
        mouseDrag: false,
        responsive: {
            0: {
                items: 5
            },
            720: {
                items: 10
            },
            1140: {
                items: 8
            }
        }
    });
});
