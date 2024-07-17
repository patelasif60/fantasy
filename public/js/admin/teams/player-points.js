var AdminTeamPlayerPointsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
          TeamPlayerPointsDatatable = $('table.admin-team-points-players-list-table').DataTable({
            ajax: {
                url: $('table.admin-team-points-players-list-table').data('url'),
                method: 'post',
            },
            columns: [
                {
                    data: 'name',
                    title: "player",
                    name: 'name'
                },
                {
                    data: 'club',
                    title: "Club",
                    name: 'club'
                },
                {
                    data: 'position',
                    title: "Position",
                    name: 'position'
                },
                {
                    data: 'app',
                    title: "Apps",
                    name: 'app',
                    defaultContent: '-'
                },
                {
                    data: 'goals',
                    title: "Goals",
                    name: 'goals',
                    defaultContent: '-'
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
                    data: 'conceded',
                    title: "Conceded",
                    name: 'conceded',
                    defaultContent: '-'
                }
            ],
            dom: 'Bfrtip',
            buttons: []
        });
    };
    return {
        init: function () {
            initDataTable();
        }
    };
}();

// Initialize when modal loads
$(document).on('show.bs.modal','#modal-create-edit-box',function(){
    AdminTeamPlayerPointsIndex.init();
});
