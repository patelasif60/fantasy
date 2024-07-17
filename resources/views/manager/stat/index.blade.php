@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li class="text-left"></li>
                @if(isset($division))
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer">{{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                @endif
                <li>
                    {{-- <a href="@if(isset($division) && $division) {{ route('manage.more.division.index', ['division' => $division ]) }} @else {{ route('manage.more.index') }} @endif">
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
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12 text-white">
                            <ul class="custom-list-group list-group-white mb-4">
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.more.players.index',['division' => $division]) }}" class="has-stepper">
                                            <span class="has-icon">Player List</span>
                                        </a>
                                    </div>
                                </li>
                                @can('update', $division)
                                <li>
                                    <div class="list-element">
                                        <a href="{{ route('manage.matches.index',['division' => $division ]) }}" class="has-stepper">
                                            <span class="has-icon">Results, Fixtures & Table</span>
                                        </a>
                                    </div>
                                </li>
                                @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
