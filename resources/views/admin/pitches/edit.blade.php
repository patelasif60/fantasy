@extends('layouts.admin')


@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/pitches/edit.js') }}"></script>
@endpush

@section('content')

<form class="js-pitch-edit-form" action="{{ route('admin.pitches.update', ['pitch' => $pitch]) }}" method="post" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Pitch</h3>
            <div class="block-options">
            </div>
        </div>

        <input type="hidden" id="pitch_id" value="{{$pitch->id}}">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Pitch name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $pitch->name }}" placeholder="Pitch name">
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
                                <input type="checkbox" class="css-control-input" name="is_published" @if($pitch->is_published == 1) checked @endif>
                                <span class="css-control-indicator"></span> Published
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                        <label for="photo">Pitch:</label>
                        <input type="file" name="crest" id="crest" data-fileuploader-files='{{ $crest }}'>
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update pitch</button>
        <a href="{{ route('admin.pitches.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
