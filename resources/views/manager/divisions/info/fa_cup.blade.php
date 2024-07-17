@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/plugins/datatables/datatables.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/info/fa_cup.js') }}"></script>
    <script>
        var divisionId = @json($division->id);
    </script>
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
                <li class="text-center">FA Cup</li>
                <li class="text-right"></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="mb-5 mb-100 text-white js-data-filter-tabs" data-url="{{ route('manage.division.info.fa.cup.filter',['division' => $division ]) }}">
                    <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary" id="info-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-standings-tab" data-toggle="pill" href="#info-standings" role="tab" aria-controls="info-standings" aria-selected="true" data-load="0">Standings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="info-rounds-tab" data-toggle="pill" href="#info-rounds" role="tab" aria-controls="info-rounds" aria-selected="false" data-load="0">Rounds</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="info-standings" role="tabpanel" aria-labelledby="info-standings-tab">
                            <div class="mt-3 mb-5">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-filter-standings">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-rounds" role="tabpanel" aria-labelledby="info-rounds-tab">

                            <div class="sliding-area">
                                <div class="sliding-nav">
                                    <div class="sliding-items">
                                        <div class="owl-carousel js-owl-carousel-round js-round-filter owl-theme sliding-items-info">
                                            @foreach($allRounds as $key => $round)
                                                <div class="item info-block js-round"
                                                @if($playedRounds->contains($key)) data-round-played="yes" @else data-round-played="no" @endif
                                                data-round="{{ $key }}">
                                                    <a href="javascript:void(0)" class="info-block-content @if($currentRound && $currentRound->stage == $key) is-active @endif">
                                                        <div class="block-section">
                                                            <div class="title">
                                                                {{ $round['title'] }}
                                                            </div>
                                                            <div class="title {{ $round['text'] != "" ? '' : 'invisible' }}">
                                                                {{ $round['text'] != "" ? $round['text'] : '&nbsp;' }}
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
                                    <table class="table text-center custom-table js-table-filter-rounds">
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
