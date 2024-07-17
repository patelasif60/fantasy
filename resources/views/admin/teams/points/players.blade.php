
<div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Edit Points > Week - {{$week}}</h3>
                <div class="block-options">
                	
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <table id="points-players" class="table table-striped table-vcenter table-hover admin-team-points-players-list-table" data-url="{{route('admin.team.points.players.data',['team'=>$team,'week'=>$week])}}">
                    
                </table>
            </div>
        </div>
       <div class="modal-footer text-left">
         
            <button type="submit" class="btn btn-hero btn-noborder btn-default" data-form="#js-team-points-players-form">Save</button>
        </div>
    </div>
</div>



