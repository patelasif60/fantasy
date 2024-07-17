<div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Edit - Week {{$week}}</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
        		<table class="table table-striped table-vcenter table-hover admin-team-player-points-list-table" data-url="{{route('admin.team.player.points.data',['team'=>$team])}}"></table>
    		</div>
		</div>
	</div>
</div>