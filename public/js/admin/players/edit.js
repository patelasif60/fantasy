var AdminPlayersEdit = function() {

    var initFormValidations = function () {
        $('.js-player-edit-form').validate(Global.buildValidateParams({
            rules: {
                'last_name': {
                    required: true,
                },
                'api_id': {
                    required: true,
                },
            },
        }));
    };

    var initPlayerImageUpload = function() {
        $('#player_image').fileuploader(Global.buildImageCropParams({
            ratio: '32:13',
            minWidth: 640,
            minHeight: 260,
            showGrid: true
        }));
    }

    return {
        init: function() {
            initFormValidations();
            initPlayerImageUpload();
        }
    };
}();

var PlayersContractList = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        playersContractTable = $('table.admin-players-contract-list-table').DataTable({
            ajax: {
                url: $('table.admin-players-contract-list-table').data('url'),
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
                    data: 'club',
                    title: "Club",
                    name: 'club',
                    sortable: false,
                    render:function(data){
                            return data.name;
                    }
                },
                {
                    data: 'position',
                    title: "Position",
                    name: 'position'
                },
                {
                    data: 'start_date',
                    title: "Start",
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    title: "End",
                    name: 'end_date',
                    render: function(data) {
                        if(data == null) {
                            return 'Open';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data, type, row, meta ) {
                        return Global.buildModalEditAction(route('admin.player.contract.edit', { player:row.player_id, contract: data })) +
                            Global.buildDeleteAction(route('admin.player.contract.destroy', { contract: data }));
                    }
                }
            ],
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
            initSelect2();
        },
        resetDatatable: function(){
            playersContractTable.draw();
        }
    }
}();

var PlayersStatusList = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        playersStatusDatatable = $('table.admin-players-status-list-table').DataTable({
            ajax: {
                url: $('table.admin-players-status-list-table').data('url'),
                method: 'post',
            },
            columns: [
                {
                    data: 'id',
                    title: 'ID',
                    name: 'id',
                },
                {
                    data: 'status',
                    title: "Type",
                    name: 'status'
                },
                {
                    data: 'description',
                    title: "Description",
                    name: 'description',
                    sortable: false,
                },
                {
                    data: 'start_date',
                    title: "Start",
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    title: "End",
                    name: 'end_date'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data, type, row, meta ) {
                        return Global.buildModalEditAction(route('admin.player.status.edit', { player:row.player_id,status: data, })) +
                            Global.buildDeleteAction(route('admin.player.status.destroy', { status: data }));
                    }
                }
            ],
        });
    };

    return {
        init: function () {
            initDataTable();
        },
        resetDatatable: function(){
            playersStatusDatatable.draw();
        }

    }
}();

// Initialize when page loads
jQuery(function() {
    AdminPlayersEdit.init();
    PlayersContractList.init();
    PlayersStatusList.init();
});
