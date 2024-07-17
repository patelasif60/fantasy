var AdminGameGuideIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        GameGuideDatatable = $('table.admin-gameguide-list-table').DataTable({
            ajax: {
                url: $('table.admin-gameguide-list-table').data('url'),
                method: 'post'                
            },
            columns: [
                {
                    data: 'id',
                    title: 'ID',
                    name: 'id',
                },
                {
                    data: 'section',
                    title: "Section",
                    name: 'section'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.gameguide.edit', { gameguide: data })) +
                            Global.buildDeleteAction(route('admin.gameguide.destroy', { gameguide: data }));
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
    AdminGameGuideIndex.init();
});
