@extends('layouts.manager')

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')

    <script src="{{ asset('js/manager/divisions/linked_league/search_league.js') }}"></script>
    <script>
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
                <li class="text-center">Select League</li>
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

                    <div class="row mt-1">
                            <div class="col-12">
                                @foreach($allLeagues as $league)
                                    <a href="{{route('manage.linked.league.select.league', ['division' => $division, 'league' => $league->id])}}" class="join_league cta-block-stepper-options link-nostyle team-management-stepper mb-3">
                                        <div class="team-management-block has-icon">
                                            {{$league->name}}
                                        </div>
                                        <p class="mt-0">Chairman: {{$league->consumer->user->first_name . ' ' . $league->consumer->user->last_name}}<br>
                                            {{mb_strimwidth($league->introduction, 0, 100, '...')}}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    <div class="container-body">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <a href="{{route('manage.division.info', ['division' => $division])}}" class="btn btn-primary btn-block">Cancel</a>
                            </div>

                            <div class="col-4">
                                <a href="{{route('manage.linked.league.search', ['division' => $division])}}" class="btn btn-primary btn-block">Add Another</a>
                            </div>

                            <div class="col-4">
                                <a href="{{route('manage.linked.league.selected.leagues', ['division' => $division])}}" class="btn btn-primary btn-block">Link League</a>
                            </div>
                        </div>
                    </div>
                    
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
