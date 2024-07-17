@extends('layouts.manager')

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/search_league.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.division.join.new.league') }}">
                        <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                    </a>
                </li>
                <li class="text-center">Search for a league</li>
                <li class="text-right"></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">

                            <p class="mb-5">You can join a league by searching for the league’s name or by searching for the email address of a league chief executive.</p>

                            <form class="js-search-league-form" action="{{ route('manage.league.search.league.results') }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('search_league') ? ' is-invalid' : '' }}">
                                    <label for="search_league" class="required">League or chairman name</label>
                                    <input type="text" class="form-control" id="search_league" name="search_league" placeholder="e.g. Magnificent Seven">
                                    @if ($errors->has('search_league'))
                                        <div class="invalid-feedback animated fadeInDown">
                                            <strong>{{ $errors->first('search_league') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="searchLeague">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
