@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">

            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.rules.scoring',['division' => $division]) }}">
                            <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Points
                        </a>
                    </li>
                    <li> {{ucwords(str_replace('_',' ', $event))}}</li>
                    <li>
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
                    <div class="row mb-150">
                        <div class="col-12 text-white">
                            <ul class="custom-list-group list-group-white">
                                @foreach($positions as $key=> $position)
                                    <li>
                                        <div class="list-element  has-icon">
                                            <span class="text-left">
                                               {{$position}}
                                            </span>
                                            <span class="text-right">
                                                {{$points[$event][$key]}}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
