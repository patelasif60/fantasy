@extends('layouts.manager')

@push('page-scripts')

    <script type="text/javascript" src="{{ asset('js/manager/divisions/linked_league/league_selection.js')}}"></script>

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
                <form action="{{route('manage.linked.league.save.leagues', ['division' => $division])}}" method="post">
                    @csrf
                    <div class="row mt-1">
                            <div class="col-12">
                                @foreach($allLeagues as $league)
                                    <label class="team-management-stepper team-payment-block block_{{$loop->iteration}}">
                                        <div class="team-management-block">
                                            
                                            <div class="team-detail-wrapper">
                                                <p class="team-title">
                                                    {{$league->name}}
                                                </p>
                                                <p class="mt-0">Chairman:  {{$league->consumer->user->first_name . ' ' . $league->consumer->user->last_name}}<br>
                                                {{mb_strimwidth($league->introduction, 0, 100, '...')}}
                                                </p>
                                            </div>
                                            <div class="team-selection-payment">
                                                <div class="custom-control custom-checkbox">
                                                    <input value="{{$league->id}}" type="checkbox" class="custom-control-input leagueId" name="leagueId[]" id="league-{{$league->id}}" checked="">
                                                     <label class="custom-control-label" for="league-{{$league->id}}"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    <div class="container-body">
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <a href="{{route('manage.division.info', ['division' => $division])}}" class="btn btn-primary btn-block">Cancel</a>
                            </div>

                            <div class="col-6">
                                <!-- <a href="{{route('manage.linked.league.save.leagues', ['division' => $division])}}" class="btn btn-primary btn-block" id="linkedLeague">Link Leagues</a> -->
                                <button type="submit" class="btn btn-primary btn-block" id="linkedLeague">Link Leagues</button>
                            </div>
                        </div>
                    </div>
                 </form>    
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
