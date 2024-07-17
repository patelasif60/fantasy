@extends('layouts.auth.selection')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card card-img-bg">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li></li>
                                    <li class="text-center">Create your league</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="form-group">
                                    <label for="league-name">League name</label>
                                    <input type="text" class="form-control" id="league-name" name="league-name" placeholder="Ben's League">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-card-content">
                    <div class="auth-card-footer">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-secondary btn-block">Back</button>
                                    </div>
                                    <div class="col-md-6 pt-3 pt-md-0">
                                        <button type="submit" class="btn btn-primary btn-block">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
