var AdminSeasonsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        $('table.admin-seasons-list-table').DataTable({
            ajax: {
                url: $('table.admin-seasons-list-table').data('url'),
                method: 'post',
            },
            columns: [
                {
                    data: 'id',
                    title: 'ID',
                    name: 'id',
                },
                {
                    data: 'name',
                    title: "Name",
                    name: 'name'
                },
                {
                    data: 'premier_api_id',
                    title: "Premier Season Api Id",
                    name: 'premier_api_id'
                },
                {
                    data: 'facup_api_id',
                    title: 'FA Cup Season Api Id',
                    name: 'facup_api_id',
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.seasons.edit', { season: data })) +
                            Global.buildDeleteAction(route('admin.seasons.destroy', { season: data }));
                    }
                }
            ],
        });
    };

    return {
        init: function () {
            initDataTable();
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminSeasonsIndex.init();
});
