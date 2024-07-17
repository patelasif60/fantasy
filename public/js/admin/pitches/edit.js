var AdminPitchesCreate = function() {
    var initFormValidations = function () {
        $('.js-pitch-edit-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    remote: {
                        url: route('admin.unique.pitch.check'),
                        type: "post",
                        data: {
                            name: function()
                            {
                                return $("#name").val();
                            },
                            id: function()
                            {
                                return $("#pitch_id").val();
                            }
                        }
                    }
                }
            },
            messages: {
                name: {
                    remote: "Pitch with provided name already exist."
                }
            }
        }));
    };

    var initCrestImageUpload = function() {
        $('#crest').fileuploader(Global.buildImageCropParams({
             ratio: '180:263',
            minWidth: 1080,
            minHeight: 1578,
            showGrid: true
        }));
    }
    return {
        init: function() {
            initFormValidations();
            initCrestImageUpload();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminPitchesCreate.init();
});
