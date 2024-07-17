var Players = function() {

     var addIsDisabled = function() {
        $( ".is-disabled" ).each(function() {
            $(this).parents('tr').addClass('is-disabled');
            $(this).removeClass('is-disabled');
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
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                serverSide: true,
                autoWidth:false,
                processing: true,
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
                    data: 'playerPositionShort',
                    title: 'Player',
                    name: 'playerPositionShort',
                    render: function(data,display,row) {

                        var position = row.position;

                        var html = '<div class="player-wrapper"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span><div><span class="team-name">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'</span></div>';


                        if(row.bid && row.team_name && Site.team.id == row.team_id){
                            return '<div class="player-wrapper"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span><div><a href="javascript:void(0);" class="text-dark js-detail-player-bid" data-bid="'+row.bid+'" data-player-id="'+row.id+'" data-team="'+row.team_id+'" data-player="'+Global.get_player_name('fullName', row.player_first_name, row.player_last_name)+'" data-club-short="'+row.short_code+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+position+'" data-contract="'+row.team_player_contract_id+'"><span class="team-name">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'</span></a></div>';
                        }

                        if(row.bid && row.team_name){
                            return html;
                        }

                        if(Site.defaultSquadSize == Site.totalTeamPlayers && Site.team.id != row.team_id){
                            return html;
                        }
                        if(typeof Site.teamClubsPlayer[row.club_id] !== 'undefined' && Site.teamClubsPlayer[row.club_id] == Site.maxClubPlayers && Site.team.id != row.team_id) {
                            return html;
                        }


                        if(row.playerPositionFull == Site.allPositionEnum.DEFENSIVE_MIDFIELDER) {

                            position = 'MF';
                        }


                        if(_.includes(Site.availablePostions, position)) {

                            return '<div class="player-wrapper"><span class="custom-badge custom-badge-lg is-square is-'+position.toLowerCase()+'">'+position+'</span><div><a href="javascript:void(0);" class="text-dark js-create-player-bid" data-player="'+Global.get_player_name('fullName', row.player_first_name, row.player_last_name)+'" data-club-id="'+row.club_id+'" data-club="'+row.short_code+'" data-id="'+row.id+'" data-position="'+position+'"><span class="team-name">'+Global.get_player_name('firstNameFirstCharAndFullLastName', row.player_first_name, row.player_last_name)+'</span></a></div>';

                        }else{

                            return html;
                        }

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
                    data: 'bid',
                    title: 'BID',
                    name: 'bid',
                    className: "text-center",
                    render: function(data,display,row) {
                        if(row.bid)
                        {
                            return '&pound;'+parseFloat(row.bid)+'m';
                        }
                        return '-';

                    }
                },
                {
                    data: 'total_game_played',
                    title: 'PLD',
                    name: 'total_game_played',
                    className: "text-center",
                    defaultContent: '0',
                },
                {
                    data: 'total',
                    title: 'PTS',
                    name: 'total',
                    className: "text-center",
                    defaultContent: '0'
                },

                {
                    data: '',
                    title: '',
                    name: '',
                    className: "text-center",
                    render: function(data,display,row) {

                        var position = row.position;
                        var isDisabled = 'is-disabled';

                        if(row.bid && row.team_name && Site.team.id == row.team_id){
                            return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark js-detail-player-bid" data-bid="'+row.bid+'" data-player-id="'+row.id+'" data-team="'+row.team_id+'" data-player="'+Global.get_player_name('fullName', row.player_first_name, row.player_last_name)+'" data-club-short="'+row.short_code+'" data-club="'+row.club_name+'" data-id="'+row.id+'" data-position="'+position+'" data-contract="'+row.team_player_contract_id+'"><span><img src="'+Site.assetUrl+'/img/auction/bid-edit.svg" draggable="false"></span></a></div></div>';
                        }

                        if(row.bid && row.team_name){
                            return '<div class="text-muted text-uppercase won-by '+isDisabled+'"><span><strong>won by</strong> <br> '+row.team_name+'</span></div>'
                        }

                        if(Site.defaultSquadSize == Site.totalTeamPlayers && Site.team.id != row.team_id){
                            return '<div class="quota-player '+isDisabled+'"><span class="text-muted text-uppercase"><strong>Full</strong> <i class="fas fa-tshirt"></i></span></div>';
                        }
                        if(typeof Site.teamClubsPlayer[row.club_id] !== 'undefined' && Site.teamClubsPlayer[row.club_id] == Site.maxClubPlayers && Site.team.id != row.team_id) {
                            return '<div class="quota-player '+isDisabled+'"><span class="text-muted text-uppercase"><strong>CLUB QUOTA</strong></span></div>';
                        }


                        if(row.playerPositionFull == Site.allPositionEnum.DEFENSIVE_MIDFIELDER) {

                            position = 'MF';
                        }


                        if(_.includes(Site.availablePostions, position)) {

                            return '<div class="text-muted text-uppercase won-by"><div class="icon-edit"><a href="javascript:void(0);" class="text-dark js-create-player-bid" data-player="'+Global.get_player_name('fullName', row.player_first_name, row.player_last_name)+'" data-club-id="'+row.club_id+'" data-club="'+row.short_code+'" data-id="'+row.id+'" data-position="'+position+'"><span><img src="'+Site.assetUrl+'/img/auction/bid-add.svg" draggable="false"></span></a></div></div>';

                        }else{

                            return '<div class="formation-validation d-flex justify-content-center align-items-center '+isDisabled+'"><div class="text-uppercase"><strong>Invalid <br> formation</strong></div></div>';
                        }

                    }
                },
            ],
            aoColumnDefs: [
                   { aTargets: [ 0 ], bSortable: true},
                   { aTargets: [ 1 ], bSortable: true},
                   { aTargets: [ 2 ], bSortable: true },
                   { aTargets: [ 3 ], bSortable: false },
                   { aTargets: [ 4 ], bSortable: false },
                   { aTargets: [ 5 ], bSortable: false },
                   { aTargets: [ 6 ], bSortable: false },
            ],
            order: []
        });

        $( datatablePlayers.table().header() ).addClass('thead-dark table-dark-header');
    };

    var readFilters = function() {

        var position =  $('.js-filter-position').val() || null;
        var club =  $('.js-filter-club').val() || null;
        var name =  $('.js-player_name').val() || null;
        var bought_player = $(".js-boughtPlayers").is(':checked') ? 'no' : 'yes';


        var auctionFilters = {
            'position' : position,
            'club' : club,
            'player' : name,
            'boughtPlayers' : bought_player,
        };

        localStorage.setItem("offlineAuctionFilters", JSON.stringify(auctionFilters));

        return auctionFilters;
    };

    var defaultFilterPlayer = function() {
        var auctionFilters = localStorage.getItem("offlineAuctionFilters");
        if (typeof(auctionFilters) !== "undefined" && auctionFilters !== null) {
            auctionFilters = JSON.parse(auctionFilters);
            $('.js-filter-position').val(auctionFilters.position);
            $('.js-filter-club').val(auctionFilters.club);
            $('.js-player_name').val(auctionFilters.player);
            if(auctionFilters.boughtPlayers == 'no') {
                $('.js-boughtPlayers').prop('checked',true);
            }
        }

        initDatatablePlayers();
    };

    var filterPlayerUrl = function() {

        datatablePlayers.ajax.reload();
    };

    var initPlayerFilters = function () {

        $('.js-filter-position').on('change', function(e) {
            filterPlayerUrl();
        });
        
        $('.js-filter-club').on('change', function(e) {
            filterPlayerUrl();
        });

        $(".js-player_name").keyup(function(){
            filterPlayerUrl();
        });

        $('.js-boughtPlayers').on('click', function(e) {
            filterPlayerUrl();
        });
    };

    var createPlayerBidModal = function() {

        $(document).on('click', '.js-create-player-bid', function(event) {
            $('.js-create-player-bid-modal #player_id').val($(this).data('id'));
            $('.js-create-player-bid-modal #club_id').val($(this).data('club-id'));
            $('.js-create-player-bid-modal #amount').val();
            $('.js-create-player-bid-modal .player-bid-modal-title').html($(this).data('player'))
            $('.js-create-player-bid-modal .player-bid-modal-text').html($(this).data('club'));
            var tshirtClass = $('.js-create-player-bid-modal .positionJs');
            removeTshirtClass(tshirtClass);

            tshirtClass.html($(this).data('position'));
            tshirtClass.addClass('is-'+$(this).data('position').toLowerCase());
            $(".js-create-player-bid-modal").modal('show');
        });
    }

    var editPlayerBidModal = function() {

        $(document).on('click', '.js-edit-player-bid', function(event) {
            $('.js-edit-player-bid-modal #player_id').val($(this).data('id'));
            $('.js-edit-player-bid-modal #team_id').val($(this).data('team'));
            $('.js-edit-player-bid-modal #amount').val(parseFloat($(this).data('bid')));
            $('.js-edit-player-bid-modal #old_amount').val(parseFloat($(this).data('bid')));
            $(".js-edit-player-bid-modal .modal-title").html($(this).data('player')+' ('+$(this).data('club-short')+') '+$(this).data('position')+' ');
            $(".js-edit-player-bid-modal").modal('show');
        });

        $('.js-edit-player-bid-modal').on('shown.bs.modal', function (e) {
          $('body').addClass('modal-open');
        });
    }

    var detailPlayerBidModal = function() {

        $(document).on('click', '.js-detail-player-bid', function(event) {
            $('.js-edit-player-bid-modal #team_id').val($(this).data('team'));
            $('.js-detail-player-bid-modal #amount').val('');
            $('.js-detail-player-bid-modal .player-bid-modal-title').html($(this).data('player'))
            $('.js-detail-player-bid-modal .player-bid-modal-text').html($(this).data('club-short'));

            var tshirtClass = $('.js-detail-player-bid-modal .positionJs');
            removeTshirtClass(tshirtClass);
            tshirtClass.html($(this).data('position'));
            tshirtClass.addClass('is-'+$(this).data('position').toLowerCase());

            $('.js-detail-player-bid-modal').modal('show');


            $('.js-edit-player-bid-modal #player_id').val($(this).data('player-id'));
            $('.js-edit-player-bid-modal #team_id').val($(this).data('team'));
            $('.js-edit-player-bid-modal #amount').val(parseFloat($(this).data('bid')));
            $('.js-edit-player-bid-modal #old_amount').val(parseFloat($(this).data('bid')));
            $('.js-edit-player-bid-modal .player-bid-modal-title').html($(this).data('player'))
            $('.js-edit-player-bid-modal .player-bid-modal-text').html($(this).data('club-short'));
            var tshirtClass = $('.js-edit-player-bid-modal .positionJs');
            removeTshirtClass(tshirtClass);
            $('.js-edit-player-bid-modal .positionJs').html($(this).data('position'));
            $('.js-edit-player-bid-modal .positionJs').addClass('is-'+$(this).data('position').toLowerCase());

            $('.delete-confirmation-button').attr('href',route('manage.division.team.contract.destroy', { division: Site.division.id, team: $(this).data('team'), player: $(this).data('player-id')}));
        });
    }

    var openPlayerEditModal = function() {

        $(document).on('click', '.edit-button-modal', function(event) {

            $(".js-detail-player-bid-modal").modal('toggle');
            $(".js-edit-player-bid-modal").modal('show');
        });
    }

     var editPlayerBid = function () {
        $('.js-player-bid-edit-form').validate(Global.buildValidateParams({
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
                        return parseFloat(Site.teamBudget) + parseFloat($('.js-edit-player-bid-modal #old_amount').val());
                    }
                },
                'old_amount': {
                    required: true,
                    number: true,
                },
            },
            messages: {
                amount: {
                    max : jQuery.validator.format("The remaining budget is £{0}m."),
                }
            },
            submitHandler: function(form) {
                $('.editBtn').attr('disabled', true);
                form.submit();
            }
        }));
    }

    var positionClick = function(){

        $('.js-player-positions').on('click', function(e) {
            if(isMobileScreen()) {
                $('#full-screen-modal').modal('show');
            }
            $('.js-filter-position').val($(this).data('position')).trigger('change');
        });

        $('#full-screen-modal').on('shown.bs.modal', function (e) {
            $(".modal-card-body").scrollTop(0);
        })
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
                    bidIncrement : true,
                    max: function() {
                        return parseFloat(Site.teamBudget);
                    }
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
            messages: {
                amount: {
                    max : jQuery.validator.format("The remaining budget is £{0}m."),
                }
            },
            submitHandler: function(form) {
                $('.createBtn').attr('disabled', true);
                form.submit();
            }
        }));
    }

    var initSelect2 = function() {
        var options = {};
        if(isMobileScreen()) {
            options = { dropdownParent: $('#full-screen-modal') };
        }

        $('.js-select2').select2(options);

    }

    var getPosition = function(mystring) {
        return  Site.playerPositions[mystring].toLowerCase();
    }

    var removeTshirtClass = function(className){
        className.removeClass (function (index, className) {
            return (className.match (/\is\S+/g) || []).join(' ');
        });
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
        window.innerWidth <= 800 ? true : false;
    }

    return {
        init: function() {
            initMoibleOrDeskTop();
            pageLoad();
            defaultFilterPlayer();
            initPlayerFilters();
            createPlayerBidModal();
            editPlayerBidModal();
            detailPlayerBidModal();
            openPlayerEditModal();
            editPlayerBid();
            createPlayerBid();
            positionClick();
            initSelect2();
            isMobileScreen();
            slimScroll();
            initFormValidationMethod();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    Players.init();
});
