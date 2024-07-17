@extends('layouts.manager')

@section('content')
	<div class="row">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1 no-gutters">
                        <div class="col-md-5 col-lg-4">
                            <div class="left-side-navigation h-100">
                                @yield('left')
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <div class="right-side-navigation px-0 px-md-4 text-white">
                                @yield('right')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection