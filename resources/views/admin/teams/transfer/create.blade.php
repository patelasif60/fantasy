<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Add Transfers and Activity</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form class="js-team-transfer-create-form" id="js-team-transfer-create-form" action="{{ route('admin.team.transfer.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-transfer_type" class="required">Type:</label>
                                        <select name="transfer_type" id="filter-transfer_type" class="form-control" style="width: 100%">
                                                <option value="">Please Select</option>
                                                @foreach($transferType as $id => $type)
                                                     <option value="{{ $id }}">{{ $type }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label for="transfer_date" class="required">Date:</label>
                                    <div class="input-group date">
                                        <input type="text" 
                                            class="form-control" 
                                            id="transfer_date" 
                                            name="transfer_date" 
                                            placeholder="Date" 
                                            data-date-format="{{config('fantasy.datetimepicker.format')}}"
                                            data-autoclose="true"
                                            data-today-highlight="true"
                                            autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-player_in" class="required" id="label-player-in">Player In:</label>
                                        <select name="player_in" id="filter-player_in" class="form-control" style="width: 100%">
                                                <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-player_out">Player Out:</label>
                                        <select name="player_out" id="filter-player_out" class="form-control" style="width: 100%">
                                                <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="transfer_value" class="required">Value (&pound;M):</label>
                                        <input type="text" class="form-control" id="transfer_value" name="transfer_value" placeholder="0.00" maxlength="6" value="0">
                                    </div>
                                </div>
                                <input type="hidden" id="team_id" name="team_id" value="{{$team}}">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" id="create-transfer-button" class="btn btn-hero btn-noborder btn-default" data-form="#js-team-transfer-create-form">Save</button>
        </div>
    </div>
</div>

