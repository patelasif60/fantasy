var AdminPitchesIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        PitchesDatatable = $('table.admin-pitches-list-table').DataTable({
            ajax: {
                url: $('table.admin-pitches-list-table').data('url'),
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
                    title: "Pitch Name",
                    name: 'name'
                },
                {
                    data: null,
                    title: "Published",
                    name: 'is_published',
                    render: function(data) {
                        if(data.is_published == 1) {
                            return '<span class="badge badge-success">Yes</span>';
                        } else {
                            return '<span class="badge badge-danger">No</span>';
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
                        return Global.buildEditAction(route('admin.pitches.edit', { pitch: data })) +
                            Global.buildDeleteAction(route('admin.pitches.destroy', { pitch: data }));
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
    AdminPitchesIndex.init();
});
