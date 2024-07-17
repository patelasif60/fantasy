var AdminClubsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        clubsDatatable = $('table.admin-clubs-list-table').DataTable({
            ajax: {
                url: $('table.admin-clubs-list-table').data('url'),
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
                    data: 'image',
                    title: 'Badge',
                    render: function(image) {
                        return "<img src='"+image+"' style='width:30px;'>";
                    }
                },
                {
                    data: 'api_id',
                    title: "Api Id",
                    name: 'api_id'
                },
                {
                    data: 'name',
                    title: "Club Name",
                    name: 'name'
                },
                {
                    data: 'is_premier',
                    title: 'Competition',
                    name: 'is_premier',
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data, type, row) {
                        var actions = Global.buildEditAction(route('admin.clubs.edit', { club: data }));

                        if (row.can_be_deleted) {
                            return actions + Global.buildDeleteAction(route('admin.clubs.destroy', { club: data }))
                        }

                        return actions + $('<button/>', {
                            html: '<i class="fa fa-trash"></i>',
                            title: 'Delete',
                            class: 'btn btn-sm btn-circle btn-alt-danger mr-5 mb-5',
                            disabled: 'disabled'
                        }).wrap('div').parent().html();
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            clubsDatatable.draw();
        });
    };

    var readFilters = function() {
        var $form = $('.js-filter-form');
        return {
            is_premier: $form.find("input[name='is_premier']").is(':checked') ? 1 : null,
            name: $form.find("input[name='name']").val() || null
        };
    };

    return {
        init: function () {
            initDataTable();
            initFilters();
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminClubsIndex.init();
});
