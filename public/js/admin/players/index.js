var AdminPlayersIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        playersDatatable = $('table.admin-players-list-table').DataTable({
            ajax: {
                url: $('table.admin-players-list-table').data('url'),
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
                    data: 'api_id',
                    title: "Api Id",
                    name: 'api_id'
                },
                {
                    data: 'first_name',
                    title: "First Name",
                    name: 'first_name'
                },
                {
                    data: 'last_name',
                    title: "Last Name",
                    name: 'last_name'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.players.edit', { player: data })) +
                            Global.buildDeleteAction(route('admin.players.destroy', { player: data }));
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            playersDatatable.draw();
        });
    };

    var initSelect2 = function () {
        $form = $('.js-filter-form');
        $form.find("select[name='club']").select2({
            allowClear: true,
            placeholder: 'Select a club'
        });
        $form.find("select[name='position']").select2({
            allowClear: true,
            placeholder: 'Select a position'
        });
    };

    var readFilters = function() {
        var $form = $('.js-filter-form');
        return {
            club: $form.find("select[name='club']").val() || null,
            position: $form.find("select[name='position']").val() || null,
            term: $form.find("input[name='term']").val() || null
        };
    };

    return {
        init: function () {
            initDataTable();
            initFilters();
            initSelect2();
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminPlayersIndex.init();
});
