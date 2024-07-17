@extends('layouts.admin')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('js/admin/prizepacks/create.js') }}"></script>
@endpush

@section('content')

<form class="js-prize-pack-create-form" action="{{ route('admin.prizepacks.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Prize Pack</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="name" class="required">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Prize pack name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback animated fadeInDown">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="auction_budget">Price:</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">&pound;</div>
                            </div>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('short_description') ? ' is-invalid' : '' }}">
                        <label for="short_description">Short description:</label>
                        <textarea class="form-control" id="short_description" rows="3" name="short_description"></textarea>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('long_description') ? ' is-invalid' : '' }}">
                        <label for="long_description">Long description:</label>
                        <textarea class="form-control" id="long_description" rows="3" name="long_description"></textarea>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('is_enabled') ? ' is-invalid' : '' }}">
                        <label for="is_enabled">Enabled:</label>
                        <select class="form-control js-select2" id="is_enabled" name="is_enabled">
                            @foreach($yesNo as $key => $value)
                                <option value="{{ $key }}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group{{ $errors->has('badge_color') ? ' is-invalid' : '' }}">
                        <label for="badge_color">Badge Color:</label>
                        <select class="form-control js-select2" id="badge_color" name="badge_color">
                            @foreach($badgeColors as $key => $value)
                                <option value="{{ $key }}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- <div class="col-xl-12">
                    <div class="form-group{{ $errors->has('is_default') ? ' is-invalid' : '' }}">
                        <div class="row no-gutters items-push">
                            <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" name="is_default">
                                <span class="css-control-indicator"></span> Is Default
                            </label>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-hero btn-noborder btn-primary">Create Prize Pack</button>
        <a href="{{ route('admin.prizepacks.index') }}" class="btn btn-hero btn-noborder btn-alt-secondary"> Cancel</a>
    </div>
</form>
@stop

