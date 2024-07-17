var Transfers = function() {

    var initDatatableTransfers = function() {
        datatableTransfers = $('.divison-transfer-history-table').DataTable({
                ajax: {
                    url: $('.divison-transfer-history-table').data('url'),
                    method: 'get',
                    data: function (d) {
                        $.each(readFilters(), function (key, value) {
                            if (value !== null) {
                                d[key] = value;
                            }
                        });
                    }
                },
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                columns: [
                {
                    data: 'transfer_date',
                    title: 'Date',
                    name: 'transfer_date',
                    className: "text-center",
                    defaultContent: '-',
                    render: function(data,display,row) {

                        return '<div><span class="team-name link-nostyle">'+formatDate(row.transfer_date)+'</span></div><div><span class="player-name link-nostyle small">'+formatTime(row.transfer_date)+'</span></div>';
                    }
                },
                {
                    data: 'name',
                    title: 'Team',
                    name: 'name',
                    className: "text-center",
                    defaultContent: '-',
                    render: function(data,display,row) {
                        var url = route('manage.team.lineup', { division: Site.division.id, team:row.id });
                        return '<div><a href="'+url+'" class="team-name link-nostyle">'+row.name+'</a></div><div><span class="player-name link-nostyle small">'+row.user_first_name+' '+row.user_last_name+'</span></div>';
                    }
                },
                {
                    data: 'transfer_type',
                    title: 'Type',
                    name: 'transfer_type',
                    className: "text-center",
                    render: function(data,display,row) {
                        if(typeof Site.transferTypes[row.transfer_type] !== 'undefined'){
                            if (Site.transferTypes[row.transfer_type] == 'Budget Correction') {
                                return Site.transferTypes[row.transfer_type] + ' (£' + row.transfer_value + 'm)';
                            }
                            return Site.transferTypes[row.transfer_type];
                        }
                        return '-';

                    }
                },
                {
                    data: 'player_in',
                    title: 'Player in',
                    name: 'player_in',
                    // className: "text-center",
                    defaultContent: '-',
                    render: function(data,display,row) {
                        var inClubName = '';
                        var playerInPosition = '';
                        if (row.player_in_club_name != null) {
                            inClubName = row.player_in_club_name
                            playerInPosition = row.player_in_position.toLowerCase();
                        }
                        return '<div class="player-wrapper"><span class="custom-badge custom-badge-lg is-square is-'+playerInPosition+'">'+playerInPosition+'</span><div><span class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_in_first_name, row.player_in_last_name)+'</span> <span class="player-name link-nostyle small">'+inClubName+'</span></div>';

                    }
                },
                {
                    data: 'player_out',
                    title: 'Player out',
                    name: 'player_out',
                    // className: "text-center",
                    defaultContent: '-',
                    render: function(data,display,row) {
                        var outClubName = '';
                        var playerOutPosition = '';
                        if (row.player_out_club_name != null) {
                            outClubName = row.player_out_club_name
                            playerOutPosition = row.player_out_position.toLowerCase();
                        }
                        return '<div class="player-wrapper"><span class="custom-badge custom-badge-lg is-square is-'+playerOutPosition+'">'+playerOutPosition+'</span><div><span class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_out_first_name, row.player_out_last_name)+'</span> <span class="player-name link-nostyle small">'+outClubName+'</span></div>';

                    }
                },
            ],
        });

        $( datatableTransfers.table().header() ).addClass('thead-dark table-dark-header');
    };

    var readFilters = function() {
        return {

            type: $('#filter-type').val() || null,
            period: $('#filter-period').val() || null,
        };
    };

    var initFilters = function () {
        $('#filter-type').on('change', function(e) {
            datatableTransfers.ajax.reload();
        });
        $('#filter-period').on('change', function(e) {
            datatableTransfers.ajax.reload();
        });

    };





    var initSelect2 = function() {
        $('.js-select2').select2();
    }

    var formatDate = function(date){
        return moment(date).format('ddd D MMM');
    }

    var formatTime = function(date){
        return moment(date).format('HH:mm');
    }



    return {
        init: function() {
            initDatatableTransfers();
            initFilters();
            initSelect2();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    Transfers.init();
});



