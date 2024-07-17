@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="standings-tab" data-toggle="pill" href="#standings" role="tab" aria-controls="standings" aria-selected="true">Standings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="matches-tab" data-toggle="pill" href="#matches" role="tab" aria-controls="matches" aria-selected="false">Matches</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="standings" role="tabpanel" aria-labelledby="standings-tab">
                                    <div class="table-responsive">
                                        <table class="table custom-table table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>Points</th>
                                                    <th>p</th>
                                                    <th>w</th>
                                                    <th>d</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Richard stenson</a></div>
                                                    </td>
                                                    <td>24</td>
                                                    <td>10</td>
                                                    <td>8</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Untappedtalent United</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Stuart Waish</a></div>
                                                    </td>
                                                    <td>24</td>
                                                    <td>10</td>
                                                    <td>8</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Oh not again</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Chris Cragg</a></div>
                                                    </td>
                                                    <td>24</td>
                                                    <td>10</td>
                                                    <td>8</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Ben Grout</a></div>
                                                    </td>
                                                    <td>24</td>
                                                    <td>10</td>
                                                    <td>8</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Ham Saladyce</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">5asideorg</a></div>
                                                    </td>
                                                    <td>24</td>
                                                    <td>10</td>
                                                    <td>8</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Dominic's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Dominic van den Bergh</a></div>
                                                    </td>
                                                    <td>24</td>
                                                    <td>10</td>
                                                    <td>8</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Gonnertasary Wanderers</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Ed Will</a></div>
                                                    </td>
                                                    <td>24</td>
                                                    <td>10</td>
                                                    <td>8</td>
                                                    <td>0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="matches" role="tabpanel" aria-labelledby="matches-tab">
                                    <div class="table-responsive">
                                        <table class="table custom-table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div class="small"><a href="#" class="player-name link-nostyle">Richard Stenson</a></div>
                                                    </td>
                                                    <td>17</td>
                                                    <td>18</td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Oh Not Again</a></div>
                                                        <div class="small"><a href="#" class="player-name link-nostyle">Chris Cragg</a></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                        <div class="small"><a href="#" class="player-name link-nostyle">Ben Grout</a></div>
                                                    </td>
                                                    <td>21</td>
                                                    <td>7</td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Ham Saladyce</a></div>
                                                        <div class="small"><a href="#" class="player-name link-nostyle">5asideorg</a></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Dominic's Team</a></div>
                                                        <div class="small"><a href="#" class="player-name link-nostyle">Dominic van den Bergh</a></div>
                                                    </td>
                                                    <td>21</td>
                                                    <td>7</td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Untappedtalent United</a></div>
                                                        <div class="small"><a href="#" class="player-name link-nostyle">Stuart Waish</a></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
