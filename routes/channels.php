<?php

use App\Models\Division;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('league.messages.{leagueId}', function ($user, $leagueId) {
    $division = Division::find($leagueId);

    if ($user->consumer->ownLeagues($division) || $user->consumer->ownTeam($division)) {
        return true;
    }

    return false;
});
