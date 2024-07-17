@extends('layouts.manager')

@include('partials.manager.leagues')

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
                    <li> Points</li>
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
                    <div class="row">
                        @if($division->package->allow_custom_scoring == $yesNo['Yes'])
                            <div class="col-12">
                                <div class="custom-alert alert-tertiary" role = "alert">
                                    <div class="alert-icon">
                                        <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                                    </div>

                                        <div class="alert-text text-dark">
                                                Did you know... your chairman can change your scoring system?
                                        </div>

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row mb-150">
                        <div class="col-12 text-white">
                            <ul class="custom-list-group list-group-white">
                                @foreach($events as $event => $eventName)
                                    <li>
                                        <div class="list-element  has-icon">
                                         @if(array_key_exists($event, $points))
                                            <span class="text-left">
                                                @if($eventName == 'Goalkeeper save x5')
                                                    Goalkeeper Save
                                                @else
                                                    {{ucwords($eventName)}}
                                                @endif
                                            </span>
                                            <span class="text-right">
                                                {{$points[$event]}}
                                            </span>
                                         @else
                                         <a href="{{route('managers.division.rules.scoring.positions',['event'=>$event,'division'=>$division])}}">
                                            @if($eventName == 'Goalkeeper save x5')
                                            Goalkeeper Save
                                            @else
                                             {{ucwords($eventName)}}
                                            @endif
                                         </a>
                                         <span><i class="fas fa-chevron-right"></i></span>
                                         @endif
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
