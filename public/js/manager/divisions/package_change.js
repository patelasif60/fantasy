var ChangePackage = function() {
    var selectPackage = function () {
        $('.js-select-package').on('click', function(e) {
            $('.js-select-package').removeClass('active');
            $(this).addClass('active');
            $(this).find("input:radio[name='package_id']").prop('checked', true);
        });
    };
    return {
        init: function() {
            selectPackage();
        }
    };
}();
// Initialize when page loads
jQuery(function() {
    ChangePackage.init();
});