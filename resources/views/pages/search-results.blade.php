@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="cta-block-stepper">
                                <a href="#">The Magnificent Seven</a>
                                <p>Legend League, 7 members</p>
                            </div>

                            <div class="cta-block-stepper">
                                <a href="#">Sealed Bids Auction</a>
                                <p>Chief Executive, The Magnificent Seven</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
