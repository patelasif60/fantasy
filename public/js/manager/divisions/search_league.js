var ManagerDivisionSearch = function() {

    var initFormValidations = function () {
        $('.js-search-league-form').validate(Global.buildValidateParams({
            groups: {
                searchGroup: "search_league invitation_code",
            },
            rules: {
                'search_league': {
                    require_from_group: [1, ".searchGroup"],
                    minlength: 3,               
                },
                'invitation_code': {
                    require_from_group: [1, ".searchGroup"],
                    remote: {
                        //if this returns true, remote will be triggered
                        depends: function(){
                            return $('#invitation_code').val() != '';
                        },
                        //using these parameters
                        param: {
                            url : route('manager.league.check.by.code'),
                            async: false,
                            type: "post",
                        }
                    },
                    maxlength: 6,
                    minlength: 6,
                },
            },
            messages: {
                'invitation_code': {
                    remote: "League with provided code does not exist.",
                    require_from_group: 'Either a League Name or Invite Code is required.',
                },
                'search_league': {
                    require_from_group: 'Either a League Name or Invite Code is required.',
                },
                'searchGroup':{
                    require_from_group: 'Either a League Name or Invite Code is required.',
                },
            }
        }));
    };

    var toggleDisabled = function($val = null) {
        var searchInput = 0;

        if( $val != null){
            searchInput += ($val.val() != '')?1:0;
        } else {
             $form = $('.js-search-league-form');
            $form.find('.searchGroup').each(function() { 
                searchInput += ($(this).val() != '')?1:0;
            });
        }
       
        (!searchInput) ? $('#leagueSearch').attr('disabled','disabled'):$('#leagueSearch').removeAttr('disabled');
    };
    
    var resetSearch = function(){
        $('.searchGroup').each( function(){
            $(this).on('change keyup paste', function() {
                toggleDisabled($(this));
            });
        });
    }

    var selectSearchType = function() {
        $('#invitation_code, #search_league').removeClass('d-none');
        $('#invitation_code, #search_league').val('');
        if ($('input[type=radio][name=search_type]:checked').val() == 'invitation') {
            $('#search_league').addClass('d-none');
        } else if($('input[type=radio][name=search_type]:checked').val() == 'league') {
            $('#invitation_code').addClass('d-none');
        } else {
            $('#invitation_code, #search_league').addClass('d-none');
        }
    }

    var selectSearchTypeChange = function() {
        $('input[type=radio][name=search_type]').change(function() {
            selectSearchType()
        });
    }

    return {
        init: function() {
            initFormValidations();
            toggleDisabled();
            resetSearch();
            selectSearchType();
            selectSearchTypeChange();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionSearch.init();
});
