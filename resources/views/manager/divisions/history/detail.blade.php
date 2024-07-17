@extends('layouts.manager')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.custom.cups.index', ['division' => $division]) }}">
                        <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Cancel
                    </a>
                    </li>
                    <li class="has-dropdown"> {{ $customCup->name }}</li>
                    <li>
                        @can('update', $customCup)
                            <a href="{{ route('manage.division.custom.cups.edit',['division' => $division, 'customCup' => $customCup ]) }}">
                                Edit &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span>
                            </a>
                        @endcan
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12 text-white">
                            <ul class="custom-list-group list-group-white">
                                <li>
                                    <div class="list-element">
                                        <a href="javascript:void(0);" class="has-stepper has-text">
                                            <span>Name</span>
                                            <span>{{ $customCup->name }}</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="javascript:void(0);" class="has-stepper has-text">
                                            <span>Teams</span>
                                            <span>{{ $customCup->teams->count() }}</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="javascript:void(0);" class="has-stepper has-text">
                                            <span>Game weeks </span>
                                            <span>Configured</span>
                                        </a>
                                    </div>
                                </li>
                                @if($customCup->teams->where('is_bye',true)->count())
                                    <li>
                                        <div class="list-element">
                                            <a href="javascript:void(0);" class="has-stepper has-text">
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
                            <div class="mt-2">
                                <a href="{{ route('manage.division.custom.cups.destroy',['division' => $division, 'customCup' => $customCup]) }}" class="btn btn-danger btn-lg btn-block delete-confirmation-button">Delete cup</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
@endpush
