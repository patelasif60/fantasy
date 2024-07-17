@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-alert alert-tertiary">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text">
                                    Your request to join '{{$division->name}}' is pending approval by the league chairman. You will be notified by email once your request has been approved.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
