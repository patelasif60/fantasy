@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}"></script>
<script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/teams/edit.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/teams/delete.js') }}"></script>

@endpush
@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.teams.settings',['division' => $division, 'team' => $team]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li>{{  $team->name }}</li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-8">
        <div class="container-wrappper">
            <div class="container-body">
                <div class="row mb-50">
                    <div class="col-12 text-white">
                        <form action="{{ route('manage.teams.settings.update',['division' => $division, 'team' => $team ]) }}" method="POST" class="js-teams-update-form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                <label for="nameAddress">Team name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback animated fadeInDown" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
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
                                    <div class="form-group">
                                        <label for="team-icon">Please select a team badge or upload your own icon.</label>
                                        <div class="team-selection owl-carousel owl-theme">
                                            @foreach ($crestChunks as $crestKey => $chunks)
                                                <div class="item @if($crestKey==0) active @endif">
                                                    <div class="row gutters-sm">
                                                        @foreach ($chunks as $key => $crest)
                                                            @if($crest->getMedia('crest')->last())
                                                                <div class="col-4 col-md-3 col-lg-2">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="crest_id{{$key}}" name="crest_id" class="custom-control-input" value="{{$crest->id}}" @if($team->crest_id == $crest->id) checked @endif>
                                                                        <label class="custom-control-label w-100" for="crest_id{{$key}}">
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

                            <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                                <div class="upload-crest">
                                    <input type="file" name="crest" id="crest" data-fileuploader-files='{{ $ownCrest }}'>
                                </div>
                                @if ($errors->has('crest'))
                                    <div class="invalid-feedback animated fadeInDown">
                                        <strong>{{ $errors->first('crest') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
