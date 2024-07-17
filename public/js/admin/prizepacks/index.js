var AdminPrizePacksIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        $('table.admin-prize-packs-list-table').DataTable({
            ajax: {
                url: $('table.admin-prize-packs-list-table').data('url'),
                method: 'post'
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
                    data: 'price',
                    title: "Price",
                    name: 'price',
                    className: 'text-center',
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.prizepacks.edit', { prizePack: data })) +
                            Global.buildDeleteAction(route('admin.prizepacks.destroy', { prizePack: data }));
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
    AdminPrizePacksIndex.init();
});
