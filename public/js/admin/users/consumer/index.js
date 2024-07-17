var ConsumerUsersAdminIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        consumerUsersDatatable = $('table.consumer-users-list-table').DataTable({
            ajax: {
                url: $('table.consumer-users-list-table').data('url'),
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
                    data: 'first_name',
                    title: "First name",
                    name: 'first_name'
                },
                {
                    data: 'last_name',
                    title: "Last name",
                    name: 'last_name'
                },
                {
                    data: 'email',
                    title: 'Email',
                    name: 'email'
                },
                {
                    data: 'last_login_at',
                    title: 'Last login',
                    name: 'last_login_at'
                },
                {
                    data: 'status',
                    title: 'Status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        if(data === Site.status['ACTIVE']) {
                            return '<span class="badge badge-success">'+data+'</span>';
                        } else {
                            return '<span class="badge badge-danger">'+data+'</span>';
                        }
                    }
                },
                {
                    data: 'consumer',
                    title: 'Profile Completed',
                    name: 'consumer',
                    render: function(data, type, full, meta) {
                       if(data.id){
                        return 'Yes';
                       }else{
                        return 'No';
                       }
                    }
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return Global.buildEditAction(route('admin.users.consumers.edit', { user: data })) +
                            Global.buildDeleteAction(route('admin.users.consumers.destroy', { user: data }));
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            consumerUsersDatatable.draw();
        });

        $('.exportCsv').on('click', function(e) {
            e.preventDefault();
            window.location = route('admin.consumer.users.data.export');
        });
    };

    var readFilters = function() {
        var $form = $('.js-filter-form');

        return {
            term: $form.find("input[name='term']").val() || null
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
    ConsumerUsersAdminIndex.init();
});
