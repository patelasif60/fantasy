var datatablePlayers = '';
var superSubMessageFlag = false;
var isPlayerTransferEnabled = false;
var playersData = Site.playersData;
var oldPlayer = [];
var newPlayer = [];
var playerClubId  = '';
var tempClubId = _.cloneDeep(Site.teamClubsPlayer);
var TransferOnlineSealedBidsPlayers = function() {

    var addIsDisabled = function() {

        $( ".is-disabled" ).each(function() {
            $(this).parents('tr').addClass('is-disabled');
            $(this).removeClass('is-disabled');
        });
    }

    var initDatatablePlayers = function() {

        if (! $.fn.DataTable.isDataTable( 'js-table-filter-players') ) {

                datatablePlayers = $('.js-table-filter-players').DataTable({
                    ajax: {
                        url: $('.js-table-filter-players').data('url'),
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
                    scrollCollapse: true,
                    scrollX: true,
                    stateSave: true,
                    processing: true,
                    drawCallback: function() {
                        addIsDisabled();
                    },
                    'order':[[3,'desc'],[2,'desc']],
                    "orderFixed": {
                        "post": [[ 1, 'asc' ], [ 7, 'asc' ],[ 5, 'asc' ], [ 6, 'asc' ]]
                    },
                    columns: [
                    {
                        data: 'playerFirstName',
                        title: 'Player',
                        name: 'playerFirstName',
                        className: "text-left position js-player-full-name",
                        orderData: [ 6, 5 ],
                        render: function(data,display,row) {

                            var position = row.playerPositionShort;

                            var tshirt = row.playerClubShortCode.toLowerCase()+'_player';
                            if(Site.isGk == position) {
                                tshirt = row.playerClubShortCode.toLowerCase()+'_gk';
                            }

                            return '<div class="player-wrapper"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span> <div><div class="player-tshirt icon-18 '+tshirt+' mr-1"></div> <a href="javascript:void(0);" class="team-name link-nostyle">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playerFirstName, row.playerLastName)+'</a></div> </div>';
                        }
                    },
                    {
                        data: 'playerClubShortCode',
                        title: 'Club',
                        name: 'playerClubShortCode',
                        defaultContent: '-',
                        "orderSequence": [ "desc", "asc" ]
                    },
                    {
                        data: 'total_game_played',
                        title: 'PLD',
                        name: 'total_game_played',
                        defaultContent: '-',
                        "orderSequence": [ "desc", "asc" ]
                    },
                    {
                        data: 'total_points',
                        title: 'TOT',
                        name: 'total_points',
                        defaultContent: '-',
                    },
                    {
                        data: 'id',
                        title: '',
                        name: 'id',
                        className: "text-center",
                        render: function(data,display,row) {

                            var isDisabled = 'is-disabled';

                            var totalClubCount = 0;

                            if(typeof Site.teamClubsPlayer[row.playerClubId] !== 'undefined') {

                                totalClubCount = Site.teamClubsPlayer[row.playerClubId];
                            }

                            if(totalClubCount >= parseInt(Site.maxClubPlayers) && Site.team.id != row.soldPlayerTeamId) {

                                return '<div class="quota-player '+isDisabled+'"><span class="text-muted text-uppercase"><strong>CLUB QUOTA</strong></span></div>';
                            }

                            if(row.soldPlayerTeamId) {

                                return '<div class="text-muted text-uppercase won-by '+isDisabled+'"><span><strong>&pound;'+row.soldPlayerTransferValue+'m</strong> <br> '+row.soldPlayerTeamName+'</span></div>';
                            }

                            var position = row.playerPosition;

                            var playerAddDisabled = 'd-none';
                            var playerAddEnabled = 'd-none';
                            var find = _.find(playersData, ['newPlayerId', row.playerId ]);


                            if(_.isUndefined(find)) {

                                playerAddEnabled = '';

                            } else {

                                playerAddDisabled = '';
                            }

                            var disabled = '<div class="'+playerAddDisabled+'" id="js_datatable_player_disabled_'+row.playerId+'"><div class="icon-edit"><a href="javascript:void(0);" data-player="'+row.playerFirstName+' '+row.playerLastName+'" data-club="'+row.playerClubName+'" data-player-id="'+row.playerId+'"  data-position="'+row.playerPositionShort+'" data-club-id="'+row.playerClubId+'" data-new="'+row.playerId+'" class="js-new-player-edit"><span><img src="'+Site.assetUrl+'/img/auction/bid-edit.svg"></span></a></div></div>';
                            var enabled = '<div class="'+playerAddEnabled+'" id="js_datatable_player_enabled_'+row.playerId+'"><div class="icon-edit"><a href="javascript:void(0);" data-player="'+row.playerFirstName+' '+row.playerLastName+'" data-club="'+row.playerClubName+'" data-player-id="'+row.playerId+'"  data-position="'+row.playerPositionShort+'" data-club-id="'+row.playerClubId+'" class="text-dark js-player-bid-add"><span><img src="'+Site.assetUrl+'/img/auction/bid-add.svg"></span></a></div></div>';

                            return disabled+enabled;
                        }
                    },
                    {
                        data: 'playerFirstName',
                        name: 'playerFirstName',
                        visible: false,
                    },
                    {
                        data: 'playerLastName',
                        name: 'playerLastName',
                        visible: false,
                    },
                    {
                        data: 'positionOrder',
                        name: 'positionOrder',
                        visible: false,
                    }
                ],
                aoColumnDefs: [
                   { aTargets: [ 0 ], bSortable: true},
                   { aTargets: [ 1 ], bSortable: true},
                   { aTargets: [ 2 ], bSortable: true},
                   { aTargets: [ 3 ], bSortable: true},
                   { aTargets: [ 4 ], bSortable: false},
                ],
            });
        }

        $( datatablePlayers.table().header() ).addClass('thead-dark table-dark-header');
    };

    var playerBidModal = function() {

            $(document).on('click', '.js-player-bid-add', function(event) {

                if(!isPlayerTransferEnabled) {

                    sweet.error('Error', Site.messages.select_player);
                    return false;
                }

                $('.js-player-bid-modal-add').find($('.player-bid-modal-title')).html($(this).data('player'));
                $('.js-player-bid-modal-add').find($('.player-bid-modal-text')).html($(this).data('club'));
                $('.js-player-bid-modal-add').find($('.custom-badge')).addClass( 'is-'+$(this).data('position').toLowerCase());
                $('.js-player-bid-modal-add').find($('.custom-badge')).html( $(this).data('position') );
                $('.js-player-bid-modal-add').find($('#amount')).val(0);
                $('.js-player-bid-modal-add').find($('#position')).val($(this).data('position'));
                $('.js-player-bid-modal-add').find($('#mode')).val('add');
                $(".js-player-bid-modal-add").modal('show');

                newPlayer = { 'id' : $(this).data('player-id'), 'amount' : $('#amount').val() , 'position': $(this).data('position'), 'club_id': $(this).data('club-id') };

            });

            $(document).on('click', '.js-replace-player', function(event) {

                var totalTransfers = playersData.length;

                if(Site.maxSealBidsPerTeamPerRound === totalTransfers) {

                    sweet.error('Error', Site.messages.max_bid_per_round);
                    return false;
                }

                if((parseInt(Site.team.monthly_quota_used) + parseInt(totalTransfers)) >= Site.monthlyFreeAgentTransferLimit) {

                    sweet.error('Error', Site.messages.monthly_quota_used);
                    return false;
                }

                if((parseInt(Site.team.season_quota_used) + parseInt(totalTransfers)) >= Site.seasonFreeAgentTransferLimit) {

                    sweet.error('Error', Site.messages.season_quota_used);
                    return false;
                }

                if(!superSubMessageFlag) {
                    
                    sweet.error('', Site.messages.supersub_reset, "warning");
                    superSubMessageFlag = true;
                }

                if(isMobileScreen()) {
                    $('#full-screen-modal-mobile').modal('show');
                }
                var amount = $(this).data('amount');
                $('#amount_old').val(amount);
                $('.auction-player-wrapper').removeClass('is-selected');
                $(this).find($('.auction-player-wrapper')).addClass('is-selected');
                $('.js-replace-player-name').removeClass('d-none').addClass('d-flex').find($('span')).html($(this).data('player-name'));
                validateClubs($(this).data('club'),'select');
                oldPlayer = { 'id' : $(this).data('player-id'), 'amount' : $(this).data('amount') };

                setBudget(amount);

                isPlayerTransferEnabled = true;
            });

            $(document).on('click', '.js-form-submit', function(event) {
                $(this).attr("disabled", true);
                $(".js-players-bids-create-form").submit();
            });

            $(document).on('click', '.js-new-player-edit', function(event) {

                $('.js-player-bid-modal-view').find($('.player-bid-modal-title')).html($(this).data('player'));
                $('.js-player-bid-modal-view').find($('.player-bid-modal-text')).html($(this).data('club'));
                $('.js-player-bid-modal-view').find($('.custom-badge')).addClass( 'is-'+$(this).data('position').toLowerCase());
                $('.js-player-bid-modal-view').find($('.custom-badge')).html( $(this).data('position') );

                var player = _.find(playersData, { 'newPlayerId': $(this).data('new') });

                if(!_.isUndefined(player)) {

                    oldPlayer = { 'id' : player.oldPlayerId, 'amount' : player.oldPlayerAmount};
                    newPlayer = { 'id' : player.newPlayerId, 'club_id' : player.club_id };

                    $('.js-player-bid-modal-add').find($('#mode')).val('edit');
                    $('.js-player-bid-modal-add').find($('.player-bid-modal-title')).html($(this).data('player'));
                    $('.js-player-bid-modal-add').find($('.player-bid-modal-text')).html($(this).data('club'));
                    $('.js-player-bid-modal-add').find($('.custom-badge')).addClass( 'is-'+$(this).data('position').toLowerCase() );
                    $('.js-player-bid-modal-add').find($('.custom-badge')).html( $(this).data('position') );
                    $('.js-player-bid-modal-add').find($('#position')).val($(this).data('position'));
                    $('.js-player-bid-modal-add').find($('#player_id')).val(player.newPlayerId);
                    
                    $('.js-player-bid-modal-add').find($('#amount')).val(player.newPlayerAmount);
                    $('.js-player-bid-modal-add').find($('#amount_old')).val(player.newPlayerAmount);

                    $('.js-player-bid-delete').attr('data-old-player', player.oldPlayerId);
                    $('.js-player-bid-delete').attr('data-new-player', player.newPlayerId);
                    $(".js-player-bid-modal-view").modal('show');
                }

                setBudget();
            });

            $(document).on('click', '.js-player-bid-edit', function(event) {
                $(".js-player-bid-modal-view").modal('hide');
                $(".js-player-bid-modal-add").modal('show');
            });

            $('.js-player-bid-modal-add').on('shown.bs.modal', function (e) {
              $('body').addClass('modal-open');
            });

            $(document).on('click', '.js-player-bid-delete', function(event) {

                var oldPlayer = $(this).attr('data-old-player');
                var newPlayer = $(this).attr('data-new-player');
                $('#js_replace_player_'+oldPlayer).removeClass('d-none');
                $('#js_datatable_player_disabled_'+newPlayer).addClass('d-none');
                $('#js_datatable_player_enabled_'+newPlayer).removeClass('d-none');
                $('.auction-player-wrapper').removeClass('is-selected');
                $('#js_new_player_'+newPlayer).remove();

                $(".js-player-bid-modal-view").modal('hide');

                var player = _.find(playersData, { 'newPlayerId': parseInt(newPlayer), 'oldPlayerId': parseInt(oldPlayer) });
                if(!_.isUndefined(player)) {
                    validateClubs(player.club_id,'remove');
                }

                _.remove(playersData, function(n) {
                    return n.newPlayerId == newPlayer && n.oldPlayerId == oldPlayer;
                });                

                setBudget();
                updateTextBoxJsonData();
                filterPlayerUrl();
            });

            $(document).on('click', '.js-player-full-name', function(event) {
                if($(this).closest('tr').find('.js-player-bid-add').length > 0) {
                    if($(this).closest('tr').find('.js-player-bid-add').is(":visible")) {    
                        $(this).closest('tr').find('.js-player-bid-add').trigger( "click" );
                    }
                }

                if($(this).closest('tr').find('.js-new-player-edit').length > 0) {
                    if($(this).closest('tr').find('.js-new-player-edit').is(":visible")) {    
                        $(this).closest('tr').find('.js-new-player-edit').trigger( "click" );
                    }
                }

            });
    };

    var getBudget = function(amount) {

        amount = _.isUndefined(amount) ? 0 : parseFloat(amount);

        var total = 0;
        var newBudget =  _.sumBy(playersData, function(o) { return parseFloat(o.newPlayerAmount); });
        var oldBudget =  _.sumBy(playersData, function(o) { return parseFloat(o.oldPlayerAmount); });

        if(Site.moneyBack == Site.moneyBackEnum.HUNDERED_PERCENT) {

            total = ( parseFloat(Site.team.budget) + parseFloat(oldBudget) + amount ) - parseFloat(newBudget);

        } else if(Site.moneyBack == Site.moneyBackEnum.FIFTY_PERCENT) {

            total = ( parseFloat(Site.team.budget) + ( parseFloat(oldBudget) / 2 ) + ( amount / 2 ) ) - parseFloat(newBudget);

        } else {

            total = parseFloat(Site.team.budget) - parseFloat(newBudget);
        }

        return total.toFixed(2);
    }

    var setBudget = function(amount) {

        $('.js-budget').html(getBudget(amount));
    }

    var updatePlayerData = function() {

        var amount = $('#amount').val();
        var position = $('#position').val();
        var mode = $('#mode').val();

        $('#js_replace_player_'+oldPlayer.id).addClass('d-none');
        $('#js_datatable_player_disabled_'+newPlayer.id).removeClass('d-none');
        $('#js_datatable_player_enabled_'+newPlayer.id).addClass('d-none');

        var newPlayerPosition = position.toLowerCase();

        $.ajax({
            url: $('.js-sealbid-transfer').data('player-details')+'?oldPlayerId='+oldPlayer.id+'&newPlayerId='+newPlayer.id+'&amount='+amount,
            type: 'GET',
            dataType: 'html',
        })
        .done(function(response) {
            $('#js_position_'+newPlayerPosition).append(response);
            if(isMobileScreen()) {
                $('#full-screen-modal-mobile').modal('hide');
            }
        })
        .fail(function(error) {
        });

        var isExist = _.find(playersData, ['oldPlayerId', parseInt(oldPlayer.id) ]);

        if(!_.isUndefined(isExist)) {

            $('#js_new_player_'+newPlayer.id).remove();

            _.remove(playersData, function(n) {
                return n.newPlayerId == newPlayer.id && n.oldPlayerId == oldPlayer.id;
            });
        }

        playersData.push({
            'club_id' : parseInt(newPlayer.club_id),
            'oldPlayerId' : parseInt(oldPlayer.id),
            'newPlayerId' : parseInt(newPlayer.id),
            'oldPlayerAmount' : oldPlayer.amount,
            'newPlayerAmount' : amount,
        });

        validateClubs(newPlayer.club_id,'selected');

        oldPlayer = [];
        newPlayer = [];
        $('#amount_old').val(0);

        $('.js-replace-player-name').addClass('d-none').removeClass('d-flex');
        setBudget()
        updateTextBoxJsonData();
        isPlayerTransferEnabled = false;
    }

    var updateTextBoxJsonData = function() {
        // $(".js-form-submit").attr("disabled", true);
        // if(playersData.length) {
        //     $(".js-form-submit").attr("disabled", false);
        // }
        var data = JSON.stringify(playersData);
        $('#json_data').val(data);
    }

    var readFilters = function() {

        var position =  $('.js-position').val();
        var club =  $('.js-club').val();
        var name =  $('.js-name').val();
        var bought_player = $(".js-bought_player").is(':checked') ? 'no' : 'yes';


        var transferFilters = {
            'position' : position,
            'club' : club,
            'name' : name,
            'bought_player' : bought_player,
        };

        localStorage.setItem("transferFilters", JSON.stringify(transferFilters));

        return transferFilters;
    };

    var filterPlayerUrl = function() {

        datatablePlayers.ajax.reload();
    };

    var defaultFilterPlayer = function() {
        var transferFilters = localStorage.getItem("transferFilters");
        var position = 'GK';
        if (typeof(transferFilters) !== "undefined" && transferFilters !== null) {
            transferFilters = JSON.parse(transferFilters);
            position = (transferFilters.position != "") ? transferFilters.position : position;
            $('.js-club').val(transferFilters.club);
            $('.js-name').val(transferFilters.name);
            if(transferFilters.bought_player == 'no') {
                $('.js-bought_player').prop('checked',true);
            }
        }

        $('.js-position').val(position);

       initDatatablePlayers();
    }

    var filterPlayerOnChange = function() {
        $('.js-position').change(function() {
            filterPlayerUrl();
        });

        $('.js-club').change(function() {
            filterPlayerUrl();
        });

        $(".js-name").keyup(function(){
            filterPlayerUrl();
        });

        $('.js-bought_player').change(function() {
            filterPlayerUrl();
        });

        $('.js-player-positions').click(function() {
            if(isMobileScreen()) {
                $('#full-screen-modal-mobile').modal('show');
            }
            $('.js-position').val($(this).data('position')).trigger('change');
        });
    };

    var initSelect2 = function() {
        var options = {};
        if(isMobileScreen()) {
            options = { dropdownParent: $('#full-screen-modal-mobile') };
        }
        
        $('.js-select2').select2(options);
        
    }

    var initMoibleOrDeskTop = function() {
        if(isMobileScreen()) {
            $('.js-tabing-details').remove();
        } else {
            $('#full-screen-modal-mobile').remove();
        }
    }

    var isMobileScreen = function() {

        if(window.innerWidth <= 800) {

            return true;
        }

        return false;
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
            $('.scrollbar').mCustomScrollbar("destroy");
        }
    }

    var initPageResize = function() {
        $(window).bind("load", function() {
            slimScroll();
        });
        $(window).on("orientationchange, resize", function(event) {
            slimScroll();
        });
    }

    var defaultContentSetOnEdit = function() {
        updateTextBoxJsonData();
        setBudget();
    };

    var initFormValidationMethod = function() {
        jQuery.validator.addMethod("bidIncrement", function(value, element) {

            if(Global.check_number_is_divisible(value, Site.sealBidIncrement)) {

               return true;
            }

            return false;

        }, 'Bid must be a multiple of &pound;'+Site.sealBidIncrement+"m");
    }

    var initFormValidations = function () {

        $('.js-player-bid-create-form').validate(Global.buildValidateParams({
            rules: {
                'amount': {
                    required: true,
                    number: true,
                    bidIncrement : true,
                    min: function() {
                        var sealBidMinimum = parseFloat(Site.sealBidMinimum);

                        return (sealBidMinimum === 0 || sealBidMinimum === 0.00) ? 0 : sealBidMinimum;
                    },
                    max: function() {

                        if($('#mode').val() == 'edit') {
                            var budget =  parseFloat(getBudget()) + parseFloat($('#amount_old').val());
                            
                            return budget;
                        }

                        var returnAmount = 0;

                        if(Site.moneyBack == Site.moneyBackEnum.HUNDERED_PERCENT) {
                            returnAmount = parseFloat($('#amount_old').val());
                        } else if(Site.moneyBack == Site.moneyBackEnum.FIFTY_PERCENT) {
                            returnAmount = (parseFloat($('#amount_old').val()) / 2);
                        }

                        return parseFloat(getBudget()) + returnAmount;
                    },
                },
            },
            submitHandler: function(form) {
                updatePlayerData();
                $(".js-player-bid-modal-add").modal('hide');
            }
        }));
    };

    var validateClubs = function (club,mode) {

        if(mode == 'select') {
            Site.teamClubsPlayer = _.cloneDeep(tempClubId);
            if(_.isUndefined(Site.teamClubsPlayer[club])) {
                Site.teamClubsPlayer[club] = 1;
                tempClubId = _.cloneDeep(Site.teamClubsPlayer);
            } else {
                Site.teamClubsPlayer[club] = Site.teamClubsPlayer[club] - 1;
            }
            playerClubId = club;
        }

        if(mode == 'selected' && $('#mode').val() == 'add') {

            if(_.isUndefined(Site.teamClubsPlayer[club])) {
                Site.teamClubsPlayer[club] = 1;
                tempClubId = _.cloneDeep(Site.teamClubsPlayer);
            } else {
                Site.teamClubsPlayer[club] = Site.teamClubsPlayer[club] + 1; 
                tempClubId = _.cloneDeep(Site.teamClubsPlayer);
            }
        }

        if(mode == 'remove') {
            // if(!_.isUndefined(Site.teamClubsPlayer[club])) {
            //     Site.teamClubsPlayer[club] = Site.teamClubsPlayer[club] - 1; 
            //     tempClubId = _.cloneDeep(Site.teamClubsPlayer);
            // }
        }
        
        filterPlayerUrl();
    }

    return {
        init: function() {
            initMoibleOrDeskTop();
            defaultFilterPlayer();
            defaultContentSetOnEdit();
            initPageResize();
            playerBidModal();
            initFormValidations();
            slimScroll();
            filterPlayerOnChange();
            initSelect2();
            initFormValidationMethod();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    TransferOnlineSealedBidsPlayers.init();
});