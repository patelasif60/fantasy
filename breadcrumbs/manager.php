<?php

/*
|--------------------------------------------------------------------------
| Manager Breadcrumbs
|--------------------------------------------------------------------------
|
| Here is where you can register the breadcrumbs for the manager routes for your application.
|
*/

Breadcrumbs::for('manager.home.index', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Dashboard', route('manager.home.index'));
});

Breadcrumbs::for('manager.incomplete.profile.edit', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Dashboard', route('manager.home.index'));
});

// Divisions
Breadcrumbs::for('manage.division.package.selection', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Create or Join a league', route('manager.home.index'));
});

// Divisions
Breadcrumbs::for('manager.division.join.a.league', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Join league', route('manager.home.index'));
});

Breadcrumbs::for('manage.division.join.new.league', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Join league', route('manager.home.index'));
});

Breadcrumbs::for('manage.division.enter.code', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Invitation code', route('manager.home.index'));
});

Breadcrumbs::for('manage.league.search.league', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Search league', route('manager.home.index'));
});

Breadcrumbs::for('manage.league.search.league.results', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Search league', route('manager.home.index'));
});

Breadcrumbs::for('manage.division.invite.managers', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Invite Managers', route('manager.home.index'));
});

Breadcrumbs::for('manage.division.create.team', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Create team', route('manager.home.index'));
});

Breadcrumbs::for('manage.division.create', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Create league', route('manager.home.index'));
});

Breadcrumbs::for('manage.division.select.crest', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Choose crest', route('manager.home.index'));
});

Breadcrumbs::for('manage.division.select.pitch', function ($trail) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('Select pitch', route('manager.home.index'));
});

Breadcrumbs::for('manage.leaguereports', function ($trail, $division) {
    $trail->push('Home', route('manager.home.index'));
    $trail->push('League Report', route('manage.leaguereports', ['division' => $division]));
});
