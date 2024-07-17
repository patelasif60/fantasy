var AdminDivisionsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        divisionsDatatable = $('table.admin-divisions-list-table').DataTable({
            ajax: {
                url: $('table.admin-divisions-list-table').data('url'),
                method: 'post',
                data: function (d) {
                    $.each(readFilters(), function (key, value) {
                        console.log(key);
                        console.log(value);
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
                    title: "League Name",
                    name: 'name'
                },
                {
                    data: 'divisons',
                    title: "Divisions",
                    render: function(data, type, row) {
                        if(!row.divisons.length){
                            return 1;
                        }
                        return row.divisons.length + 1;
                    }
                },
                {
                    data: 'chairman_name',
                    title: "Chairman",
                    name: 'chairman_name'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data, type, row) {

                        if(!row.divisons.length){
                            var html = Global.buildEditAction(route('admin.divisions.edit', { division: data }));
                        }else{
                            var html = Global.buildEditAction(route('admin.divisions.subdivison', { division: data }));
                        }

                        return html + Global.buildDeleteAction(route('admin.divisions.destroy', { division: data }));
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            divisionsDatatable.draw();
        });
    };

    var readFilters = function() {
        var $form = $('.js-filter-form');
        return {
            chairman_id: $form.find("select[name='chairman_id']").val() || null,
            season: $form.find("select[name='season']").val() || null,
            name: $form.find("input[name='name']").val() || null,
            status: $form.find("select[name='status']").val() || null,
        };
    };

    return {
        init: function () {
            initDataTable();
            initFilters();
            $("#filter-season-id").select2();
            Global.select2Options({
                "options": [
                    {
                      "id": '#filter-chairman_id',
                      "placeholder": "Please select",
                      "allowClear": true,
                      "minimumInputLength": 3,
                      "ajax" : {
                        url: route('admin.users.searchEmail'),
                        data: function (params) {
                          params.term = $.trim(params.term).replace(/ /g, '+')
                          var query = {
                            search: params.term.replace(/ /g, '+')
                          }
                          return query;
                        },
                        processResults: function (data) {
                          return {
                            results: data
                          }
                        }
                      }
                    },
                    {
                      "id": '#filter-status',
                      "placeholder": "Please select",
                      "allowClear": true
                    }
                  ],
            });
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminDivisionsIndex.init();
});
