@extends('layouts.manager')

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/manager/global.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/approval.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                    </li>
                    <li>{{  $division->name }}</li>
                    <li>
                        {{-- <a href="{{ route('manage.more.division.index', ['division' => $division ]) }}">
                            <span><i class="fas fa-bars"></i></span>
                        </a> --}}
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fl fl-bar"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">

                    @foreach($team_approvals as $team)
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="approval-block">
                                <p class="mb-4"><span class="manager-name">{{$team->consumer->user->first_name . ' ' . $team->consumer->user->last_name}}</span> {{$team->name}}</p>
                                <div class="row gutters-md">
                                    <div class="col-6 js-msg-{{$team->id}}" style="display: none;">
                                        <span class="f-14">Approved</span> <i class="fas fa-check-circle text-primary"></i>
                                    </div>
                                    <div class="col-6  js-action-{{$team->id}}">
                                        <a href="javascript:void(0)" data-href="{{route('manage.division.approve.team', ['division' => $division, 'team' => $team])}}" class="btn btn-primary btn-block js-approve" data-id="{{$team->id}}">Approve</a>
                                    </div>
                                    <div class="col-6  js-action-{{$team->id}}">
                                        <a href="javascript:void(0)" data-href="{{route('manage.division.ignore.team', ['division' => $division, 'team' => $team])}}" class="btn btn-danger btn-block js-ignore" data-id="{{$team->id}}">Reject</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

<div class="modal fade confirmModal" id="matchDetailsModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom">
                <h6 class="m-0 text-danger">Reject join request</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm btn-reject">Reject</button>
            </div>
        </div>
    </div>
</div>
@endsection
