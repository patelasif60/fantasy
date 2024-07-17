@extends('layouts.admin')


@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/options/crests/edit.js') }}"></script>
@endpush

@section('content')

<form class="js-crest-edit-form" action="{{ route('admin.options.crests.update', ['crest' => $crestData]) }}" method="post" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Badge</h3>
            <div class="block-options">
            </div>
        </div>
        <input type="hidden" id="crest_id" value="{{$crestData->id}}">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Badge name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $crestData->name }}" placeholder="Badge name" maxlength="100">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <label for="filter-is_published">&nbsp;</label>
                    <div class="row no-gutters items-push">
                        <label class="css-control css-control-primary css-checkbox">
                            <input type="checkbox" class="css-control-input" id="filter-is_published" name="is_published" value="1" @if(($crestData->is_published)) checked @endif>
                            <span class="css-control-indicator"></span> Published
                        </label>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group {{ $errors->has('crest') ? ' is-invalid' : '' }}">
                        <label for="photo">Badge:</label>
                        <input type="file" name="crest" id="crest" data-fileuploader-files='{{ $crest }}'>
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update Badge</button>
        <a href="{{ route('admin.options.crests.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
