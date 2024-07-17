@extends('layouts.manager-league-settings')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/divisions/settings/points_setting.js') }}"></script>
@endpush

@section('page-name')
    Scoring System Settings
@endsection

@section('right')
    @if($division->package->allow_custom_scoring == \App\Enums\YesNoEnum::YES)
        <p>The table below shows points scored for each event by position, but can be customised for your league. Click on individual cells to edit.</p>
    @else
        <p>Points scoring for Novice and Pro packages is fixed as below. Upgrade to the Legend package to customise scoring.</p>
    @endif
    <form action="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'points_setting' ]) }}" method="POST" class="js-division-update-form">
        @csrf
        <table class="table custom-table table-with-no-error-msg point-settings">
            <thead>
                <tr>
                    <th>Event/Position</th>
                    @foreach($positionsEnum as $key => $value)
                    <th>{{$value}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($eventsEnum as $event_key => $event_value)
                    <tr>
                        <th>{{$event_value}}</th>
                        @foreach($positionsEnum as $position_key => $position_value)
                        <td>
                            <div class='mb-0 form-group{{ $errors->has("points.$event_key.$position_key") ? " is-invalid" : "" }}'>
                                <input type="text" class='form-control events-points {{ $errors->has("points.$event_key.$position_key") ? " is-invalid" : "" }}' name="points[{{$event_key}}][{{$position_key}}]" value="{{($division->getOptionValue($position_key,$event_key) ? $division->getOptionValue($position_key,$event_key) : 0)}}" {{ ( $division->package->allow_custom_scoring == $onlyNoEnum ) ? 'readonly' : '' }}>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

        </table>
        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
        </div>
    </form>
@endsection
