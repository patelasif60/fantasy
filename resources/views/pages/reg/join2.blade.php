@extends('layouts.auth.selection')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-header">
                    <div class="row">
                        <div class="col-12">
                            <ul class="top-navigation-bar">
                                <li>
                                    <a href="javascript:void(0);">
                                        <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                    </a>
                                </li>
                                <li class="text-center">Join a private league</li>
                                <li class="text-right"></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-0 mt-md-4">
                        <div class="col-12 col-md-11">
                            <div class="custom-alert alert-primary">
                                <div class="alert-text">
                                    Your can join a league by searching for the league's name or by searching for the email address of a league chief executive.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5">

                            <div class="d-flex text-white align-items-center mb-4 mt-4">
                                <div class="mr-2 mb-0 h2"><i class="far fa-qrcode"></i></div>
                                <div>
                                    <h6 class="m-0">I have an invitation code</h6>
                                    <p class="m-0 small"> Invitation Code</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="invitation-code" name="invitation-code" placeholder="e.g. X578DF148">
                            </div>

                            <p class="text-center text-white position-relative or-block mb-4">OR</p>

                            <div class="d-flex text-white align-items-center mb-4">
                                <div class="mr-2 mb-0 h2"><i class="far fa-search"></i></div>
                                <div>
                                    <h6 class="m-0">Search for a league</h6>
                                    <p class="m-0 small">Email address, friend's name or league name</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="league-name" name="league-name" placeholder="e.g. Magnificent Seven">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-card-footer">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                            <button type="button" class="btn btn-primary btn-block">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
