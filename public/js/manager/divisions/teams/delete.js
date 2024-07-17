var ManagerTeamsDelete = function() {

    var initRemoveTeam = function() {
        $("#removeTeam").on('click', function() {
            if(confirm("Are you sure you want to delete? On clicking 'Ok' the team gets deleted permanently!"))
                $.post({
                    url: $("#removeTeam").attr('data-url'),
                    success:function(response){
                       window.location = route('manage.division.teams.index');    
                    }
                });
           
        });
    };

    return {
        init: function() {
            initRemoveTeam();
        },
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerTeamsDelete.init();
});
