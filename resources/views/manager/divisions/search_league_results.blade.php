@extends('layouts.manager')

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/join_league.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.division.join.new.league') }}">
                        <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                    </a>
                </li>
                <li class="text-center">Matching Leagues</li>
                <li class="text-right"></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-8">
                <div class="container-wrapper">
                    <div class="container-body">
                        @if(count($divisions) == 0)
                                <div class="custom-alert alert-danger text-dark text-center justify">
                            <div class="alert-icon">
                                <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                            </div>
                            <div class="alert-text text-dark">
                             There are no leagues that match this description. Please try again.
                            </div>
                        </div>
                            @endif
                        <div class="row mt-1">
                            <div class="col-12">
                                @foreach($divisions as $division)
                                    <a href="javascript:void(0);" class="join_league cta-block-stepper-options link-nostyle team-management-stepper mb-3" data-division-id="{{$division->id}}">
                                        <div class="team-management-block has-icon">
                                            {{$division->name}}
                                        </div>
                                        <p class="mt-0">Chairman: {{$division->consumer->user->first_name . ' ' . $division->consumer->user->last_name}}<br>
                                            {{mb_strimwidth($division->introduction, 0, 100, '...')}}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @if($divisions->toArray()['last_page'] > 1)
                        <div class="row justify-content-between">
                            <div class="col-6 col-md-3">
                                <a href="@if($divisions->previousPageUrl()){{$divisions->previousPageUrl()}} @endif" class="btn btn-primary btn-block btn-sm @if(!$divisions->previousPageUrl())disabled @endif">Previous</a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="@if($divisions->nextPageUrl()){{$divisions->nextPageUrl()}}@endif" class="btn btn-primary btn-block btn-sm @if(!$divisions->nextPageUrl())disabled @endif">Next</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
