var AdminTeamTransferCreate = function() {
    var initFormValidation = function () {
        
        $('.js-team-transfer-create-form').validate(Global.buildValidateParams({
            rules: {
                'player_in': {
                    required: {
                        depends: function(element) {
                                    return ($("#filter-player_in").val() != Site.budgetCorrection);
                                }
                    }
                },
                'transfer_type': {
                    required: true,
                },
                'transfer_value': {
                    required: true,
                    number: true
                },
                'transfer_date': {
                    required: true,
                }
            },
            submitHandler: function(form) {
               $('#create-transfer-button').attr('disabled',true);
                $.post({
                    url:$(form).attr('action'),
                    type:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        sweet.success('Congrats !',response.message).then((value)=>{
                            $('#modal-create-edit-box').modal('toggle');
                            AdminTeamTransferIndex.resetDatatable();
                        });                       
                    }
                }).fail(function(response) {
                    $('#create-transfer-button').attr('disabled',false);
                    if(typeof response.responseJSON.errors != 'undefined' ){
                        sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
                    }  
                });
            }
        }));
    };

    var initSelect2 = function () {
        $form = $('.js-team-transfer-create-form');
        $form.find("select[name='player_in']").select2({
            allowClear: true,
            placeholder: 'Please select'
        });
        $form.find("select[name='player_out']").select2({
            allowClear: true,
            placeholder: 'Please select'
        });
        $form.find("select[name='transfer_type']").select2({
            allowClear: true,
            placeholder: 'Please select'
        });
        
    };

    var initDTpicker = function(){
        $form = $('.js-team-transfer-create-form');
        $form.find("input[name='transfer_date']").datetimepicker();
    }

    
    var transferTypeChange = function() {
       $('#filter-transfer_type').on('change', function(e) {
            $("#filter-player_in option").remove();
            $("#filter-player_out option").remove();
            var self = $(this);
            if(self.val())
            {
                if(self.val() == Site.budgetCorrection)
                {
                   $("#label-player-in").removeClass('required');
                   $("#filter-player_in").attr('disabled',true);
                   $("#filter-player_out").attr('disabled',true);
                }else{
                   $("#label-player-in").addClass('required');
                   $("#filter-player_in").attr('disabled',false);
                   $("#filter-player_out").attr('disabled',false);

                    $.post({
                        url:route('admin.transfer.player.get', { team: $('#team_id').val()}),
                        dataType:'json',
                        data:{ auction_type: self.val()},
                        success:function(response){
                            var playersIn = [];
                            var playersOut = [];
                    
                            if(self.val() == Site.substitution || self.val() == Site.superSub)
                            {
                                //With iin team transfer
                                var options = {};
                                    options.id = '';
                                    options.text = 'Please select';
                                    playersIn.push(options);
                                    playersOut.push(options);
                                $.each(response.playersOut, function(value, key) {
                                    var options = {};
                                    if(key.is_active)
                                    {
                                        options.id = key.player_id;
                                        options.text = key.first_name+' '+key.last_name+' ('+key.name+' - '+Global.shortPlayerPosition(key.position)+')';
                                        playersOut.push(options);
                                    }else{
                                        options.id = key.player_id;
                                        options.text = key.first_name+' '+key.last_name+' ('+key.name+' - '+Global.shortPlayerPosition(key.position)+')';
                                        playersIn.push(options);
                                    }
                                });
                                
                                $("#filter-player_in").select2({
                                  data: playersIn,
                                  allowClear: true,
                                  placeholder: 'Please select'
                                });

                                $("#filter-player_out").select2({
                                  data: playersOut,
                                  allowClear: true,
                                  placeholder: 'Please select'
                                });

                            }else{
                                //Outside team transfer
                                var options = {};
                                    options.id = '';
                                    options.text = 'Please select';
                                    playersIn.push(options);
                                    playersOut.push(options);
                                $.each(response.playersIn, function(value, key) {
                                    var options = {};
                                    options.id = key.player_id;
                                    options.text = key.first_name+' '+key.last_name+' ('+key.name+' - '+Global.shortPlayerPosition(key.position)+')';
                                    playersIn.push(options);
                                });

                                $("#filter-player_in").select2({
                                  data: playersIn,
                                  allowClear: true,
                                  placeholder: 'Please select'
                                });

                               
                                $.each(response.playersOut, function(value, key) {
                                    var options = {};
                                    options.id = key.player_id;
                                    options.text = key.first_name+' '+key.last_name+' ('+key.name+' - '+Global.shortPlayerPosition(key.position)+')';
                                    playersOut.push(options);
                                });

                                $("#filter-player_out").select2({
                                  data: playersOut,
                                  allowClear: true,
                                  placeholder: 'Please select'
                                });
                            } 
                        }

                    }).fail(function(response) {
                        console.log(response); 
                    }); 
                }   
            }
        });
    };

    return {
        init: function() {
            transferTypeChange();
            initFormValidation();
            initDTpicker();
            Codebase.helpers(['core-tab']);
            Global.select2Options({
                "options": [
                    {
                      "id": '#filter-player_in',
                      "placeholder": "Please select",
                      "allowClear": true
                    },
                    {
                      "id": '#filter-player_out',
                      "placeholder": "Please select",
                      "allowClear": true
                    },
                    {
                      "id": '#filter-transfer_type',
                      "placeholder": "Please select",
                      "allowClear": true
                    }
                  ],
            });
        }
    };
}();

// Initialize when modal loads
$(document).on('show.bs.modal','#modal-create-edit-box',function(){
    AdminTeamTransferCreate.init();
});