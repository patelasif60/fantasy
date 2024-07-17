@extends('layouts.manager')

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/teams/delete.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li><a href="{{ url()->previous() }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a></li>
                    <li>{{  $team->name }}</li>
                    <li></li>
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
                    <div class="row mb-150">
                        <div class="col-12 text-white">
                            <ul class="custom-list-group list-group-white">
                                <li>
                                    <div class="list-element">
                                        <a href="@can('accessTab', $division) {{ route('manage.team.lineup',['division' => $division,'team' => $team]) }} @else # @endcan" class="has-stepper @cannot('accessTab', $division)text-dark @endcannot"><span class="has-icon">Lineup</span></a>
                                    </div>
                                </li>
                                @can('update', $team)
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.teams.settings.edit',['division' => $division,'team' => $team]) }}" class="has-stepper"><span class="has-icon">Settings</span></a>
                                    </div>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                    @can('delete', $team)
                    <div class="row justify-content-center">
                        <div class="col-6 text-white">
                             <div class="row gutters-sm">
                                <button type="button" class="btn btn-danger btn-block" id="removeTeam" data-url="{{route('manage.teams.settings.remove', ['team' => $team ])}}">
                                    Remove team from league
                                </button>
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
