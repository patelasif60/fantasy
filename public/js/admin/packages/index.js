var AdminPackagesIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        packagesDatatable = $('table.admin-packages-list-table').DataTable({
            ajax: {
                url: $('table.admin-packages-list-table').data('url'),
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
                    title: "Package Name",
                    name: 'name'
                },
                {
                    data: 'display_name',
                    title: "Dispay Name",
                    name: 'display_name'
                },
                {
                    data: 'price',
                    title: "Price",
                    name: 'price',
                    className: 'text-center',
                },
                {
                    data: 'minimum_teams',
                    title: "Minimum Teams",
                    name: 'minimum_teams',
                    className: 'text-center',
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.packages.edit', { package: data })) +
                            Global.buildDeleteAction(route('admin.packages.destroy', { package: data }));
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            packagesDatatable.draw();
        });
    };

    var readFilters = function() {
        var $form = $('.js-filter-form');
        return {
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
    AdminPackagesIndex.init();
});
