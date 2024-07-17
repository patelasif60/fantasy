var europeanCupTeamSelection = function() {
    var championsTeamSelect = function(){
        $('#champions_league_team').on('change', function() {
            $("#europa_league_team_1 option, #europa_league_team_2 option").prop('disabled', false);
            $("#europa_league_team_1 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
            $("#europa_league_team_2 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
            $("#europa_league_team_1 option[value=" + $("#europa_league_team_2").val() + "]").attr('disabled','disabled');
            $("#europa_league_team_2 option[value=" + $("#europa_league_team_1").val() + "]").attr('disabled','disabled');
        });
    };
    var europeanTeamOneSelect = function(){
        $('#europa_league_team_1').on('change', function() {
            $("#europa_league_team_2 option, #champions_league_team option").prop('disabled', false);
            $("#europa_league_team_2 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
            $("#europa_league_team_2 option[value=" + $("#champions_league_team").val() + "]").attr('disabled','disabled');
            $("#champions_league_team option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
            $("#champions_league_team option[value=" + $("#europa_league_team_2").val() + "]").attr('disabled','disabled');
        });
    };
    var europeanTeamTwoSelect = function(){
        $('#europa_league_team_2').on('change', function() {
            $("#europa_league_team_1 option, #champions_league_team option").prop('disabled', false);
            $("#europa_league_team_1 option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
            $("#europa_league_team_1 option[value=" + $("#champions_league_team").val() + "]").attr('disabled','disabled');
            $("#champions_league_team option[value=" + $('option:selected', this).val() + "]").attr('disabled','disabled');
            $("#champions_league_team option[value=" + $("#europa_league_team_1").val() + "]").attr('disabled','disabled');
        });
    };
    return {
        init: function() {
            championsTeamSelect();
            europeanTeamOneSelect();
            europeanTeamTwoSelect();
        }
    };
}();
// Initialize when page loads
jQuery(function() {
    europeanCupTeamSelection.init();
});
