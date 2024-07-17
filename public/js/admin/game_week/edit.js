var AdminGameWeeksEdit = function() {
    var initFormValidations = function () {
        $('.js-game-week-form-edit').validate(Global.buildValidateParams({
            rules: {
                'number': {
                    required: true,
                    number:true,
                },
                'start': {
                    required: true,
                },
                'end': {
                    required: true,
                },
            },
        }));
    };

    var gameWeekEdit = function () {
        $(document).on("click",".js-button-gameweek-edit",function() {
            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                dataType: 'html',
            })
            .done(function(response) {
                $('#modal_game_week_edit').html(response);
                $("#modal_game_week_edit").modal('show');
                Codebase.helpers(['datepicker']);
                $(".js-select2").select2({ width: '100%' });
                initFormValidations();
            })
            .fail(function(error) {
            });
        });
    };

    return {
        init: function() {
            gameWeekEdit();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminGameWeeksEdit.init();
});
