@extends('layouts.admin')

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/pitches/create.js') }}"></script>
@endpush

@section('content')

<form class="js-pitch-create-form" action="{{ route('admin.pitches.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Pitch</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Pitch name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Pitch name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="filter-is-published">&nbsp;</label>
                        <div class="row no-gutters items-push">
                            <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" name="is_published">
                                <span class="css-control-indicator"></span> Published
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                        <label for="photo">Pitch:</label>
                        <input type="file" name="crest" id="crest">
                        <div class="form-text text-muted mt-10">Optimum image dimensions: 1080px &times; 1578px</div>
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Create Pitch</button>
        <a href="{{ route('admin.pitches.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
