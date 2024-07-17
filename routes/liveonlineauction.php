<?php

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/league/{division}/lonauction', 'LiveOnlineAuctionController@index')->name('manage.live.online.auction.index');
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
});
