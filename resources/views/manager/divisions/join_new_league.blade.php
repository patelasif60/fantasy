@extends('layouts.manager')

@push('header-content')
    {{-- @include('partials.auth.header') --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.join.league.select')  }}">
                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    </li>
                    <li class="text-center">Join a Private League</li>
                    <li class="text-right"></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/search_league.js') }}"></script>
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <form class="js-search-league-form" action="{{ route('manage.league.search.league') }}" method="get">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row justify-content-center mt-0 mt-md-4">
                        <div class="col-12 col-md-11">
                            <div class="custom-alert alert-primary">
                                <div class="alert-text">
                                    Your can join a league by searching for the league's name or a league chairman.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                            <div class="d-flex text-white align-items-center mb-4 mt-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="search_type_invitation" name="search_type" class="custom-control-input" value="invitation">
                                    <label class="custom-control-label d-flex" for="search_type_invitation">
                                        <div class="mr-2 mb-0 h2"><i class="far fa-qrcode"></i></div>
                                        <div>
                                            <h6 class="m-0">I have an invitation code</h6>
                                            <p class="m-0 small"> Enter or paste your invitation code below</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control searchGroup d-none" id="invitation_code" name="invitation_code" placeholder="e.g. XDF148">
                            </div>

                            <p class="text-center text-white position-relative or-block mb-4">OR</p>

                            <div class="d-flex text-white align-items-center mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="search_type_league" name="search_type" class="custom-control-input" value="league">
                                    <label class="custom-control-label d-flex" for="search_type_league">
                                        <div class="mr-2 mb-0 h2"><i class="far fa-search"></i></div>
                                        <div>
                                            <h6 class="m-0">Search for a league</h6>
                                            <p class="m-0 small">Enter email address, friend's name or league name below</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control searchGroup d-none" id="search_league" name="search_league" placeholder="e.g. Magnificent Seven">
                            </div>
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
            </div>
        </form>
        {{-- <div class="auth-card">
            <div class="auth-card-body">
                <form class="js-search-league-form" action="{{ route('manage.league.search.league') }}" method="get">
                <div class="auth-card-header">
                    <div class="row">
                        <div class="col-12">
                            <ul class="top-navigation-bar">
                                <li>
                                    <a href="{{ route('manage.division.join.league.select')  }}">
                                        <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                    </a>
                                </li>
                                <li class="text-center">Join a Private League</li>
                                <li class="text-right"></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-0 mt-md-4">
                        <div class="col-12 col-md-11">
                            <div class="custom-alert alert-primary">
                                <div class="alert-text">
                                    Your can join a league by searching for the league's name or a league chairman.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                            <div class="d-flex text-white align-items-center mb-4 mt-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="search_type_invitation" name="search_type" class="custom-control-input" value="invitation">
                                    <label class="custom-control-label d-flex" for="search_type_invitation">
                                        <div class="mr-2 mb-0 h2"><i class="far fa-qrcode"></i></div>
                                        <div>
                                            <h6 class="m-0">I have an invitation code</h6>
                                            <p class="m-0 small"> Enter or paste your invitation code below</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control searchGroup d-none" id="invitation_code" name="invitation_code" placeholder="e.g. XDF148">
                            </div>

                            <p class="text-center text-white position-relative or-block mb-4">OR</p>

                            <div class="d-flex text-white align-items-center mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="search_type_league" name="search_type" class="custom-control-input" value="league">
                                    <label class="custom-control-label d-flex" for="search_type_league">
                                        <div class="mr-2 mb-0 h2"><i class="far fa-search"></i></div>
                                        <div>
                                            <h6 class="m-0">Search for a league</h6>
                                            <p class="m-0 small">Enter email address, friend's name or league name below</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control searchGroup d-none" id="search_league" name="search_league" placeholder="e.g. Magnificent Seven">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="auth-card-footer">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                            <button id = "leagueSearch" type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div> --}}
    </div>
</div>

@endsection
