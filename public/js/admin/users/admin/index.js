var AdminUsersAdminIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        adminUsersDatatable = $('table.admin-users-list-table').DataTable({
            ajax: {
                url: $('table.admin-users-list-table').data('url'),
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
                    data: 'role',
                    title: 'Role',
                    name: 'role'
                },
                {
                    data: 'status',
                    title: 'Status',
                    name: 'status',
                    render: function(data) {
                        if(data === Site.status['ACTIVE']) {
                            return '<span class="badge badge-success">'+data+'</span>';
                        } else {
                            return '<span class="badge badge-danger">'+data+'</span>';
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
                        return Global.buildEditAction(route('admin.users.admin.edit', { user: data })) +
                            Global.buildDeleteAction(route('admin.users.admin.destroy', { user: data }));
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            adminUsersDatatable.draw();
        });
    };

    var initSelect2 = function () {
        $('.js-filter-form').find("select[name='role']").select2({
            allowClear: true,
            placeholder: 'Select user type'
        })
    };

    var readFilters = function() {
        var $form = $('.js-filter-form');

        return {
            role: $form.find("select[name='role']").val() || null,
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
    AdminUsersAdminIndex.init();
});
