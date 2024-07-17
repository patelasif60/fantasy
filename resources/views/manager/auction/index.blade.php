@extends('layouts.manager')

@include('partials.manager.leagues')


@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.info',['division' => $division ]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
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
                        <div class="mb-5 mb-100 text-white">
                            @if($division->auction_closing_date && $division->auction_closing_date <= now())
                                <p class="text-center mt-5"> Auction closed. </p>
                            @else
                                <p class="text-center mt-5"> Auction not start yet. </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
