@extends('layouts.manager')

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/manager/global.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/select_pitch.js') }}"></script>
@endpush

@push('header-content')
	<div class="container">
	    <div class="row">
	        <div class="col-12">
	            <ul class="top-navigation-bar">
	                <li>
	                    <a href="{{ url()->previous() }}">
                            <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                        </a>
	                </li>
	                <li class="text-center">Create a team</li>
	                <li class="text-right"></li>
	            </ul>
	        </div>
	    </div>
	</div>
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <form class="js-select-pitch-form" action="{{ route('manage.division.team.assign_pitch', ['division' => $division, 'team' => $team])}} " method="post">
                @if($via)
                    <input type="hidden" name="via" value="{{$via}}">
                @endif
                {{ csrf_field() }}
                <div class="container-wrapper">
                    <div class="container-body">
                        <div class="row mt-1">
                            <div class="col-12 text-white">
                                <div class="team-creation">
                                    <label class="text-white">Select a pitch</label>
                                    <div class="pitch-selection mb-4">
                                        <div class="row gutter-sm">
	                                        @foreach($pitches as $key => $pitch)
	                                            @if($pitch->getMedia('crest')->last())
	                                                <div class="col-6">
	                                                    <div class="custom-control custom-radio">
	                                                        <input type="radio" id="pitch_id{{$key}}" @if($pitch->id == $team->pitch_id) checked @endif name="pitch_id" value="{{$pitch->id}}" class="custom-control-input">
	                                                        <label class="custom-control-label w-100" for="pitch_id{{$key}}">
	                                                            <img class="lazyload pitch-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png') }}" data-src="{{ $pitch->getMedia('crest')->last()->getUrl('thumb')}}" alt="">
	                                                        </label>
	                                                    </div>
	                                                </div>
	                                            @endif
	                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
