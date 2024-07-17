var PrizePackSelection = function() {
    var selectPrizePack = function () {
        $('.js-select-prize-pack').on('click', function(e) {
            $('.js-select-prize-pack').removeClass('active');
            $(this).addClass('active');
            $(this).find("input:radio[name='prize_pack_id']").prop('checked', true);
            $('.js-prize-pack-done').attr('disabled', false);
        });
    };
    return {
        init: function() {
            selectPrizePack();
        }
    };
}();
// Initialize when page loads
jQuery(function() {
    PrizePackSelection.init();
});