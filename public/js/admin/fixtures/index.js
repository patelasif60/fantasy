var AdminFixturesIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        fixturesDatatable = $('table.admin-fixtures-list-table').DataTable({
            ajax: {
                url: $('table.admin-fixtures-list-table').data('url'),
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
                    data: 'home_team',
                    title: "Home Team",
                    name: 'home_team',
                    render:function(data){
                        return data.name;
                    }
                },
                {
                    data: 'away_team',
                    title: "Away Team",
                    name: 'away_team',
                    render:function(data){
                        return data.name;
                    }
                },
                {
                    data: 'date_time',
                    title: "Date",
                    name: 'date_time'
                },
                {
                    data: 'competition',
                    title: "Competition",
                    name: 'competition'
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.fixtures.edit', { fixture: data })) +
                            Global.buildDeleteAction(route('admin.fixtures.destroy', { fixture: data }));
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            fixturesDatatable.draw();
        });
    };

    var initSelect2 = function () {
        $form = $('.js-filter-form');
        $form.find("select[name='season']").select2({
            allowClear: true,
            placeholder: 'Select a season'
        });
        $form.find("select[name='competition']").select2({
            allowClear: true,
            placeholder: 'Select a competition'
        });
        $form.find("select[name='home_club']").select2({
            allowClear: true,
            placeholder: 'Select a club'
        });
        $form.find("select[name='away_club']").select2({
            allowClear: true,
            placeholder: 'Select a club'
        });
    };

    var readFilters = function() {
        var $form = $('.js-filter-form');
        return {
            season: $form.find("select[name='season']").val() || null,
            competition: $form.find("select[name='competition']").val() || null,
            home_club: $form.find("select[name='home_club']").val() || null,
            away_club: $form.find("select[name='away_club']").val() || null,
            from_date_time: $form.find("input[name='from_date_time']").val() || null,
            to_date_time: $form.find("input[name='to_date_time']").val() || null
        };
    };

    var initDTpicker = function(){
        $form = $('.js-filter-form');
        $form.find("input[name='from_date_time']").datetimepicker();
        $form.find("input[name='to_date_time']").datetimepicker();
    }

    return {
        init: function () {
            initDataTable();
            initFilters();
            initSelect2();
            initDTpicker();
            Codebase.helpers(['core-tab']);
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminFixturesIndex.init();
});
