var AdminDivisionTeamCreate = function() {
    var initFormValidation = function () {
        $('.js-divison-team-create-form').validate(Global.buildValidateParams({
            rules: {
                'team_id': {
                    required: true,
                },
                'season_id': {
                    required: true,
                },
                'email': {
                    required: true,
                }
            },
            submitHandler: function(form) {
                 $('#create-team-button').attr('disabled',true);
                $.post({
                    url:$(form).attr('action'),
                    type:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        sweet.success('Congrats !',response.message).then((value)=>{
                            $('#modal-create-edit-box').modal('toggle');
                            AdminDivisionTeamIndex.resetDatatable();
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

    var seasonChange = function() {
        $("#filter-season_id").val($('#filter-season option:selected').val());
    };

    var seasonChangeTeam = function() {
       $('#filter-season_id').on('change', function(e) {
            if($(this).val())
            {
                $.post({
                    url:route('admin.divisions.team.get', { division: Site.division_id, season: $(this).val()}),
                    dataType:'json',
                    data:{},
                    success:function(response){
                        $("#filter-team_id option").remove();
                        if(response.teams)
                        {
                            var teamOptions = [];
                            var options = {};
                                options.id = '';
                                options.text = 'Please select';
                                teamOptions.push(options);
                            $.each(response.teams, function(value, key) {
                                var options = {};
                                options.id = key.id;
                                options.text = key.name+' ('+key.consumer.user.first_name+' '+key.consumer.user.last_name+')';
                                teamOptions.push(options);
                            });

                            $("#filter-team_id").select2({
                              data: teamOptions,
                              allowClear: true,
                              placeholder: 'Please select'
                            });

                        }
                    }
                }).fail(function(response) {
                    console.log(response); 
                });
            }else{
                $("#filter-team_id option").remove();
            }
            
        });
    };

    var initCrestImageUpload = function() {
        $('#crest').fileuploader(Global.buildImageCropParams());
    }


    var crest_template = function(option) {

        if(option.text == 'Please select')
            return option.text;
        else {

            var imgUrl = '';
            if(typeof(option.element) == 'object') {
                imgUrl = '<img style="width:20px;" class="mb-1" src="' + option.element.dataset.img + '"> ';
            }

            return imgUrl + option.text;
        }
    }

    var initSelectCrestDefault = function() {
        $('#crest_id').on('select2:select', function (e) {
          var api = $.fileuploader.getInstance('#crest');
            if(!api.isEmpty()) {
                api.remove(api.getFileList()[0]);
            }
        });
    }

    var initSelect2 = function () {
        $form = $('.js-team-create-form');
        $form.find("select[name='crest_id']").select2({
            templateSelection: crest_template,
            templateResult: crest_template,
            escapeMarkup: function(m) { return m; }
        });
        $form.find("select[name='manager_id']").select2({
            allowClear: true,
            placeholder: 'Please select',
            minimumInputLength: 2
        });
    };

    return {
        init: function() {
            initFormValidation();
            initCrestImageUpload();
            seasonChange();
            seasonChangeTeam();
            Global.select2Options();
            initSelect2();
            initSelectCrestDefault();
        }
    };
}();

// Initialize when modal loads
$(document).on('show.bs.modal','#modal-create-edit-box',function(){
    AdminDivisionTeamCreate.init();
});

var createTeamFormValidation = function () {
    $('.js-team-create-form').validate(Global.buildValidateParams({
        rules: {
            'name': {
                required: true,
            },
            'crest_id': {
                required: function(element) {
                    return $("input[name='fileuploader-list-crest']").val() === '' || $("input[name='fileuploader-list-crest']").val() == '[]';
                }
            },
            'fileuploader-list-crest': {
                required: function(element) {
                    return $("#crest_id").val() === "";
                }
            },
            'manager_id': {
                required: true,
            },
            'division_id': {
                required: true,
            }
        },
        messages: {
            'crest_id': {
                required: "Select team badge or upload your own badge",
            },
            'fileuploader-list-crest': {
                required: "Select team badge or upload your own badge",
            }
        },
        submitHandler: function(form) {
            $('#create-new-team-button').attr('disabled',true);
            var data = new FormData(form);
            $.post({
                url:$(form).attr('action'),
                type:$(form).attr('method'),
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success:function(response){
                    sweet.success('Congrats !',response.message).then((value)=>{
                        $('#modal_create_team_box').modal('toggle');
                        $('.js-team-create-form').find("input[type=text], select[name=manager_id], select[name=pitch_id], select[name=crest_id], hidden").val("");
                        $('#create-new-team-button').attr('disabled', false);
                        var api = $.fileuploader.getInstance('#crest');
                        if(!api.isEmpty()) {
                            api.remove(api.getFileList()[0]);
                        }
                        $(".fileuploader-theme-thumbnails").find("input[name=fileuploader-list-crest]").remove();
                        $(".fileuploader-theme-thumbnails").find("div.fileuploader-items").remove();
                        AdminDivisionTeamIndex.resetDatatable();
                    });
                }
            }).fail(function(response) {
                if(typeof response.responseJSON.errors != 'undefined' ){
                     $('#create-new-team-button').removeAttr('disabled');
                    sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
                }
            });
        }
    }));
};

$(document).on("click",".js-modal-create-team-box",function() {
    $('#modal-create-edit-box').modal('hide');
    $('#modal_create_team_box').modal('show');
    createTeamFormValidation();
});
