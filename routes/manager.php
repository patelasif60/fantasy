<?php
/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
|
| Here is where you can register manager routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/incomplete/profile/edit', 'UserProfileController@completeProfile')->name('manager.incomplete.profile.edit');
    Route::post('/incomplete/profile/save', 'UserProfileController@saveCompleteProfile')->name('manager.incomplete.profile.save');
    Route::get('/more', 'HomeController@more')->name('manage.more.index');

    Route::middleware(['current.season'])->group(function () {
        Route::get('division/{division}/more', 'HomeController@moreWithDivision')->name('manage.more.division.index');
        Route::get('/more/players/{division}', 'PlayersController@getMorePLayersList')->name('manage.more.players.index');
        Route::post('/more/players/{division}', 'PlayersController@players')->name('manage.more.players.data');
        Route::post('/more/insout/{division}', 'PlayersController@insout')->name('manage.more.insout.data');
        Route::get('/more/players/{division}/details', 'PlayersController@playersDetails')->name('manage.more.players.data.details');
        Route::get('/more/players/export_pdf/{division}', 'PlayersController@exportToPdf')->name('manage.more.players.export_pdf');
        Route::get('/more/players/export_xlsx/{division}', 'PlayersController@exportToXlsx')->name('manage.more.players.export_xlsx');
        Route::post('/more/history/{division}/playerdata', 'PlayersController@historyPlayerdata')->name('manage.more.history.playerdata');
    });

    Route::middleware(['consumer.profile'])->group(function () {
        // Route::get('/home', 'HomeController@index')->name('manager.home.index');
        
        // Division package route
        Route::get('/division/package/selection', 'DivisionsController@selection')->name('manage.division.package.selection');
        Route::post('/division/package/description/{package}', 'DivisionsController@description')->name('manager.division.package.description');
        // Division package route
        Route::get('/division/create/', 'DivisionsController@create')->name('manage.division.create');
        Route::post('/division/check', 'DivisionsController@validateLeagueName')->name('manager.unique.league.check');
        Route::post('/division/join', 'DivisionsController@joinDivision')->name('manager.join.league.save');
        Route::post('/division/save/{package}', 'DivisionsController@store')->name('manager.division.save');
        //select join private/social league
        Route::get('/division/join/league/select', 'DivisionsController@selectJoin')->name('manage.division.join.league.select');
        // Invitation url to league
        Route::get('/division/join/a/league/{code}', 'DivisionsController@getInvitationDetails')->name('manager.division.join.a.league');
        // join league form
        Route::get('/division/join/new/league', 'DivisionsController@joinNewLeague')->name('manage.division.join.new.league');
        Route::get('/division/join/new/social-league', 'DivisionsController@joinNewSocialLeague')->name('manage.division.join.new.social-league');
        Route::get('/division/join/already/social-league', 'DivisionsController@joinAlreadySocialLeague')->name('manage.division.join.already.social-league');
        // join league via code
        Route::get('/division/enter/code', 'DivisionsController@enterCode')->name('manage.division.enter.code');
        Route::post('/division/search/league/by/code', 'DivisionsController@checkLeagueByCode')->name('manager.league.check.by.code');
        // Search league using provided keyword
        Route::get('/division/search/league', 'DivisionsController@searchLeague')->name('manage.league.search.league');
        Route::post('/division/search/league/results', 'DivisionsController@searchLeagueResults')->name('manage.league.search.league.results');
        Route::post('/team/check', 'TeamsController@validateTeamName')->name('manager.valid.team.check');

        Route::middleware(['current.season'])->group(function () {

            Route::get('/division/{division}/edit/', 'DivisionsController@edit')->name('manage.division.edit');
            Route::post('/division/{division}', 'DivisionsController@updateName')->name('manage.division.updateName');
            Route::get('/division/{division}/create/', 'DivisionsController@createDivision')->name('manage.division.createnew');
            Route::post('/division/{division}/save/{package}', 'DivisionsController@storeDivision')->name('manager.division.savenew');
            Route::get('/division/{division}/package/change', 'DivisionsController@changePackage')->name('manage.division.package.change');
            Route::post('/division/{division}/package/description/{package}', 'DivisionsController@packageDescription')->name('manager.division.package.details');
            Route::post('/division/{division}/package/update', 'DivisionsController@updatePackage')->name('manage.division.package.update');
            Route::get('/division/{division}/prizepack/selection', 'DivisionsController@prizePackSelection')->name('manage.division.prizepack.selection');
            Route::post('/division/{division}/prizepack/description/{prizePack}', 'DivisionsController@prizepackDescription')->name('manager.division.prizepack.details');
            Route::post('/division/{division}/prizepack/update', 'DivisionsController@updatePrizePack')->name('manage.division.prizepack.update');

            // League team routes
            Route::get('/division/{division}/create/team', 'TeamsController@create')->name('manage.division.create.team');
            Route::post('/division/{division}/store/team', 'TeamsController@store')->name('manage.division.team.store');
            //League team crest
            Route::get('/division/{division}/select/crest/{team}', 'TeamsController@selectCrest')->name('manage.division.select.crest');
            Route::post('/division/{division}/crest/store/{team}', 'TeamsController@uploadCrest')->name('manage.division.team.upload_crest');
            //League team pitch
            Route::get('/division/{division}/select/pitch/{team}', 'TeamsController@selectPitch')->name('manage.division.select.pitch');
            Route::post('/division/{division}/pitch/store/{team}', 'TeamsController@assignPitch')->name('manage.division.team.assign_pitch');
            Route::get('/division/{division}/done', 'TeamsController@appInfo')->name('manage.division.app.info');
            Route::get('/league/{team}/{division}/approval', 'DivisionsController@approvalMsg')->name('manage.division.approval.msg');
            Route::get('/division/{division}/transfers/history', 'TransfersController@history')->name('manage.division.transfer.history');
            Route::get('/division/{division}/transfers/history/list', 'TransfersController@divisionTransferHistory')->name('manage.division.transfer.history.list');
            Route::get('/division/{division}/transfers', 'TransfersController@index')->name('manage.transfer.index');
            Route::get('/division/{division}/teams', 'TeamsController@teamBudget')->name('manage.teams.budget');
            Route::get('/division/{division}/teams/list', 'TeamsController@teamsBudgetList')->name('manage.teams.budget.list');
            Route::post('/division/{division}/teams/budget/update', 'TeamsController@teamsBudgetUpdate')->name('manage.teams.budget.update');
            Route::get('/division/{division}/transfers/free_agents', 'FreeAgentsController@freeAgents')->name('manage.transfer.free_agents');
            Route::get('/division/{division}/transfers/free_agents/pdf', 'FreeAgentsController@getfreeAgentsPdf')->name('manage.transfer.free_agents.pdf');
            Route::get('/division/{division}/transfers/free_agents/excel', 'FreeAgentsController@getfreeAgentsExcel')->name('manage.transfer.free_agents.excel');
            Route::post('/division/{division}/transfers/get_free_agents', 'FreeAgentsController@getFreeAgents')->name('manage.transfer.get.free_agents');
            Route::get('/division/{division}/transfers/swap', 'SwapController@swap')->name('manage.transfer.swap');
            Route::post('/division/{division}/transfers/swap/store', 'SwapController@store')->name('manage.division.transfer.store');
            Route::post('/division/{division}/transfers/swap/get_team_players', 'SwapController@getTeamPlayers')->name('manage.division.transfer.getteamplayers');
            Route::get('/division/{division}/transfers/transfer_teams', 'TransfersController@transferTeams')->name('manage.transfer.teams');
            Route::get('/division/{division}/transfers/{team}/transfer_players', 'TransfersController@transferPlayers')->name('manage.transfer.transfer_players');
            Route::post('/division/{division}/transfers/{team}/add_players', 'TransfersController@addPlayers')->name('manage.division.transfer.add_players');
            Route::post('/division/{division}/transfers/{team}/create', 'TransfersController@create')->name('manage.division.transfer.create');
            Route::post('/division/{division}/transfers/{team}/transfer_players/store', 'TransfersController@store')->name('manage.division.transfer.transfer_players.store');
            Route::get('/division/{division}/transfers/who_owns_who', 'WhoOwnsWhoController@whoOwnsWho')->name('manage.transfer.who_owns_who');
            Route::post('/division/{division}/transfers/get_who_owns_who_players', 'WhoOwnsWhoController@getOwnedPlayers')->name('manage.transfer.get.who_owns_who');
            Route::post('/division/{division}/team/{team}', 'TransfersController@getTransferPlayers')->name('manage.division.transfer.get.players');
            Route::get('/league/{division}/auction/pdfdownloads', 'AuctionController@pdfdownloads')->name('manage.division.auction.pdfdownloads');

            // League invitations routes
            Route::get('/division/{division}/invite/managers', 'InviteManagersController@index')->name('manage.division.invite.managers');
        });

        Route::middleware(['consumer.leagueorteam'])->group(function () {

            Route::middleware(['current.season'])->group(function () {
                //Update Team on create or update
                Route::get('/division/{division}/edit/team/{team}', 'TeamsController@edit')->name('manage.division.edit.team');
                Route::post('/division/{division}/update/team/{team}', 'TeamsController@update')->name('manage.division.team.update');
                //League payment routes
                Route::get('/division/{division}/{type}/payment/index', 'LeaguePaymentsController@index')->name('manage.division.payment.index');
                Route::get('/division/{division}/{type}/preauction/index', 'LeaguePaymentsController@auctionIndex')->name('manage.auction.payment.index');
                Route::post('/division/{division}/payment/teams', 'LeaguePaymentsController@select')->name('manage.division.payment.teams');
                Route::post('/division/{division}/preauction/teams', 'LeaguePaymentsController@teams')->name('manage.division.preauction.teams');
                Route::post('/division/{division}/payment/checkout', 'LeaguePaymentsController@checkout')->name('manage.division.payment.checkout');
                Route::post('/division/{division}/payment/', 'LeaguePaymentsController@payment')->name('manage.division.payment');
                //Settings legue
                Route::get('/leagues/{division}/settings', 'DivisionsController@leagueSettings')->name('manage.division.settings');
                Route::get('/leagues/{division}/custom/cups', 'CustomCupsController@index')->name('manage.division.custom.cups.index');
                Route::get('/leagues/{division}/custom/cups/create', 'CustomCupsController@create')->name('manage.division.custom.cups.create');
                Route::get('/leagues/{division}/custom/cups/round', 'CustomCupsController@round')->name('manage.division.custom.cups.round');
                Route::post('/leagues/{division}/custom/cups/store', 'CustomCupsController@store')->name('manage.division.custom.cups.store');
                Route::get('/leagues/{division}/custom/cups/{customCup}/details', 'CustomCupsController@details')->name('manage.division.custom.cups.details');
                Route::get('/leagues/{division}/custom/cups/{customCup}/edit', 'CustomCupsController@edit')->name('manage.division.custom.cups.edit');
                Route::put('/leagues/{division}/custom/cups/{customCup}', 'CustomCupsController@update')->name('manage.division.custom.cups.update');
                Route::delete('/leagues/{division}/custom/cups/{customCup}', 'CustomCupsController@destroy')->name('manage.division.custom.cups.destroy');
                Route::get('/leagues/{division}/history', 'PastWinnerHistoryController@index')->name('manage.division.history.index');
                Route::get('/leagues/{division}/history/create', 'PastWinnerHistoryController@create')->name('manage.division.history.create');
                Route::post('/leagues/{division}/history/store', 'PastWinnerHistoryController@store')->name('manage.division.history.store');
                Route::get('/leagues/{division}/history/{selectedhistory}/edit', 'PastWinnerHistoryController@edit')->name('manage.division.history.edit');
                Route::put('/leagues/{division}/history/{history}', 'PastWinnerHistoryController@update')->name('manage.division.history.update');
                Route::delete('/leagues/{division}/history/{history}/remove', 'PastWinnerHistoryController@delete')->name('manage.division.history.remove');

                Route::get('/leagues/{division}/settings/{name}', 'DivisionsController@leagueSettingsEdit')->where('name', 'package|league|prizepack|squad_and_formations|transfer|points_setting|european_cups|history')->name('manage.division.settings.edit');
                Route::post('/leagues/{division}/settings/{name}', 'DivisionsController@leagueSettingsUpdate')->where('name', 'package|league|prizepack|squad_and_formations|transfer|points_setting|european_cups|history')->name('manage.division.settings.edit');

                //Team Approvals
                Route::get('/leagues/{division}/team/approvals', 'DivisionsController@teamApprovals')->name('manage.division.team.approvals');
                Route::get('/leagues/{division}/teams/{team}/approve', 'TeamsController@approveTeam')->name('manage.division.approve.team');
                Route::get('/leagues/{division}/teams/{team}/ignore', 'TeamsController@ignoreTeam')->name('manage.division.ignore.team');

                //For Preauction & Modals
                Route::get('/division/{division}/rules/data', 'PreauctionController@showRules')->name('manage.division.rules.data');
                Route::get('/division/{division}/rules/scoring', 'PreauctionController@scoringSystem')->name('manage.division.rules.scoring');
                Route::get('/division/{division}/rules/scoring/{event}', 'PreauctionController@positionPoints')->name('managers.division.rules.scoring.positions');
                Route::get('/division/{division}/invite/data', 'PreauctionController@showInvite')->name('manage.division.invite.data');

                //Setting League
                Route::get('/leagues/{division}/start/{role?}', 'DivisionsController@leagueIndex')->name('manage.division.start');
            });
            
            //Team Lineup Section
            Route::get('/supersub/guide/counter', 'TeamLineupController@getSupersubGuideCounter')->name('manage.supersub.guide.counter');

            //Team & League Tab Index Payment Route
            Route::middleware(['league.preauction'])->group(function () {

                //Setting League
                Route::get('/leagues', 'DivisionsController@index')->name('manage.division.index');

                Route::middleware(['current.season'])->group(function () {
                    //Settings Team
                    Route::get('/leagues/{division}/teams/{team}/lineup/view', 'TeamLineupController@lineupView')->name('manage.teams.view.lineup');
                    // pro cup fixture
                    Route::get('/leagues/{division}/info/pro_cup', 'ProCupFixtureController@index')->name('manage.league.procupfixture');
                    Route::get('/leagues/{division}/info/get_pro_cup/filter', 'ProCupFixtureController@getPhaseFixtureFilter')->name('manage.league.procupfixture.filter');
                    // custom cup
                    Route::get('/leagues/{division}/info/custom_cup/{customCup}', 'CustomCupFixtureController@index')->name('manage.league.customcupfixture');
                    Route::get('/leagues/{division}/info/custom_cup/{customCup}/round/filter', 'CustomCupFixtureController@getRoundFixtureFilter')->name('manage.league.customcupfixture.filter');
                    //FA Cup
                    Route::get('/leagues/{division}/info/fa_cup', 'DivisionsController@infoFaCup')->name('manage.division.info.fa.cup');
                    Route::get('/leagues/{division}/info/fa_cup/filter', 'DivisionsController@infoFaCupFilter')->name('manage.division.info.fa.cup.filter');
                    //Head to Head
                    Route::get('/leagues/{division}/info/head_to_head', 'DivisionsController@infoHeadToHead')->name('manage.division.info.head.to.head');
                    Route::get('/leagues/{division}/info/head_to_head/filter', 'DivisionsController@infoHeadToHeadFilter')->name('manage.division.info.head.to.head.filter');
                    //League Report division detail
                    Route::get('/league/{division}/report', 'LeagueReportsController@index')->name('manage.leaguereports');
                    //League Report division detail
                    Route::get('/league/report/division/{division}', 'LeagueReportsController@division')->name('manage.leaguereports.division');
                    Route::post('/league/report/division/{division}/email', 'LeagueReportsController@sendEmail')->name('manage.leaguereports.division.email');
                    //League Report team detail
                    Route::get('/report/{division}/team/{team?}', 'LeagueReportsController@team')->name('manage.leaguereports.team');
                    //League Report player detail
                    Route::get('/report/{division}/player', 'LeagueReportsController@player')->name('manage.leaguereports.player');

                    Route::post('/league/{division}/report/player/data', 'LeagueReportsController@players')->name('manager.leaguereports.player.data');
                    Route::post('/division/{division}/teamplayers/data', 'LeagueReportsController@teamPlayersData')->name('manage.leaguereports.teamplayersdata');
                    Route::get('/leagues/{division}/team/player/{team}/stats', 'TeamLineupController@getPlayerStats')->name('manage.team.player.stats');
                    Route::get('/leagues/{division}/team/player/{team}/stats/sold', 'TeamLineupController@getPlayerStatsSold')->name('manage.team.player.stats.sold');
                    Route::get('/leagues/{division}/team/{team}/player/{player}/season/{season}/stats', 'PlayersController@getPlayerStatsBySeason')->name('player.stats.by.season');

                    Route::get('/division/{division}/hall_of_fame', 'DivisionsController@hallOfFame')->name('manage.division.halloffame');

                    // champion-europa league
                    Route::get('/leagues/{division}/info/champion', 'ChampionEuropaController@getChampionPhases')->name('manage.league.champion.phases');
                    Route::get('/leagues/{division}/info/champion/filter', 'ChampionEuropaController@getChampionPhaseFixtures')->name('manage.league.champion.phase.fixtures');
                    Route::get('/leagues/{division}/info/champion/group', 'ChampionEuropaController@getChampionGroupStandings')->name('manage.league.champion.group');
                    Route::get('/leagues/{division}/info/europa', 'ChampionEuropaController@getEuropaPhases')->name('manage.league.europa.phases');
                    Route::get('/leagues/{division}/info/europa/filter', 'ChampionEuropaController@getEuropaPhaseFixtures')->name('manage.league.europa.phase.fixtures');
                    Route::get('/leagues/{division}/info/competition', 'ChampionEuropaController@getChampionEuropaPhaseFixtures')->name('manage.league.competition.fixtures');
                    Route::get('/leagues/{division}/info/competition/group', 'ChampionEuropaController@getChampionEuropaGroupStandings')->name('manage.league.competition.group');

                    //Team Lineup Section
                    Route::get('/leagues/{division}/teams/{team}/lineup', 'TeamLineupController@index')->name('manage.team.lineup');
                    Route::get('/leagues/{division}/player/history', 'PlayersController@historyLineupPage')->name('manage.team.player.history');
                    Route::get('/leagues/{division}/teams/{team}/lineup/more/{competition}', 'TeamLineupController@more')->name('manage.team.lineup.more');
                    Route::post('/leagues/{division}/teams/{team}/player/swap', 'TeamLineupController@swapPlayer')->name('manage.team.player.swap');
                    Route::post('/leagues/{division}/team/fixture/players', 'TeamLineupController@getPlayersForfixture')->name('manage.team.fixture.players');
                    Route::post('/leagues/{division}/team/fixture/players/{team}/swap', 'TeamLineupController@getPlayersForfixtureForSwap')->name('manage.team.fixture.players.swap');
                    Route::get('/leagues/{division}/team/{team}/supersub/check', 'TeamLineupController@checkSuperSubData')->name('manage.team.supersub.check');
                    Route::post('/leagues/{division}/team/supersub/save', 'TeamLineupController@saveSuperSubData')->name('manage.team.supersub.save');
                    Route::post('/leagues/{division}/team/{team}/supersub/send_emails', 'TeamLineupController@sendConfirmationEmails')->name('manage.team.supersub.sendemails');
                    Route::post('/leagues/{division}/team/supersub/delete', 'TeamLineupController@deleteSuperSubData')->name('manage.team.supersub.delete');
                    Route::post('/leagues/{division}/team/supersub/delete_all', 'TeamLineupController@deleteAllSuperSubData')->name('manage.team.supersub.delete_all');
                    Route::post('/leagues/{division}/team/supersub/check/next_fixture_data', 'TeamLineupController@checkTeamNextFixtureUpdatedData')->name('manage.team.supersub.check.next_fixture_data');
                    Route::post('/leagues/{division}/team/supersub/fixtures', 'TeamLineupController@getTeamSuperSubFixtures')->name('manage.team.supersub.fixtures');


                    //League standing
                    // Route::get('/leagues/{division}/info/league_standings', 'DivisionsController@infoLeagueStandings')->name('manage.division.info.league.standings');
                    Route::get('/leagues/{division}/info', 'DivisionsController@leagueInfo')->name('manage.division.info');
                    Route::get('/leagues/{division}/info/league_standings/filter', 'DivisionsController@infoLeagueStandingsFilter')->name('manage.division.info.league.standings.filter');

                    //Link League
                    Route::get('/league/{division}/linked_leagues', 'LinkedLeaguesController@index')->name('manage.linked.league.list');
                    Route::get('/league/{division}/linked_leagues/search', 'LinkedLeaguesController@searchLeague')->name('manage.linked.league.search');
                    Route::get('/league/{division}/linked_leagues/search/value', 'LinkedLeaguesController@searchLeagueByValue')->name('manage.linked.league.search.value');
                    Route::get('/league/{division}/linked_leagues/select/{league}', 'LinkedLeaguesController@selectLeague')->name('manage.linked.league.select.league');
                    Route::get('/league/{division}/linked_leagues/selected/leagues', 'LinkedLeaguesController@getAllSelectedLeague')->name('manage.linked.league.selected.leagues');
                    Route::post('/league/{division}/linked_leagues/save/leagues', 'LinkedLeaguesController@saveLinkedLeague')->name('manage.linked.league.save.leagues');
                    Route::post('/league/{division}/linked_leagues/store/leagues', 'LinkedLeaguesController@store')->name('manage.linked.league.store.leagues');
                    Route::get('/leagues/{division}/linked_leagues/{parentLinkedLeague}/info', 'LinkedLeaguesController@leagueInfo')->name('manage.linked.league.info');
                });
            });

            Route::middleware(['current.season'])->group(function () {

                //Team Settings
                Route::get('/leagues/{division}/teams', 'TeamsController@teamIndex')->name('manage.teams.index');
                Route::get('/leagues/{division}/teams/settings/{team}', 'TeamsController@teamSettings')->name('manage.teams.settings');
                Route::get('/leagues/{division}/teams/settings/{team}/edit', 'TeamsController@teamSettingsEdit')->name('manage.teams.settings.edit');
                Route::post('/leagues/{division}/teams/settings/{team}/update', 'TeamsController@teamSettingsUpdate')->name('manage.teams.settings.update');
                
                //Auction Settings
                Route::get('/league/{division}/auction/setting', 'AuctionController@create')->name('manage.division.auction.settings');
                Route::get('/league/{division}/auction/pendingpayment', 'AuctionController@pendingPayment')->name('manage.division.auction.pendingpayment');
                Route::post('/leagues/{division}/auction/setting/store', 'AuctionController@store')->name('manage.division.auction.store');
                Route::get('/leagues/{division}/auction/setting/reset', 'AuctionController@reset')->name('manage.division.auction.reset');

                Route::middleware(['auction.payment'])->group(function () {
                    
                    //Auction Routes
                    Route::get('/league/{division}/auction', 'AuctionController@index')->name('manage.auction.index');
                    //Online sealed bids
                    Route::get('/league/{division}/sealed/bids/teams', 'OnlineSealedBidController@index')->name('manage.auction.online.sealed.bid.index');
                    Route::get('/league/{division}/sealed/bids/teams/json/data', 'OnlineSealedBidController@getTeamsDataJson')->name('manage.auction.online.sealed.bid.teams.json');
                    Route::get('/league/{division}/sealed/bids/teams/{team}/details', 'OnlineSealedBidController@getTeamsDetails')->name('manage.auction.online.sealed.bid.teams');
                    Route::post('/league/{division}/sealed/bids/{team}/data/json/{tabs}', 'OnlineSealedBidController@getTabsData')->where('name', 'teams|players|bids')->name('manage.auction.online.sealed.bid.json.data');
                    Route::post('/league/{division}/sealed/bids/players/{team}/data/store', 'OnlineSealedBidController@store')->name('manage.auction.online.sealed.bid.players.store');
                    Route::put('/league/{division}/sealed/bids/players/{team}/data/update', 'OnlineSealedBidController@update')->name('manage.auction.online.sealed.bid.players.update');
                    Route::delete('/league/{division}/sealed/bids/players/{sealBid}/data/delete', 'OnlineSealedBidController@destroy')->name('manage.auction.online.sealed.bid.players.destroy');
                    Route::post('/league/{division}/sealed/bids/process/start', 'OnlineSealedBidController@processManualStart')->name('manage.auction.online.sealed.bid.process.start');

                    Route::get('/league/{division}/transfers/sealed/bids/teams', 'SealedBidTransferController@index')->name('manage.transfer.sealed.bid.index');
                    Route::get('/league/{division}/transfers/sealed/bids/teams/{team}/bids', 'SealedBidTransferController@getTeamBids')->name('manage.transfer.sealed.bid.bids');
                    Route::get('/league/{division}/transfers/sealed/bids/teams/pending/{team}', 'SealedBidTransferController@getPendingBids')->name('manage.transfer.online.sealed.bid.teams.pending');
                    Route::get('/league/{division}/transfers/sealed/bids/teams/process/{team}', 'SealedBidTransferController@getPrcoessBids')->name('manage.transfer.online.sealed.bid.teams.process');
                    Route::get('/league/{division}/transfers/sealed/bids/teams/{team}', 'SealedBidTransferController@getTeamsDetails')->name('manage.transfer.sealed.bid.team');
                    Route::post('/league/{division}/transfers/sealed/bids/{team}/data/json/players', 'SealedBidTransferController@getPlayersData')->name('manage.transfer.online.sealed.bid.json.players');
                    Route::post('/league/{division}/transfers/sealed/bids/players/{team}/data/store', 'SealedBidTransferController@store')->name('manage.transfer.online.sealed.bid.players.store');
                    Route::get('/league/{division}/transfers/sealed/bids/{team}/player/details', 'SealedBidTransferController@getPlayerDetails')->name('manage.transfer.online.sealed.bid.players.details');
                    Route::post('/league/{division}/transfers/sealed/bids/process/start', 'SealedBidTransferController@processManualStart')->name('manage.transfer.online.sealed.bid.process.start');
                    Route::post('/league/{division}/transfers/sealed/bids/process/start/single/{sealbid}', 'SealedBidTransferController@processSingleBid')->name('manage.transfer.online.sealed.bid.process.start.single');
                    Route::post('/league/{division}/transfers/sealed/bids/round/close', 'SealedBidTransferController@roundClose')->name('manage.transfer.online.sealed.bid.round.close');
                    Route::get('/league/{division}/transfers/sealed/bids/round/status', 'SealedBidTransferController@isJobExecuted')->name('manage.transfer.online.sealed.bid.round.status');

                });

                //Live offline auction
                Route::get('/league/{division}/auction/offline', 'LiveOfflineAuctionController@index')->name('manage.auction.offline.index');
                Route::get('/league/{division}/auction/teams', 'LiveOfflineAuctionController@getTeams')->name('get.auction.division.teams');
                Route::get('/league/{division}/team/{team}/auction', 'LiveOfflineAuctionController@getTeamDetails')->name('manage.auction.division.team');
                Route::post('/league/{division}/team/{team}', 'LiveOfflineAuctionController@getPlayers')->name('manage.auction.get.players');
                Route::post('league/{division}/team/{team}/create', 'LiveOfflineAuctionController@create')->name('manage.division.team.auction.create');
                Route::post('league/{division}/team/{team}/edit', 'LiveOfflineAuctionController@edit')->name('manage.division.team.auction.edit');
                Route::delete('/league/{division}/team/{team}/player/{player}/destroy', 'LiveOfflineAuctionController@destroy')->name('manage.division.team.contract.destroy');
                Route::get('/league/{division}/auction/close', 'LiveOfflineAuctionController@close')->name('manage.division.team.auction.close');

                // Stats routes
                Route::get('/league/stats/{division?}', 'StatsController@index')->name('manage.stat.index');

                //Chat Routes
                Route::get('/league/{division}/chat/read', 'ChatController@updateUnreadMessage')->name('manage.chat.read.count');
                Route::get('/league/{division}/chat/unread', 'ChatController@getUnreadMessageCount')->name('manage.league.chat.unread');
                Route::get('/league/{division}/chat/new', 'ChatController@newMessage')->name('manage.league.chat.new.message');
                Route::post('/league/{division}/chat/store', 'ChatController@store')->name('manage.chat.store');
                Route::post('/league/{division}/chat/{chat}/delete', 'ChatController@delete')->name('manage.chat.delete');

                // Feed routes
                Route::get('/league/{division?}/feed', 'FeedsController@index')->name('manage.feed.index');
                Route::get('/league/{division?}/feed/read', 'FeedsController@read')->name('manage.feed.read');
                Route::get('/league/{division?}/news/{slug}', 'FeedsController@postDetails')->name('manage.feed.post.details');

                Route::get('/leagues/{division}/teams/{team}/lineup/history', 'TeamLineupController@getHistoryPlayers')->name('team.lineup.history.players');
                Route::get('/leagues/{division}/teams/{team}/lineup/sold', 'TeamLineupController@getSoldPlayers')->name('team.lineup.sold.players');
            });

            //Team Settings
            Route::get('/leagues/teams', 'TeamsController@index')->name('manage.division.teams.index');
            Route::post('/leagues/teams/settings/{team}/remove', 'TeamsController@delete')->name('manage.teams.settings.remove');
            Route::delete('/leagues/team/{team}/payment/remove', 'TeamsController@delete')->name('manage.teams.payment.remove');

            //Account Settings Routes
            Route::get('/account/settings', 'UserProfileController@editAccount')->name('manage.account.settings');
            Route::post('/account/settings/store', 'UserProfileController@saveAccount')->name('manage.account.settings.store');
            Route::get('/account/validateEmail/{user?}', 'UserProfileController@validateEmail')->name('manage.account.email.validate');
            Route::get('/account/validateUserName/{user?}', 'UserProfileController@validateUserName')->name('manage.account.username.validate');
        });
    });
});

require_once 'liveonlineauction.php';
require_once 'matches.php';
