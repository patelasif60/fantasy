var AdminTeamsIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        TeamsDatatable = $('table.admin-teams-list-table').DataTable({
            ajax: {
                url: $('table.admin-teams-list-table').data('url'),
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
                    data: 'name',
                    title: "Team Name",
                    name: 'name'
                },
                {
                    data: 'manager',
                    title: "Manager",
                    name: 'manager'
                },
                {
                    data: 'division',
                    title: "Division",
                    name: 'division'
                },
                {
                    data: 'status',
                    title: "Status",
                    name: 'status'
                },

                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data,type, row, meta) {
                        var actions = '';
                        if(row.paidStatus){
                            actions = buildPaidAction(route('admin.teams.mark.paid.to.unpaid', { team: data }));
                        }
                        if(row.isUnpaid) {
                            actions = buildUnPaidToPaidAction(route('admin.teams.mark.unpaid.to.paid', { team: data }));   
                        }
                        return actions +
                            Global.buildEditAction(route('admin.teams.edit', { team: data })) +
                            Global.buildDeleteAction(route('admin.teams.destroy', { team: data }));
                    }
                }
            ],
        });
    };

    var initFilters = function () {
        $('.js-filter-form').on('submit', function(e) {
            e.preventDefault();
            TeamsDatatable.draw();
        });
    };


    var readFilters = function() {
        var $form = $('.js-filter-form');
        return {
            name: $form.find("input[name='name']").val() || null,
            manager_id: $form.find("select[name='manager_id']").val() || null,
            division_id: $form.find("select[name='division_id']").val() || null,
        };
    };

    var initSelect2 = function () {
        $form = $('.js-filter-form');
        $form.find("select[name='division_id']").select2({
            allowClear: true,
            placeholder: 'Please select'
        });
        $form.find("select[name='status']").select2({
            allowClear: true,
            placeholder: 'Please select'
        });
        $form.find("select[name='manager_id']").select2({
            allowClear: true,
            placeholder: 'Please select',
            // minimumInputLength: 3
        });
    };

    var buildPaidAction = function(link) {
        return $('<a/>', {
            html: '<i class="fal fa-fw fa-money-bill-alt"></i>',
            href: link || 'javascript:void(0)',
            title: 'Mark as Unpaid',
            class: 'btn btn-sm btn-circle btn-alt-info mr-5 mb-5 unpaid-confirmation-button',
        }).wrap('div').parent().html();
    };

    var buildUnPaidToPaidAction = function(link) {
        return $('<a/>', {
            html: '<i class="fal fa-fw fa-money-bill-alt"></i>',
            href: link || 'javascript:void(0)',
            title: 'Mark as Paid',
            class: 'btn btn-sm btn-circle btn-alt-info mr-5 mb-5 paid-confirmation-button btn-alt-danger',
        }).wrap('div').parent().html();
    };

    var initConfirmationOnUnPaid = function() {
        $('body').on('click', '.unpaid-confirmation-button', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            sweet.alert({
                title: 'Are you sure?',
                text: 'Team payment will be marked as unpaid.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ok',
                html: false,
            }).then(function(result) {
                if (result.value) {
                    submitPaidResourceForm(url);
                }
            });
        });
    };

    var initConfirmationOnPaid = function() {
        $('body').on('click', '.paid-confirmation-button', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            sweet.alert({
                title: 'Are you sure?',
                text: 'Team payment will be marked as paid.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ok',
                html: false,
            }).then(function(result) {
                if (result.value) {
                    submitPaidResourceForm(url);
                }
            });
        });
    };

    var submitPaidResourceForm = function(url) {
        $('<form>', {
            'method': 'GET',
            'action': url,
            'target': '_top'
        })
        .append($('<input>', {
            'name': '_token',
            'value': $('meta[name="csrf-token"]').attr('content'),
            'type': 'hidden'
        }))
        .hide().appendTo("body").submit();
    }

    return {
        init: function () {
            initDataTable();
            initFilters();
            initSelect2();
            initConfirmationOnPaid();
            initConfirmationOnUnPaid();
            Global.select2Options({
                "options": [
                    {
                      "id": '#manager_id',
                      "placeholder": "Please select",
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
                  ],
            });
            Global.select2Options({
                "options": [
                    {
                      "id": '#division_id',
                      "placeholder": "Please select",
                      "minimumInputLength": 3,
                      "ajax" : {
                        url: route('admin.divisions.searchDivisions'),
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
                  ],
            });
        }
    }
}();

// Initialize when page loads
jQuery(function() {
    AdminTeamsIndex.init();
});
