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
    <script>
        var divisionId = @json($division->id);
    </script>
    <script src="{{ asset('js/manager/divisions/info/custom_cup.js') }}"></script>
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
                <li class="text-center">{{ $customCup->name }}</li>
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
                <div class="mb-5 mb-100 text-white js-data-filter-tabs" data-url="{{ route('manage.league.customcupfixture.filter',['division' => $division, 'customCup' => $customCup ]) }}">

                    <div class="tab-content active show" id="info-tabContent">
                        <div class="tab-pane fade active show" id="info-monthly" role="tabpanel" aria-labelledby="info-monthly-tab">
                            <div class="sliding-area">
                                <div class="sliding-nav">
                                    <div class="sliding-items">
                                        <div class="owl-carousel js-owl-carousel-phases-info js-phases-filter owl-theme sliding-items-info">
                                            @foreach($customCup->rounds as $key => $round)
                                                <div class="item info-block js-phases" data-phase="{{ $round->round }}" @if($loop->last) data-round="final" @else data-round="" @endif>
                                                         <a href="javascript:void(0)" class=" js-round-link info-block-content {{ $activeRound == $round->round ? ' is-active' :  is_now_between_dates($round->gameweeks->last()->gameweek['start'] , $round->gameweeks->last()->gameweek['end']) ? ' is-active' : '' }}" data-number="{{ $loop->iteration }}">
                                                        <div class="block-section">
                                                            <div class="title">
                                                                Round
                                                            </div>
                                                            <div class="desc">
                                                                {{ $round->round }}
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

                                <div class="text-center d-none js-result">
                                    <p class="js-winners"> Winners: <strong>Ashish Parmar</strong> </p>
                                    <p class="js-runners-up"> Runners-Up: <strong>Ashish Parmar</strong> </p>
                                </div>

                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-pro-cup">
                                    </table>
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
