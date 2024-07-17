@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/info/pro_cup.js') }}"></script>
@endpush

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
                <li class="text-center">Pro Cup</li>
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
                <div class="mb-5 mb-100 text-white js-data-filter-tabs" data-url="{{ route('manage.league.procupfixture.filter',['division' => $division ]) }}">

                    <div class="tab-content active show" id="info-tabContent">
                        <div class="tab-pane fade active show" id="info-monthly" role="tabpanel" aria-labelledby="info-monthly-tab">
                            <div class="sliding-area">
                                <div class="sliding-nav">
                                    <div class="sliding-items">
                                        <div class="owl-carousel js-owl-carousel-phases-info js-phases-filter owl-theme sliding-items-info">
                                            @foreach($rounds as $key => $round)
                                                @php
                                                    $round = explode(' ',$round);
                                                @endphp
                                                <div class="item info-block js-phases" data-phase="{{ $key}}">
                                                    <a href="javascript:void(0)" class="info-block-content {{ $loop->last ? ' is-active' : '' }}">
                                                        <div class="block-section">
                                                            <div class="title">
                                                                {{ $round[0] }}
                                                            </div>
                                                            <div class="desc">
                                                                {{ $round[1] }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-5">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-pro-cup">
                                    </table>
                                </div>
                            </div>

                            <div class="mt-5 mt-lg-125 js-match">
                                <div class="js-match-info text-center">
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
