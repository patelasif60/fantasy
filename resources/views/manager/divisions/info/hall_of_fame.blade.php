@extends('layouts.manager')

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.division.info',['division' => $division]) }}">
                        <span><i class="fas fa-chevron-left mr-2"></i></span>League
                    </a>
                </li>
                <li class="text-center">Hall of fame</li>
                <li class="text-left"></li>
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
                <div class="text-white js-data-filter-tabs">
                    <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary" id="info-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="history-tab" data-toggle="pill" href="#history" role="tab" aria-controls="history" aria-selected="true" data-load="0">History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="trophy-room-tab" data-toggle="pill" href="#trophy-room" role="tab" aria-controls="trophy-room" aria-selected="false" data-load="0">Trophy Room</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                    		<ul class="custom-list-group list-group-white">
						        @foreach($histories as $history)
						            <li>
						                <div class="list-element">
					                        <span>{{ $history->season->name }}</span>
					                        <span class="has-icon">{{ $history->name }}</span>
						                </div>
						            </li>
						        @endforeach
						    </ul>
				        </div>
                        <div class="tab-pane fade" id="trophy-room" role="tabpanel" aria-labelledby="trophy-room-tab">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
