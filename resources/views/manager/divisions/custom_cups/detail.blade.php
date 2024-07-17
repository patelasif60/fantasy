@extends('layouts.manager-league-settings')

@section('page-name')    
{{ $customCup->name }}
@endsection

@section('page-action')
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button>
@endsection

@section('left')
    <ul class="custom-list-group list-group-white">
        @foreach($customCups as $cp)
            <li>
                <div class="list-element">
                    <a href="{{ route('manage.division.custom.cups.details',['division' => $division, 'customCup' => $cp ]) }}" class="has-stepper"><span class="has-icon">{{ $cp->name }}</span></a>
                </div>
            </li>
        @endforeach
    </ul>
@endsection

@section('right')
    <ul class="custom-list-group list-group-white">
        <li>
            <div class="list-element">
                <a href="javascript:void(0);" class="has-stepper has-text cursor-default">
                    <span>Name</span>
                    <span>{{ $customCup->name }}</span>
                </a>
            </div>
        </li>
        <li>
            <div class="list-element">
                <a href="javascript:void(0);" class="has-stepper has-text cursor-default">
                    <span>Teams</span>
                    <span>{{ $customCup->teams->count() }}</span>
                </a>
            </div>
        </li>
        <li>
            <div class="list-element">
                <a href="javascript:void(0);" class="has-stepper has-text cursor-default">
                    <span>Rounds </span>
                    <a class="text-right" href="javascript:void(0);" data-toggle="modal" data-target="#js_configured_gameweeks">Configured</a>
                </a>
            </div>
        </li>
        @if($customCup->teams->where('is_bye',true)->count())
            <li>
                <div class="list-element">
                    <a href="javascript:void(0);" class="has-stepper has-text cursor-default">
                        <span>First round byes</span>
                        @if($customCup->is_bye_random)
                            <a class="text-right" href="javascript:void(0);" data-toggle="modal" data-target="#js_bye_teams">View Teams</a>
                        @else
                            <span>Automatic</span>
                        @endif
                    </a>
                </div>
            </li>
        @endif
    </ul>
    @can('update', $customCup)
        <div class="mt-2">
            <a href="{{ route('manage.division.custom.cups.edit',['division' => $division, 'customCup' => $customCup ]) }}" class="btn btn-danger btn-lg btn-block">Edit cup</a>
        </div>
    @endcan
    <div class="mt-2">
        <a href="{{ route('manage.division.custom.cups.destroy',['division' => $division, 'customCup' => $customCup]) }}" class="btn btn-theme-danger btn-lg btn-block delete-confirmation-button">Delete cup</a>
    </div>
@endsection

@push('modals')
    @if($customCup->is_bye_random)
        <div id="js_bye_teams" class="modal fade" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content theme-modal">
                    <div class="modal-close-area">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                        </button>
                        <div class="f-12">Close</div>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Bye Teams</h5>
                    </div>

                    <div class="modal-body">
                        @foreach($customCup->teams as $byeTeam)
                            @if($byeTeam->is_bye)
                                <p> {{ $byeTeam->team->name }} </p>
                            @endif
                        @endforeach
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="js_configured_gameweeks" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content theme-modal">
                <div class="modal-close-area">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                    </button>
                    <div class="f-12">Close</div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title">Rounds</h5>
                </div>

                <div class="modal-body">
                    @foreach($customCup->rounds as $round)
                        <strong class="mb-1">Round {{ $round->round }}</strong>
                        <table class="table custom-table table-striped fixed-column">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Week</th>
                                    <th class="text-center">Start</th>
                                    <th class="text-center">End</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($round->gameweeks as $gameweek)
                                <tr>
                                    <td class="text-center">Week {{ $gameweek->gameweek->number }}</td>
                                    <td class="text-center">{{ $gameweek->gameweek->start->format(config('fantasy.view.day_month')) }}</td>
                                    <td class="text-center">{{ $gameweek->gameweek->end->format(config('fantasy.view.day_month')) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endpush
