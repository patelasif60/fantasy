@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/summernote/summernote-bs4.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/codebase/js/plugins/summernote/summernote-bs4.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/gameguide/create.js') }}"></script>
<script>
    jQuery(function() { 
        Codebase.helpers(['summernote']); 
    });
</script>
@endpush

@section('content')

<form class="js-gameguide-edit-form" action="{{ route('admin.gameguide.update', ['gameguide' => $gameguide]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit GameGuide</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-4">
                    <div class="form-group{{ $errors->has('section') ? ' is-invalid' : '' }}">
                        <label for="section" class="required">Section:</label>
                        <input type="text" class="form-control" id="section" name="section" value="{{ $gameguide->section }}" placeholder="Section name">
                        @if ($errors->has('section'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('section') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-8">
                    <label for="name">Content:</label>
                    <textarea class="js-summernote form-control" rows="10" name="content">{{ $gameguide->content }}</textarea>
                    @if ($errors->has('content'))
                        <div class="invalid-feedback animated fadeInDown">
                            <strong>{{ $errors->first('content') }}</strong>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Update GameGuide</button>
        <a href="{{ route('admin.gameguide.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop
