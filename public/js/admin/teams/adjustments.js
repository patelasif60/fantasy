var AdminTeamsAdjustmentsList = function() {
    var initDataTable = function () {
        Global.configureDataTables();
        $('table.point-adjustments-list-table').DataTable({
            dom: '<"top"><"row"<"col-xl-12 d-flex justify-content-end"rf>><"table-responsive"t><"row"<"col-sm-3"i><"col-sm-6 text-center mt-10"l><"col-sm-3"p>>',
            autoWidth:false,
            ajax: {
                url: $('table.point-adjustments-list-table').data('url'),
                method: 'post',
            },
            columns: [
                {
                    data: 'points',
                    title: "Points (+/-)",
                    name: 'points'
                },
                {
                    data: 'note',
                    title: "Note",
                    name: 'note'
                },
                {
                    data: 'competition_type',
                    title: 'Competition',
                    name: 'competition_type',
                },
                {
                    data: 'id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        return $('<button/>', {
                            href: route('admin.point.adjustments.destroy', { adjustment: data }),
                            html: '<i class="fa fa-trash"></i>',
                            title: 'Delete',
                            class: 'btn btn-circle btn-outline-danger btn-noborder mr-5 mb-5 delete-point-adjustment',
                        }).wrap('div').parent().html();
                    }
                }
            ],
        });
    };

    return {
        init: function () {
            initDataTable();
        }
    }
}();

var AdminPointAdjustmentValidation = function() {
    jQuery.validator.addMethod("onlyNumberWithSign", function(value, element) {
        return /^[-+]?\d{1,5}$/.test(value);
    }, "* Numbers only please");

    var initFormValidations = function () {
        $('.js-point-adjustments-create-form').validate(Global.buildValidateParams({
            rules: {
                'points': {
                    required: true,
                    onlyNumberWithSign: true,
                },
                'note': {
                    required: true,
                },
            },
        }));
    };
    return {
        init: function() {
            initFormValidations();
        }
    };
}();

$(document).on('click','.show_create_edit_within_modal',function(){
    var url = $(this).attr('href');
    $.get({
        url:url,
        success:function(response){
            $('#modal-create-edit-box').html(response);
            AdminPointAdjustmentValidation.init();
            Codebase.helpers(['select2']);
        }
    });
});

$(document).on('click','button.btn-submit-point-adjustment',function(){
	var form = $('form.js-point-adjustments-create-form');
    if($('form.js-point-adjustments-create-form').valid())
    {
        $.post({
            url:form.attr('action'),
            data: form.serialize(),
            success:function(response){
                sweet.success('Congrats !',response.message);
                $('button.show-point-adjustments-table').trigger('click');
            }
        });
    }
});

$(document).on('click','button.show-point-adjustments-table',function(){
    var url = $(this).attr('href');
    $.get({
        url:url,
        success:function(response){
            $('#modal-create-edit-box').html(response);
            $('#modal-create-edit-box').modal('show');
            AdminTeamsAdjustmentsList.init();
        }
    });
});

$(document).on('click','button.btn-show-point-adjustments-list',function(){
    $('button.show-point-adjustments-table').trigger('click');
});

$(document).on('click','button.delete-point-adjustment',function(){
    var deleteUrl = $(this).attr('href');
    var deleteBtn = $(this);
    sweet.alert({
        title: 'Are you sure?',
        text: 'This information will be permanently deleted!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        html: false,
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: '_method=DELETE',
                success:function(response){
                    if(response.success){
                        sweet.success('Congrats !',response.message);
                        $(deleteBtn).parent().parent().remove();
                        $('table.point-adjustments-list-table').DataTable().ajax.reload();
                    } else {
                        sweet.error('Error !', response.message);
                    }
                }
            });
        }
    });

});