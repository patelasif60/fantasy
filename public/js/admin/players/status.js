var AdminPlayerStatusCreate = function() {

    var initFormValidations = function () {
        $('.js-player-status-create-form').validate(Global.buildValidateParams({
            rules: {
                'status': {
                    required: true,
                },
                'start_date': {
                    required: true,
                },
            },
            submitHandler: function(form) {
                $.post({
                    url:$(form).attr('action'),
                    type:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        sweet.success('Congrats !',response.message).then((value)=>{
                            $('#modal-create-edit-box').modal('hide');
                            PlayersStatusList.resetDatatable();
                        });   
                    }
                }).fail(function(response) {
					if(typeof response.responseJSON.errors != 'undefined' ){
						sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
					}  
                });
            }
        }));
    };
    var initSelect = function () {
        $form = $('.js-player-status-create-form');
        $formselect = $form.find("select[name='status']");
        $formselect.css('width', '100%');
    };
    var statusOnChange = function(){
        $form = $('.js-player-status-create-form');
        $formselect = $form.find("select[name='status']");
        $formselect.on('change',function(){
            if($.inArray($formselect.select2('val'),Site.not_end_date) != -1){
                $form.find("input[name='end_date']").val('');
                $form.find("input[name='end_date']").prop('disabled',true);
            }
            else{
                $form.find("input[name='end_date']").prop('disabled',false);
                $form.find("input[name='end_date']").val($form.find("input[name='end_date']").data('value'));
            }
        })
    };

    return {
        init: function() {
            initFormValidations();
            initSelect();
            statusOnChange();
            Global.select2Options({
                "options": [
                    {
                      "id": '#filter-status',
                      "placeholder": "Select a Status type",
                      'allowClear': true,
                    }
                  ],
            });
        }
    };
}();

// Initialize when modal loads
$(document).on('show.bs.modal','#modal-create-edit-box',function(){
    AdminPlayerStatusCreate.init();
});
