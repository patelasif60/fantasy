var AdminTeamTransferIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        transfersDatatable = $('table.admin-teams-transfer-list-table').DataTable({
            ajax: {
                url: $('table.admin-teams-transfer-list-table').data('url'),
                method: 'post',
                data: function (d) {
                    $.each(readFilters(), function (key, value) {
                        if (value !== null) {
                            d[key] = value;
                        }
                    });
                }
            },
            columns: [
                {
                    data: 'transfer_date',
                    title: "Date",
                    name: 'transfer_date'
                },
                {
                    data: 'transfer_type',
                    title: "Type",
                    name: 'transfer_type',
                    render: function(data) {
                        if(Site.transferType[data])
                        {
                            return Site.transferType[data];
                        }
                    }
                },
                {
                    data: 'player_in',
                    title: "In",
                    name: 'player_in'
                },
                {
                    data: 'player_out',
                    title: "Out",
                    name: 'player_out'
                },
                {
                    data: 'transfer_value',
                    title: "&pound;M",
                    name: 'transfer_value'
                },
                // {
                //     data: 'id',
                //     title: 'Actions',
                //     searchable: false,
                //     sortable: false,
                //     className: 'text-center text-nowrap',
                //     render: function(data, type, row, meta ) {
                //         return Global.buildDeleteAction(route('admin.team.transfer.destroy', { transfer: data }));
                //     }
                // }
            ],
            dom: 'Bfrtip',
            buttons: []
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            transfersDatatable.draw();
        });
        $('.transfer-types').on('click', function(e) {
            transfersDatatable.draw();
        });
        $('#filter-season').on('change', function(e) {
            transfersDatatable.draw();
        });
        $('.exportCsv').on('click', function(e) {
            e.preventDefault();
            window.location = route('admin.team.transfer.data.export') + '?' + $.param(transfersDatatable.ajax.params());
        });
    };

    var readFilters = function() {
        var transfer_types = [];
        $.each($(".transfer-types:checked"), function(){
            transfer_types.push($(this).val());
        });
        return {
            transfer_types,
            season:  $("#filter-season").val() || null,
            uuid:  $("#filter-uuid").val() || null,
            team:  $("#filter-team_id").val() || null,
        };
    };



    return {
        init: function () {
            initDataTable();
            initFilters();
            Codebase.helpers(['datepicker']);
        },
        resetDatatable: function(){
            transfersDatatable.draw();
        }
    }
}();


// Initialize when page loads
jQuery(function() {
    AdminTeamTransferIndex.init();
});
