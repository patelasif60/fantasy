$(document).ready(function() {
    $(document).ready(function() {
        let FooterHeight = $('.footer').outerHeight();
        $('.contact').css({ 'height': 'calc(100vh - ' + FooterHeight + 'px)' });
    });
});
