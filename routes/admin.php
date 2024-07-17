<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth', 'role:superadmin|staff'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard.index');

    Route::get('/profile', 'UserProfileController@create')->name('admin.users.profile');
    Route::post('/profile/update', 'UserProfileController@update')->name('admin.users.update.profile');

    Route::get('/password', 'UserPasswordController@create')->name('admin.users.password');
    Route::post('/password/update', 'UserPasswordController@update')->name('admin.users.update.password');

    // Admin users section
    Route::get('/users', 'AdminUsersController@index')->name('admin.users.admin.index');
    Route::post('/users/data', 'AdminUsersController@data')->name('admin.users.admin.data');
    Route::get('/users/create', 'AdminUsersController@create')->name('admin.users.admin.create');
    Route::post('/users', 'AdminUsersController@store')->name('admin.users.admin.store');
    Route::get('/users/{user}/edit', 'AdminUsersController@edit')->name('admin.users.admin.edit');
    Route::put('/users/{user}', 'AdminUsersController@update')->name('admin.users.admin.update');
    Route::delete('/users/{user}', 'AdminUsersController@destroy')->name('admin.users.admin.destroy');
    Route::get('/users/validateEmail/{user?}', 'AdminUsersController@validateEmail')->name('admin.users.email.validate');
    Route::get('/users/validateUserName/{user?}', 'AdminUsersController@validateUserName')->name('admin.users.username.validate');
    Route::get('/user/search', 'AdminUsersController@search')->name('admin.users.search');
    Route::get('/user/searchEmail', 'AdminUsersController@searchEmail')->name('admin.users.searchEmail');

    // User hijack routes
    Route::post('/users/{user}/hijack', 'UserPasswordController@hijack')->name('admin.users.admin.hijack');

    //Customer Users section
    Route::get('/consumers', 'ConsumersUsersController@index')->name('admin.users.consumers.index');
    Route::post('/consumers/data', 'ConsumersUsersController@data')->name('admin.users.consumers.data');
    Route::get('/consumers/create', 'ConsumersUsersController@create')->name('admin.users.consumers.create');
    Route::post('/consumers', 'ConsumersUsersController@store')->name('admin.users.consumers.store');
    Route::get('/consumers/{user}/edit', 'ConsumersUsersController@edit')->name('admin.users.consumers.edit');
    Route::put('/consumers/{user}', 'ConsumersUsersController@update')->name('admin.users.consumers.update');
    Route::delete('/consumers/{user}', 'ConsumersUsersController@destroy')->name('admin.users.consumers.destroy');

    // Teams routes
    Route::get('/teams', 'TeamsController@index')->name('admin.teams.index');
    Route::post('/teams/data', 'TeamsController@data')->name('admin.teams.data');
    Route::get('/teams/create', 'TeamsController@create')->name('admin.teams.create');
    Route::post('/teams', 'TeamsController@store')->name('admin.teams.store');
    Route::get('/teams/{team}/edit', 'TeamsController@edit')->name('admin.teams.edit');
    Route::get('/teams/{team}/mark/unpaid', 'TeamsController@markAsUnPaid')->name('admin.teams.mark.paid.to.unpaid');
    Route::get('/teams/{team}/mark/paid', 'TeamsController@markAsPaid')->name('admin.teams.mark.unpaid.to.paid');
    Route::put('/teams/{team}', 'TeamsController@update')->name('admin.teams.update');
    Route::delete('/teams/{team}', 'TeamsController@destroy')->name('admin.teams.destroy');
    Route::post('/teams/transfer/data', 'TransfersController@data')->name('admin.team.transfer.data');
    Route::get('/teams/{team}/create', 'TransfersController@create')->name('admin.team.transfer.create');
    Route::post('/teams/transfer', 'TransfersController@store')->name('admin.team.transfer.store');
    Route::get('/teams/{transfer}/transfer/edit', 'TransfersController@edit')->name('admin.team.transfer.edit');
    Route::delete('/teams/transfer/{transfer}', 'TransfersController@destroy')->name('admin.team.transfer.destroy');
    Route::post('/teams/{transfer}/transfer', 'TransfersController@update')->name('admin.team.transfer.update');
    Route::get('/teams/transfer/data/export', 'TransfersController@export')->name('admin.team.transfer.data.export');
    Route::post('/transfer/{team}/player', 'TransfersController@getTransferPlayers')->name('admin.transfer.player.get');
    Route::post('/team/{team}/recalculate/points', 'TeamsController@recalculatePoints')->name('admin.team.points.recalculate');

    // Team Points adjustments
    Route::get('/point/adjustments/table/{team}', 'PointAdjustmentsController@table')->name('admin.point.adjustments.table');
    Route::get('/point/adjustments/create/{team}', 'PointAdjustmentsController@create')->name('admin.point.adjustments.create');
    Route::put('/point/adjustments', 'PointAdjustmentsController@store')->name('admin.point.adjustments.store');
    Route::delete('/point/adjustments/{adjustment}', 'PointAdjustmentsController@destroy')->name('admin.point.adjustments.destroy');
    Route::post('/point/adjustments/data/{team}', 'PointAdjustmentsController@data')->name('admin.point.adjustments.data');

    // GameGuide Routes
    Route::get('/gameguide', 'GameGuideController@index')->name('admin.gameguide.index');
    Route::get('/gameguide/create', 'GameGuideController@create')->name('admin.gameguide.create');
    Route::post('/gameguide', 'GameGuideController@store')->name('admin.gameguide.store');
    Route::get('/gameguide/{gameguide}/edit', 'GameGuideController@edit')->name('admin.gameguide.edit');
    Route::put('/gameguide/{gameguide}', 'GameGuideController@update')->name('admin.gameguide.update');
    Route::delete('/gameguide/{gameguide}', 'GameGuideController@destroy')->name('admin.gameguide.destroy');
    Route::post('/gameguide/data', 'GameGuideController@data')->name('admin.gameguide.data');

    //Team Points routes
    Route::post('/teams/points/data', 'TeamPointsController@data')->name('admin.team.points.data');
    Route::get('/teams/{team}/points/{point}/edit', 'TeamPointsController@edit')->name('admin.team.points.edit');

    //Team Player Points Routes
    Route::post('/teams/{team}/points/{point}/players/data', 'TeamPlayerPointsController@data')->name('admin.team.points.players.data');
    Route::post('/teams/{team}/player/{player}/points/recalculate', 'TeamPlayerPointsController@recalculate')->name('admin.team.players.points.recalculate');

    // Team Player routes
    Route::post('/teams/players/data', 'TeamPlayerController@data')->name('admin.team.player.data');
    Route::get('/teams/{team}/player/{player}/contract', 'TeamPlayerContractController@data')->name('admin.team.player.contract.data');
    Route::post('/teams/{team}/player/{player}/contract', 'TeamPlayerContractController@store')->name('admin.team.player.contract.store');

    // Clubs routes
    Route::get('/clubs', 'ClubsController@index')->name('admin.clubs.index');
    Route::post('/clubs/data', 'ClubsController@data')->name('admin.clubs.data');
    Route::get('/clubs/create', 'ClubsController@create')->name('admin.clubs.create');
    Route::post('/clubs', 'ClubsController@store')->name('admin.clubs.store');
    Route::get('/clubs/{club}/edit', 'ClubsController@edit')->name('admin.clubs.edit');
    Route::put('/clubs/{club}', 'ClubsController@update')->name('admin.clubs.update');
    Route::delete('/clubs/{club}', 'ClubsController@destroy')->name('admin.clubs.destroy');

    // Seasons routes
    Route::get('/seasons', 'SeasonsController@index')->name('admin.seasons.index');
    Route::post('/seasons/data', 'SeasonsController@data')->name('admin.seasons.data');
    Route::get('/seasons/create', 'SeasonsController@create')->name('admin.seasons.create');
    Route::post('/seasons', 'SeasonsController@store')->name('admin.seasons.store');
    Route::get('/seasons/{season}/edit', 'SeasonsController@edit')->name('admin.seasons.edit');
    Route::put('/seasons/{season}', 'SeasonsController@update')->name('admin.seasons.update');
    Route::put('/seasons/{season}/rollover', 'SeasonsController@rollover')->name('admin.seasons.rollover');
    Route::delete('/seasons/{season}', 'SeasonsController@destroy')->name('admin.seasons.destroy');

    // Game week routes
    Route::post('/gameweeks/{season}', 'GameWeeksController@store')->name('admin.gameweeks.store');
    Route::post('/gameweeks/data/{season}', 'GameWeeksController@data')->name('admin.gameweeks.data');
    Route::get('/gameweeks/{gameweek}/edit', 'GameWeeksController@edit')->name('admin.gameweeks.edit');
    Route::put('/gameweeks/{gameweek}', 'GameWeeksController@update')->name('admin.gameweeks.update');
    Route::delete('/gameweeks/{gameweek}', 'GameWeeksController@destroy')->name('admin.gameweeks.destroy');

    // Players section
    Route::get('/players', 'PlayersController@index')->name('admin.players.index');
    Route::post('/players/data', 'PlayersController@data')->name('admin.players.data');
    Route::get('/players/create', 'PlayersController@create')->name('admin.players.create');
    Route::post('/players', 'PlayersController@store')->name('admin.players.store');
    Route::get('/players/{player}/edit', 'PlayersController@edit')->name('admin.players.edit');
    Route::put('/players/{player}', 'PlayersController@update')->name('admin.players.update');
    Route::delete('/players/{player}', 'PlayersController@destroy')->name('admin.players.destroy');

    //Players Contract section
    Route::post('/players/{player}/contract/data', 'PlayerContractController@data')->name('admin.player.contract.data');
    Route::get('/players/{player}/contract/create', 'PlayerContractController@create')->name('admin.player.contract.create');
    Route::post('/players/{player}/contract', 'PlayerContractController@store')->name('admin.player.contract.store');
    Route::get('/players/{player}/contract/{contract}/edit', 'PlayerContractController@edit')->name('admin.player.contract.edit');
    Route::put('/players/{player}/contract/{contract}', 'PlayerContractController@update')->name('admin.player.contract.update');
    Route::delete('/players/contract/{contract}', 'PlayerContractController@destroy')->name('admin.player.contract.destroy');

    //Players Status Section
    Route::post('/players/{player}/status/data', 'PlayerStatusController@data')->name('admin.player.status.data');
    Route::get('/players/{player}/status/create', 'PlayerStatusController@create')->name('admin.player.status.create');
    Route::post('/players/{player}/status', 'PlayerStatusController@store')->name('admin.player.status.store');
    Route::get('/players/{player}/status/{status}/edit', 'PlayerStatusController@edit')->name('admin.player.status.edit');
    Route::put('/players/{player}/status/{status}', 'PlayerStatusController@update')->name('admin.player.status.update');
    Route::delete('/players/status/{status}', 'PlayerStatusController@destroy')->name('admin.player.status.destroy');

    // Division section
    Route::get('/divisions', 'DivisionsController@index')->name('admin.divisions.index');
    Route::post('/divisions/data', 'DivisionsController@data')->name('admin.divisions.data');
    Route::get('/divisions/searchDivisions', 'DivisionsController@searchDivisions')->name('admin.divisions.searchDivisions');
    Route::get('/divisions/create/{parentdivision?}', 'DivisionsController@create')->name('admin.divisions.create');
    Route::post('/divisions', 'DivisionsController@store')->name('admin.divisions.store');
    Route::get('/divisions/{division}/edit', 'DivisionsController@edit')->name('admin.divisions.edit');
    Route::put('/divisions/{division}', 'DivisionsController@update')->name('admin.divisions.update');
    Route::delete('/divisions/{division}', 'DivisionsController@destroy')->name('admin.divisions.destroy');
    Route::get('/divisions/{division}/subdivision', 'DivisionsController@subdivison')->name('admin.divisions.subdivison');
    Route::post('/divisions/subdivisons', 'DivisionsController@subdivisons')->name('admin.divisions.subdivison.data');
    Route::post('/divisions/{division}/points/recalculate', 'DivisionTeamController@recalculatePoints')->name('admin.divisions.points.recalculate');

    Route::post('/divisions/team/data', 'DivisionTeamController@data')->name('admin.division.team.data');
    Route::get('/divisions/{division}/team/create/{season}', 'DivisionTeamController@create')->name('admin.divisions.team.create');
    Route::post('/divisions/team', 'DivisionTeamController@store')->name('admin.division.team.store');
    Route::post('/divisions/createTeam', 'TeamsController@storeTeam')->name('admin.division.team.storeTeam');
    Route::get('/divisions/{divisonteam}/team/edit', 'DivisionTeamController@edit')->name('admin.division.team.edit');
    Route::post('/divisions/{divisonteam}/team', 'DivisionTeamController@update')->name('admin.division.team.update');
    Route::delete('/divisions/{division}/team/{divisonteam}', 'DivisionTeamController@destroy')->name('admin.division.team.destroy');
    Route::post('/divisions/{division}/team/{season}', 'DivisionTeamController@team')->name('admin.divisions.team.get');
    Route::get('/divisions/team/data/export', 'DivisionTeamController@export')->name('admin.division.team.data.export');

    Route::post('/players/{player}/status/data', 'PlayerStatusController@data')->name('admin.player.status.data');
    Route::get('/players/{player}/status/create', 'PlayerStatusController@create')->name('admin.player.status.create');
    Route::post('/players/{player}/status', 'PlayerStatusController@store')->name('admin.player.status.store');
    Route::get('/players/{player}/status/{status}/edit', 'PlayerStatusController@edit')->name('admin.player.status.edit');
    Route::put('/players/{player}/status/{status}', 'PlayerStatusController@update')->name('admin.player.status.update');
    Route::delete('/players/status/{status}', 'PlayerStatusController@destroy')->name('admin.player.status.destroy');

    // Fixtures routes
    Route::get('/fixtures', 'FixtureController@index')->name('admin.fixtures.index');
    Route::post('/fixtures/data', 'FixtureController@data')->name('admin.fixtures.data');
    Route::get('/fixtures/create', 'FixtureController@create')->name('admin.fixtures.create');
    Route::post('/fixtures', 'FixtureController@store')->name('admin.fixtures.store');
    Route::get('/fixtures/{fixture}/edit', 'FixtureController@edit')->name('admin.fixtures.edit');
    Route::put('/fixtures/{fixture}', 'FixtureController@update')->name('admin.fixtures.update');
    Route::delete('/fixtures/{fixture}', 'FixtureController@destroy')->name('admin.fixtures.destroy');

    // PreDefined crest routes
    Route::get('/options/crests', 'PredefinedCrestsController@index')->name('admin.options.crests.index');
    Route::post('/options/crests/data', 'PredefinedCrestsController@data')->name('admin.options.crests.data');
    Route::get('/options/crests/create', 'PredefinedCrestsController@create')->name('admin.options.crests.create');
    Route::post('/options/crests', 'PredefinedCrestsController@store')->name('admin.options.crests.store');
    Route::get('/options/crests/{crest}/edit', 'PredefinedCrestsController@edit')->name('admin.options.crests.edit');
    Route::put('/options/crests/{predefined_crest}', 'PredefinedCrestsController@update')->name('admin.options.crests.update');
    Route::delete('/options/crests/{crest}', 'PredefinedCrestsController@destroy')->name('admin.options.crests.destroy');
    Route::post('/options/crests/check', 'PredefinedCrestsController@check')->name('admin.options.crests.check');

    //Fixture Lineups
    Route::post('/fixtures/{fixture}/lineup', 'FixtureLineupController@store')->name('admin.fixtures.lineup.store');
    Route::put('/fixtures/{fixture}/lineup/', 'FixtureLineupController@update')->name('admin.fixtures.lineup.update');

    //Fixture Event Routes
    Route::post('/fixtures/{fixture}/event/data', 'FixtureEventsController@data')->name('admin.fixture.event.data');
    Route::get('/fixtures/{fixture}/event/create', 'FixtureEventsController@create')->name('admin.fixture.event.create');
    Route::post('/fixtures/{fixture}/event', 'FixtureEventsController@store')->name('admin.fixture.event.store');
    Route::get('/fixtures/{fixture}/event/{event}/edit', 'FixtureEventsController@edit')->name('admin.fixture.event.edit');
    Route::put('/fixtures/{fixture}/event/{event}', 'FixtureEventsController@update')->name('admin.fixture.event.update');
    Route::delete('/fixtures/event/{event}', 'FixtureEventsController@destroy')->name('admin.fixture.event.destroy');

    // Package routes
    Route::get('/packages', 'PackagesController@index')->name('admin.packages.index');
    Route::post('/packages/data', 'PackagesController@data')->name('admin.packages.data');
    Route::get('/packages/create', 'PackagesController@create')->name('admin.packages.create');
    Route::post('/packages', 'PackagesController@store')->name('admin.packages.store');
    Route::get('/packages/{package}/edit', 'PackagesController@edit')->name('admin.packages.edit');
    Route::put('/packages/{package}', 'PackagesController@update')->name('admin.packages.update');
    Route::delete('/packages/{package}', 'PackagesController@destroy')->name('admin.packages.destroy');

    // Package prize routes
    Route::get('/prizepacks', 'PrizePacksController@index')->name('admin.prizepacks.index');
    Route::post('/prizepacks/data', 'PrizePacksController@data')->name('admin.prizepacks.data');
    Route::get('/prizepacks/create', 'PrizePacksController@create')->name('admin.prizepacks.create');
    Route::post('/prizepacks', 'PrizePacksController@store')->name('admin.prizepacks.store');
    Route::get('/prizepacks/{prizePack}/edit', 'PrizePacksController@edit')->name('admin.prizepacks.edit');
    Route::put('/prizepacks/{prizePack}', 'PrizePacksController@update')->name('admin.prizepacks.update');
    Route::delete('/prizepacks/{prizePack}', 'PrizePacksController@destroy')->name('admin.prizepacks.destroy');

    // Pitches routes
    Route::get('/pitches', 'PitchesController@index')->name('admin.pitches.index');
    Route::post('/pitches/data', 'PitchesController@data')->name('admin.pitches.data');
    Route::get('/pitches/create', 'PitchesController@create')->name('admin.pitches.create');
    Route::post('/pitches', 'PitchesController@store')->name('admin.pitches.store');
    Route::get('/pitches/{pitch}/edit', 'PitchesController@edit')->name('admin.pitches.edit');
    Route::put('/pitches/{pitch}', 'PitchesController@update')->name('admin.pitches.update');
    Route::delete('/pitches/{pitch}', 'PitchesController@destroy')->name('admin.pitches.destroy');
    Route::post('/pitch/check', 'PitchesController@checkUniquePitch')->name('admin.unique.pitch.check');
    Route::get('/consumer/users/data/export', 'ConsumersUsersController@export')->name('admin.consumer.users.data.export');

    // Message Routes
    Route::get('/message/edit/{key}', 'MessagesController@edit')->name('admin.message.edit');
    Route::put('/message/{message}', 'MessagesController@update')->name('admin.message.update');
    Route::get('/message/delete/{key}', 'MessagesController@destroy')->name('admin.message.destroy');
});
