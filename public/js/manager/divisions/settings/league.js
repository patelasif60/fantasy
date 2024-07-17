var ManagerDivisionsUpdate = function() {

    var initFormValidations = function () {
        $('.js-division-update-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    maxlength: 255
                },
                'package_id': {
                    required: true,
                }
            }
        }));
    };

    var initSelect2 = function(){
        $('.js-select2').select2();
    }

    var initSummernote = function(){
        $('.js-summernote').summernote({
            height:150,
            tooltip:false,
            toolbar: []
            });
    };

    var initChairmanDropDown = function() {

        $(document).on('change', '#chairman_id', function () {
            $('#co_chairman_id').val(null).trigger('change');
            $("#co_chairman_id option[data-id=" + $('option:selected', this).attr('data-id') + "]").attr('disabled','disabled');
            $("#co_chairman_id option[data-id=" + $(this).attr('data-prev-id') + "]").removeAttr('disabled');
            $(this).attr('data-prev-id',$('option:selected', this).attr('data-id'));
            $('.js-co_chairman').select2();
        });
    };

    return {
        init: function() {
            initFormValidations();
            initSelect2();
            initSummernote();
            initChairmanDropDown();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionsUpdate.init();
});