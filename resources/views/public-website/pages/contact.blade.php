@extends('public-website.layouts.default')

@push('plugin-styles')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
@endpush

@section('content')
<section class="terms-section contact">
    <div class="container-fluid" data-aos="fade-down">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="keypoint-section mt-5 mb-5">
                    <h4 class="keypoint-title">contact</h4>
                </div>
            </div>
        </div>
        <div class="row justify-content-around mb-5">
            <div class="col-xl-12">
                <div class="keypoint-section">
                    <h6 class="keypoint-desc text-uppercase">CUSTOMER SERVICE & GAMES ENQUIRIES</h6>
                    <p class="keypoint-desc"><a class="text-success font-weight-bold" href="mailto:auctionsupport@fantasyleague.com">auctionsupport@fantasyleague.com </a></p>

                    <h6 class="keypoint-desc text-uppercase">COMMERCIAL & PARTNER ENQUIRIES</h6>
                    <p class="keypoint-desc"><a class="text-success font-weight-bold" href="mailto:corporate@fantasyleague.com">corporate@fantasyleague.com </a></p>

                    <div class="star-group"><span class="fl fl-stars"></span></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('modals')
@endpush
