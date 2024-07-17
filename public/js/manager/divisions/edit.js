var ManagerDivisionEdit = function() {

    var initFormValidations = function () {
        $('.js-division-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    maxlength: 100
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

// Initialize when page loads
jQuery(function() {
    ManagerDivisionEdit.init();
    Global.select2Options();
});

$(document).ready(function(){
	$('div.modal').on('click', 'button.btn-create-division', function(){
		$('div.div-continer').hide();
		$('.division-create-league').show();
		$('button[data-dismiss="modal"]').trigger('click');
		$('form.js-create-division-form #package_id').val($('#modal_package_id').val());
	});
});

