
var DivisionTeam = function() {

    var addIsDisabled = function() {
        $( ".is-disabled" ).each(function() {
            $(this).parents('tr').addClass('is-disabled');
            $(this).removeClass('is-disabled');
        });
    }
    var initFormValidations = function () {
        var userForm = $('.js-division-update-form');
        userForm.validate({
            ignore: [],
            errorClass: 'invalid-feedback animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e)
            {   
              $(e).parents('.form-group').append(error);
            },
            rules: {
                'season_quota_used[]' : {
                    required : true,
                },
            },
        });
       $(".btnAdd").click(function(){
            $('.js-fields-wrapper').each(function () {
                $(this).rules('add', {
                    required: true
                });
            });
        });
    };
   
    var initDatatableTeams = function() {
        datatableTeams = $('.js-table-division-teams').DataTable({
                ajax: $(".js-table-division-teams-url").data('url'),
                // responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: true,
                autoWidth:false,
                drawCallback: function() {
                    addIsDisabled();
                },
                'order':[[5,'desc']],
                columns: [
                {
                    data: 'name',
                    title: 'Team',
                    name: 'name',
                    render: function(data,display,row) {

                        var link = data;
                        if(Site.ownLeague || (Site.ownTeam && Site.ownTeam.id == row.id)){
                            var url = route('manage.team.lineup', { division: Site.division.id, team:row.id });
                            link = '<a href="'+url+'" class="text-dark link-nostyle font-weight-bold">'+textLimit(data)+'</a>';
                        }


                        return '<div class="d-flex align-items-center"><div class="league-crest"><img src="'+row.crest+'"></div><div class="ml-2"><div>'+link+'</div></div></div>';
                    },
                },
                {
                    data: '',
                    title: 'Manager',
                    name: '',
                    className: "text-left",
                    defaultContent: 0,
                    render: function(data,display,row) {
                        return row.first_name+' '+row.last_name;
                    }
                },
                {
                    data: 'team_budget',
                    title: 'Budget (&pound;M)',
                    name: 'team_budget',
                    className: "text-center table-input",
                    defaultContent: 0,
                    width: '150px',
                    orderData: [5],
                    render: function(data,display,row) {
                        if(Site.ownLeague){
                            return '<div class="form-group"><div class="input-group input-group-sm"><input type="text" class="form-control has-small-font else-mobile" id="budget_correction" name="budget_correction['+row.id+']" value="'+row.team_budget+'" aria-describedby="pre_season_auction_budget-error" aria-invalid="false"></div></div>';
                        }
                        // return parseFloat(row.team_budget);
                        return row.team_budget;
                    }
                },
                {
                    data: 'season_quota_used',
                    title: 'XFERS (TOT)',
                    name: 'season_quota_used',
                    className: "text-center table-input",
                    defaultContent: 0,
                    width: '150px',
                    render: function(data,display,row) {
                        if(Site.ownLeague){
                            return '<div class="form-group is-invalid"><div class="input-group input-group-sm"><input type="number" min="0" max="'+row.season_free_agent_transfer_limit+'" class="form-control has-small-font else-mobile js-fields-wrapper" id="season_quota_used" name="season_quota_used['+row.id+']" value="'+row.season_quota_used+'" aria-describedby="pre_season_auction_budget-error" aria-invalid="false"></div><div class="invalid-feedback animated fadeInDown"><strong></strong></div></div>';
                        }
                        return row.season_quota_used;
                    }
                },
                {
                    data: 'monthly_quota_used',
                    title: 'XFERS (MTH)',
                    name: 'monthly_quota_used',
                    className: "text-center table-input",
                    defaultContent: 0,
                    width: '150px',
                    render: function(data,display,row) {
                        if(Site.ownLeague){
                            return '<div class="form-group is-invalid"><div class="input-group input-group-sm"><input type="number" min="0" class="js-fields-wrapper form-control has-small-font else-mobile" max="'+row.monthly_free_agent_transfer_limit+'" id="monthly_quota_used" name="monthly_quota_used['+row.id+']" value="'+row.monthly_quota_used+'" aria-describedby="pre_season_auction_budget-error" aria-invalid="false"></div><div class="invalid-feedback animated fadeInDown"><strong></strong></div></div>';
                        }
                       return row.monthly_quota_used;
                    }
                },
                {
                    data: 'team_budget',
                    name: 'team_budget',
                    visible: false,
                },
            ],
        });

         $( datatableTeams.table().header() ).addClass('thead-dark table-dark-header');
    };

    var textLimit = function(text) {

        if(window.innerWidth <= 800) {
            var count = 12;
            var result = text.slice(0, count) + (text.length > count ? "..." : "");

            return result;
        } else {
            return text;
        }
    };

    return {
        init: function() {
            initDatatableTeams();
            initFormValidations();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    DivisionTeam.init();
});
