<?php

/*
|--------------------------------------------------------------------------
| Admin Breadcrumbs
|--------------------------------------------------------------------------
|
| Here is where you can register the breadcrumbs for the admin routes for your application.
|
*/

Breadcrumbs::for('admin.dashboard.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
});

Breadcrumbs::for('admin.users.profile', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Profile', route('admin.users.profile'));
});

Breadcrumbs::for('admin.users.password', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Change password', route('admin.users.password'));
});

// Admin Users
Breadcrumbs::for('admin.users.admin.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Admin users', route('admin.users.admin.index'));
});

Breadcrumbs::for('admin.users.admin.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Admin users', route('admin.users.admin.index'));
    $trail->push('Add admin user', route('admin.users.admin.create'));
});

Breadcrumbs::for('admin.users.admin.edit', function ($trail, $user) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Admin users', route('admin.users.admin.index'));
    $trail->push($user->first_name.' '.$user->last_name, route('admin.users.admin.edit', ['user' => $user]));
});

// Consumer Users
Breadcrumbs::for('admin.users.consumers.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Consumer users', route('admin.users.consumers.index'));
});

Breadcrumbs::for('admin.users.consumers.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Consumer users', route('admin.users.consumers.index'));
    $trail->push('Add consumer', route('admin.users.consumers.create'));
});

Breadcrumbs::for('admin.users.consumers.edit', function ($trail, $user) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Consumer users', route('admin.users.consumers.index'));
    $trail->push($user->first_name.' '.$user->last_name, route('admin.users.consumers.edit', ['user' => $user]));
});

// Teams
Breadcrumbs::for('admin.teams.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Teams', route('admin.teams.index'));
});

Breadcrumbs::for('admin.teams.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Teams', route('admin.teams.index'));
    $trail->push('Add team', route('admin.teams.create'));
});

Breadcrumbs::for('admin.teams.edit', function ($trail, $team) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Teams', route('admin.teams.index'));
    $trail->push($team->name, route('admin.teams.edit', ['team' => $team]));
});

// Clubs
Breadcrumbs::for('admin.clubs.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Clubs', route('admin.clubs.index'));
});

Breadcrumbs::for('admin.clubs.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Clubs', route('admin.clubs.index'));
    $trail->push('Add club', route('admin.clubs.create'));
});

Breadcrumbs::for('admin.clubs.edit', function ($trail, $club) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Clubs', route('admin.clubs.index'));
    $trail->push($club->name, route('admin.clubs.edit', ['club' => $club]));
});

// Seasons
Breadcrumbs::for('admin.seasons.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Seasons', route('admin.seasons.index'));
});

Breadcrumbs::for('admin.seasons.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Seasons', route('admin.seasons.index'));
    $trail->push('Add season', route('admin.seasons.create'));
});

Breadcrumbs::for('admin.seasons.edit', function ($trail, $season) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Seasons', route('admin.seasons.index'));
    $trail->push($season->name, route('admin.seasons.edit', ['season' => $season]));
});

// Players
Breadcrumbs::for('admin.players.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Players', route('admin.players.index'));
});

Breadcrumbs::for('admin.players.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Players', route('admin.players.index'));
    $trail->push('Add player', route('admin.players.create'));
});

Breadcrumbs::for('admin.players.edit', function ($trail, $player) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Players', route('admin.players.index'));
    $trail->push('Edit player', route('admin.players.create'));
    $trail->push($player->full_name, route('admin.players.edit', ['player' => $player]));
});

// Fixtures
Breadcrumbs::for('admin.fixtures.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Fixtures', route('admin.fixtures.index'));
});

Breadcrumbs::for('admin.fixtures.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Fixtures', route('admin.fixtures.index'));
    $trail->push('Add fixture', route('admin.fixtures.create'));
});

Breadcrumbs::for('admin.fixtures.edit', function ($trail, $fixture) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Fixtures', route('admin.fixtures.index'));
    $trail->push($fixture->season()->first()->name.' Fixture', route('admin.fixtures.edit', ['fixture' => $fixture]));
});

// Division
Breadcrumbs::for('admin.divisions.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Divisions', route('admin.divisions.index'));
});

Breadcrumbs::for('admin.divisions.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Divisions', route('admin.divisions.index'));
    $trail->push('Add division', route('admin.divisions.create'));
});

Breadcrumbs::for('admin.divisions.edit', function ($trail, $division) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Divisions', route('admin.divisions.index'));
    $trail->push($division->name, route('admin.divisions.edit', ['division' => $division]));
});

Breadcrumbs::for('admin.divisions.subdivison', function ($trail, $division) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Divisions', route('admin.divisions.subdivison', ['division' => $division]));
});

// Predefined Crests
Breadcrumbs::for('admin.options.crests.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Crests', route('admin.options.crests.index'));
});

Breadcrumbs::for('admin.options.crests.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Crests', route('admin.options.crests.index'));
    $trail->push('Add crest', route('admin.options.crests.create'));
});

Breadcrumbs::for('admin.options.crests.edit', function ($trail, $crestData) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Crests', route('admin.options.crests.index'));
    $trail->push($crestData->name, route('admin.options.crests.edit', ['crestData' => $crestData]));
});

// Packages
Breadcrumbs::for('admin.packages.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('packages', route('admin.packages.index'));
});

Breadcrumbs::for('admin.packages.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Packages', route('admin.packages.index'));
    $trail->push('Add Package', route('admin.packages.create'));
});

Breadcrumbs::for('admin.packages.edit', function ($trail, $package) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Packages', route('admin.packages.index'));
    $trail->push($package->name, route('admin.packages.edit', ['package' => $package]));
});

// Prize packs
Breadcrumbs::for('admin.prizepacks.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Prize Packs', route('admin.prizepacks.index'));
});

Breadcrumbs::for('admin.prizepacks.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Prize Packs', route('admin.prizepacks.index'));
    $trail->push('Add Prize Pack', route('admin.prizepacks.create'));
});

Breadcrumbs::for('admin.prizepacks.edit', function ($trail, $prizePack) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Prize Packs', route('admin.prizepacks.index'));
    $trail->push($prizePack->name, route('admin.prizepacks.edit', ['prizePack' => $prizePack]));
});

// Pitches
Breadcrumbs::for('admin.pitches.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Pitches', route('admin.pitches.index'));
});

// GameGuide
Breadcrumbs::for('admin.gameguide.index', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('GameGuide', route('admin.gameguide.index'));
});

Breadcrumbs::for('admin.gameguide.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('GameGuide', route('admin.gameguide.index'));
    $trail->push('Add new', route('admin.gameguide.create'));
});

Breadcrumbs::for('admin.gameguide.edit', function ($trail, $gameguide) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('GameGuide', route('admin.gameguide.index'));
    $trail->push($gameguide->section, route('admin.gameguide.edit', ['gameguide' => $gameguide]));
});

Breadcrumbs::for('admin.pitches.create', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Pitches', route('admin.pitches.index'));
    $trail->push('Add new', route('admin.pitches.create'));
});

Breadcrumbs::for('admin.pitches.edit', function ($trail, $pitch) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Pitches', route('admin.pitches.index'));
    $trail->push($pitch->name, route('admin.pitches.edit', ['pitch' => $pitch]));
});

Breadcrumbs::for('admin.message.edit', function ($trail, $key) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
    $trail->push('Message', route('admin.message.edit', ['key' => $key]));
    $trail->push('League Message', route('admin.message.edit', ['key' => $key]));
});
