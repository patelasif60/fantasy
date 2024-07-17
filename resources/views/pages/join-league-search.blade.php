@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center join-league">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">
                            <p>You can join a league by searching or by entering an invitation code.</p>
                        </div>
                    </div>
                </div>
                <div class="container-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="#" class="btn btn-secondary has-icon btn-block">
                                <i class="fas fa-qrcode"></i> I have an invitation code
                            </a>
                            <a href="#" class="btn btn-secondary has-icon btn-block">
                                <i class="fas fa-search"></i> Search for a league
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
