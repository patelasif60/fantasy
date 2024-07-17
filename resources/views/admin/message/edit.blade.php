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
<script src="{{ asset('js/admin/message/edit.js') }}"></script>
<script>
    jQuery(function() {
        Codebase.helpers(['summernote']);
    });
</script>
@endpush

@section('content')

<form class="js-message-edit-form" action="{{ route('admin.message.update', ['key' => $key]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">@if(strip_tags($value)) Edit @else Add @endif League Info Message</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="block-content block-content-full">
            <div class="row">

                <div class="col-12">
                    <label for="name">Content:</label>
                    <input type="hidden" name="key" value="{{$key}}">
                    <textarea class="js-summernote form-control" rows="10" name="content">{{ $value }}</textarea>
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
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">@if(strip_tags($value)) Update @else Add @endif Message</button>
        @if(strip_tags($value))
        <a href="{{ route('admin.message.destroy', ['key' => $key]) }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Delete</a>
        @endif
    </div>
</form>
@stop
