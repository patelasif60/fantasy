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
    <script src="{{ asset('js/manager/divisions/info/europa_league.js') }}"></script>
     <script src="{{ asset('js/manager/divisions/info/europa_league_two.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li> <a href="{{ route('manage.division.info',['division' => $division]) }}"> <span><i class="fas fa-chevron-left pr-2"></i></span>League</a></li>
                <li class="text-center">Europa League</li>
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
            <div class="container-body text-white">
                <label>{{ $europaTeamOne ? $europaTeamOne->name : '' }}</label>
                <div class="text-white js-data-filter-tabs" data-url="{{ route('manage.league.competition.fixtures',['division' => $division ]) }}">
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
                                             @foreach($groupStagesOne as $key => $groupStage)
                                                 <div class="item info-block js-match {{$runningPhaseOne['phase'] == $groupStage->id ? 'is_default' : ''}}" data-phase="{{ $groupStage->id }}" data-group="{{ $groupStage->group_no }}">
                                                    @if ($runningPhaseOne['phase'] == $groupStage->id)
                                                        <a href="javascript:void(0)" class="info-block-content is-active">
                                                    @else
                                                        <a href="javascript:void(0)" class="info-block-content">
                                                    @endif
                                                        <div class="block-section">
                                                            <div class="title">{{ get_group_stage_and_number($groupStage,'stage')}}</div>
                                                            <div class="desc">{{ get_group_stage_and_number($groupStage,'number')}}</div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-3">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-match">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-group" role="tabpanel" aria-labelledby="info-group-tab">
                            <div class="mt-3 mb-3">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-group-filter"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
		      
                <label>{{ $europaTeamTwo ? $europaTeamTwo->name : '' }}</label>
                <div class="text-white js-data-filter-tabs-two" data-url="{{ route('manage.league.competition.fixtures',['division' => $division ]) }}">
                   <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary" id="info-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-match-tab-two" data-toggle="pill" href="#info-match-two" role="tab" aria-controls="info-match-two" aria-selected="false" data-load="0">Matches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="info-group-tab-two" data-toggle="pill" href="#info-group-two" role="tab" aria-controls="info-group-two" aria-selected="false" data-load="0" data-url="{{ route('manage.league.competition.group',['division' => $division ]) }}">Group</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="info-match-two" role="tabpanel" aria-labelledby="info-match-tab-two">
                            <div class="sliding-area">
                                <div class="sliding-nav">
                                    <div class="sliding-items">
                                        <div class="owl-carousel js-owl-carousel-date-info-two js-match-filter-two owl-theme sliding-items-info">
                                             @foreach($groupStagesTwo as $key => $groupStage)
                                                 <div class="item info-block js-match-two {{$runningPhaseTwo['phase'] == $groupStage->id ? 'is_default' : ''}}" data-phase="{{ $groupStage->id }}" data-group="{{ $groupStage->group_no }}">
                                                    @if ($runningPhaseTwo['phase'] == $groupStage->id)
                                                        <a href="javascript:void(0)" class="info-block-content is-active">
                                                    @else
                                                        <a href="javascript:void(0)" class="info-block-content">
                                                    @endif
                                                    <div class="block-section">
                                                        <div class="title">{{ get_group_stage_and_number($groupStage,'stage')}}</div>
                                                        <div class="desc">{{ get_group_stage_and_number($groupStage,'number')}}</div>
                                                    </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-3">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-table-match-two">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-group-two" role="tabpanel" aria-labelledby="info-group-tab-two">
                            <div class="mt-3 mb-3">
                                <div class="table-responsive">
                                    <table class="table text-center custom-table js-group-filter-two">
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
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
@endpush

