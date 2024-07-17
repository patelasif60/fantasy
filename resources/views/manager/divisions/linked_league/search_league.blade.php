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
                <li class="text-center">SEARCH FOR LEAGUE</li>
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
                <form class="js-search-league-form" action="{{ route('manage.linked.league.search.value', ['division' => $division]) }}" method="get">

                     <div class="row justify-content-center mt-0 mt-md-4">
                        <div class="col-12 col-md-11">
                            <div class="custom-alert alert-primary">
                                <div class="alert-text">
                                    Your can link a league by searching for the league's name or a league ID.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                            <div class="d-flex text-white align-items-center mb-4 mt-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="search_type_name" name="search_type" class="custom-control-input" value="leagueName" checked>
                                    <label class="custom-control-label d-flex" for="search_type_name">
                                        <div>
                                            <h6 class="m-0">Search by league name</h6>
                                        </div>
                                    </label>
                                </div>
                            </div>


                            <div class="d-flex text-white align-items-center mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="search_type_id" name="search_type" class="custom-control-input" value="leagueId">
                                    <label class="custom-control-label d-flex" for="search_type_id">
                                        <div>
                                            <h6 class="m-0">Search by league ID</h6>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="search_league" name="search_league" placeholder="e.g. Magnificent Seven">
                            </div>
                        </div>
                    </div>

                    <div class="container-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10 col-lg-7">
                                <button id = "leagueSearch" type="submit" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </div>
                </form>    
            </div>
        </div>
    </div>
</div>
@endsection
