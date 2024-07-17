var datatablePlayers = '';
var transferPlayerArray = [];
var datatableActionFlag =false;
var revertData = JSON.parse(Site.playerData);
var intialBudget = parseFloat(Site.teamBudget).toFixed(2);
var intialTeamClubPlayer =_.cloneDeep(Site.teamClubsPlayer);
var flag = 1;
var isTableLoad = false;

$(document).on('click', '.js-revert-data', function () {
    $('#dbdata').val(JSON.stringify(revertData));
    data = {'player': $('#dbdata').val(),'teamPlayers':Site.teamPlayers}
    $.ajax
    ({
         url: $(this).data('url'),
         type: 'POST',
         dataType: 'html',
         data:data,
    })
    .done(function(response) {
         $('.js-player-view').html(response);
         Site.teamBudget = intialBudget;
         Site.teamClubsPlayer = intialTeamClubPlayer;
         $(".js-team-budget").text(Site.teamBudget);
         $('#transferData').val('');
         transferPlayerArray = [];
    })
    .fail(function(error) {
    });
    $(".js-count-player").text(Site.totalTeamPlayers +'/'+ Site.totalTeamPlayers +' players');
    $( ".js-create-player-bid" ).each(function() {
            $(this).parents('tr').addClass('is-disabled');
    });
    $('.js-create-transfer').removeAttr('disabled');
});

$(document).on('click', '.js-create-transfer', function () {
    $('.js-create-transfer').attr("disabled", 'disabled');
    data= {'dbdata': $('#dbdata').val(),'transferData':$('#transferData').val()}
    if(parseFloat(Site.teamBudget) < 0)
    {
        sweet.error('Error', 'You have exceeded your budget.Transfers have not been saved');
        $('.js-revert-data').trigger('click');
        return false;
    }
    $.ajax
    ({
         url: $(this).data('url'),
         type: 'POST',
         data:data,
    })
    .done(function(response) {
        if(response.status == 'sucess'){
            $(".js-create-transfer").submit();
        }
        else{
            sweet.error('Error',response.error);
            $('.js-revert-data').trigger('click');
        }
    })
    .fail(function(error) {

    });
});

