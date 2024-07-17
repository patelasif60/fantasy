@extends('layouts.manager')

@push('plugin-scripts')
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
<!--     <script src="{{ asset('js/manager/divisions/info/head_to_head.js') }}"></script>
 -->    <script>
        var divisionId = @json($division->id);
    </script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.division.info',['division' => $division]) }}">
                        <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;League
                    </a>
                </li>
                <li class="text-center">Linked Leagues</li>
                <li class="text-right"></li>
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
                    <div class="custom-alert alert-danger text-dark text-center justify">
                        <div class="alert-icon">
                            <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                        </div>
                        @can('ownLeagues',$division)
                            <div class="alert-text text-dark">
                                Choose to link to an existing Linked for Merged Info or create a new one:
                            </div>
                        @else
                            <div class="alert-text text-dark">
                                Choose to link to an existing Linked for Merged Info:
                            </div>
                        @endcan    
                    </div>
                @can('ownLeagues',$division)
                <div class="row justify-content-center mb-3">
                    <div class="col-8">
                        <a href="{{ route('manage.linked.league.search', ['division' => $division]) }}" class="btn btn-primary btn-block">Create New Linked League</a>
                    </div>
                </div>
                @endcan
                <div class="row mt-1">
                    <div class="col-12">
                        @foreach($linkedLeagues as $league)
                            <a href="{{ route('manage.linked.league.info',['division' => $division, 'parentLinkedLeague' => $league->parent_linked_league_id]) }}" class="join_league cta-block-stepper-options link-nostyle team-management-stepper mb-3" data-division-id="{{$division->id}}">
                                <div class="team-management-block has-icon">
                                    {{$league->name}}
                                </div>
                                <p class="mt-0">Chairman: {{$league->first_name . ' ' . $league->last_name}}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
