
var DivisionTeam = function() {

    var addIsDisabled = function() {
        $( ".is-disabled" ).each(function() {
            $(this).parents('tr').addClass('is-disabled');
            $(this).removeClass('is-disabled');
        });
    }

    var initDatatableTeams = function() {
        datatableTeams = $('.js-table-division-teams').DataTable({
                ajax: $(".js-table-division-teams-url").data('url'),
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                autoWidth:false,
                drawCallback: function() {
                    addIsDisabled();
                },
                columns: [
                {
                    data: 'name',
                    title: 'Team',
                    name: 'name',
                    render: function(data,display,row) {

                        var url = 'javascript:void(0);';

                        if(Site.ownLeague || Site.coChairmanOwnLeagues || (Site.ownTeam && Site.ownTeam.id == row.id)){
                            var url = route('manage.auction.division.team', { division: divisionId, team:row.id });
                        }

                        var isYou = '';
                        var isDisabled = 'is-disabled';
                        if(Site.ownTeam != null && typeof Site.ownTeam !== 'undefined' && Site.ownTeam.id == row.id){
                            isDisabled = '';
                        }

                        if(Site.ownLeague || Site.coChairmanOwnLeagues) {
                            isDisabled = '';
                        }

                        return '<div class="d-flex align-items-center '+isDisabled+'"><div class="league-crest"><img src="'+row.crest+'"></div><div class="ml-2"><div><a href="'+url+'" class="text-dark link-nostyle">'+data+'</a></div><div><a href="'+url+'" class="link-nostyle small">'+row.first_name+' '+row.last_name+' '+isYou+' </a></div></div></div>';
                    },
                },
                {
                    data: 'team_players_count',
                    title: 'Players',
                    name: 'team_players_count',
                    className: "text-center",
                    defaultContent: 0,
                    render: function(data,display,row) {
                        if(row.team_players_count !== row.defaultSquadSize){
                            return row.team_players_count;
                        }
                        return row.team_players_count+' <i class="fas fa-check"></i>';
                    }
                },
                {
                    data: 'team_budget',
                    title: 'Budget',
                    name: 'team_budget',
                    className: "text-center",
                    defaultContent: 0,
                    render: function(data,display,row) {
                        return "&pound;"+parseFloat(row.team_budget)+"m";
                    }
                },
            ],
        });

         $( datatableTeams.table().header() ).addClass('thead-dark table-dark-header');
    };

    return {
        init: function() {
            initDatatableTeams();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    DivisionTeam.init();
});
