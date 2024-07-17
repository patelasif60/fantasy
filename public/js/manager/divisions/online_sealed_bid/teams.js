var datatableTeams
var AuctionOnlineSealedBids = function() {

    var initDatatableTeams = function() {
        datatableTeams =  $('.js-table-filter-teams').DataTable({
                ajax: $('.js-table-filter-teams').data('url'),
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                columns: [
                {
                    data: 'teamName',
                    title: 'Team',
                    name: 'Team',
                    className: "text-left",
                    render: function(data,display,row) {
                        
                        var url = route('manage.auction.online.sealed.bid.teams', { division: Site.divisionId, team:row.id });

                        var isYou = (typeof Site.consumer !== 'undefined' && Site.consumer.id == row.manager_id) ? '<strong>(You)</strong>' : '';

                        return '<div class="d-flex align-items-center"><div class="league-crest"><img src="'+row.crest+'"></div><div class="ml-2"><div><a href="'+url+'?tab=players" class="text-dark link-nostyle">'+row.name+'</a></div><div><a href="'+url+'" class="link-nostyle small">'+row.first_name+' '+row.last_name+' '+isYou+'</a></div></div></div>';
                    }
                },
                {
                    data: 'bidsWin',
                    title: 'Bids won',
                    name: 'bidsWin',
                    defaultContent: 0
                },
                {
                    data: 'bidsInRound',
                    title: 'Bids in round',
                    name: 'bidsInRound',
                    defaultContent: 0,
                    render: function(data,display,row) {

                        if(Site.defaultSquadSize == row.totalBids) {

                            return '<span class="text-primary"><i class="fas fa-check"></i></span>';
                            
                        } else if(row.bidsInRound <= 0) {

                            return '<span class="text-danger"><i class="fas fa-times"></i> </span>';

                        } else {

                            return '<span class="text-danger"><i class="fas fa-exclamation"></i></span>';
                        }

                        // if(row.bidsInRound > 0) {

                        //     return '<span class="text-primary"><i class="fas fa-check"></i></span>';
                        // }
                    }
                },
                {
                    data: 'budget',
                    title: 'Budget',
                    name: 'budget',
                    defaultContent: 0,
                    render: function(data,display,row) {

                        return '&pound;'+row.budget+'m';
                    }
                },
                {
                    data: 'tieOrder',
                    title: 'Tie Order',
                    name: 'tieOrder',
                    defaultContent: '-'
                },
            ],
        });

        $( datatableTeams.table().header() ).addClass('thead-dark');
    };

    var initProcessBid = function() {

        $('body').on('click', '.js-process-bid-start', function(event) {
            event.preventDefault();
            var processUrl = $(this).attr('data-link');
            var round = $(this).attr('data-round');
            sweet.alert({
                title: 'Are you sure you want to process bids?',
                text: 'All current bids will be processed with players awarded to the highest bidder and round '+round+' will begin immediately',
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

    return {
        init: function() {
            initDatatableTeams();
            initProcessBid();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AuctionOnlineSealedBids.init();
});
