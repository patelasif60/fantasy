var AdminGameWeekIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        $('table.admin-game-week-list-table').DataTable({
            ajax: {
                url: $('table.admin-game-week-list-table').data('url'),
                method: 'post',
            },
            columns: [
                {
                    data: 'id',
                    title: 'ID',
                    name: 'id',
                },
                {
                    data: 'number',
                    title: "Week",
                    name: 'number'
                },
                {
                    data: 'start',
                    title: 'Start',
                    name: 'start',
                },
                {
                    data: 'end',
                    title: 'End',
                    name: 'end',
                },
                {
                    data: 'notes',
                    title: 'Notes',
                    name: 'notes',
                },
                {
                    data: 'is_valid_cup_round',
                    title: "Cup week ?",
                    name: 'is_valid_cup_round',
                    render: function(data) {
                        if(data){
                            return 'Yes';
                        }
                        return 'No';
                    }
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return $('<button/>', {
                                html: '<i class="fa fa-pencil"></i>',
                                type: 'button',
                                title: 'Edit',
                                href: route('admin.gameweeks.edit', { gameweek: data }),
                                class: 'btn btn-sm btn-circle btn-alt-info mr-5 mb-5 js-button-gameweek-edit',
                            }).wrap('div').parent().html() + Global.buildDeleteAction(route('admin.gameweeks.destroy', { gameweek: data }));
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
    AdminGameWeekIndex.init();
});
