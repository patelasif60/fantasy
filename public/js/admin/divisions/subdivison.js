var AdminSubDivisionsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        subDivisionsDatatable = $('table.admin-sub-divisions-list-table').DataTable({
            ajax: {
                url: $('table.admin-sub-divisions-list-table').data('url'),
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
                    data: 'id',
                    title: 'ID',
                    name: 'id',
                },
                {
                    data: 'name',
                    title: "League Name",
                    name: 'name'
                },
                {
                    data: 'chairman_name',
                    title: "Chairman",
                    name: 'chairman_name'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data, type, row) {
                        return Global.buildEditAction(route('admin.divisions.edit', { division: data })) +
                               Global.buildDeleteAction(route('admin.divisions.destroy', { division: data }));
                    }
                                    
                }
            ],
            dom: 'Bfrtip',
            buttons: []
        });
    };


    var readFilters = function() {
        return {
            division_id: $('#filter-division_id').val() || null
        };
    };

    return {
        init: function () {
            initDataTable();
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminSubDivisionsIndex.init();
});
