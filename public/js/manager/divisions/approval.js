function approve(dataUrl, element)
{
    var id = element.data('id');
    $.ajax({
        url: dataUrl,
        type: 'GET',
        beforeSend:function(response){
            $('.js-action-' + id+' .js-approve').html('<i class="fa fa-spinner fa-spin"></i>');
            $('.js-approve').addClass('disabled');
            $('.js-ignore').addClass('disabled');
        },
        error:function(response){
            $('.js-action-' + id+' .js-approve').html('Approve');
            $('.js-approve').removeClass('disabled');
            $('.js-ignore').removeClass('disabled');
        },
        success:function(response){
            $('.js-action-' + id+' a').text('Approve');
            $('.js-approve').removeClass('disabled');
            $('.js-ignore').removeClass('disabled');

            if (response.redirect) {
                window.location.replace(response.redirect);
            }
            if(response.success)
            {
                $('.js-msg-' + id).find('span').text('Approved');
                $('.js-msg-' + id).find('i').removeClass('fa-times text-danger').addClass('fa-check-circle text-primary');
                $('.js-msg-' + id).show();
                $('.js-action-' + id).hide();
            }
        }
    });
}

var ignoreUrl = '';
var ignoreElement = '';
function ignore(dataUrl, element)
{
    var id = element.data('id');
    $.ajax({
        url: dataUrl,
        type: 'GET',
        beforeSend:function(response){
            $('.js-action-' + id+' .js-ignore').html('<i class="fa fa-spinner fa-spin"></i>');
            $('.js-approve').addClass('disabled');
            $('.js-ignore').addClass('disabled');
        },
        error:function(response){
            $('.js-action-' + id+' .js-ignore').html('Reject');
            $('.js-approve').removeClass('disabled');
            $('.js-ignore').removeClass('disabled');
        },
        success:function(response){
            $('.js-action-' + id+' .js-ignore').html('Reject');
            $('.js-approve').removeClass('disabled');
            $('.js-ignore').removeClass('disabled');
            if (response.redirect) {
                window.location.replace(response.redirect);
            }
            if(response.success)
            {

                $('.js-msg-' + id).find('span').text('Rejected');
                $('.js-msg-' + id).find('i').removeClass('fa-check-circle text-primary').addClass('fa-times text-danger');
                $('.js-msg-' + id).show();
                $('.js-action-' + id).hide();
            }
        }
    });
}

function ignoreConfirm(dataUrl, element) {
    ignoreUrl = dataUrl;
    ignoreElement = element;
    $('div.modal.confirmModal').modal('show');
}

$(document).ready(function() {

	$('a.js-approve').on('click', function(){
		approve($(this).attr('data-href'), $(this));
	});

	$('a.js-ignore').on('click', function(){
		ignoreConfirm($(this).attr('data-href'), $(this));
	});

    $('button.btn-reject').on('click', function(){
        ignore(ignoreUrl, ignoreElement);
        $('div.modal.confirmModal').modal('hide');
    });

});
