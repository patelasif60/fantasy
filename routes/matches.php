<?php

Route::middleware(['auth', 'role:user','auction.payment'])->group(function () {
    Route::get('/matches/{division}/index', 'MatchesController@index')->name('manage.matches.index');
    Route::post('/matches/{division}/{gameWeek}/matches', 'MatchesController@gameWeekMatches')->name('manage.gameWeek.matches');
    Route::post('/matches/{division}/{gameWeek}/{fixture}/stats', 'MatchesController@gameWeekFixtureStats')->name('manage.gameWeek.fixture.stats');
    Route::get('/matches/{division}/{gameWeek}/{fixture}/stats', 'MatchesController@gameWeekFixtureStats')->name('manage.gameWeek.fixture.stats');
    Route::get('/matches/{division}/pltable/stats', 'PlTableController@index')->name('manage.pltable.stats');
    Route::get('/{division}/player/injuries/suspensions', 'MatchesController@injuriesAndSuspensions')->name('manage.injuries.suspensions');
    Route::get('/leagues/{division}/team/squads', 'TeamsController@teamSquads')->name('manage.division.team.squad');
    Route::get('/leagues/{division}/standings/', 'LeagueStandingsController@index')->name('manage.division.standings');
    Route::get('/leagues/{division}/standings/team', 'LeagueStandingsController@teamDetails')->name('manage.division.standings.team.details');
    Route::post('/leagues/{division}/season/standings/', 'LeagueStandingsController@getSeasonRanking')->name('manage.division.season.standings');
    Route::post('/leagues/{division}/month/standings/', 'LeagueStandingsController@getMonthRanking')->name('manage.division.month.standings');
    Route::post('/leagues/{division}/week/standings/', 'LeagueStandingsController@getWeekRanking')->name('manage.division.week.standings');
});
