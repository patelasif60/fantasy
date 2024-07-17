@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1 text-center">
                        <div class="col-12">
                            <div class="approval-block">
                                <p class="mb-4"><span class="manager-name">Mukesh Tilokani</span> Three Lions</p>
                                <div class="row gutters-md">
                                    <div class="col-6">
                                        <a href="#" class="btn btn-primary btn-block">Approve</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="btn btn-outline-dark btn-block">Ignore</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
