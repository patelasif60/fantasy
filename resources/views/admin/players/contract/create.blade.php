<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Add Contract</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form class="js-player-contract-create-form" id="js-player-contract-create-form" action="{{ route('admin.player.contract.store',['player'=>$player]) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-club" class="required">Club:</label>
                                        <select name="club_id" id="filter-club" class="form-control js-select2">
                                                <option value="">Select Club</option>
                                                @foreach($clubs as $id => $club)
                                                    <option value="{{ $id }}">{{ $club }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-position" class="required">Position:</label>
                                        <select name="position" id="filter-position" class="form-control js-select2">
                                                <option value="">Select Position</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position }}">{{ $position }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                              
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="start_date" class="required">Start Date:</label>
                                        <input type="text" 
                                            class="form-control js-datepicker" 
                                            id="start_date" 
                                            name="start_date" 
                                            value="{{ old('start_date') }}" 
                                            placeholder="Start Date" 
                                            data-date-format="{{config('fantasy.datepicker.format')}}"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input 
                                            type="text" 
                                            class="form-control js-datepicker" 
                                            id="end_date" 
                                            name="end_date" 
                                            value="{{ old('end_date') }}" 
                                            placeholder="End Date"
                                            data-date-format="{{config('fantasy.datepicker.format')}}"
                                            data-week-start="1"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            autocomplete="off">
                                    </div>
                                </div>
                                 <div class="col-xl-6">
                                    <div class="form-group">
                                        <div class="row no-gutters items-push">                            
                                            <label class="css-control css-control-primary css-checkbox">
                                                <input type="checkbox" class="css-control-input" name="is_active">
                                                <span class="css-control-indicator"></span> Is Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-hero btn-noborder btn-default" data-form="#js-player-contract-create-form">Save</button>
        </div>
    </div>
</div>