$('.js-submit-transfer').click(function() {
    if($('#transferAmount').val() == '' )
    {
       sweet.error('Error', 'Sold amount field is required');
        return false;
    }
    $(".js-count-player").text(Site.totalTeamPlayers-1 +'/'+ Site.totalTeamPlayers +' players');
    Site.teamClubsPlayer[$("#clubId").val()] = Site.teamClubsPlayer[$("#clubId").val()] - 1;
    var obj=JSON.parse($('#dbdata').val());
    var currentPlayerId = $("#transferPlayerId").val();
    $('#playerRadio_'+currentPlayerId).addClass('d-none');
    $('.js-player-radio').removeClass('playerRadio');
    for(var i=0; i<obj.length; i++) {
        if(obj[i].playerId == currentPlayerId) {
            transferPlayerArray.push({soldAmount: parseFloat($("#transferAmount").val()), boughtAmount:'',  boughtPlayerId:'', soldPlayerId:parseFloat(currentPlayerId),teamId:Site.team.id});
            obj.splice(i, 1);
            break;
        }
    }
    $('#dbdata').val(JSON.stringify(obj));
    Site.teamBudget =  parseFloat(Site.teamBudget) + parseFloat($("#transferAmount").val())
    Site.teamBudget = Site.teamBudget.toFixed(2);
    $(".js-team-budget").text(Site.teamBudget);
    datatableActionFlag = true;
   $('.js-create-transfer').attr("disabled", 'disabled');
    datatablePlayers.ajax.reload();
});
$('.js-transfer-player').click(function() {
    if($('.js-create-player-bid-modal #amount').val() == '' )
    {
       sweet.error('Error', 'Bid amount field is required');
        return false;
    }
    if(parseFloat($('.js-create-player-bid-modal #amount').val()) > parseFloat(Site.teamBudget))
    {
        //sweet.error('Error', 'You have exceeded your budget.');
        //return false;
    }
     var obj=JSON.parse($('#dbdata').val());
     if(Site.chkDefenderPosition)
     {
        if($('.js-create-player-bid-modal .positionJs').text() == 'FB' || $('.js-create-player-bid-modal .positionJs').text() == 'CB')
        {
            temPosition = 'DF'
        }
        else
        {
          temPosition = $('.js-create-player-bid-modal .positionJs').text();
        }

     }
     else{
         temPosition = $('.js-create-player-bid-modal .positionJs').text();
     }
    if(temPosition == 'DMF')
    {
        if(!Site.chkDefenciveMidfilderPosition)
        {
            temPosition = 'MF'
        }
    }
    if(Site.teamClubsPlayer[$('.js-create-player-bid-modal #club_id').val()] == undefined){
        var temp = $('.js-create-player-bid-modal #club_id').val();
        Site.teamClubsPlayer[temp] = 1;
    }
    else{
        Site.teamClubsPlayer[$('.js-create-player-bid-modal #club_id').val()] = Site.teamClubsPlayer[$('.js-create-player-bid-modal #club_id').val()] + 1;
    }
    $(".js-count-player").text(Site.totalTeamPlayers +'/'+ Site.totalTeamPlayers +' players');
    var element = {};
        element.playerName = $('.js-create-player-bid-modal #playerNameNoneModel').val();
        element.plyerModelName = $('.js-create-player-bid-modal .player-bid-modal-title').text();
        element.playerId = parseInt($('.js-create-player-bid-modal #player_id').val());
        element.teamId = Site.team.id;
        element.position = temPosition;
        element.shortCode = $('.js-create-player-bid-modal #club_shortCode').val();
        element.transferValue = parseFloat($('.js-create-player-bid-modal #amount').val()).toFixed(2);
        element.clubId = $('.js-create-player-bid-modal #club_id').val();
        element.amount = $('.js-create-player-bid-modal #amount').val();
        obj.push(element);
    $('#dbdata').val(JSON.stringify(obj));
    $('js-player-radio').addClass('playerRadio');
    //$('.js-action-datatable').removeClass('js-create-player-bid');
    Site.teamBudget =  parseFloat(Site.teamBudget) - parseFloat($('.js-create-player-bid-modal #amount').val());
    Site.teamBudget = Site.teamBudget.toFixed(2);
    $("#teamBudget").val(Site.teamBudget);
    $(".js-team-budget").text(Site.teamBudget);
    $.each(transferPlayerArray, function (index, value) {
        if(value.boughtPlayerId == ''){
            transferPlayerArray[index]['boughtPlayerId'] = parseFloat($('.js-create-player-bid-modal #player_id').val());
            transferPlayerArray[index]['boughtAmount'] = parseFloat($('.js-create-player-bid-modal #amount').val());
        }
    });
    $('#transferData').val(JSON.stringify(transferPlayerArray));
    data= {'player': $('#dbdata').val(),'teamPlayers':Site.teamPlayers}
    datatableActionFlag=false;
    if(!datatableActionFlag)
    {
        $('.js-create-player-bid').addClass('is-disabled');
        $('.is-disabled').removeClass('js-create-player-bid');
    }
    $.ajax
    ({
         url: $(this).data('url'),
         type: 'POST',
         dataType: 'html',
         data:data,
    })
    .done(function(response) {
         $('.js-player-view').html(response);
         EnbleSave();
    })
    .fail(function(error) {
    });
    datatablePlayers.ajax.reload();
});
var EnbleSave= function(){
    if($('.js-player-view .fa-times').length == $('.js-player-view .transfer-process').length){
        $('.js-create-transfer').removeAttr('disabled');
    }
    else{
        setTimeout(function(){
            EnbleSave();
         },1000);
    }
}
var Players = function() {
     var addIsDisabled = function() {
        $( ".is-disabled" ).each(function() {
            $(this).parents('tr').addClass('is-disabled');
             $(this).removeClass('is-disabled');
        });
    }
    var initDatatablePlayers = function() {
        datatablePlayers = $('.manager-teams-list-table').DataTable({
                ajax: {
                    url: $('.manager-teams-list-table').data('url'),
                    method: 'post',
                    data: function (d) {
                        $.each(readFilters(), function (key, value) {
                            if (value !== null) {
                                d[key] = value;
                            }
                        });
                    }
                },
                searching: false,
                paging: false,
                info: false,
                serverSide: false,
                autoWidth:false,
                scrollX: true,
                scrollCollapse: true,
                // processing: true,
                fixedColumns:   {
                    leftColumns: 3,
                    rightColumns: 3
                },
                'order':[],
                "orderFixed": {
                    "post": [[4,'desc'],[5,'asc'],[ 7, 'asc' ],[ 6, 'asc' ]]
                },
                "initComplete": function() {
                    if(!isTableLoad) {
                        openSoldPopup();
                        isTableLoad = true;
                    }
                },
                 drawCallback: function() {
                     addIsDisabled();
                 },
                columns: [
                {
                    data: 'player_short_code',
                    title: 'CODE',
                    name: 'player_short_code',
                    width:'4%',
                    defaultContent: '-',
                    render: function(data,display,row) {
                        return row.player_short_code;
                    }
                },
                {

                    data: 'position',
                    orderData: [ 7, 6 ],
                    title: 'Player',
                    name: 'position',
                    render: function(data,display,row) {
                        var position = getPositionShortCode(row.position,row.id);

                        if(Site.mergeDefenders == 'Yes' && (position == 'CB' || position == 'FB')){
                            position = 'DF';
                        }

                        if(Site.defensiveMidfields == 'Yes' && position == 'DMF'){
                            position = 'DM';
                        }else if(Site.defensiveMidfields == 'No' && position == 'DMF'){
                            position = 'MF';
                        }

                        var dbtbClass = 'is-disabled';
                        if(datatableActionFlag) {
                            var dbtbClass = 'js-create-player-bid';
                        }
                        if(typeof Site.teamClubsPlayer[row.club_id] !== 'undefined' && Site.teamClubsPlayer[row.club_id] == Site.maxClubPlayers && Site.team.id != row.team_id) {

                            return '<div class="player-wrapper" data-player-modal="'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'" data-player="'+Global.get_player_name('lastName', row.player_first_name, row.player_last_name)+'" data-club-id="'+row.club_id+'" data-short-code="'+row.shortCode+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+row.position+'"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span><div><span class="team-name">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'</span></div>';
                        }

                        var objTransferPlayers=JSON.parse($('#dbdata').val());
                            for(var i=0; i<objTransferPlayers.length; i++) {
                                if(objTransferPlayers[i].playerId == row.id ) {
                                   return '<div class="player-wrapper is-disabled" data-player-modal="'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'" data-player="'+Global.get_player_name('lastName', row.player_first_name, row.player_last_name)+'" data-club-id="'+row.club_id+'" data-short-code="'+row.shortCode+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+row.position+'"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span><div><span class="team-name">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'</span></div>';
                                }
                            }
                        return '<span class="cursor-pointer player-wrapper '+dbtbClass+'" data-player-modal="'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'" data-player="'+Global.get_player_name('lastName', row.player_first_name, row.player_last_name)+'" data-club-id="'+row.club_id+'" data-short-code="'+row.shortCode+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+row.position+'"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span><div><span class="team-name">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'</span></span>';
                    }
                },
                {
                    data: 'clubShortCode',
                    title: 'CLUB',
                    name: 'clubShortCode',
                    className: "text-center",
                    render: function(data,display,row) {

                        return row.short_code;

                    }
                },
                
                {
                    data: 'total_game_played',
                    title: 'PLD',
                    name: 'total_game_played',
                    className: "text-center",
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ]
                },
                {
                    data: 'total',
                    title: 'PTS',
                    name: 'total',
                    className: "text-center",
                    defaultContent: '0',
                    "orderSequence": [ "desc", "asc" ]
                },
                {
                    data: 'positionOrder',
                    name: 'positionOrder',
                    visible: false,
                },
                 {
                    data: 'player_first_name',
                    name: 'player_first_name',
                    visible: false,
                },
                {
                    data: 'player_last_name',
                    name: 'player_last_name',
                    visible: false,
                },
                {
                    data: '',
                    title: '',
                    name: '',
                    className: "text-center",
                    render: function(data,display,row) {
                        if(Site.chkFixture){
                            return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark" data-bid="'+row.bid+'" data-player-id="'+row.id+'" data-team="'+row.team_id+'" data-player="'+Global.get_player_name('fullName', row.player_first_name, row.player_last_name)+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+row.position+'" data-contract="'+row.team_player_contract_id+'"><span><img src="" draggable="false"></span></a></div></div>';
                        }
                        if(row.team_name && Site.team.id == row.team_id){
                            return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark" data-bid="'+row.bid+'" data-player-id="'+row.id+'" data-team="'+row.team_id+'" data-player="'+Global.get_player_name('fullName', row.player_first_name, row.player_last_name)+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+row.position+'" data-contract="'+row.team_player_contract_id+'"><span><img src="" draggable="false"></span></a></div></div>';
                        }
                        if(Site.defaultSquadSize == Site.totalTeamPlayers && Site.team.id != row.team_id) {
                        }

                        if(typeof Site.teamClubsPlayer[row.club_id] !== 'undefined' && Site.teamClubsPlayer[row.club_id] == Site.maxClubPlayers && Site.team.id != row.team_id) {
                            return '<div class="quota-player is-disabled"><span class="text-muted text-uppercase"><strong>CLUB QUOTA</strong></span></div>';
                        }

                        if(row.bid && row.team_name){
                            return '<div class="text-muted text-uppercase won-by"><span><strong>won by</strong> <br> '+row.team_name+'</span></div>'
                        }

                        var position = (Site.mergeDefenders == 'Yes' && (row.position == Site.allPositionEnum.CENTREBACK || row.position == Site.allPositionEnum.FULLBACK)) ? Site.allPositionEnum.DEFENDER : row.position;
                        position = (Site.defensiveMidfields == 'No' && (row.position == Site.allPositionEnum.DEFENSIVE_MIDFIELDER)) ? Site.allPositionEnum.MIDFIELDER : row.position;
                        var dbtbClass = 'is-disabled';

                        if(datatableActionFlag){
                            var dbtbClass = 'js-create-player-bid';
                        }
                        if(_.includes(Site.availablePostions, position)) {
                            var objTransferPlayers = JSON.parse($('#dbdata').val());
                            for(var i=0; i < objTransferPlayers.length; i++) {
                                if(objTransferPlayers[i].playerId == row.id ) {

                                   return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark"><span><img src="'+Site.assetUrl+'/img/auction/bid-add-disabled.svg" draggable="false"></span></a></div></div>';
                                }
                            }

                            return '<span class="text-muted text-uppercase won-by  '+dbtbClass+'" data-player-modal="'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'" data-player="'+Global.get_player_name('lastName', row.player_first_name, row.player_last_name)+'" data-club-id="'+row.club_id+'" data-short-code="'+row.shortCode+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+row.position+'"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark"><span><img src="'+Site.assetUrl+'/img/auction/bid-add.svg" draggable="false"></span></a></div></span>';
                        } else {
                            var objTransferPlayers = JSON.parse($('#dbdata').val());
                            for(var i=0; i < objTransferPlayers.length; i++) {
                                if(objTransferPlayers[i].playerId == row.id ) {

                                   return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark"><span><img src="'+Site.assetUrl+'/img/auction/bid-add-disabled.svg" draggable="false"></span></a></div></div>';
                                }
                            }

                            return '<span class="text-muted text-uppercase won-by  '+dbtbClass+'" data-player-modal="'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'" data-player="'+Global.get_player_name('lastName', row.player_first_name, row.player_last_name)+'" data-club-id="'+row.club_id+'" data-short-code="'+row.shortCode+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+row.position+'"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark"><span><img src="'+Site.assetUrl+'/img/auction/bid-add.svg" draggable="false"></span></a></div></span>';
                        }

                    }
                },
            ],
            aoColumnDefs: [
                   { aTargets: [ 0 ], bSortable: true},
                   { aTargets: [ 1 ], bSortable: true},
                   { aTargets: [ 2 ], bSortable: true },
                   { aTargets: [ 3 ], bSortable: true },
                   { aTargets: [ 4 ], bSortable: true },
                   { aTargets: [ 5 ], bSortable: false },
                   { aTargets: [ 6 ], bSortable: false },
            ],
            order: []
        });

        $( datatablePlayers.table().header() ).addClass('thead-dark table-dark-header');
    };

    var readFilters = function() {
        return {
            position: $('#filter-position').val() || null,
            club: $('#filter-club').val() || null,
            player: $('#player_name').val() || null,
            boughtPlayers : $("#boughtPlayers").is(':checked') ? 'yes' : 'no',
        };
    };

    var initPlayerFilters = function () {
        $('#filter-position').on('change', function(e) {
            localStorage.setItem('transferPosition', $('#filter-position').val());
            datatablePlayers.ajax.reload();
        });
        $('#filter-club').on('change', function(e) {
            localStorage.setItem('transferClub', $('#filter-club').val());
            datatablePlayers.ajax.reload();
        });
        $('#player_name').on('keyup', function(e) {
            localStorage.setItem('transferPlayer', $('#player_name').val());
            datatablePlayers.ajax.reload();
        });
        $('#boughtPlayers').on('click', function(e) {
            var boughtPlayers = $("#boughtPlayers").is(':checked') ? 'yes' : 'no';
            localStorage.setItem('liveOfflineBoughtPlayers', boughtPlayers);
            datatablePlayers.ajax.reload();
        });
    };

    var getPositionShortCode = function(mystring,id) {
        if(typeof mystring == 'undefined') {
            mystring = null;
        }
        var matches = mystring.match(/\((.*?)\)/);
        if (matches) {
            return matches[1];
        }
        return '';
    }
    var createPlayerBid = function () {
        $('.js-player-bid-create-form').validate(Global.buildValidateParams({
            rules: {
                'player_id': {
                    required: true,
                },
                'amount': {
                    required: true,
                    number: true,
                    min:0,
                },
                'team_id': {
                    required: true,
                    number: true,
                },
                'club_id': {
                    required: true,
                    number: true,
                },
            },
        }));
    }

    var initSelect2 = function() {
        $('.js-select2').select2();
    }

    var getPosition = function(mystring) {
        return  Site.playerPositions[mystring].toLowerCase();
    }

    var slimScroll = function(){
        if ($(window).width() > 991) {
                let ContentHeight = $('.js-left-pitch-area').height();
                $('.scrollbar').mCustomScrollbar({
                    scrollButtons:{enable:true},
                    theme:"light-thick",
                    scrollbarPosition:"outside",
                    mouseWheel:{ enable: true }
                });
                $(function(){
                    $('.player-data').height(ContentHeight);
                });

            } else {
                $('scrollbar').mCustomScrollbar("destroy");
            }
        }

   var pageLoad = function(){
        $(window).bind("load", function() {
            slimScroll();
        });

        $(window).on("orientationchange, resize", function(event) {
            slimScroll();
        });
         $(document).ready(function() {
            fitty('.player-wrapper-title', {
                minSize: 7,
                maxSize: 11
            });
        });
   }

   var initMoibleOrDeskTop = function() {
        if(isMobileScreen()) {
            $('.js-player-filters').remove();
        } else {
            $('.full-screen-modal').remove();
        }
    }

    var isMobileScreen = function() {
        if(window.innerWidth <= 800) {
            return true;
        }

        return false;
    }

    var positionClick = function(){

        $(document).on('click', '.js-player-positions', function () {
            if(isMobileScreen()) {
                $('#full-screen-modal').modal('show');
            }
            if($(this).data('position') != $('#filter-position').val()) {
                $('#filter-position').val($(this).data('position')).trigger('change');
            }
        });


        $('#full-screen-modal').on('shown.bs.modal', function (e) {
            $(".modal-card-body").scrollTop(0);
        })
    }
     var getFilterValues = function() {

        var transferPosition = localStorage.getItem('transferPosition');
        var position = 'Goalkeeper (GK)';
        if (typeof(transferPosition) !== "undefined" && transferPosition !== null && transferPosition !== '') {
            position = transferPosition;
        }
        $('#filter-position').val(position);

        var transferClub = localStorage.getItem('transferClub');
        if (typeof(transferClub) !== "undefined" && transferClub !== null) {
            $('#filter-club').val(transferClub);
        }

        var transferPlayer = localStorage.getItem('transferPlayer');
        if (typeof(transferPlayer) !== "undefined" && transferPlayer !== null) {
            $('#player_name').val(transferPlayer);
        }

        var boughtPlayers = localStorage.getItem('transferBoughtPlayers');
        if(typeof(boughtPlayers) !== "undefined" && boughtPlayers !== null && boughtPlayers == 'yes') {
            $("#boughtPlayers").prop("checked", true);
        } else {
            $("#boughtPlayers").prop("checked", false);
        }

       initDatatablePlayers();
    }

    var openSoldPopup = function() {
        $(document).on('click', '.playerRadio', function () {
            $(".js-player-name").text($(this).data('value'));
            var objDB = JSON.parse(Site.playerData);
            var objTransferPlayers = JSON.parse($('#dbdata').val());
            var tempPlayerId = $(this).data('player-id');
            $('#transfer_price .positionJs').html($(this).data('position'));
            $('#transfer_price .positionJs').addClass('is-'+$(this).data('position').toLowerCase());
            $("#transferPlayerId").val(tempPlayerId);
            $("#clubId").val($(this).data('club-id'));
            $('#transferAmount').val($(this).data('bought-val'));
             if(flag == 1) {
                sweet.error('', 'If you complete this process, team supersubs will be cancelled', "warning");
                flag++;
            }
            for(var i=0; i<objDB.length; i++) {
                if(objDB[i].playerId == tempPlayerId ) {
                    $("#transfer_price").modal('show');
                    return;
                }
            }
            $(".js-count-player").text(Site.totalTeamPlayers +'/'+ Site.totalTeamPlayers +' players');
            Site.teamClubsPlayer[$(this).data('club-id')] = Site.teamClubsPlayer[$(this).data('club-id')] - 1;
            $.each(transferPlayerArray, function (index, value) {
                if(value.boughtPlayerId == tempPlayerId){
                    for(var i=0; i<objTransferPlayers.length; i++) {
                        if(objTransferPlayers[i].playerId == tempPlayerId) {
                            objTransferPlayers.splice(i, 1);
                        }
                    }
                    for(var i=0; i<objDB.length; i++) {
                        if(objDB[i].playerId == value.soldPlayerId) {
                           objTransferPlayers.push(objDB[i]);
                        }
                    }
                    Site.teamBudget =  parseFloat(Site.teamBudget) + parseFloat(value.boughtAmount) - parseFloat(value.soldAmount);
                    Site.teamBudget = Site.teamBudget.toFixed(2);
                    $(".js-team-budget").text(Site.teamBudget);
                    transferPlayerArray.splice(index,1)
                    $('#transferData').val(JSON.stringify(transferPlayerArray));
                    return false;
                }
            });
            $('#dbdata').val(JSON.stringify(objTransferPlayers));
            data= {'player': $('#dbdata').val(),'teamPlayers':Site.teamPlayers}
            $.ajax
            ({
                 url: $(this).data('url'),
                 type: 'POST',
                 dataType: 'html',
                 data:data,
            })
            .done(function(response) {
                 $('.js-player-view').html(response);
            })
            .fail(function(error) {
            });
            datatablePlayers.ajax.reload();
        });
        $(document).on('click', '.js-create-player-bid', function(event) {
            event.preventDefault();
            if($(this).data('id') > 0) {
                $('.js-create-player-bid-modal #player_id').val($(this).data('id'));
                $('.js-create-player-bid-modal #club_id').val($(this).data('club-id'));
                $('.js-create-player-bid-modal #club_shortCode').val($(this).data('short-code'));
                $('.js-create-player-bid-modal #amount').val('0.00');
                $('.js-create-player-bid-modal .player-bid-modal-title').html($(this).data('player-modal'));
                $('.js-create-player-bid-modal #playerNameNoneModel').val($(this).data('player'))
                $('.js-create-player-bid-modal .player-bid-modal-text').html($(this).data('club'));
                $('.js-create-player-bid-modal .positionJs').html(getPositionShortCode($(this).data('position'),$(this).data('id')));
                $('.js-create-player-bid-modal .positionJs').addClass('is-'+getPositionShortCode($(this).data('position'),$(this).data('id')).toLowerCase());
                $(".js-create-player-bid-modal").modal('show');        
            }
        });
    };

    return {
        init: function() {
            pageLoad();
            initMoibleOrDeskTop();
            initPlayerFilters();
            createPlayerBid();
            isMobileScreen();
            slimScroll();
            getFilterValues();
            positionClick();
            initSelect2();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    Players.init();
});