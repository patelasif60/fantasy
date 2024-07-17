@extends('layouts.auth.selection')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/divisions/create_team.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/manager/divisions/choose_crest.js') }}"></script>
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <form class="js-create-team-form" action="{{ route('manage.division.team.update', ['division' => $division, 'team' => $team ])}} " method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="{{ url()->previous() }}"><span>
                                            <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                                        </a>
                                    </li>
                                    <li class="text-center">Edit Team</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
 
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                    <label for="team-name">Team Name</label>
                                    <input type="text"  class="form-control" id="name" name="name" placeholder="{{ $team->name }}" value="{{ $team->name }}" maxlength="100">
                                </div>
                                @mobile
                                    @php
                                        $crestChunks = $crests->chunk(9)
                                    @endphp
                                @elsemobile
                                    @php
                                        $crestChunks = $crests->chunk(18)
                                    @endphp
                                @endmobile
                                @php
                                    $count = 0;
                                    $tabs = count($crestChunks)
                                @endphp
                               
                                <div class="team-creation team-carousel">
                                    <div class="team-selection">
                                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators align-items-center mb-0">
                                                @for ($i = 0; $i < $tabs ; $i++)
                                                <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" @if($i==0)
                                                    class="active"
                                                    @endif></li>
                                                @endfor
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach ($crestChunks as $crestKey => $chunks)
                                                    <div class="carousel-item @if($crestKey==0) active @endif">
                                                        <div class="row gutters-sm">
                                                            @foreach ($chunks as $key => $crest)
@if($crest->getMedia('crest')->last())                                                        
<div class="col-4 col-md-3 col-lg-2">
    <div class="custom-control custom-radio">
        <input type="radio" id="crest_id{{$key}}" name="crest_id" class="custom-control-input" value="{{$crest->id}}" @if($crest->id == $team->crest_id) checked @endif>
        <label class="custom-control-label" for="crest_id{{$key}}">
            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ $crest->getMedia('crest')->last()->getUrl('thumb') }}" alt="">
        </label>
    </div>
</div>
@endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-card-content">
                    <div class="auth-card-footer">
                        <div class="row justify-content-center text-white mt-5">
                            <div class="col-12 col-md-11">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                                        <div class="upload-crest">
                                            <input type="file" name="crest" id="crest" data-fileuploader-files="{{ $teamCrest }}">
                                        </div>
                                        @if ($errors->has('crest'))
                                            <div class="invalid-feedback animated fadeInDown">
                                                <strong>{{ $errors->first('crest') }}</strong>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
