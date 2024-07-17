var ManagerSelectPitch = function() {

    var initSelectPitchFormValidations = function () {
        $('.js-select-pitch-form').validate(Global.buildValidateParams({
            rules: {
                'pitch_id': {
                    required: true,
                },
            },
        }));
    };

    return {
        init: function() {
            initSelectPitchFormValidations();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerSelectPitch.init();
});