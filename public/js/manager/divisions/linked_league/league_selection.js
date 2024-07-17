var ManagerLeagueSelection = function() {
    
    var toggleDisabled = function() {
        var checked = 1;

        $('.leagueId').click(function() { 

            if(!$('.leagueId:checked').length){

                $('#linkedLeague').attr('disabled','disabled');

            }else{

                $('#linkedLeague').removeAttr('disabled');

            }
        });
    };
    
    return {
        init: function() {
            toggleDisabled();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerLeagueSelection.init();
});

