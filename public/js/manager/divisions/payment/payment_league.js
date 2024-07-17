var ManagerLeaguePayment = function() {
	
    var initMakePayment = function () {
        $('#makePayment').click(function() {
          Worldpay.submitTemplateForm();
        });
    };

    var buildWorldPayForm = function () {
    var $form = $('#paymentForm');
    var $clientKey = $form.attr('data-clientKey');

        Worldpay.useTemplateForm({
            'clientKey': $clientKey,
            'form': 'paymentForm',
            'saveButton':false,
            'paymentSection':'paymentSection',
            'display':'inline',
            'reusable': false,
            'callback': function(obj) {
                if (obj && obj.token) {
                    $('<input>').attr({
                        type : 'hidden',
                        id   : 'token',
                        name : 'token',
                        value: obj.token
                    }).appendTo('#paymentForm');
                    $('#paymentForm').submit();
                }
            }
        });
    };
    
    return {
        init: function() {
            initMakePayment();
            buildWorldPayForm();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerLeaguePayment.init();
});

