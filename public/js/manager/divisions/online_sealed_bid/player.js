var datatablePlayers = '';
var AuctionOnlineSealedBidsPlayers = function() {

    var initDatatablePlayers = function() {
        if (! $.fn.DataTable.isDataTable( 'js-table-filter-players') ) {
            datatablePlayers =  $('.js-table-filter-players').DataTable({
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
                    //autoWidth: true,
                    scrollCollapse: true,
                    scrollX: true,
                    stateSave: true,
                    drawCallback: function() {
                        addIsDisabled();
                    },
                    'order':[[3,'desc'],[2,'desc']],
                    "orderFixed": {
                        "post": [[ 1, 'asc' ], [ 7, 'asc' ], [ 5, 'asc' ], [ 6, 'asc' ]]
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
                        "orderSequence": [ "desc", "asc" ]
                    },
                    {
                        data: 'id',
                        title: '&nbsp;&nbsp;&nbsp;&nbsp;',
                        name: 'id',
                        className: "text-center",
                        render: function(data,display,row) {

                            var isDisabled = 'is-disabled';

                            if(!Site.isOwnTeam) {
                                
                                return '<div class="text-muted text-uppercase won-by disabled '+isDisabled+'"><div class="icon-edit"><a href="javascript:void(0);"  class="text-dark"><i class="fas fa-minus"></i></a></div></div>';
                            }

                            var totalClubCount = 0;

                            if(typeof Site.teamClubsPlayer[row.playerClubId] !== 'undefined') {

                                totalClubCount = Site.teamClubsPlayer[row.playerClubId];
                            }

                            if(Site.team.defaultSquadSize == Site.team.squadSize && Site.team.id != row.soldPlayerTeamId) {

                                return '<div class="quota-player '+isDisabled+'"><span class="text-muted text-uppercase"><strong>Full</strong> <i class="fas fa-tshirt"></i></span></div>';
                            }

                            if(!row.sealed_bid_id && totalClubCount === parseInt(Site.maxClubPlayers) && Site.team.id != row.soldPlayerTeamId) {

                                return '<div class="quota-player '+isDisabled+'"><span class="text-muted text-uppercase"><strong>CLUB QUOTA</strong></span></div>';
                            }

                            if(row.sealed_bid_id) {

                                return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark js-player-bid-view" data-player="'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playerFirstName, row.playerLastName)+'" data-club="'+row.playerClubName+'" data-player-id="'+row.playerId+'" data-position="'+row.playerPositionShort+'" data-amount="'+row.sealed_bid_amount+'" data-id="'+row.sealed_bid_id+'"><span><img src="'+Site.assetUrl+'/img/auction/bid-edit.svg" draggable="false"></span></a></div></div>';
                            }

                            if(row.soldPlayerTeamId) {

                                if(row.soldPlayerTeamId === Site.team.id) {

                                    return '<div class="won-player '+isDisabled+'"><span class="bg-primary text-white py-1 px-2 text-uppercase">Won <i class="far fa-check"></i></span></div>';
                                }

                                return '<div class="text-muted text-uppercase won-by '+isDisabled+'"><span><strong>won by</strong> <br> '+row.soldPlayerTeamName+'</span></div>';
                            }


                            if(row.playerPosition == Site.allPositionEnum.DEFENSIVE_MIDFIELDER) {

                                row.playerPositionShort = 'MF';
                            }
                            

                            if(!_.includes(Site.availablePostions, row.playerPositionShort)) {

                                return '<div class="formation-validation d-flex justify-content-center align-items-center '+isDisabled+'"><div class="text-uppercase"><strong>FORMATION QUOTA</strong></div></div>';
                            }

                            return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" data-player="'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.playerFirstName, row.playerLastName)+'" data-club="'+row.playerClubName+'" data-player-id="'+row.playerId+'"  data-position="'+row.playerPositionShort+'" class="text-dark js-player-bid-add"><span><img src="'+Site.assetUrl+'/img/auction/bid-add.svg" draggable="false"></span></a></div></div>';
                            
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
                       // { aTargets: [ 5 ], bSortable: true},
                       // { aTargets: [ 6 ], bSortable: true},
                       // { aTargets: [ 7 ], bSortable: true},
                       // { aTargets: [ 8 ], bSortable: false},
                       
                ],
            });
        }

        $( datatablePlayers.table().header() ).addClass('thead-dark table-dark-header');
    };

    var playerBidModal = function() {

        $(document).on('click', '.js-player-bid-add', function(event) {
            $('.js-player-bid-modal-add').find($('.player-bid-modal-title')).html($(this).data('player'));
            $('.js-player-bid-modal-add').find($('.player-bid-modal-text')).html($(this).data('club'));
            $('.js-player-bid-modal-add').find($('#player_id')).val($(this).data('player-id'));
            $('.js-player-bid-modal-add').find($('.custom-badge')).addClass( 'is-'+$(this).data('position').toLowerCase());
            $('.js-player-bid-modal-add').find($('.custom-badge')).html( $(this).data('position') );
            $('.js-player-bid-modal-add').find($('#amount')).val(0);
            $(".js-player-bid-modal-add").modal('show');
        });

        $(document).on('click', '.js-player-bid-view', function(event) {

            $('.js-player-bid-modal-view').find($('.player-bid-modal-title')).html($(this).data('player'));
            $('.js-player-bid-modal-view').find($('.player-bid-modal-text')).html($(this).data('club'));
            $('.js-player-bid-modal-view').find($('#player_id')).val($(this).data('player-id'));
            $('.js-player-bid-modal-view').find($('.custom-badge')).addClass( 'is-'+$(this).data('position').toLowerCase() );
            $('.js-player-bid-modal-view').find($('.custom-badge')).html( $(this).data('position') );

            var deleteUrl = route('manage.auction.online.sealed.bid.players.destroy', { division : Site.divisionId, sealBid: $(this).data('id') })
            $('.js-player-bid-modal-view').find($('.delete-confirmation-button')).attr('href',deleteUrl);

            //Edit Model
            $('.js-player-bid-modal-edit').find($('.player-bid-modal-title')).html($(this).data('player'));
            $('.js-player-bid-modal-edit').find($('.player-bid-modal-text')).html($(this).data('club'));
            $('.js-player-bid-modal-edit').find($('.custom-badge')).addClass( 'is-'+$(this).data('position').toLowerCase() );
            $('.js-player-bid-modal-edit').find($('.custom-badge')).html( $(this).data('position') );
            $('.js-player-bid-modal-edit').find($('#player_id_edit')).val($(this).data('player-id'));
            $('.js-player-bid-modal-edit').find($('#amount_edit')).val($(this).data('amount'));
            $('.js-player-bid-modal-edit').find($('#amount_edit_old')).val($(this).data('amount'));
            $('.js-player-bid-modal-edit').find($('#bid_id')).val($(this).data('id'));
            $(".js-player-bid-modal-view").modal('show');
        });

        $(document).on('click', '.js-player-bid-edit', function(event) {
            $(".js-player-bid-modal-view").modal('hide');
            $(".js-player-bid-modal-edit").modal('show');
        });

        $('.js-player-bid-modal-edit').on('shown.bs.modal', function (e) {
          $('body').addClass('modal-open');
        });

        $(document).on('click', '.js-player-full-name', function(event) {
            if($(this).closest('tr').find('.js-player-bid-add').length > 0) {
                $(this).closest('tr').find('.js-player-bid-add').trigger( "click" );
            }

            if($(this).closest('tr').find('.js-player-bid-view').length > 0) {
                $(this).closest('tr').find('.js-player-bid-view').trigger( "click" );
            }

        });
    };

    var readFilters = function() {

        var position =  $('.js-position').val();
        var club =  $('.js-club').val();
        var name =  $('.js-name').val();
        var bought_player = $(".js-bought_player").is(':checked') ? 'no' : 'yes';


        var auctionFilters = {
            'position' : position,
            'club' : club,
            'name' : name,
            'bought_player' : bought_player,
        };

        localStorage.setItem("auctionFilters", JSON.stringify(auctionFilters));

        return auctionFilters;
    };

    var filterPlayerUrl = function() {

        datatablePlayers.ajax.reload();
    };

    var defaultFilterPlayer = function() {
        var auctionFilters = localStorage.getItem("auctionFilters");
        if (typeof(auctionFilters) !== "undefined" && auctionFilters !== null) {
            auctionFilters = JSON.parse(auctionFilters);
            $('.js-position').val(auctionFilters.position);
            $('.js-club').val(auctionFilters.club);
            $('.js-name').val(auctionFilters.name);
            if(auctionFilters.bought_player == 'no') {
                $('.js-bought_player').prop('checked',true);
            }
        }

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

        if($(window).width() > 991) {

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

    var initPlayerName = function() {
        fitty('.player-wrapper-title', {
                minSize: 7,
                maxSize: 11
            });
    }

    var initFormValidationMethod = function() {
        jQuery.validator.addMethod("bidIncrement", function(value, element) {

            if(Global.check_number_is_divisible(value, Site.bidIncrement)) {

               return true;
            }

            return false;

        }, 'Bid must be a multiple of &pound;'+Site.bidIncrement+"m");
    }

    var initFormValidations = function () {
        $('.js-player-bid-create-form').validate(Global.buildValidateParams({
            rules: {
                'player_id': {
                    required: true,
                },
                'amount': {
                    required: true,
                    number: true,
                    min:0,
                    bidIncrement : true,
                    max: function() {
                        return parseFloat(Site.teamBudget);
                    }
                },
            },
            messages: {
                amount: {
                    max : jQuery.validator.format("The remaining budget is £{0}m."),
                }
            },
            submitHandler: function(form) {
                $(".js-btn-create").attr("disabled", true);
                form.submit();
            }
        }));

        $('.js-player-bid-edit-form').validate(Global.buildValidateParams({
            rules: {
                'player_id': {
                    required: true,
                },
                'bid_id': {
                    required: true,
                },
                'amount': {
                    required: true,
                    number: true,
                    min:0,
                    bidIncrement : true,
                    max: function() {

                        return parseFloat(Site.teamBudget) + parseFloat($('#amount_edit_old').val());
                    }
                },
            },
            messages: {
                amount: {
                    max : jQuery.validator.format("The remaining budget is £{0}m."),
                }
            },
            submitHandler: function(form) {
                $(".js-btn-update").attr("disabled", true);
                form.submit();
            }
        }));
    };

    var addIsDisabled = function() {

        $( ".is-disabled" ).each(function() {
            $(this).parents('tr').addClass('is-disabled');
            $(this).removeClass('is-disabled');
        });
    }

    return {
        init: function() {
            initMoibleOrDeskTop();
            defaultFilterPlayer();
            initPageResize();
            playerBidModal();
            initFormValidations();
            slimScroll();
            filterPlayerOnChange();
            initSelect2();
            initPlayerName();
            initFormValidationMethod();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AuctionOnlineSealedBidsPlayers.init();
});
