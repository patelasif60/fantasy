var backUrl = $('.js-cup-back-url');
var globalDataStep = '';
var globalDataRound = '';

var ManagerCustomCupCreate = function() {

    var initFormValidations = function () {
        $('.js-custom-cup-create-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                },
                'teams[]': {
                    required: true,
                    minlength: 2
                },
                'bye_teams[]': {
                        required: function() {
                            if(parseInt(globalDataStep) === 3 && ! $('#is_bye_random').is(":checked")) {

                                return true;
                            }

                            return false;
                        },
                        minlength: function() {
                            if(parseInt(globalDataStep) === 3 && ! $('#is_bye_random').is(":checked")) {
                                return byesTeamCount();
                            }
                        }
                    }
            },
            messages: {
                "teams[]": "Please select at least two teams",
                'bye_teams[]': {
                    required: "Please select teams",
                    minlength: "Please select at least {0} teams",
                }
            }
        }));
    };

    var previousButtonProcess = function () {

        $(document).on('click','.js-cup-back-url',function(){
            var step = parseInt(globalDataStep);
            var round = parseInt(globalDataRound);
            scrollAnimation();
            if(step > 1 && step <= 4) {
                $('.js-step').addClass('d-none');
                if(step === 2) {
                    if(round === 1) {
                        $('.js-cup-title').html('New cup');
                        $('.js-step-one').removeClass('d-none');
                        globalDataStep = 1;
                        globalDataRound = 1;
                        backUrl.addClass('d-none');
                    } else {
                        round = round - 1;
                        globalDataRound = round;
                        $('.js-cup-title').html('Round '+round);
                        $(".js-round-with-gameweek").addClass('d-none');
                        $("#js_round_with_gameweek_"+round).removeClass('d-none');
                        $('.js-step-two').removeClass('d-none');
                    }
                } else if(step === 3) {
                    globalDataRound = round;
                    globalDataStep = 2;
                    $('.js-cup-title').html('Round '+round);
                    $(".js-round-with-gameweek").addClass('d-none');
                    $("#js_round_with_gameweek_"+round).removeClass('d-none');
                    $('.js-step-two').removeClass('d-none');
                } else if(step === 3 || step === 4) {
                    if(byesTeamCount() > 0) {
                        globalDataStep = 3;
                        $('.js-cup-title').html('First round byes');
                        $('.js-step-three').removeClass('d-none');
                    } else {
                        globalDataRound = round;
                        globalDataStep = 2;
                        $('.js-cup-title').html('Round '+round);
                        $(".js-round-with-gameweek").addClass('d-none');
                        $("#js_round_with_gameweek_"+round).removeClass('d-none');
                        $('.js-step-two').removeClass('d-none');
                    }
                }
            }
        });
    }

    var nextButtonProcess = function () {
        $(".js-next-step").click(function(event) {
            var step = parseInt($(this).data('step'));

            if(step === 2 || step === 4) {
                if (!$(".js-custom-cup-create-form").valid()) {
                    return false;
                }
            }

            scrollAnimation();

            backUrl.removeClass('d-none');

            if(step > 1 && step <= 4) {
                globalDataStep = step;
                $('.js-step').addClass('d-none');
                if(step == 2) {
                    $('.js-step-two').removeClass('d-none');
                    $('.js-cup-title').html('Round 1');
                    globalDataRound = 1;
                    startRound();
                } else if(step == 4) {
                    stepComplete();
                    $('.js-cup-title').html('Complete');
                    $('.js-step-four').removeClass('d-none');
                }
            }
            event.preventDefault();
        });
    };

    var byeTeams = function () {

            $(".js-bye-team-checkbox").addClass('d-none');
            $.each(favoriteTeams(), function( index, value ) {
                $('#js_bye_team_checkbox_'+value).removeClass('d-none');
            });

            $(".js-bye-team-checkbox input[type='checkbox']").change(function() {
            if(selectedForByeTeamsCount() < byesTeamCount()) {
                if(!this.checked) {
                    $.each(favoriteTeams(), function( index, value ) {
                        $("#js_bye_team_checkbox_"+value).find('[type=checkbox]').attr("disabled", false);
                    });
                }
            } else {

                var teams = _.difference(favoriteTeams(), selectedForByeTeams());
                $.each(teams, function( index, value ) {
                    $("#js_bye_team_checkbox_"+value).find('[type=checkbox]').attr("disabled", true);
                });

            }
        });
    }

    var favoriteTeams = function () {
        var teams = [];
        $(".js-cup-teams:checked").each(function() {
            teams.push(parseInt($(this).val()));
        });

        return teams;
    }

    var favoriteTeamsCount = function () {
        var count = favoriteTeams().length;

        return count;
    }

    var selectedForByeTeams = function () {
        var teams = [];
        $(".js-bye-team-checkbox input[type='checkbox']:checked").each(function() {
            teams.push(parseInt($(this).val()));
        });

        return teams;
    }

    var selectedForByeTeamsCount = function () {
        return selectedForByeTeams().length;
    }

    var getRounds = function () {
        var teams = favoriteTeamsCount();
        var rounds = 0;
        if(teams > 0) {

            return MathGlobal.getLogValue(teams);
        }

        return rounds;
    }

    var startRound = function () {
        if(getRounds() > 0) {
            generateRoundFromAjax();
            roundProcessSteps();
        }
    };

    var byesTeamCount = function () {

        var teams = favoriteTeamsCount();
        var near_power = MathGlobal.getNearestPowerValue(teams);
        var teams_to_be_eliminate = teams - near_power;
        var byes_team_count = 0;

        if(teams_to_be_eliminate > 0) {
            byes_team_count = teams - (teams_to_be_eliminate * 2);
        }

        return byes_team_count;
    }

    var selectedGameWeekDisable = function () {

        var round = globalDataRound;

        if(round > 1) {

            let checkRound = round - 1;
            var gameWeeks = [];
            $("#js_round_with_gameweek_"+checkRound).find($(".js-rounds-gameweek:checked")).each(function() {
                gameWeeks.push(parseInt($(this).val()));
            });

            var max_of_array = Math.max.apply(Math, gameWeeks);

            $("#js_round_with_gameweek_"+round).find($(".js-rounds-gameweek")).each(function() {
                if($(this).val() <= max_of_array) {
                    if($(this).prop('checked')) {
                        $(this).prop('checked', false);
                    }
                    $(this).attr("disabled", true);
                } else {
                    $(this).attr("disabled", false);
                }
            });
        }
    }

    var roundProcessSteps = function () {
        $(document).on("click",".js-next-step-round",function() {
            var step = parseInt(globalDataStep);
            var round = parseInt($(this).data('round'));
            if(round > 0) {

                 if(step === 2) {
                    if(! $('#js_round_with_gameweek_'+round).find($(".js-rounds-gameweek:checked")).length) {
                        sweet.error('Error', 'Please select a gameweek');
                        return false;
                    }
                }

                scrollAnimation();

                round = round + 1;
                if(round <= getRounds()) {
                    globalDataRound = round;
                    $('.js-cup-title').html('Round '+round);
                    $(".js-round-with-gameweek").addClass('d-none');
                    $("#js_round_with_gameweek_"+round).removeClass('d-none');
                    selectedGameWeekDisable();
                } else {
                    $('.js-step').addClass('d-none');
                    var byesCount = byesTeamCount();
                    var totalTeams = favoriteTeamsCount();
                    if(byesCount > 0) {
                        byeTeams();
                        globalDataStep = 3;
                        $('.js-cup-title').html('First round byes');
                        $('.js-step-three').removeClass('d-none');
                        $(".js-total-team-count").html(totalTeams);
                        if(byesCount > 1) {
                            $(".js-bye-team-count").html(byesCount+' teams');
                        } else {
                            $(".js-bye-team-count").html(byesCount+' team');
                        }
                        $("#is_bye_random").prop('checked', false);
                        $('.js-bye-teams-list').removeClass('d-none');

                        $('.js-bye-team-checkbox input[type="checkbox"]').each(function() {
                            $(this).prop('checked', false);
                            $(this).attr("disabled", false);
                        });

                    } else {
                        $("#is_bye_random").prop('checked', true);
                        $('.js-bye-teams-list').addClass('d-none');
                        globalDataStep = 4;
                        stepComplete();
                        $('.js-cup-title').html('Complete');
                        $('.js-step-four').removeClass('d-none');
                    }
                }
            }
            event.preventDefault();
        });
    }

    var generateRoundFromAjax = function() {
            $.ajax({
                url: $('.js-main-custom-cup').data('round')+"?rounds="+getRounds(),
                type: 'GET',
                dataType: 'html',
            })
            .done(function(response) {
                $('.js-step-two .js-step-rounds').html(response);
            })
            .fail(function(error) {
            });
    };

    var checkByeTeamHideShow = function () {
        $('.js-first-round-bye').click(function(event) {
            if($(this).is(":checked")) {
                $('.js-bye-teams-list').addClass('d-none');
            } else {
                $('.js-bye-teams-list').removeClass('d-none');
            }
        });
    }

    var stepComplete = function () {

        $('.js-cup-name').html($('#name').val());

        $('.js-final-teams').html('');
        _.forEach(favoriteTeams(), function(value) {
                var team = _.find(allTeams, ['id', value]);
                jQuery('<li/>', {
                    id: '',
                    class: '',
                    text: team.name + ' ('+team.first_name+' '+team.last_name+')'
                }).appendTo('.js-final-teams');
        });

        var byesCount = byesTeamCount();
        $('.js-final-rounds-byes-main').addClass('d-none');
        if(byesCount > 0) {
            $('.js-final-rounds-byes-main').removeClass('d-none');
            $('.js-final-rounds-byes').html('');
            if($('#is_bye_random').is(":checked")) {
                $('.js-final-rounds-byes').html('<li>Random selection</li>');
            } else {
                $('.js-bye-team-checkbox input[type="checkbox"]').each(function() {
                    if($(this).is(":checked")) {
                        var team = _.find(allTeams, ['id', parseInt($(this).val()) ]);
                        jQuery('<li/>', {
                            id: '',
                            class: '',
                            text: team.name
                        }).appendTo('.js-final-rounds-byes');
                    }
                });
            }
        }

        var gamweeks = getSelectedGameWeek();
        $('.js-final-rounds').html('');
        var rounds = getRounds();
        for (i = 1; i <= rounds; i++) {
            var gameweekText = '';
            $.each(gamweeks[i], function( index, value ) {
                var gameweek = _.find(allGameweeks, ['id', value]);
                if(gameweek) {
                    gameweekText += gameweekText == '' ? 'Week '+gameweek.number : ', Week '+gameweek.number;
                }
            });

            jQuery('<li/>', {
                id: '',
                class: '',
                text: 'Round '+i+': '+gameweekText
            }).appendTo('.js-final-rounds');
        }

    }

    var getSelectedGameWeek = function () {
        var gameWeeks = [];
        $('.js-round-with-gameweek').each(function() {
            var round = parseInt($(this).attr('data-round'));
            gameWeeks[round] = [];
            $(this).find($('input[type="checkbox"]')).each(function() {
                if($(this).prop("checked") == true) {
                    gameWeeks[round].push(parseInt($(this).val()));
                }
            });
        });

        return gameWeeks;
    }

    var initFormSubmit = function () {
        $(".js-custom-cup-create-form").submit(function(){
            $('.js-step-submit').attr("disabled", true);
        });
    }

    var teamCheckBoxChecked = function () {
        $(".js-team-checkbox-select").click(function(){
            if($(this).find($('.js-cup-teams')).is(":checked")){
                $(this).find($('.js-cup-teams')).prop('checked', false);
            } else {
                $(this).find($('.js-cup-teams')).prop('checked', true);
            }
        });
    }

    var scrollAnimation = function () {
        var body = $("html, body");
        body.stop().animate({scrollTop:0}, 500, 'swing', function() { 
        });
    }

    return {
        init: function() {
            nextButtonProcess();
            previousButtonProcess();
            checkByeTeamHideShow();
            initFormValidations();
            initFormSubmit();
            teamCheckBoxChecked();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerCustomCupCreate.init();
});
