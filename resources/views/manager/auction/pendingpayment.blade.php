@extends('layouts.manager')

@include('partials.manager.leagues')


@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.info',['division' => $division ]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
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
                        <div class="mb-5 mb-100 text-white">
                            <p class="text-center mt-5"> Offline auction team entry can only commence when there is a minimum of {{ $division->package->minimum_teams }} paid teams and no teams with outstanding payment. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
