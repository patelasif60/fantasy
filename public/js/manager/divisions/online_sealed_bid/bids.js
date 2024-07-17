var datatableBids = '';
var AuctionOnlineSealedBidsBids = function() {

    var initDatatableBids = function() {

        if ( ! $.fn.DataTable.isDataTable( '.js-table-filter-bids' ) ) {

            datatableBids =  $('.js-table-filter-bids').DataTable({
                    ajax: {
                        url: $('.js-table-filter-bids').data('url'),
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
                    paging: false,
                    info: false,
                    serverSide: false,
                    autoWidth:true,
                    scrollCollapse: true,
                    scrollX: false,
                    "orderFixed": {
                        "post": [[ 3, 'asc' ], [ 7, 'asc' ], [ 6, 'asc' ], [ 5, 'asc' ]]
                    },
                    columns: [
                    {
                        data: 'teamName',
                        title: 'Team',
                        name: 'Team',
                        className: "text-left",
                        render: function(data,display,row) {

                            return '<div><a href="javascript:void(0);" class="team-name link-nostyle">'+row.TeamName+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.managerFirstName+' '+row.managerLastName+'</a></div>';
                        }
                    },
                    {
                        data: 'playerFirstName',
                        title: 'Player',
                        name: 'playerFirstName',
                        className: "text-left position",
                        orderData: [ 6, 5 ],
                        render: function(data,display,row) {

                            var position = row.playerPositionShort;

                            return '<div class="player-wrapper"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span> <div> <a href="javascript:void('+row.playerId+');" class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playerFirstName, row.playerLastName)+'</a> <br> <a href="javascript:void('+row.playerClubId+');" class="player-name link-nostyle small">'+row.playerClubName+'</a></div> </div>';
                        }
                    },
                    {
                        data: 'sealedBidAmount',
                        title: 'Price',
                        name: 'sealedBidAmount',
                        render: function(data,display,row) {

                            return '&pound;'+row.sealedBidAmount+'m';
                        }
                    },
                    {
                        data: 'roundNumber',
                        title: 'Round',
                        name: 'roundNumber',
                    },
                    {
                        data: 'sealedBidStatus',
                        title: '',
                        name: 'sealedBidStatus',
                        render: function(data,display,row) {

                            if(row.sealedBidStatus == 'W') {

                                var span = $('<span/>', {
                                    html: 'Won <i class="far fa-check"></i>',
                                    title: 'Won',
                                    class: 'bg-primary text-white py-1 px-2 text-uppercase',
                                }).wrap('div').parent().html();

                                return $('<div/>', {
                                    html: span,
                                    title: 'Won',
                                    class: 'won-player',
                                }).wrap('div').parent().html();
                            }

                            if(row.sealedBidStatus == 'L') {

                                var span = $('<span/>', {
                                    html: 'Lost <i class="far fa-times"></i>',
                                    title: 'Lost',
                                    class: 'bg-danger text-white py-1 px-2 text-uppercase',
                                }).wrap('div').parent().html();

                                return $('<div/>', {
                                    html: span,
                                    title: 'Lost',
                                    class: 'won-player',
                                }).wrap('div').parent().html();

                            }

                            return '-';
                        }
                    },
                    {
                        data: 'playerFirstName',
                        name: 'playerFirstName',
                        visible: false,
                    },
                    {
                        data: 'playerLastName',
                        name: 'playerLastName',
                        visible: false,
                    },
                    {
                        data: 'positionOrder',
                        name: 'positionOrder',
                        visible: false,
                    }
                ],
                aoColumnDefs: [
                   { aTargets: [ 0 ], bSortable: true},
                   { aTargets: [ 1 ], bSortable: true},
                   { aTargets: [ 2 ], bSortable: true},
                   { aTargets: [ 3 ], bSortable: true},
                   { aTargets: [ 4 ], bSortable: false},
                   { aTargets: [ 5 ], bSortable: false},
                   { aTargets: [ 6 ], bSortable: false},
                   { aTargets: [ 7 ], bSortable: false},
                   
            ],
            order: []
            });

            $( datatableBids.table().header() ).addClass('thead-dark table-dark-header');
        }
    };

    var readFilters = function() {
        var round =  $('#round').val();
        var club =  $('#club_bid').val();
        var team =  $('#team').val();
        var position =  $('#position_bid').val();

        var filters = {
            'round' : round,
            'club' : club,
            'team' : team,
            'position' : position,
        };

        return filters;
    }

    var filterBids = function() {

        datatableBids.ajax.reload();
    };

    var filterBidsOnChange = function() {
        $('#round').change(function() {
            filterBids();
        });

        $('#club_bid').change(function() {
            filterBids();
        });

        $('#team').change(function() {
            filterBids();
        });

        $('#position_bid').change(function() {
            filterBids();
        });
    };

    var initBidClick = function() {

        $(document).on('click', '#bid-tab', function(event) {
            initDatatableBids();
        });
    }

    return {
        init: function() {
            initBidClick();
            filterBidsOnChange();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AuctionOnlineSealedBidsBids.init();
});
