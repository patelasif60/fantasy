var AdminTeamsCreate = function() {
    var initFormValidations = function () {
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
                $('#create-button').attr('disabled',true);
                form.submit();
            }
        }));
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
            // minimumInputLength: 2
        });
    };

    return {
        init: function() {
            initFormValidations();
            initCrestImageUpload();
            initSelect2();
            initSelectCrestDefault();
            Global.select2Options({
                "options": [
                    {
                      "id": '#manager_id',
                      "placeholder": "Please select",
                      "minimumInputLength": 3,
                      "ajax" : {
                        url: route('admin.users.search'),
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
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminTeamsCreate.init();
});

var onCroperImageLoad = function() {

    $('#crest_id').val('').trigger('change');
}