var AdminTeamPointsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
          TeamPointsDatatable = $('table.admin-team-points-list-table').DataTable({
            ajax: {
                url: $('table.admin-team-points-list-table').data('url'),
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
                    data: 'week',
                    title: "Week",
                    name: 'week'
                },
                {
                    data: 'total',
                    title: "Total",
                    name: 'total'
                },
                {
                    data: 'goals',
                    title: "Goals",
                    name: 'goals'
                },
                {
                    data: 'assists',
                    title: "Assists",
                    name: 'assists',
                    defaultContent: '-'
                },
                {
                    data: 'clean_sheets',
                    title: "Clean Sheets",
                    name: 'clean_sheets',
                    defaultContent: '-'
                },
                {
                    data: 'goals_against',
                    title: "Goals Against",
                    name: 'goals_against',
                    defaultContent: '-'
                },
                {
                    data: 'def_app',
                    title: "Def app",
                    name: 'def_app',
                    defaultContent: '-'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data,type, row, meta) {
                        return Global.buildModalEditAction(route('admin.team.points.edit', { team:row['team_id'],point: row['week'] }));
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: []
        });
    };

    var initFilters = function () {
        $('#filter-season').on('change', function(e) {
            TeamPointsDatatable.draw();
        });
        
    };
    var readFilters = function() {
        return {
            season:  $("#filter-season").val() || null,
            uuid:  $("#filter-uuid").val() || null,
            team:  $("#filter-team_id").val() || null,
        };
    };

    return {
        init: function () {
            initDataTable();
            initFilters();
        },
        resetDatatable: function(){
            TeamPointsDatatable.draw();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminTeamPointsIndex.init();
});
