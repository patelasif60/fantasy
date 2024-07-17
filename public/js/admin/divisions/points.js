var AdminDivisionsPoints = function() {

    var initRecalculatePoints = function () {
       $('#recalculate-points').on('click',function(){
            var athis =  $(this);
            athis.prop('disabled', true);
            $url = $(this).attr("data-url");
            $.post({
                url:$url,
                type:$('.js-division-edit-form').attr('method'),
                success:function(response) {
                    sweet.success('Congrats !',response.message);
                    athis.prop('disabled', false);
                }
            }).fail(function(response) {
                if(typeof response.responseJSON.errors != 'undefined' ){
                    sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
                }  
                athis.prop('disabled', false);
            });
        });
    };

    return {
        init: function() {
            initRecalculatePoints();
            
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminDivisionsPoints.init();
});