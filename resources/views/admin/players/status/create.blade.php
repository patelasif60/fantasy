
<div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Add Status</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form class="js-player-status-create-form" id="js-player-status-create-form" action="{{ route('admin.player.status.store',['player'=>$player->id]) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-status" class="required">Status Type:</label>
                                        <select name="status" id="filter-status" class="form-control js-select2">
                                                <option value="">Select Status</option>
                                                @foreach($status_list as $id => $stat)
                                                    <option value="{{ $id }}">{{ $stat }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="Enter status description here">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="start_date" class="required">Start Date:</label>
                                        <input type="text" 
                                            class="form-control js-datepicker"       
                                            data-date-format="{{config('fantasy.datepicker.format')}}"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true" 
                                            id="start_date" 
                                            name="start_date" 
                                            value="{{ old('start_date') }}" 
                                            placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="text" 
                                            class="form-control js-datepicker" 
                                            data-date-format="{{config('fantasy.datepicker.format')}}"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true" 
                                            id="end_date" 
                                            name="end_date" 
                                            value="{{ old('end_date') }}" 
                                            placeholder="End Date">
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



