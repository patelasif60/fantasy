@extends('layouts.manager')

{{-- @push('header-content')
    @include('partials.auth.header')
@endpush --}}

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.edit', ['division' => $division]) }}"><span>
                            <i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    </li>
                    <li class="text-center">Invite Your Friends</li>
                    <li class="text-right">
                        @include('partials.manager.more_menu')
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('page-scripts')
<script src="{{ asset('js/manager/global.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/invite_members.js') }}"></script>
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="row justify-content-center text-white">
                    <div class="col-12 col-md-11">
                        <div class="progressbar-area">
                            <div class="progessbar-bg">
                                <div class="bar-block"></div>
                            </div>
                            <ul class="stepper">
                                <li class="completed">Profile</li>
                                <li class="completed">League</li>
                                <li class="active">Friends</li>
                                <li>Team</li>
                            </ul>
                        </div>
                        <div class="mt-4"></div>
                        <p>Now it’s time to invite your friends. Please share your unique link below.</p>
                        <div class="snippet code-copy">
                            <span id="invite_code">{{route('manager.division.join.a.league', ['code' => $code])}}</span>
                        </div>
                        <div class="row gutters-md">
                            <div class="col-6">
                                <button class="btn btn-secondary btn-block has-icon copy-invite-code">
                                    <i class="far fa-clipboard "></i>  Copy Link
                                </button>
                            </div>
                            <div class="col-6">

                                <a class="btn btn-secondary btn-block has-icon"  id = "shareCode" data-url="{{route('manager.division.join.a.league', ['code' => $code])}}" data-text="Join my league with this link " data-title="Join my league">
                                    <i class="far fa-share-alt"></i>
                                    Share code
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-body">
                <div class="row justify-content-center text-white mt-3">
                    <div class="col-12 col-md-11">
                        <div class="row gutters-md mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('manage.division.edit', ['division' => $division]) }}" class="btn btn-secondary btn-block invite-manager-back">Back</a>
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <a href="{{ route('manage.division.create.team', ['division' => $division]) }}" class="btn btn-primary btn-block">Next</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="{{ route('manage.division.edit', ['division' => $division]) }}"><span>
                                            <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                                        </a>
                                    </li>
                                    <li class="text-center">Invite Your Friends</li>
                                    <li class="text-right">
                                        @include('partials.manager.more_menu')
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body ">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="progressbar-area">
                                    <div class="progessbar-bg">
                                        <div class="bar-block"></div>
                                    </div>
                                    <ul class="stepper">
                                        <li class="completed">Profile</li>
                                        <li class="completed">League</li>
                                        <li class="active">Friends</li>
                                        <li>Team</li>
                                    </ul>
                                </div>
                                <div class="mt-4"></div>
                                <p>Now it’s time to invite your friends. Please share your unique link below.</p>
                                <div class="snippet code-copy">
                                    <span id="invite_code">{{route('manager.division.join.a.league', ['code' => $code])}}</span>
                                </div>
                                <div class="row gutters-md">
                                    <div class="col-6">
                                        <button class="btn btn-secondary btn-block has-icon copy-invite-code">
                                            <i class="far fa-clipboard "></i>  Copy Link
                                        </button>
                                    </div>
                                    <div class="col-6">

                                        <a class="btn btn-secondary btn-block has-icon"  id = "shareCode" data-url="{{route('manager.division.join.a.league', ['code' => $code])}}" data-text="Join my league with this link " data-title="Join my league">
                                            <i class="far fa-share-alt"></i>
                                            Share code
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-card-content">
                    <div class="auth-card-footer">
                        <div class="row justify-content-center text-white mt-3">
                            <div class="col-12 col-md-11">
                                <div class="row gutters-md mt-4">
                                    <div class="col-md-6">
                                        <a href="{{ route('manage.division.edit', ['division' => $division]) }}" class="btn btn-secondary btn-block invite-manager-back">Back</a>
                                    </div>
                                    <div class="col-md-6 pt-3 pt-md-0">
                                        <a href="{{ route('manage.division.create.team', ['division' => $division]) }}" class="btn btn-primary btn-block">Next</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

@endsection

@push ('modals')
    <!-- Modal -->
    <div class="modal fade share-modal" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header align-items-center border-bottom">
                    <h6 class="m-0">Share Code Via</h6>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row gutters-md justify-content-center">
                        <div class="col-sm-6">
                            <a class="btn btn-secondary btn-block has-icon" href="mailto:?subject=Join my league&amp;body=Join my league with this link {{route('manager.division.join.a.league', ['code' => $code])}}">
                                <i class="far fa-envelope"></i>  Email
                            </a>
                        </div>
                        @mobile
                        <div class="col-sm-6 mt-2 mt-sm-0">
                            <a class="btn btn-secondary btn-block has-icon" href="sms:?body=Join my league with this link {{route('manager.division.join.a.league', ['code' => $code])}}">
                                <i class="fas fa-envelope"></i>  Text Message
                            </a>
                        </div>
                        @endmobile
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endpush
