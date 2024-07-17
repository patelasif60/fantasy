
<div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Player Contract - {{$player->full_name}}</h3>
                <div class="block-options">
                	<button class="btn btn-default mr-15" id="add-contract">Add New Contract</button>
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form class="js-team-player-contract-form" id="js-team-player-contract-form" action="{{ route('admin.team.player.contract.store',['player'=>$player,'team'=>$team]) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="block">
                        <div class="block-content block-content-full">
                        	<table class="table table-default table-striped">
                        		<thead id="contracts-head">
                        			<tr>
                        				<th><b>Start Date</b></th>
                        				<th><b>End Date</b></th>
                        				<th><b>Active</b></th>
                        			</tr>
                        		</thead>
                        		<tbody id="contracts">
		                           	@foreach($contracts as $contract)
		                           	<tr>
		                           		<td>
		                           			<div class="input-group">
		                           				<input type="text" 
		                           					name="start_date[{{$contract->id}}]" 
		                           					value="{{ ($contract->start_date ? carbon_format_to_time($contract->start_date) : '' ) }}" 
		                           					class="form-control datetimepicker"
		                           					data-date-format="{{config('fantasy.datetimepicker.format')}}"
	                            					autocomplete="off">
                            					<div class="input-group-append">
				                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
				                                </div>
                            				</div>
		                           		</td>
		                           		<td>
		                           			<div class="input-group">
		                           				<input type="text" 
		                           					name="end_date[{{$contract->id}}]" 
		                           					value="{{ ($contract->end_date ? carbon_format_to_time($contract->end_date) : '') }}" 
		                           					class="form-control datetimepicker"
		                           					data-date-format="{{config('fantasy.datetimepicker.format')}}"
	                            					autocomplete="off">
		                           				<div class="input-group-append">
				                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
				                                </div>
                            				</div>
		                           		</td>
		                           		<td>
		                           			
		                           			<label class="css-control css-control-primary css-checkbox">
					                            <input type="checkbox" class="css-control-input" value="1" id="is_active-{{$contract->id}}" name="is_active[{{$contract->id}}]" @if($contract->is_active) checked="" @endif>
					                            <span class="css-control-indicator"></span> On Pitch
					                        </label>
					                    	
		                           		</td>
		                           	</tr>
		                           	@endforeach
                           		</tbody>
                           	</table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="d-none" id="repeat">
            <tbody>
                <tr>
                    <td>
                        <div class="input-group">
                            <input type="text" 
                                name="start_date_new[]" 
                                value="" 
                                class="form-control datetimepicker"
                                data-date-format="{{config('fantasy.datetimepicker.format')}}"
                                autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" 
                                name="end_date_new[]" 
                                value="" 
                                class="form-control datetimepicker"
                                data-date-format="{{config('fantasy.datetimepicker.format')}}"
                                autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        
                        <label class="css-control css-control-primary css-checkbox">
                            <input type="checkbox" class="css-control-input" value="1" id="is_active" name="is_active_new[]">
                            <span class="css-control-indicator"></span> On Pitch
                        </label>
                        
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="modal-footer text-left">
            <div class="block-content pb-15 text-earth js-loading-message d-none"><i class="fal fa-spinner fa-spin mr-1"></i> Please wait we are calculating points...</div>
            <button type ="button" id="recalculate-points" data-team = "{{$team}}" data-player = "{{$player}}" data-url="{{route('admin.team.players.points.recalculate', ['team'=>$team,'player'=>$player])}}" class="btn btn-hero btn-noborder btn-default">Recalculate Points</button> 
            <button type="submit" class="btn btn-hero btn-noborder btn-default" data-form="#js-team-player-contract-form" id="js-team-player-contract-form-save">Save</button>
        </div>
    </div>
</div>



