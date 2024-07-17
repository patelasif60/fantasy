var ManagerLeagueTeamSelection = function() {
    var $amount = parseFloat($("#selectPrize").val());
    var initCalculateAmount = function () {
        $('.js-league-team-selection-form .teams').each(function(){
            $(this).on('change', function() { 
                $price = parseFloat($(this).val());
                if($(this).is(':checked')){
                    $amount += $price;
                }
                else {
                    $amount -= $price;
                }
                
                $('#lblAmount').text($amount.toFixed(2));
                toggleDisabled();
            });
        });
    };

    var resetCheckboxes = function($checkbox) {
        $('.js-league-team-selection-form .teams').each(function(){
            $(this).prop('checked', false);
        });
        toggleDisabled();
    };
    
    var toggleDisabled = function() {
        var teamChecked = 0;

        $form = $('.js-league-team-selection-form');
        $form.find('.teams').each(function() { 
            teamChecked += $(this).is(":checked")?1:0;
        });
        (!teamChecked) ? $('#makePayment').attr('disabled','disabled'):$('#makePayment').removeAttr('disabled');
    };
    
    return {
        init: function() {
            toggleDisabled();
            //resetCheckboxes();
            initCalculateAmount();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerLeagueTeamSelection.init();
});

