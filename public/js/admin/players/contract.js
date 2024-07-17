var AdminPlayersContractCreate = function() {

    var initFormValidations = function () {
        $('.js-player-contract-create-form').validate(Global.buildValidateParams({
            rules: {
                'position': {
                    required: true,
                },
                'start_date': {
                    required: true,
                },
                'club_id': {
                    required: true,
                }
            },
            submitHandler: function(form) {
                $.post({
                    url:$(form).attr('action'),
                    type:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        sweet.success('Congrats !',response.message).then((value)=>{
                            $('#modal-create-edit-box').modal('hide');
                            PlayersContractList.resetDatatable();
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
    var initSelect2 = function () {
        $form = $('.js-player-contract-create-form');
		$formselect = $form.find("select[name='club_id']");
        $formselect.css('width', '100%');

		$formselect = $form.find("select[name='position']");
        $formselect.css('width', '100%');

    };

    return {
        init: function() {
            initFormValidations();
            initSelect2();
            Codebase.helpers(['datepicker']);
            Global.select2Options({
                "options": [
                    {
                      "id": '#filter-club',
                      "placeholder": "Select a Club",
                      "allowClear": true
                    },
                    {
                      "id": '#filter-position',
                      "placeholder": "Select a Position",
                      "allowClear": true
                    }
                  ],
            });
        }
    };
}();

// Initialize when modal loads
$(document).on('show.bs.modal','#modal-create-edit-box',function(){
    AdminPlayersContractCreate.init();
});
