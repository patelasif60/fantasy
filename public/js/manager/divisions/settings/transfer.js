var ManagerDivisionsUpdate = function() {

    var initFormValidations = function () {
        $('.js-division-update-form').validate(Global.buildValidateParams({
            rules: {
                'season_free_agent_transfer_limit': {
                    number: true,
                },
                'monthly_free_agent_transfer_limit': {
                    number: true,
                },
            },
            submitHandler: function(form) {
                form.submit();
                $(".btn-transfer-submit").attr("disabled", true);
            }
        }));
    };

    var initRoundCreate = function() {
        if(Site.isPostAuctionState) {

            $(".js-btn-manually-round-create").click(function () {
                $('.js-round-create-modal').modal('show');
            });

            $("#add-more-round-js").click(function () {

                Site.unprocessRoundCount++;
                if(Site.unprocessRoundCount >= 1) {
                    $("#add-more-round-js").attr("disabled", true);
                }

                var roundNumber = parseInt($(this).attr('data-round')) + 1;
                $(this).attr('data-round',roundNumber);

                var roundHtml = '<div class="round-js mt-2">'
                    +'<h5 class="text-muted">Round '+roundNumber+'</h5>'
                    +'<div class="row">'
                        +'<div class="form-group col-6">'
                            +'<label for="round_end_date">End date</label>'
                            +'<input type="text"'
                                +'class="form-control js-datetimepicker-modal"'
                                +'id="round_end_date"'
                                +'name="round_end_date[][]"'
                                +'placeholder="Round End Date"'
                                +'data-date-format="'+Site.dateFormat+'"'
                                +'data-autoclose="true"'
                                +'data-today-highlight="true"'
                                +'autocomplete="off" >'
                        +'</div>'
                        +'<div class="form-group col-6">'
                            +'<label for="round_start_date">End Time</label>'
                            +'<input  type="text"'
                                +'class="form-control js-timepicker"'
                                +'id="round_end_time"'
                                +'name="round_end_time[][]"'
                                +'placeholder="Round End time"'
                                +'data-autoclose="true"'
                                +'data-today-highlight="true"'
                                +'autocomplete="off"'
                                +'value="12:00:00">'
                        +'</div>'
                    +'</div>'
                +'</div>';

                initDateTimePicker('new',roundHtml);
            });

            initDateTimePicker();
        }
    }

    var initDateTimePicker = function(round, roundHtml) {

        if(round == 'new') {
            var lastDateVal = '';
            if($('#seal_bid_deadline_repeat').val() == Site.deadlineEveryMonth) {
                lastDateVal = moment($('.js-datetimepicker-modal:last').val(), "DD/MM/YYYY").add(1, 'M');
            } else if($('#seal_bid_deadline_repeat').val() == Site.deadlineFortNight) {
                lastDateVal = moment($('.js-datetimepicker-modal:last').val(), "DD/MM/YYYY").add(14, 'day');
            } else if($('#seal_bid_deadline_repeat').val() == Site.deadlineEveryWeek) {
                lastDateVal = moment($('.js-datetimepicker-modal:last').val(), "DD/MM/YYYY").add(7, 'day');
            } else {
                lastDateVal = moment($('.js-datetimepicker-modal:last').val(), "DD/MM/YYYY").add(1, 'day');
            }

            var lastDateStart = moment($('.js-datetimepicker-modal:last').val(), "DD/MM/YYYY").add(0, 'day');
            if(lastDateVal.isValid()) {
                var startdate = moment();
                $('.js-new-rounds-area').append(roundHtml);
                $('.js-datetimepicker-modal:last').datetimepicker({useCurrent: false, defaultDate: lastDateVal, minDate: lastDateStart});
            }

        } else {
            $('.js-datetimepicker-modal').datetimepicker();
        }

        $('.js-timepicker').datetimepicker({format: 'HH:mm:ss'});
    }

    var initSelect2 = function(){
        $('.js-select2').select2();
    }

    return {
        init: function() {
            initFormValidations();
            initRoundCreate();
            initSelect2();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionsUpdate.init();
});
