<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth routes
Route::namespace('Auth')->group(function () {
    Route::post('/login', 'LoginController@login');
    Route::post('/login/social', 'SocialLoginController@login');
    Route::post('/register', 'RegisterController@register');
    Route::get('/logout', 'LoginController@logout');

    //Forgot password
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::get('/app/details', 'BasicController@index');

// Protected routes
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {

    //UserProfile
    Route::get('/user-profile', 'UserProfileController@getProfileDetails');
    Route::post('/user-profile', 'UserProfileController@saveAccount');

    //Division
    Route::get('/leagues', 'DivisionsController@index');
    Route::get('/leagues/{division}/auction/basic', 'DivisionsController@basic');
    Route::get('/leagues/{division}/details', 'DivisionsController@details');
    Route::get('/leagues/{division}/settings', 'DivisionsController@edit');
    Route::post('/leagues/{division}/settings', 'DivisionsController@update');
    Route::post('/leagues/{divisionpoint}/points', 'DivisionsController@updateDivisionPoint');
    Route::get('/leagues/{division}/auction/settings', 'AuctionController@edit');
    Route::post('/leagues/{division}/auction/settings', 'AuctionController@update');
    Route::post('/leagues/{division}/auction/reset', 'AuctionController@reset');

    // Packages routed required for Create New League
    Route::get('division/package/selection', 'PackagesController@selection');
    Route::post('division/package/description/{package}', 'PackagesController@description');
    // Create League routes
    Route::post('division/check', 'DivisionsController@validateLeagueName');
    Route::post('division/save/{package}', 'DivisionsController@store');
    Route::post('division/{division}/first_approved_team', 'DivisionsController@firstApprovedTeam');

    Route::post('division/{division}/transfers/show_transfers_menu', 'TransfersController@showTransfersMenu');
    Route::get('division/{division}/transfers/get_free_agents', 'FreeAgentsController@getFreeAgentsFilters');
    Route::post('division/{division}/transfers/get_free_agents', 'FreeAgentsController@getFreeAgents');
    Route::get('division/{division}/transfers/export/pdf', 'FreeAgentsController@exportPdf');
    Route::get('division/{division}/transfers/export/excel', 'FreeAgentsController@exportExcel');
    Route::get('division/{division}/swaps/getTeams', 'SwapController@getTeams');
    Route::get('division/{division}/team/{team}/swaps/getTeamPlayers', 'SwapController@getTeamPlayers');
    Route::post('division/{division}/swaps/swapPlayers', 'SwapController@swapPlayers');
    Route::get('division/{division}/transfers/transfer_teams', 'TransfersController@transferTeams');
    Route::get('division/{division}/transfers/teams/{team}/team_details', 'TransfersController@getTeamsDetails');
    Route::post('division/{division}/team/{team}', 'TransfersController@getAllPlayers');
    Route::post('division/{division}/team/{team}/create', 'TransfersController@create');
    Route::post('division/{division}/team/{team}/transfers/transfer_players/store', 'TransfersController@store');

    Route::post('/division/{division}/transfers/get_who_owns_who_players', 'WhoOwnsWhoController@getOwnedPlayers');

    // Stats Section
    Route::post('/more/seasons', 'PlayersController@seasons');
    Route::post('/more/players/{division}', 'PlayersController@players');
    Route::post('/more/insout/{division}', 'PlayersController@insout');
    Route::post('/more/history/{division}', 'PlayersController@history');
    Route::post('/{division}/player/injuries/suspensions', 'PlayersController@injuriesAndSuspensions');
    Route::post('/matches/{division}/pltable/stats', 'PlTableController@index');
    Route::get('/more/players/{division}/details', 'PlayersController@playersDetails');

    // Division invite managers via email routes
    Route::post('division/invite/managers/{division}', 'InvitationsController@getInvitation');
    Route::post('division/send/invitation/{division}', 'InvitationsController@sendInvitations');
    Route::post('division/enter/code', 'InvitationsController@getDivision');
    // Create Team route
    Route::post('team/division/{division}/create', 'TeamsController@store');
    Route::get('division/select/crest', 'TeamsController@selectCrest');
    Route::get('division/select/pitch', 'TeamsController@selectPitch');

    Route::get('/teams', 'TeamsController@index');
    Route::get('/division/{division}/teams/list', 'TeamsController@teamsBudgetList');
    Route::post('/division/{division}/teams/budget/update', 'TeamsController@teamsBudgetUpdate');
    Route::get('/teams/{team}/data', 'TeamsController@edit');
    Route::post('/teams/{team}/update', 'TeamsController@update');
    Route::get('/division/{division}/teams', 'TeamsController@divisionTeams');
    Route::post('/division/{division}/team/{team}/payment/remove', 'TeamsController@delete');

    //League reports
    Route::post('/league/report/player/{division}', 'LeagueReportsController@players');
    Route::get('/league/report/data', 'LeagueReportsController@index');

    //League standings
    Route::get('/leagues/{division}/info/league_standings', 'DivisionsController@infoLeagueStandings');
    Route::post('/leagues/{division}/info/league_standings/filter', 'DivisionsController@infoLeagueStandingsFilter');

    // pro cup fixture
    Route::get('/leagues/{division}/info/phases', 'ProCupFixtureController@getPhases');
    Route::get('/leagues/{division}/info/pro_cup/filter', 'ProCupFixtureController@getPhaseFixtureFilter');

    // custom cup
    Route::get('/leagues/{division}/info/custom_cup', 'CustomCupFixtureController@getCustomCups');
    Route::get('/leagues/{division}/info/custom_cup/{customCup}', 'CustomCupFixtureController@index');
    Route::get('/leagues/{division}/info/custom_cup/{customCup}/round/filter', 'CustomCupFixtureController@getRoundFixtureFilter');

    //Fa Cup
    Route::get('/leagues/{division}/info/fa_cup', 'DivisionsController@infoFaCupFilter')->name('manage.division.info.fa.cup.filter');

    //Head to head
    Route::get('/leagues/{division}/info/head_to_head', 'DivisionsController@infoHeadToHead')->name('manage.division.info.head.to.head');
    Route::get('/leagues/{division}/info/head_to_head/filter', 'DivisionsController@infoHeadToHeadFilter')->name('manage.division.info.head.to.head.filter');

    Route::get('/report/league/{division}/teams', 'LeagueReportsController@leagueTeams');
    Route::get('/report/league/{division}/team/{team}/players', 'LeagueReportsController@teamPlayers');
    Route::post('/report/league/{league}/players', 'LeagueReportsController@players');
    Route::get('/report/league/data', 'LeagueReportsController@index');
    Route::get('/report/league/{division}/email', 'LeagueReportsController@sendEmail');

    // champion-europa league
    Route::get('/leagues/{division}/info/competition', 'ChampionEuropaController@getChampionEuropaPhases');
    Route::get('/leagues/{division}/info/competition/filter', 'ChampionEuropaController@getChampionEuropaPhaseFixtures');
    Route::get('/leagues/{division}/info/competition/group', 'ChampionEuropaController@getChampionEuropaGroupStandings');

    Route::get('/teams/{division}', 'TeamsController@getRequestList');
    Route::get('/team/approve/{team}', 'TeamsController@approveTeam');
    Route::get('/teams/ignore/{team}', 'TeamsController@ignoreTeam');

    // Team players lineup
    Route::post('/leagues/{division}/teams/{team}/lineup', 'TeamsController@lineup');
    Route::post('/leagues/{division}/teams/{team}/player/swap', 'TeamsController@swapPlayer');
    Route::get('/leagues/{division}/teams/{team}/lineup/history', 'TeamsController@getHistoryPlayers');

    // Team players stats
    Route::post('/teams/player/{team}/lineup', 'TeamLineupController@getPlayerStats');
    Route::post('/team/fixture/players', 'TeamLineupController@getPlayersForfixture');
    Route::post('/team/player/{team}/stats', 'TeamsController@getPlayerStats');
    Route::post('/team/{team}/player/{player}/season/{season}/stats', 'TeamsController@getPlayerStatsBySeason');

    Route::post('/leagues/{division}/player/history', 'PlayersController@historyLineupPage');

    Route::get('/team/{team}/supersub/check', 'TeamLineupController@checkSuperSubData')->name('manage.team.supersub.check');
    Route::post('/team/supersub/save', 'TeamLineupController@saveSuperSubData')->name('manage.team.supersub.save');
    Route::post('/team/supersub/delete', 'TeamLineupController@deleteSuperSubData')->name('manage.team.supersub.delete');
    Route::post('/team/supersub/check/next_fixture_data', 'TeamLineupController@checkTeamNextFixtureUpdatedData')->name('manage.team.supersub.check.next_fixture_data');
    Route::post('/team/supersub/fixtures', 'TeamLineupController@getTeamSuperSubFixtures')->name('manage.team.supersub.fixtures');

    Route::post('/leagues/{division}/team/{team}/supersub/send_emails', 'TeamLineupController@sendConfirmationEmails');
    Route::post('/leagues/{division}/team/supersub/delete_all', 'TeamLineupController@deleteAllSuperSubData');

    //Route::post('/teams/player/{team}/lineup', 'TeamLineupController@getPlayerStats');

    //Chat
    Route::post('/league/{division}/chat', 'ChatsController@getMessages');
    Route::get('/league/{division}/chat/unread', 'ChatsController@getUnreadMessageCount');
    Route::post('/league/{division}/chat/read', 'ChatsController@updateUnreadMessage');
    Route::post('/league/{division}/chat/create', 'ChatsController@create');
    Route::post('/league/{division}/chat/{chat}/delete', 'ChatsController@delete');

    //Feed
    Route::post('/league/{division}/feed/read', 'FeedsController@read');

    //User
    Route::post('/notification', 'UserProfileController@notification');

    Route::get('/leagues/{division}/custom/cups', 'CustomCupsController@index');
    Route::get('/leagues/{division}/custom/cups/create', 'CustomCupsController@create');
    Route::post('/leagues/{division}/custom/cups/store', 'CustomCupsController@store');
    Route::get('/leagues/{division}/custom/cups/{customCup}/details', 'CustomCupsController@details');
    Route::get('/leagues/{division}/custom/cups/{customCup}/edit', 'CustomCupsController@edit');
    Route::post('/leagues/{division}/custom/cups/{customCup}/update', 'CustomCupsController@update');
    Route::post('/leagues/{division}/custom/cups/{customCup}/delete', 'CustomCupsController@destroy');

    Route::post('/leagues/{division}/europeancup/teams/update', 'DivisionsController@updateDivisionsEuropeanCupTeams');
    Route::get('/leagues/{division}/history', 'PastWinnerHistoryController@index');
    Route::get('/leagues/{division}/history/create', 'PastWinnerHistoryController@create');
    Route::post('/leagues/{division}/history/store', 'PastWinnerHistoryController@store');
    Route::get('/leagues/{division}/history/{history}/edit', 'PastWinnerHistoryController@edit');
    Route::post('/leagues/{division}/history/{history}/update', 'PastWinnerHistoryController@update');
    Route::post('/leagues/{division}/history/{history}/delete', 'PastWinnerHistoryController@delete');

    //Live offline auction
    Route::get('/league/{division}/auction/teams', 'LiveOfflineAuctionController@getTeams');
    Route::get('/league/{division}/team/{team}/auction', 'LiveOfflineAuctionController@getTeamDetails');
    Route::post('/league/{division}/team/{team}', 'LiveOfflineAuctionController@getPlayers');
    Route::post('/league/{division}/team/{team}/create', 'LiveOfflineAuctionController@create');
    Route::post('league/{division}/team/{team}/edit', 'LiveOfflineAuctionController@edit');
    Route::post('/league/{division}/team/{team}/player/{player}/destroy', 'LiveOfflineAuctionController@destroy');
    Route::get('/league/{division}/auction/close', 'LiveOfflineAuctionController@close');
    Route::get('/league/{division}/auction/pdf_downloads', 'LiveOfflineAuctionController@auctionPackPdfDownload');

    Route::get('/league/{division}/sealed/bids/teams', 'OnlineSealedBidController@index');
    Route::get('/league/{division}/sealed/bids/teams/{team}/details', 'OnlineSealedBidController@getTeamsDetails');
    Route::get('/league/{division}/sealed/bids/{team}/data/players', 'OnlineSealedBidController@getPlayers');
    Route::get('/league/{division}/sealed/bids/{team}/data/bids', 'OnlineSealedBidController@getBids');
    Route::post('/league/{division}/sealed/bids/players/{team}/data/store', 'OnlineSealedBidController@store');
    Route::post('/league/{division}/sealed/bids/players/{team}/data/update', 'OnlineSealedBidController@update');
    Route::post('/league/{division}/sealed/bids/players/{sealBid}/data/delete', 'OnlineSealedBidController@destroy');
    Route::post('/league/{division}/sealed/bids/process/start', 'OnlineSealedBidController@processManualStart');

    Route::get('/league/{division}/transfers/sealed/bids/teams', 'SealedBidTransferController@index');
    Route::get('/league/{division}/transfers/sealed/bids/teams/{team}/bids', 'SealedBidTransferController@getTeamBids');
    Route::get('/league/{division}/transfers/sealed/bids/teams/{team}', 'SealedBidTransferController@getTeamsDetails');
    Route::get('/league/{division}/transfers/sealed/bids/{team}/data/json/players', 'SealedBidTransferController@getPlayersData');
    Route::post('/league/{division}/transfers/sealed/bids/players/{team}/data/store', 'SealedBidTransferController@store');
    Route::post('/league/{division}/transfers/sealed/bids/{team}/player/details', 'SealedBidTransferController@getPlayerDetails');
    Route::post('/league/{division}/transfers/sealed/bids/process/start', 'SealedBidTransferController@processManualStart');
    Route::post('/league/{division}/transfers/sealed/bids/process/start/single/{sealbid}', 'SealedBidTransferController@processSingleBid');
    Route::post('/league/{division}/transfers/sealed/bids/round/close', 'SealedBidTransferController@roundClose');

    //League Change History
    Route::get('/division/{division}/transfers/history', 'TransferController@history');
    Route::get('/division/{division}/transfers/history/list', 'TransferController@divisionTransferHistory');

    //Preauction State Routes
    Route::get('/division/{division}/preauction/teams/', 'PreauctionController@teamList');
    Route::get('/division/{division}/preauction/rules/data', 'PreauctionController@showRules');
    Route::get('/division/{division}/preauction/rules/scoring/data', 'PreauctionController@scoringSystem');
    Route::get('/division/{division}/preauction/rules/scoring/{event}', 'PreauctionController@positionPoints');
    Route::get('/division/{division}/preauction/auction', 'PreauctionController@auctionIndex');
    Route::get('/division/{division}/preauction/invite/data', 'PreauctionController@showInvite');

    //////////////////////////////// Live Online Auction ///////////////////////////

    Route::get('/league/{division}/lonauction/start', 'LiveOnlineAuctionController@start')->name('manage.live.online.auction.start');
    Route::get('/league/{division}/lonauction/search/player', 'LiveOnlineAuctionController@searchPlayers')->name('manage.live.online.auction.search.players');
    Route::get('/league/{division}/player', 'LiveOnlineAuctionController@getPlayers')->name('manage.live.online.auction.players');
    Route::post('/league/{division}/player/sold', 'LiveOnlineAuctionController@playerSold')->name('manage.live.online.auction.player.sold');
    Route::post('/league/{division}/update/sold/player', 'LiveOnlineAuctionController@updateSoldPlayer')->name('manage.lonauction.update.sold.player');
    Route::post('/league/{division}/delete/sold/player', 'LiveOnlineAuctionController@deleteSoldPlayer')->name('manage.lonauction.delete.sold.player');
    Route::get('/league/{division}/sold/player/team/{team}', 'LiveOnlineAuctionController@getSoldPlayersOfTeam')->name('manage.lonauction.team.sold.player');
    Route::get('/league/{division}/club/{club}/players/team/{team}', 'LiveOnlineAuctionController@getTeamPlayerCountForClub')->name('manage.lonauction.team.club.players.count');
    Route::get('/get/server_time', 'LiveOnlineAuctionController@getServerTime')->name('manage.lonauction.get.server.time');
    Route::post('/end/{division}/lonauction', 'LiveOnlineAuctionController@endLonAuction')->name('end.lonauction');
    Route::post('/check/{division}/lon/isclosed', 'LiveOnlineAuctionController@isLonAuctionTeamsSquadFull')->name('check.lon.isclosed');

    //////////////////////////////// Live Online Auction ///////////////////////////

    //////////////////////////////// Overall Standings ///////////////////////////
    Route::get('/leagues/{division}/standings', 'LeagueStandingsController@index')->name('manage.division.standings');
    Route::post('/leagues/{division}/season/standings', 'LeagueStandingsController@getSeasonRanking')->name('manage.division.season.standings');
    Route::post('/leagues/{division}/month/standings/', 'LeagueStandingsController@getMonthRanking')->name('manage.division.month.standings');
    Route::post('/leagues/{division}/week/standings/', 'LeagueStandingsController@getWeekRanking')->name('manage.division.week.standings');
    Route::get('/leagues/{division}/standings/team', 'LeagueStandingsController@teamDetails');
    //////////////////////////////// Overall Standings ///////////////////////////

    ////////////////////////////////////Link League///////////////////////////////////////////////////////////

    Route::get('/league/{division}/getLinkedLeagues', 'LinkedLeaguesController@index')->name('manage.linked.league.list');
    Route::get('/leagues/{division}/linkedLeagues/{parentLinkedLeague}/info', 'LinkedLeaguesController@leagueInfo')->name('manage.linked.league.info');
    Route::post('/league/{division}/linkedLeagues/search/value', 'LinkedLeaguesController@searchLeagueByValue')->name('manage.linked.league.search.value');
    Route::post('/league/{division}/linkedLeagues/save/leagues', 'LinkedLeaguesController@save')->name('manage.linked.league.save.leagues');

    /////////////////////////////////////Link League////////////////////////////////////////////////////////////

    //////////////////////////////// Stats Menu ///////////////////////////
    Route::post('/matches/{division}/{gameWeek}/matches', 'MatchesController@matches');
    Route::post('/matches/{division}/{gameWeek}/gameWeekMatches', 'MatchesController@gameWeekMatches');
    Route::post('/matches/{division}/{gameWeek}/{fixture}/gameWeekFixtureStats', 'MatchesController@gameWeekFixtureStats');

    // League Settings API
    Route::post('/leagues/{division}/settings/package', 'LeagueSettingsController@package');
    Route::post('/leagues/{division}/settings/prizepack', 'LeagueSettingsController@prizepack');
    Route::post('/leagues/{division}/settings/league', 'LeagueSettingsController@league');
    Route::post('/leagues/{division}/settings/european_cups', 'LeagueSettingsController@europeanCups');
    Route::post('/leagues/{division}/settings/squad_and_formation', 'LeagueSettingsController@squadAndFormation');
    Route::post('/leagues/{division}/settings/points_setting', 'LeagueSettingsController@pointsSetting');
    Route::get('/leagues/{division}/transfer/settings', 'LeagueSettingsController@transferSettings');
    Route::post('/leagues/{division}/transfer/settings/update', 'LeagueSettingsController@transferSettingsUpdate');

    Route::get('/players/{division}/export/pdf', 'PlayersController@exportPdf');
    Route::get('/players/{division}/export/excel', 'PlayersController@exportExcel');

    Route::get('/news/{division}/url', 'FeedsController@getUrl');
});
