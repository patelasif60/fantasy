<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Points Adjustments</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-striped table-vcenter table-hover point-adjustments-list-table" data-url="{{ route('admin.point.adjustments.data', ['team' => $team]) }}" id="PointAdjustmentsDataTables"></table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" href="{{ route('admin.point.adjustments.create',['team' => $team]) }}" class="btn btn-outline-primary add-team-btn show_create_edit_within_modal"><i class="fa fa-plus mr-5"></i>Add adjustment</button>
        </div>
    </div>
</div>

