<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Edit Status</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form class="js-player-status-create-form" id="js-player-status-create-form" action="{{ route('admin.player.status.update', ['player'=>$player,'status' => $status]) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('status') ? ' is-invalid' : '' }}">
                                        <label for="filter-status" class="required">Status Type:</label>
                                        <select name="status" id="filter-status" class="form-control js-select2">
                                                <option value="">Select Status</option>
                                                @foreach($status_list as $id => $stat)
                                                    <option value="{{ $id }}" @if($id == $status->status) selected ="selected" @endif>{{ $stat }}</option>
                                                @endforeach
                                        </select>
                                        @if ($errors->has('status'))
                                            <div class="invalid-feedback animated fadeInDown">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('description') ? ' is-invalid' : '' }}">
                                        <label for="description">Description:</label>
                                        <input type="text" class="form-control" id="description" name="description" value="{{ $status->description }}" placeholder="Enter status description here">
                                        @if ($errors->has('description'))
                                            <div class="invalid-feedback animated fadeInDown">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('start_date') ? ' is-invalid' : '' }}">
                                        <label for="start_date" class="required">Start Date:</label>
                                        <input type="text" class="form-control js-datepicker"
                                            data-date-format="{{config('fantasy.datepicker.format')}}"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true"  
                                            id="start_date" 
                                            name="start_date" 
                                            value="{{ carbon_format_to_date($status->start_date) }}" 
                                            placeholder="Start Date">
                                        @if ($errors->has('start_date'))
                                            <div class="invalid-feedback animated fadeInDown">
                                                <strong>{{ $errors->first('start_date') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('end_date') ? ' is-invalid' : '' }}">
                                        <label for="end_date">End Date:</label>
                                        <input type="text" class="form-control js-datepicker"
                                            data-value="{{ $status->end_date }}"
                                            data-date-format="{{config('fantasy.datepicker.format')}}"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            id="end_date" name="end_date" 
                                            value="{{ ( $status->end_date ? carbon_format_to_date($status->end_date) : null ) }}" 
                                            placeholder="End Date" 
                                            @if($disabled_end_date) disabled="disabled" @endif>
                                        @if ($errors->has('end_date'))
                                            <div class="invalid-feedback animated fadeInDown">
                                                <strong>{{ $errors->first('end_date') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-hero btn-noborder btn-default" data-form="#js-player-status-create-form">Save</button>
        </div>
    </div>
</div>

