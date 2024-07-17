$(document).ready(function() {

    $("#joinDivision").on("click", function() {
        submitDivision();
    })

    $(document).on('click', '.join_league', function(){
        var divId = $(this).data('division-id');
        var via = 'join';
        if($(this).data('via'))
            via = $(this).data('via'); 
        $.post({
            url: route('manager.join.league.save'),
            data: 'division_id=' + $(this).data('division-id'),
            success:function(response){
                if(response.success)
                {
                    window.location = route('manage.division.create.team', {division: divId, via: via});
                } 
                else
                {
                    alert('Error : ' + response.message);
                }
            }
        });
    });

});
