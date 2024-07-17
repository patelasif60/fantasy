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
                <form class="js-team-transfer-create-form" id="js-team-transfer-create-form" action="{{ route('admin.team.transfer.update',['transfer'=>$transfer]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-player_in" class="required">Player In:</label>
                                        <select name="player_in" id="filter-player_in" class="form-control" style="width: 100%">
                                                <option value="">Please Select</option>
                                                @foreach($playersIn as $id => $in)
                                                    <option value="{{ $in->player->id }}" @if($in->player->id == $transfer->player_in) selected @endif>{{ $in->player->full_name }} ({{$in->club->name.' '.$in->position}})</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-player_out" class="required">Player Out:</label>
                                        <select name="player_out" id="filter-player_out" class="form-control" style="width: 100%">
                                                <option value="">Please Select</option>
                                                @foreach($playersOut as $id => $out)
                                                     <option value="{{ $out->player->id }}" @if($out->player->id == $transfer->player_out) selected @endif>{{  $out->player->full_name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-transfer_type" class="required">Type:</label>
                                        <select name="transfer_type" id="filter-transfer_type" class="form-control" style="width: 100%">
                                                <option value="">Please Select</option>
                                                @foreach($transferType as $id => $type)
                                                     <option value="{{ $id }}" @if($id == $transfer->transfer_type) selected @endif>{{ $type }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="transfer_value" class="required">Value (&pound;M):</label>
                                        <input type="text" class="form-control" id="transfer_value" name="transfer_value" value="{{$transfer->transfer_value}}" placeholder="0.00" maxlength="6">
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
                                            autocomplete="off"
                                            value="{{$transfer->transfer_date}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="team_id" value="{{$transfer->team_id}}">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-hero btn-noborder btn-default" data-form="#js-team-transfer-create-form">Save</button>
        </div>
    </div>
</div>

