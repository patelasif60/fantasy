var datatableBidsProcess = '';
var datatableBidsPending = '';

var TransferOnlineSealedBids = function() {

    var initDatatableBids = function() {

        var groupColumn = 7;

        datatableBidsProcess =  $('.js-table-filter-process-bids').DataTable({
                ajax: $('.js-table-filter-process-bids').data('url'),
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
                                '<tr class="group"><td colspan="7" class="text-dark"><strong class="h6">'+group+'</strong></td></tr>'
                            );
         
                            last = group;
                        }
                    } );
                },
                columns: [
                {
                    data: 'teamNm',
                    title: 'Team',
                    name: 'teamNm',
                    className: "text-left",
                    render: function(data,display,row) {

                        return '<div><a href="javascript:void(0)" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.first_name+' '+row.last_name+'</a></div>';
                    }
                },
                {
                    data: 'playersOutLastName',
                    title: 'Player out',
                    name: 'playersOutLastName',
                    className: "text-left",
                    defaultContent: '-',
                    render: function(data,display,row) {

                        return '<div><a href="javascript:void(0)" class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playersOutFirstName, row.playersOutLastName)+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.shortCodeOut+' - '+row.positionOutShort+'</a></div>';
                    }
                },
                {
                    data: 'playersInLastName',
                    title: 'Player in',
                    name: 'playersInLastName',
                    className: "text-left",
                    defaultContent: '-',
                    render: function(data,display,row) {

                        return '<div><a href="javascript:void(0)" class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playersInFirstName, row.playersInLastName)+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.shortCodeIn+' - '+row.positionInShort+'</a></div>';
                    }
                },
                {
                    data: 'amount',
                    title: 'Price',
                    name: 'amount',
                    defaultContent: '-',
                    render: function(data,display,row) {

                        return '&pound;'+row.amount+'m';
                    }
                },
                {
                    data: 'tieOrder',
                    title: 'Tie Preference',
                    name: 'tieOrder',
                    defaultContent: '-',
                },
                {
                    data: 'createdAtFormated',
                    title: 'Date',
                    name: 'createdAtFormated',
                    defaultContent: '-'
                },
                {
                    data: 'status',
                    title: '',
                    name: 'status',
                    render: function(data,display,row) {

                        if(data == 'W') {

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

                        if(data == 'L') {

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
                    data: 'roundNumber',
                    title: 'roundNumber',
                    name: 'roundNumber',
                    defaultContent: '-',
                    visible:false
                },
            ],
        });

        $( datatableBidsProcess.table().header() ).addClass('thead-dark');
    };

    var initDatatableBidsPending = function() {
        datatableBidsPending =  $('.js-table-filter-pending-bids').DataTable({
                ajax: $(".js-table-filter-pending-bids").data('url'),
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                columns: [
                {
                    data: 'teamNm',
                    title: 'Team',
                    name: 'teamNm',
                    className: "text-left",
                    render: function(data,display,row) {

                        return '<div><a href="javascript:void(0)" class="team-name link-nostyle">'+data+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.first_name+' '+row.last_name+'</a></div>';
                    }
                },
                {
                    data: 'status',
                    title: '',
                    name: 'status',
                    defaultContent: '-',
                    visible: Site.isManager,
                    render: function(data,display,row) {

                        if(!Site.isManager || row.is_process) {
                            return '';
                        }

                        var url = route('manage.transfer.online.sealed.bid.process.start.single', { division: Site.divisionId, sealbid:row.sealBidId });

                        var htmlData = '';

                        if(data == 'L') {
                            htmlData = '<button data-link="'+url+'" class="btn-sm btn btn-theme-danger js-button-process-single-bid">Override</button>';
                        }
                        if(data == 'W') {
                            htmlData = '<button data-link="'+url+'" class="btn-sm btn btn btn-primary js-button-process-single-bid">Process</button>';
                        }

                        return htmlData;
                    }
                },
                {
                    data: 'teamId',
                    title: '',
                    name: 'teamId',
                    defaultContent: '-',
                    //visible: Site.isManager,
                    render: function(data,display,row) {
                        
                        if(row.status == 'L') {

                            return '<span class="text-theme-danger h6 m-0"><i class="fas fa-times"></i></span>';
                        }

                        if(row.status == 'W') {

                            if(row.is_process) {

                                return '<span class="text-primary h6 m-0"><i class="fas fa-check"></i></span>';
                            }

                            return '<span class="text-dark h6 m-0"><i class="fas fa-check"></i></span>';
                        }

                        return '';
                    }
                },
                {
                    data: 'playersOutLastName',
                    title: 'Player out',
                    name: 'playersOutLastName',
                    className: "text-left",
                    defaultContent: '-',
                    render: function(data,display,row) {

                        return '<div><a href="javascript:void(0)" class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playersOutFirstName, row.playersOutLastName)+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.shortCodeOut+' - '+row.positionOutShort+'</a></div>';
                    }
                },
                {
                    data: 'playersInLastName',
                    title: 'Player in',
                    name: 'playersInLastName',
                    className: "text-left",
                    defaultContent: '-',
                    render: function(data,display,row) {

                        return '<div><a href="javascript:void(0)" class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playersInFirstName, row.playersInLastName)+'</a></div><div class="small"><a href="javascript:void(0);" class="player-name link-nostyle">'+row.shortCodeIn+' - '+row.positionInShort+'</a></div>';
                    }
                },
                {
                    data: 'amount',
                    title: 'Price',
                    name: 'amount',
                    defaultContent: '-',
                    render: function(data,display,row) {

                        return '&pound;'+row.amount+'m';
                    }
                },
                {
                    data: 'tieOrder',
                    title: 'Tie Preference',
                    name: 'tieOrder',
                    defaultContent: '-',
                },
                {
                    data: 'createdAtFormated',
                    title: 'Date',
                    name: 'createdAtFormated',
                    defaultContent: '-'
                },
            ],
        });

        $( datatableBidsPending.table().header() ).addClass('thead-dark');
    };

    var initProcessSingleBid = function() {

        $('body').on('click', '.js-button-process-single-bid', function(event) {
            var vm = $(this);
            event.preventDefault();
            var processUrl = $(this).attr('data-link');
            sweet.alert({
                text: 'Are you sure you want to process bid?',
                //title: 'Are you sure you want to process bids?',
                //text: 'All current bids will be processed with players awarded to the highest bidder and round '+round+' will begin immediately',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                html: false,
            }).then(function(result) {
                if (result.value) {
                    vm.attr("disabled", true);
                    submitProcessResourceForm(processUrl);
                }
            });
        });
    }

    var initRoundClose = function() {

        $('body').on('click', '.btn-round-close', function(event) {
            var vm = $(this);
            event.preventDefault();
            var processUrl = route('manage.transfer.online.sealed.bid.round.close', { division: Site.divisionId });
            sweet.alert({
                title: 'Are you sure you want to close this round?',
                text: 'Make sure that all bids have been actioned before you close the round.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                html: false,
            }).then(function(result) {
                if (result.value) {
                    vm.attr("disabled", true);
                    submitProcessResourceForm(processUrl);
                }
            });
        });
    }

    var initProcessBid = function() {

        $('body').on('click', '.js-process-bid-start', function(event) {
            event.preventDefault();
            var processUrl = $(this).attr('data-link');
            var round = $(this).attr('data-round');
            sweet.alert({
                title: 'Are you sure you want to process bids?',
                text: 'All current bids will be processed with players awarded to the highest bidder',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                html: false,
            }).then(function(result) {
                if (result.value) {
                    $('.js-process-bid-start').attr("disabled", true);
                    submitProcessResourceForm(processUrl);
                }
            });
        });
    }

    var submitProcessResourceForm = function(processUrl) {
        $('<form>', {
            'method': 'POST',
            'action': processUrl,
            'target': '_top'
        })
        .append($('<input>', {
            'name': '_token',
            'value': $('meta[name="csrf-token"]').attr('content'),
            'type': 'hidden'
        }))
        .append($('<input>', {
            'name': '_method',
            'value': 'POST',
            'type': 'hidden'
        }))
        .hide().appendTo("body").submit();
    }

    var initPageRefresh = function() {
        if(Site.isRoundProcess) {
            isJobExecuted();
            setInterval(isJobExecuted, 5000);
        }
    };

    var isJobExecuted = function() {
         $.ajax({
            url: route('manage.transfer.online.sealed.bid.round.status', { division: Site.divisionId }),
            type: 'get',
            success: function(response) {
                if(response.data.status) {
                    location.reload();
                }
            }
        });
    };

    return {
        init: function() {
            initDatatableBids();
            initDatatableBidsPending();
            initProcessBid();
            initProcessSingleBid();
            initRoundClose();
            initPageRefresh();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    TransferOnlineSealedBids.init();
});
