<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Players</h3>
        <div class="block-options">
            <a href="" class="btn btn-outline-primary exportCsv"><i class="fa fa-plus mr-5"></i>Export to CSV</a>
        </div>
    </div>
</div>
<div class="block">
    <form action="#" class="block-header block-header-default js-player-filter-form" method="POST">
        <div class="block-options">
            <div class="form-group mb-0">
                <div class="row no-gutters items-push">
                    <label class="css-control css-control-primary css-radio">
                        <input type="radio" class="css-control-input players" value="all" id="players-all" name="player" checked="">
                        <span class="css-control-indicator"></span> All Players
                    </label>
                    <label class="css-control css-control-primary css-radio">
                        <input type="radio" class="css-control-input players" value="squad" id="players-team" name="player" checked="">
                        <span class="css-control-indicator"></span> Current Squad
                    </label>
                </div>
            </div>
        </div>
        <input type="hidden" class="form-control" id="filter-team_id" name="team_id" value={{$team->id}}>
    </form>    
    <div class="block-content block-content-full">
        <table id='testPlayer' class="table table-striped table-vcenter table-hover admin-team-players-list-table" data-url="{{route('admin.team.player.data')}}"></table>
    </div>
</div>

@push('modals')
<div class="modal fade" id="modal-create-edit-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
</div>
@endpush