var injuredPlayersDatatable = '';
var InjuredPlayers = function() {

    var initInjuredPlayersDataTable = function () {
        injuredPlayersDatatable = $('table.injured-players-table').DataTable({
            ajax: {
                url: $('table.injured-players-table').data('url'),
                method: 'get',
                // data: function (d) {
                //     $.each(readDivisionPlayersFilters(), function (key, value) {
                //         if (value !== null) {
                //             d[key] = value;
                //         }
                //     });
                // }
            },
            dom: '<"top"><"row"<"col-xl-12 d-flex justify-content-end mb-25"rfB>><"table-responsive"t><"row"<"col-sm-3"i><"col-sm-6 text-center"l><"col-sm-3"p>>',
            language: {
                "infoFiltered": "",
                "processing" : "Loading..."
            },
            //responsive: true,
            ordering: true,
            searching: false,
            serverSide: false,
            processing: true,
            pageLength: 25,
            autoWidth: false,
            //scrollY: '52vh',
            scrollCollapse: true,
            //scrollX: true,
            paging: false,
            // stateSave: true,
            // fixedColumns:   {
            //     leftColumns: 4,
            //     rightColumns: 4
            // },
            'order':[[6,'desc'],[7,'desc'],[8,'desc'],[5,'asc'],[3,'asc'],[10,'asc']],
            columns: [
                {
                    data: 'position',
                    title: 'POS',
                    name: 'position',
                    orderData: [11],
                    width:'4%',
                },
                {
                    data: 'player',
                    title: 'Player',
                    name: 'player',
                    orderData: [ 10, 9 ],
                },
                {
                    data: 'status',
                    title: 'Status',
                    name: 'status',
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'club',
                    title: 'Club',
                    name: 'club',
                    "orderSequence": [ "desc", "asc" ],
                },
                {
                    data: 'end_date',
                    title: 'RETURN',
                    name: 'end_date',
                    orderData: [ 6, 7, 8, 5, 3, 10 ],
                },
                {
                    data: 'srank',
                    name: 'srank',
                    visible: false,
                },
                {
                    data: 'year',
                    name: 'year',
                    visible: false,
                },
                {
                    data: 'month',
                    name: 'month',
                    visible: false,
                },
                {
                    data: 'day',
                    name: 'day',
                    visible: false,
                },
                {
                    data: 'first_name',
                    name: 'first_name',
                    visible: false,
                },
                {
                    data: 'surname',
                    name: 'surname',
                    visible: false,
                },
                {
                    data: 'positionOrder',
                    name: 'positionOrder',
                    visible: false,
                }
            ]
        });
        $( injuredPlayersDatatable.table().header() ).addClass('thead-dark table-dark-header');
    };

    var initPlayerFilters = function () {
        $(document).on('change','.js-player-filter-form select',function(e){
            e.preventDefault();
            injuredPlayersDatatable.ajax.reload();
        });
    };

    var playerTabClick = function() {
        $('#injuries-tab').on("click", function() {

            $('#injuries-tab').addClass('active');
            $('button.btn-InsOuts').removeClass('active');

            $('div.js-InsOuts').hide();
            $('div.js-Injuries').show();

            if($(this).attr('data-load') == '0') {
                initInjuredPlayersDataTable();
                $(this).attr('data-load',1);
            }

        });

        $('button.btn-InsOuts').on("click", function() {

            $('#injuries-tab').removeClass('active');
            $('button.btn-InsOuts').addClass('active');

            $('div.js-Injuries').hide();
            $('div.js-InsOuts').show();
        });
    };

    return {
        init: function() {
            playerTabClick();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    InjuredPlayers.init();
});