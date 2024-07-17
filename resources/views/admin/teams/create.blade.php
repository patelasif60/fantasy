@extends('layouts.admin')

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/teams/create.js') }}"></script>
@endpush

@section('content')

<form class="js-team-create-form" action="{{ route('admin.teams.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Team</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Team name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Team name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('manager_id') ? ' is-invalid' : '' }}">
                        <label for="manager_id" class="required">Manager:</label>
                        <select class="form-control" id="manager_id" name="manager_id">
                            <option value="">Please select</option>
                            @foreach($managers as $key => $manager)
                                <option value="{{$manager->id}}">{{$manager->first_name . ' ' . $manager->last_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('manager_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('manager_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('division_id') ? ' is-invalid' : '' }}">
                        <label for="division_id" class="required">Division:</label>
                        <select class="form-control js-select2" id="division_id" name="division_id">
                            <option value="">Please select</option>
                            @foreach($divisions as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('division_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('division_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('pitch_id') ? ' is-invalid' : '' }}">
                        <label for="pitch_id">Pitch:</label>
                        <select class="form-control js-select2" id="pitch_id" name="pitch_id">
                            <option value="">Please select</option>

                            @foreach($pitches as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('pitch_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('pitch_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('crest_id') ? ' is-invalid' : '' }}">
                        <label for="crest_id">Badge:</label>
                        <select class="form-control" id="crest_id" name="crest_id">
                            <option value="">Please select</option>
                            @foreach($crests as $key => $crest)
                                <option data-img="{{$crest->getMedia('crest')->last() ? $crest->getMedia('crest')->last()->getUrl('thumb') : ''}}" value="{{$crest->id}}">{{$crest->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('crest_id'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('crest_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                        <label for="photo">User Badge:</label>
                        <input type="file" name="crest" id="crest">
                        <div class="form-text text-muted mt-10">Optimum image dimensions: 250px &times; 250px</div>
                        @if ($errors->has('crest'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('crest') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group">
        <button type="submit" id="create-button" class="btn btn-hero btn-noborder btn-primary">Create Team</button>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
