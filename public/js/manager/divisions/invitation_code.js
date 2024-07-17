var ManagerDivisionSearchByCode = function() {

    var initFormValidations = function () {
        $('.js-invitation-code-form').validate(Global.buildValidateParams({
            rules: {
                'invitation_code': {
                    required: true,
                    maxlength: 6,
                    minlength: 6,
                    remote: {
                        url: route('manager.league.check.by.code'),
                        type: "post",
                    }
                },
            },
            messages: {
                invitation_code: {
                    remote: "League with provided code does not exist."
                }
            }
        }));
    };

    return {
        init: function() {
            initFormValidations();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionSearchByCode.init();
});

$(document).ready(function() {

    // $("#searchLeague").on("click", function() {
    //     if($('.js-invitation-code-form').valid())
    //     {
    //         // $('form.js-invitation-code-form').submit();
    //     }
    // })

});

function submitDivision()
{
    $.ajax({
        url: $('form.js-invitation-code-form').attr('action'),
        type: 'POST',
        data: $('form.js-invitation-code-form').serialize(),
        success:function(response){
            if(response.success)
            {
                alert('Success ... ');
                window.location = route('manager.home.index');               
            } 
            else
            {
                alert('Error ... ' + response.message);
            }
        }
    });
}
