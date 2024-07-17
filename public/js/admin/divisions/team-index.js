var AdminDivisionTeamIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        divisionsDatatable = $('table.admin-divisions-team-list-table').DataTable({
            ajax: {
                url: $('table.admin-divisions-team-list-table').data('url'),
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
                    data: 'team',
                    title: "Team Name",
                    name: 'team'
                },
                {
                    data: 'manager',
                    title: "Manager",
                    name: 'manager'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data, type, row, meta ) {
                        return Global.buildModalEditAction(route('admin.division.team.edit', { divisonteam: data })) +
                            Global.buildDeleteAction(route('admin.division.team.destroy', { division: row.division_id, divisonteam: data }));
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: []
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            divisionsDatatable.draw();
        });
        $('#filter-season').on('change', function(e) {
            divisionsDatatable.draw();
            $('.add-team-btn').attr('href',route('admin.divisions.team.create', { division: Site.division_id, season: $('#filter-season option:selected').val()}));
        });
        $('.exportCsv').on('click', function(e) {
            e.preventDefault();
            window.location = route('admin.division.team.data.export') + '?' + $.param(divisionsDatatable.ajax.params());
        });
    };

    var readFilters = function() {
        return {
            division_id: $("#filter-division_id").val() || null,
            season:  $("#filter-season").val() || null,
        };
    };

    var initSelect2 = function () {
        $form = $('.js-filter-form');
        $form.find("select[name='chairman_id']").select2({
            allowClear: true,
            placeholder: 'Please select'
        });
        $form.find("select[name='status']").select2({
            allowClear: true,
            placeholder: 'Please select'
        });
    };

    return {
        init: function () {
            initDataTable();
            initFilters();
            initSelect2();
        },
        resetDatatable: function(){
            divisionsDatatable.draw();
        }
    }
}();


// Initialize when page loads
jQuery(function() {
    AdminDivisionTeamIndex.init();
});
