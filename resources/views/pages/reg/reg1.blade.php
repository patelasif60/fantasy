@extends('layouts.auth.selection')

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-content-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="crest-logo text-center">
                                    <a href="{{ route('landing') }}">
                                        <img class="lazyload d-inline" src="{{ asset('assets/frontend/img/crest-logo/crest-thumb.png')}}" data-src="{{ asset('assets/frontend/img/crest-logo/crest.png')}}" data-srcset="{{ asset('assets/frontend/img/crest-logo/crest.png')}} 1x, {{ asset('assets/frontend/img/crest-logo/crest@2x.png')}} 2x" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                                <a href="#" class="cta-block-stepper-options link-nostyle team-management-stepper">
                                    <div class="d-flex team-management-block has-icon">
                                        <img src="{{ asset('assets/frontend/img/cup/cup1-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cup/cup1.svg')}}" alt="" class="img-cup lazyload">
                                        Create a League
                                    </div>
                                    <p>Curabitur imperdiet sed justo vitae placerat. Fusce porta dui at sagittis.</p>
                                </a>

                                <a href="#" class="cta-block-stepper-options link-nostyle team-management-stepper mt-3 mb-5">
                                    <div class="d-flex team-management-block has-icon">
                                        <img src="{{ asset('assets/frontend/img/cup/cup2-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cup/cup2.svg')}}" alt="" class="img-cup lazyload">
                                        Join a League
                                    </div>
                                    <p>Sed faucibus ultrices iaculis. Aliquam hendrerit erat facillisis venenatis.</p>
                                </a>

                                <a href="#" class="btn btn-secondary btn-block">
                                    Login to an existing account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            if($(window).width() < 768) {
               $(".auth-area").addClass("start-screen");
            }
            else{
                $(".auth-area").removeClass("start-screen");
            }
        });

        $(window).resize(function () {
            if ($(window).width() < 768) {
                $(".auth-area").addClass("start-screen");
            }
            else{
                $(".auth-area").removeClass("start-screen");
            }
        });
    </script>
@endpush
