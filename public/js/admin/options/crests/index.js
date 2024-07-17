var AdminOptionsCrestsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        $('table.admin-options-crests-list-table').DataTable({
            ajax: {
                url: $('table.admin-options-crests-list-table').data('url'),
                method: 'post',
            },
            columns: [
                {
                    data: 'id',
                    title: 'ID',
                    name: 'id',
                },
                {
                    data: 'image',
                    title: 'Badge',
                    render: function(image) {
                        return "<img src='"+image+"' style='width:30px;'>";
                    }
                },
                {
                    data: 'name',
                    title: "Name",
                    name: 'name',
                },
                {
                    data: 'is_published',
                    title: "Published",
                    name: 'is_published',
                    render: function(data) {
                        if(data) {
                            return '<span class="badge badge-success">'+Site.status['YES']+'</span>';
                        } else {
                            return '<span class="badge badge-danger">'+Site.status['NO']+'</span>';
                        }
                    }
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.options.crests.edit', { crest: data })) +
                            Global.buildDeleteAction(route('admin.options.crests.destroy', { crest: data }));
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
    AdminOptionsCrestsIndex.init();
});
