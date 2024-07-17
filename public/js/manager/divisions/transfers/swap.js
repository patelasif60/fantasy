var swapPlayers = [];
var editPlayerData = [];
var PlayerSwapUpdate = function() {

        var checkTransferEnabled = function(){

            if(Site.chkFixture){
                $("#team1 option").prop('disabled','disabled');
                $("#team2 option").prop('disabled','disabled');
                $("#player1 option").prop('disabled','disabled');
                $("#player2 option").prop('disabled','disabled');
            }
        };

        var teamOneSelect = function() {
            $('#team1').on('change', function() {
                getTeamPlayers($('option:selected', this).attr('data-team-id'), '#player1');
                $("#team2").select2('destroy');
                //$("#team2 option").show();
                $("#team2 option").removeAttr('disabled');
                $("#team2 option[data-team-id=" + $('option:selected', this).attr('data-team-id') + "]").attr('disabled','disabled');
                $('#team2').select2();
                enabledSwapButton();
            });
        };

        var teamTwoSelect = function(){
            $('#team2').on('change', function() {
                getTeamPlayers($('option:selected', this).attr('data-team-id'), '#player2');
                $("#team1").select2('destroy');
                //$("#team1 option").show();
                $("#team1 option").removeAttr('disabled');
                $("#team1 option[data-team-id=" + $('option:selected', this).attr('data-team-id') + "]").attr('disabled','disabled');
                $('#team1').select2();
                enabledSwapButton();
            });
        };

        var playerOneSelect = function(){
            $('#player1').on('change', function() {
                // $("#player2").select2('destroy');
                // //$("#player2 option").show();
                // $("#player2 option").removeAttr('disabled');
                // $("#player2 option[data-team-id=" + $('option:selected', this).attr('data-team-id') + "]").attr('disabled','disabled');
                // $('#player2').select2();
                enabledSwapButton();
            });
        };



        var playerTwoSelect = function(){
            $('#player2').on('change', function() {
                // $("#player1").select2('destroy');
                // //$("#player1 option").show();
                // $("#player1 option").removeAttr('disabled');
                // $("#player1 option[data-team-id=" + $('option:selected', this).attr('data-team-id') + "]").attr('disabled','disabled');
                // $('#player1').select2();
                enabledSwapButton();
            });
        };

        var outSwapAmountTextBox = function(){
            $('#outSwapAmount').on('change', function() {
                enabledSwapButton();
            });

            $('#outSwapAmount').on('blur', function() {
                enabledSwapButton();
            });
        };

        var inSwapAmountTextBox = function(){
            $('#inSwapAmount').on('change', function() {
                enabledSwapButton();
            });

            $('#inSwapAmount').on('blur', function() {
                enabledSwapButton();
            });
        };

        var getTeamPlayers = function(teamId, player, callback){
            $.post({
                url: route('manage.division.transfer.getteamplayers', { division: Site.division.id}),
                type: 'post',
                data: {teamId: teamId},
                success:function(response){
                    $(player).empty().append("<option value=''>Select player</option>");
                    $.each(response, function(value, key) {
                        var option = $('<option/>');
                        option.attr({ 'data-player-club': key.club_short_code, 'data-team-id': key.team_id, 'data-team-name': key.team_name, 'data-player-id': key.player_id, 'data-player-name': Global.get_player_name('firstNameFirstCharAndFullLastName', key.player_first_name, key.player_last_name), 'data-manager-name' : key.manager_first_name + ' ' + key.manager_last_name, 'value': key.player_id }).text(Global.get_player_name('fullName', key.player_first_name, key.player_last_name) + ' (' + key.club_short_code + ') ' + key.position);
                        $('a.editPlayer').each(function(index, value) {
                            if (key.player_id == $(this).attr('data-player-one-id') || key.player_id == $(this).attr('data-player-two-id')) {
                                option.attr({'disabled': true});
                            }
                        });
                        $(player).append(option);
                    });

                    if($.isFunction(callback)) {
                        callback();
                    }
                }
            }).fail(function(response) {
                if(typeof response.responseJSON != 'undefined' &&
                    response.responseJSON.status == 'error'
                ){
                    sweet.error('Error !', response.responseJSON.message);
                    location.reload();
                }
            });
        }

        var initSelect2 = function(){
            $('.js-select2').select2();
        }

        var swap = function(){

            $('#addSwapBtn').on('click', function() {

                $(this).attr('disabled', true);
                var data = getSwapDetails();
                addPlayers(data);
                resetFields();

            });


            $('#editSwapBtn').on('click', function() {

                var data = getSwapDetails();
                editPlayers(data);
                resetFields();

                $(this).hide();
                $('#addSwapBtn').show();

            });
        }

        var addPlayers = function(data){
            if(!$('.player-list-table').is(":visible")){
                $('.player-list-table').show();
            }

            var html = '<tr data-id="'+($('.player-list-table tbody tr').length + 1)+'"><td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['teamOneName']+'</a></div><div><a href="javascript:void(0);" class="player-name link-nostyle small">'+data['teamOneManager']+'</a></div></td><td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['playerOne']+'</a> <small>'+data['playerOneClub']+'</div><div class="small">+&pound;'+data['playerOneValue']+'m</div></td><td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['teamTwoName']+'</a></div><div><a href="javascript:void(0);" class="player-name link-nostyle small">'+data['teamTwoManager']+'</a></div></td><td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['playerTwo']+'</a> <small>'+data['playerTwoClub']+'</small></div><div class="small">+&pound;'+data['playerTwoValue']+'m</div></td><td class="text-center"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark editPlayer" data-player-one-value="'+data['playerOneValue']+'" data-player-two-value="'+data['playerTwoValue']+'" data-player-one-id = "'+data['playerOneId']+'" data-player-two-id = "'+data['playerTwoId']+'" data-team-one-id="'+data['teamOneId']+'" data-team-two-id="'+data['teamTwoId']+'"><span><i class="fas fa-pencil"></i></span></a> <a href="javascript:void(0);" class="btnDeleteSwap text-dark ml-2" data-player-one-id = "'+data['playerOneId']+'" data-player-two-id = "'+data['playerTwoId']+'"><span><i class="fas fa-trash"></i></span></a></div></td></tr>';
            $('.player-list-table tbody').append(html);
            setPlayerData(data);

        }

        var editPlayers = function(data) {

            var html = '<td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['teamOneName']+'</a></div><div><a href="javascript:void(0);" class="player-name link-nostyle small">'+data['teamOneManager']+'</a></div></td><td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['playerOne']+'</a> <small>'+data['playerOneClub']+'</small></div><div class="small">+&pound;'+data['playerOneValue']+'m</div></td><td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['teamTwoName']+'</a></div><div><a href="javascript:void(0);" class="player-name link-nostyle small">'+data['teamTwoManager']+'</a></div></td><td><div><a href="javascript:void(0);" class="team-name link-nostyle">'+data['playerTwo']+'</a> <small>'+data['playerTwoClub']+'</small></div><div class="small">+&pound;'+data['playerTwoValue']+'m</div></td><td class="text-center"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark editPlayer" data-player-one-value="'+data['playerOneValue']+'" data-player-two-value="'+data['playerTwoValue']+'" data-player-one-id = "'+data['playerOneId']+'" data-player-two-id = "'+data['playerTwoId']+'" data-team-one-id="'+data['teamOneId']+'" data-team-two-id="'+data['teamTwoId']+'"><span><i class="fas fa-pencil"></i></span></a> <a href="javascript:void(0);" class="btnDeleteSwap text-dark ml-2" data-player-one-id = "'+data['playerOneId']+'" data-player-two-id = "'+data['playerTwoId']+'"><span><i class="fas fa-trash"></i></span></a></div></td>';

            $('.player-list-table tbody tr:nth-child('+$('#editSwapBtn').attr('data-id')+')').html(html);
            setPlayerData(data);
        }

        var editPlayerDetails = function() {

            $(document).on('click', '.editPlayer', function() {

                var vm = $(this);


                editPlayerData['playerOne'] = vm.attr('data-player-one-id');
                editPlayerData['playerTwo'] = vm.attr('data-player-two-id');

                $('#team1').val(vm.attr('data-team-one-id')).trigger('change.select2');
                $('#team2').val(vm.attr('data-team-two-id')).trigger('change.select2');

                getTeamPlayers(vm.attr('data-team-one-id'), '#player1', function() {
                    $("#player1 option[data-player-id=" + editPlayerData['playerOne'] + "]").attr('disabled', false)
                    $("#player1 option[data-player-id=" + editPlayerData['playerTwo'] + "]").attr('disabled', false)
                    $('#player1').val($("#player1 option[data-player-id=" + editPlayerData['playerOne'] + "]").val()).trigger("change");
                });
                $("#team2 option").show();
                $("#team2 option[data-team-id=" + vm.attr('data-team-one-id') + "]").attr('disabled','disabled');

                getTeamPlayers(vm.attr('data-team-two-id'), '#player2', function() {
                    $("#player2 option[data-player-id=" + editPlayerData['playerOne'] + "]").attr('disabled', false)
                    $("#player2 option[data-player-id=" + editPlayerData['playerTwo'] + "]").attr('disabled', false)
                    $('#player2').val($("#player2 option[data-player-id=" + editPlayerData['playerTwo'] + "]").val()).trigger("change");
                });
                $("#team1 option").show();
                $("#team1 option[data-team-id=" + vm.attr('data-team-two-id') + "]").attr('disabled','disabled');

                $('#outSwapAmount').val(vm.attr('data-player-one-value'));
                $('#inSwapAmount').val(vm.attr('data-player-two-value'));

                $('#editSwapBtn').attr('data-id', vm.closest('tr').attr('data-id'));

                $('#addSwapBtn').hide();
                $('#editSwapBtn').show();

            });
        }

        var resetFields = function(){

                $('.js-player-swap-form').trigger("reset");

                $("#player1 option").removeAttr('disabled');
                $("#player2 option").removeAttr('disabled');

                $("#team1 option").removeAttr('disabled');
                $("#team2 option").removeAttr('disabled');

                $("#player1 option[data-player-id=" + $("#player1 option:selected").attr('data-player-id') + "]").attr('disabled','disabled');
                $("#player2 option[data-player-id=" + $("#player2 option:selected").attr('data-player-id') + "]").attr('disabled','disabled');

                $.each(swapPlayers, function(value, key) {

                    $("#player1 option[data-player-id=" + key.playerIn + "]").attr('disabled','disabled')
                    $("#player1 option[data-player-id=" + key.playerOut + "]").attr('disabled','disabled')
                    $("#player2 option[data-player-id=" + key.playerIn + "]").attr('disabled','disabled')
                    $("#player2 option[data-player-id=" + key.playerOut + "]").attr('disabled','disabled')

                });

                $('#player1').val('').trigger("change");
                $('#player2').val('').trigger("change");
                $('#team1').val('').trigger("change");
                $('#team2').val('').trigger("change");

                $("#player1").select2({ "placeholder": "Select player"});
                $("#player2").select2({ "placeholder": "Select player"});
        }

        var getSwapDetails = function(){

            var player1 = $("#player1 option:selected");
            var player2 = $("#player2 option:selected");

            var data = [];

            data['teamOneName'] = getPlayerData(player1,'data-team-name');
            data['teamOneManager'] = getPlayerData(player1,'data-manager-name');
            data['playerOne'] = getPlayerData(player1,'data-player-name');
            data['playerOneValue'] = $('#outSwapAmount').val();
            data['playerOneId'] = getPlayerData(player1,'data-player-id');
            data['playerOneClub'] = getPlayerData(player1,'data-player-club');
            data['teamOneId'] = getPlayerData(player1,'data-team-id');
            data['playerOneTeam'] = getPlayerData(player1,'data-team-id');
            data['teamTwoName'] = getPlayerData(player2,'data-team-name');
            data['teamTwoManager'] = getPlayerData(player2,'data-manager-name');
            data['playerTwo'] = getPlayerData(player2,'data-player-name');
            data['playerTwoValue'] = $('#inSwapAmount').val();
            data['teamTwoId'] = getPlayerData(player2,'data-team-id');
            data['playerTwoId'] = getPlayerData(player2,'data-player-id');
            data['playerTwoClub'] = getPlayerData(player2,'data-player-club');
            data['playerTwoTeam'] = getPlayerData(player2,'data-team-id');

            return data;
        }

        var getPlayerData = function(player,field){

            return player.attr(field);
        }

        var setPlayerData = function(data) {

            if(!_.isUndefined(editPlayerData) && !_.isUndefined(editPlayerData['playerOne'])) {
                _.remove(swapPlayers , { playerIn: editPlayerData['playerTwo'], playerOut: editPlayerData['playerOne'] });
            }

            item = {};
            item ["playerOut"] = data['playerOneId'];
            item ["playerOutTeam"] = data['playerOneTeam'];
            item ["playerOutPrice"] = data['playerOneValue'];
            item ["playerIn"] = data['playerTwoId'];
            item ["playerInTeam"] = data['playerTwoTeam'];
            item ["playerInPrice"] = data['playerTwoValue'];
            swapPlayers.push(item);

            editPlayerData = [];
        }

        var swapRemove = function() {

            $(document).on("click",".btnDeleteSwap",function() {
                var playerOne = $(this).attr('data-player-one-id');
                var playerTwo = $(this).attr('data-player-two-id');
                _.remove(swapPlayers , { playerIn: playerTwo, playerOut: playerOne });
                $(this).closest('tr').remove();
                if(swapPlayers.length <= 0) {
                    $('.player-list-table').hide();
                    $('#finishedBtn').attr('disabled',true);
                }
            });
        }

        var swapSelectedPlayers = function() {

            $('#finishedBtn').on('click', function() {

                if(swapPlayers.length > 0) {

                    $('#finishedBtn').attr('disabled',true);
                    $('#addSwapBtn').attr('disabled',true);

                    $.post({
                        url: route('manage.division.transfer.store', { division: Site.division.id}),
                        type: 'post',
                        data: JSON.stringify(swapPlayers),
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        success:function(response){
                            $('#finishedBtn').attr('disabled',false);
                            $('#addSwapBtn').attr('disabled',false);

                            if(typeof response.status != 'undefined' &&
                                response.status == 'success'
                            ){
                                sweet.success('Congrats !',response.message);
                                setTimeout(function(){ location.reload(); }, 5000);
                            }
                        }
                    }).fail(function(response) {

                        $('#finishedBtn').attr('disabled',false);
                        $('#addSwapBtn').attr('disabled',false);

                        if(typeof response.responseJSON != 'undefined' &&
                            response.responseJSON.status == 'error'
                        ){
                            swal('Error !', response.responseJSON.message, "error");
                            setTimeout(function(){ location.reload(); }, 5000);
                        }
                    });
                }
            });
        }

        var select2Validation = function(){
           // $("select").on("select2:close", function (e) {
           //      $(this).valid();
           //  });
        };

        var enabledSwapButton = function(){

           if($('#team1').val() && $('#team2').val() &&
              $('#player1').val() && $('#player2').val() &&
              $('#outSwapAmount').val() && $('#outSwapAmount').val() >= 0 &&
              $('#inSwapAmount').val() && $('#inSwapAmount').val() >= 0
           ){
                $('#addSwapBtn').removeAttr('disabled');

           }else{

                $('#addSwapBtn').attr('disabled', true);
           }

        };

        var initFormValidation = function () {

            $('.js-player-swap-form').validate(Global.buildValidateParams({
                rules: {
                    'teamOut': {
                        required: true,
                    },
                    'teamIn': {
                        required: true,
                    },
                    'playerOut': {
                        required: true,
                    },
                    'playerIn': {
                        required: true,
                    },
                    'outSwapAmount': {
                        required: true,
                        number: true,
                        min: 0,
                    },
                    'inSwapAmount': {
                        required: true,
                        number: true,
                        min: 0,
                    }
                },
                submitHandler: function(form) {

                    if ($('.actionBtn:visible').attr('data-type') == 'edit') {

                        var data = getSwapDetails();
                        editPlayers(data);
                        resetFields();

                        $(this).hide();
                        $('#addSwapBtn').show();
                        $('#editSwapBtn').hide();

                    }else{

                        var data = getSwapDetails();
                        addPlayers(data);
                        resetFields();

                    }

                    if($('.player-list-table').is(":visible")){
                        $('#finishedBtn').removeAttr('disabled');
                    }
                }
        }));



    };

    return {
        init: function() {
            teamOneSelect();
            playerOneSelect();
            teamTwoSelect();
            playerTwoSelect();
            initSelect2();
            editPlayerDetails();
            resetFields();
            initFormValidation();
            swapSelectedPlayers();
            checkTransferEnabled();
            swapRemove();
            select2Validation();
            outSwapAmountTextBox();
            inSwapAmountTextBox();

        }
    };
}();

// Initialize when page loads
jQuery(function() {
    PlayerSwapUpdate.init();
});
