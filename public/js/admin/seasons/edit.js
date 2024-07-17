var AdminSeasonsCreate = function() {
    var initFormValidations = function () {
        $('.js-season-edit-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                },
                'premier_api_id': {
                    required: true,
                },
                'facup_api_id': {
                    required: true,
                },
                'start_at': {
                    required: true,
                },
                'end_at': {
                    required: true,
                },
                'package_id': {
                    required: true,
                },
                'default_package_for_existing_user': {
                    required: true,
                },
                'available_packages[]': {
                    required: true,
                },
            },
        }));
    };

    var initFormValidationsRollover = function () {
        $('.js-season-rollover-form').validate(Global.buildValidateParams({
            rules: {
                'duplicate_from': {
                    required: true,
                },
            },
        }));
    }

    var manageDefaultPackages = function() {
        $('#available_packages').on('change', function(e) {
            var selectedPackages = $(this).select2('data');
            $('#default_package').empty().append('<option selected="selected" value="">Select Package</option>');
            $('#default_package_for_existing_user').empty().append('<option selected="selected" value="">Select Package</option>');
            $.each(selectedPackages, function(key, value) {
                if (!$('#default_package').find("option[value='" + value.id + "']").length) {
                    var data = {
                        id: value.id,
                        text: value.text
                    };
                    var newOption = new Option(data.text, data.id);
                    $('#default_package').append(newOption);
                }
                if (!$('#default_package_for_existing_user').find("option[value='" + value.id + "']").length) {
                    var data = {
                        id: value.id,
                        text: value.text
                    };
                    var newOption = new Option(data.text, data.id);
                    $('#default_package_for_existing_user').append(newOption);
                }
            });
        });
    };

    return {
        init: function() {
            initFormValidations();
            initFormValidationsRollover();
            Codebase.helpers(['datepicker']);
            Global.select2Options({
                "options": [
                    {
                      "id": '#duplicate_from',
                      "width":'100%',
                      "placeholder": "Please select"
                    },
                  ],
            });
            manageDefaultPackages();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminSeasonsCreate.init();
});
