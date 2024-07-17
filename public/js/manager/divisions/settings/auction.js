var UNPROCESSROUND = Site.UNPROCESSROUND;
var ManagerDivisionsUpdate = function() {

    var initFormValidations = function () {
        $('.js-division-update-form').validate(Global.buildValidateParams({
            rules: {
                'pre_season_auction_budget': {
                    number: true,
                    min: 0,
                    max: 1000
                },
                'pre_season_auction_bid_increment': {
                    number: true,
                    min: 0,
                    max: 10
                },
                'auction_date' : {
                    required : true
                },
                'auction_time' : {
                    required : true
                },
            }
        }));

        $('.auction-types-js').change(function(){

            if(Site.SEALBID_FEATURE_LIVE == 'true') {
                $('#auction_date').val('');
                $('#auction_date').data('DateTimePicker').date(null);
                manageAuctionType();

            } else {

                if($(this).val() == "Online sealed bids") {
                    $("#auctionModal").modal("show");
                    $(this).val(Site.AUCTION_TYPE);
                } else {
                    $('#auction_date').val('');
                    $('#auction_date').data('DateTimePicker').date(null);
                    manageAuctionType();
                }
            }
        });
        $('.allow-passing-on-nominations-js').change(function(){
            if($(this).prop("checked")){
                $('.remote-bidding-time-limit-js').removeClass('d-none');
            }else
            {
                $('.remote-bidding-time-limit-js').addClass('d-none');
            }
        });

        $('#add-more-round-js').click(function() {

        	var round = '<div class="round-js" data-new="1"><span>Round '+( $('.round-js').length + 1)+'</span><div class="row"><div class="form-group col-6"> <label for="auction_date">End date</label> <div class="row gutters-sm"> <input type="text" class="form-control js-datetimepicker-modal" id="auction_date" name="round_end_date[][]" placeholder="Round End Date" data-date-format="'+Site.DATEPICKER+'" data-autoclose="true" data-today-highlight="true" autocomplete="off" value=""> </div> </div>  <div class="form-group col-6"> <label for="round_end_time">End Time</label><div class="row gutters-sm"><input  type="text" class="form-control js-timepicker" id="round_end_time" name="round_end_time[][]" placeholder="Round End time" data-autoclose="true" data-today-highlight="true" autocomplete="off"value="12:00:00"></div></div></div></div>';
            var lastDateVal = moment($('.js-datetimepicker-modal:last').val(), "DD/MM/YYYY").add(1, 'day');
            var lastDateStart = moment($('.js-datetimepicker-modal:last').val(), "DD/MM/YYYY").add(0, 'day');
            if(lastDateVal.isValid()) {
                $('.round-group-js').append(round);
                var startdate = moment();
            	//startdate = startdate.subtract(1, "days");
                $('.js-datetimepicker-modal:last').datetimepicker({useCurrent: false, defaultDate: lastDateVal, minDate: lastDateStart});
                $('.js-timepicker:last').datetimepicker({format: 'HH:mm:ss'});
            }

            // var round = '<div class="round-js mb-4"><h5 class="text-muted">Round '+( $('.round-js').length + 1)+'</h5><div class="row"><div class="form-group col-6"> <label for="auction_date">End date</label><input type="text" class="form-control js-datetimepicker-modal" id="auction_date" name="round_end_date[][]" placeholder="Round End Date" data-date-format="'+Site.DATEPICKER+'" data-autoclose="true" data-today-highlight="true" autocomplete="off" value=""> </div>  <div class="form-group col-6"> <label for="round_end_time">End Time</label><input  type="text" class="form-control js-timepicker" id="round_end_time" name="round_end_time[][]" placeholder="Round End time" data-autoclose="true" data-today-highlight="true" autocomplete="off"value="12:00:00"></div></div></div>';
            // $('.round-group-js').append(round);
            // var startdate = moment();
            // //startdate = startdate.subtract(1, "days");
            // $('.js-datetimepicker-modal:last').datetimepicker({useCurrent: false});
            // $('.js-timepicker:last').datetimepicker({format: 'HH:mm:ss'});

        });
    };
    
    var initModelpicker = function(){
        var startdate = moment();
        $('.js-datetimepicker-modal').datetimepicker({useCurrent: false, widgetPositioning: {vertical: "bottom", horizontal: "right"}});

    	$(document).on("dp.change", ".js-datetimepicker-modal", function(e) {
            var count = 0;
			var index = $(".js-datetimepicker-modal").index(this);
            var timeIndex = $(".js-timepicker").index(this);

             var eventDate = e.date;
			 $('.js-datetimepicker-modal').each(function() {
				if(index < count) {

                    // var nextdate = moment(eventDate.add(1, 'day').format("DD/MM/YYYY"), "DD/MM/YYYY");
                    // $('.main-round-group-js .js-datetimepicker-modal').eq(count).data("DateTimePicker").destroy();
                    // $('.main-round-group-js .js-datetimepicker-modal').eq(count).datetimepicker({useCurrent: false, defaultDate: nextdate, minDate: nextdate});
                    // $('.js-datetimepicker-modal').eq(count).val(nextdate.format("DD/MM/YYYY"));

                    // $('.js-datetimepicker-modal').eq(count).val(nextdate.format("DD/MM/YYYY"));
				}
				count++;
			});
	    });
    }
    var initDTpicker = function(){
    	// var startdate = moment();
    	//startdate = startdate.subtract(1, "days");
        $('.js-datetimepicker').datetimepicker().on('dp.change', function (e) {
		 	if($(this).hasClass('js-schedule-round')) {
    			endDate = e.date.add(1, 'day');
    			startDate = moment($(this).val(), "DD/MM/YYYY");
                setStartEndDate(startDate, endDate);
                $(".js-bidding-round").attr('data-toggle','modal');
    		}
	 	});

        setTimeout(function() {
            if($('#round_start_date').val() && $('#round_end_date').val()) {
                var startDate = moment($('#round_start_date').val(), "DD/MM/YYYY");
                var endDate = moment($('#round_end_date').val(), "DD/MM/YYYY");
                setStartEndDate(startDate, endDate);
            }
        }, 500)
    }

    function setStartEndDate(startDate, endDate) {
        $('#round_start_date').data("DateTimePicker").destroy();
        $("#round_start_date").datetimepicker({useCurrent: false, defaultDate: startDate, minDate: startDate, widgetPositioning: {vertical: "bottom"}});
        $("#round_start_date").val(startDate.format("DD/MM/YYYY"));

        $('#round_end_date').data("DateTimePicker").destroy();
        $("#round_end_date").datetimepicker({useCurrent: false, defaultDate: endDate, minDate: startDate, widgetPositioning: {vertical: "bottom"}});
        $("#round_end_date").val(endDate.format("DD/MM/YYYY"));
    }

    var initSelect2 = function(){
        $('.js-select2').select2();
    }
    var initTimepicker = function(){
        $('.js-timepicker').datetimepicker({format: 'HH:mm:ss'});
        $(document).on("dp.change", ".js-timepicker", function(e) {
            var count=0;
            var timeValue = $(this).val();
            var timeIndex = $(".js-timepicker").index(this);
            var eventDate = timeIndex;
            $('.js-timepicker').each(function(){
                if(timeIndex < count)
                {
                      $('.js-timepicker').eq(count).val(timeValue);
                }
                if(timeIndex==0 && count==2)
                {
                    return;
                }
                count++;
            });
        });
    }
    function manageAuctionType()
    {
        $('.live-online-auction-js, .online-sealed-bids-js, .live-offline-js').addClass('d-none');
        //$('.auction-venue-js').removeClass('d-none');
        if($('.auction-types-js option:selected').val() == Site.LIVE_ONLINE_AUCTION)
        {
            $('.live-online-auction-js').removeClass('d-none');
            $('#auction_date').removeClass('js-schedule-round');
            $('#auction_venue').removeAttr('disabled')
            $('#auction_date_label').text('Auction date');
        }else if ($('.auction-types-js option:selected').val() == Site.ONLINE_SEALED_BIDS_AUCTION)
        {
            $('.online-sealed-bids-js').removeClass('d-none');
            $('#auction_date_label').text('Auction start date');
            $('#auction_venue').attr('disabled', 'disabled')
            if($("#js-round").val()<= 0)
            {
            	$('#auction_date').addClass('js-schedule-round');
            }
        }else if ($('.auction-types-js option:selected').val() == Site.OFFLINE_AUCTION)
        {
            $('#auction_date_label').text('Auction date');
            $('.live-offline-js').removeClass('d-none');
            $('#auction_date').removeClass('js-schedule-round');
            $('#auction_venue').removeAttr('disabled')
        }
    }

    manageAuctionType();

    return {
        init: function() {
            initFormValidations();
            initDTpicker();
            initSelect2();
            initModelpicker();
            initTimepicker();
        }
    };
}();
// Initialize when page loads
jQuery(function() {
    ManagerDivisionsUpdate.init();
});
