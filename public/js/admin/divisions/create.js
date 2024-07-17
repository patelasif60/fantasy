var AdminDivisionsCreate = function() {

    var initFormValidations = function () {
        $('.js-division-create-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    maxlength: 255
                },
                'chairman_id': {
                  required: {
                        depends: function(element) {
                            return $('#social_id').val() > 0 ? false : true;
                        }
                    }
                },
                'package_id': {
                    required: true,
                }
            }
        }));
    };

    return {
        init: function() {
            initFormValidations();
            Global.select2Options({
                "options": [
                    {
                      "id": '#chairman_id',
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
                    {
                      "id": '#co_chairman_id',
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
                    {
                      "id": '#parent_division_id',
                      "placeholder": "No parent division",
                      "allowClear": true
                    }
                  ],
            });
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminDivisionsCreate.init();
});
$(document).on('change', '#package_id', function () {
    if($('option:selected', this).data('league-type') == 'No'){
      $('#chairman_id').attr('disabled','disabled');
      $('#co_chairman_id').attr('disabled','disabled');
      $('#parent_division_id').attr('disabled','disabled');
      $('#social_id').val($('option:selected', this).data('default-id'));
      $('.chairman_id #select2-chairman_id-container').text($('option:selected', this).data('default-name'));
  }
    else{
      $('#chairman_id').removeAttr('disabled');
      $('#co_chairman_id').removeAttr('disabled');
      $('#parent_division_id').removeAttr('disabled'); 
      $('#social_id').val(0);
      $('.chairman_id  #select2-chairman_id-container').text('Please select');
    }
});