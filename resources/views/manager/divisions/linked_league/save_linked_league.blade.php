@extends('layouts.manager')

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')

    <script src="{{ asset('js/manager/divisions/linked_league/save_league.js') }}"></script>
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
                <li class="text-center">Saved Link Leagues</li>
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
                <form class="js-save-league-form" action="{{ route('manage.linked.league.store.leagues', ['division' => $division]) }}" method="post">
                    @csrf
                     <div class="row justify-content-center mt-0 mt-md-4">
                        <div class="col-12 col-md-11">
                            <div class="custom-alert alert-primary">
                                <div class="alert-text">
                                    Save a name for your Linked Leagues.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" value="{{$division->name}}" placeholder="e.g. Magnificent Seven">
                            </div>
                        </div>
                    </div>

                    <div class="container-body">
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <a href="{{route('manage.division.info', ['division' => $division])}}" class="btn btn-primary btn-block">Cancel</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </div>
                        </div>
                    </div>
                </form>    
            </div>
        </div>
    </div>
</div>
@endsection
