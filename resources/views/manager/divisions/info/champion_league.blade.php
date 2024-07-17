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
    <script src="{{ asset('js/manager/divisions/info/champion_league.js') }}"></script>
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
                <li class="text-center">Champions League</li>
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
                <div class="mb-5 mb-100 text-white js-data-filter-tabs" data-url="{{ route('manage.league.competition.fixtures',['division' => $division ]) }}">
                   <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary" id="info-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="info-match-tab" data-toggle="pill" href="#info-match" role="tab" aria-controls="info-match" aria-selected="false" data-load="0">Matches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="info-group-tab" data-toggle="pill" href="#info-group" role="tab" aria-controls="info-group" aria-selected="false" data-load="0" data-url="{{ route('manage.league.competition.group',['division' => $division ]) }}">Group</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">


                        <div class="tab-pane fade show active" id="info-match" role="tabpanel" aria-labelledby="info-match-tab">

                            <div class="sliding-area">
                                <div class="sliding-nav">
                                    <div class="sliding-items">
                                        <div class="owl-carousel js-owl-carousel-date-info js-match-filter owl-theme sliding-items-info">
                                             @foreach($groupStages as $key => $groupStage)
                                                 <div class="item info-block js-match {{$runningPhase['phase'] == $groupStage->id ? 'is_default' : ''}}" data-phase="{{ $groupStage->id }}" data-group="{{ $groupStage->group_no }}">
                                                    @if ($runningPhase['phase'] == $groupStage->id)
                                                        <a href="javascript:void(0)" class="info-block-content is-active">
                                                    @else
                                                        <a href="javascript:void(0)" class="info-block-content">
                                                    @endif

                                                        <div class="block-section">
                                                            <div class="title">
                                                            {{ get_group_stage_and_number($groupStage,'stage')}}
                                                            </div>
                                                            <div class="desc">
                                                                {{ get_group_stage_and_number($groupStage,'number')}}
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
                                    <table class="table text-center custom-table js-table-match">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-group" role="tabpanel" aria-labelledby="info-group-tab">


                            <div class="mt-3 mb-5">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-group-filter">
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

@push ('modals')
    <div class="modal fade" id="js_team_details_modal" data-url="{{ route('manage.division.standings.team.details',['division' => $division]) }}" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content theme-modal">
                <div class="modal-header pb-0">
                    <h3 class="modal-title js-team-name"></h3>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endpush

